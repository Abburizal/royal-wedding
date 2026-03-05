<?php

namespace App\Services;

use App\Mail\InvoiceCreatedMail;
use App\Mail\PaymentVerifiedMail;
use App\Mail\PaymentRejectedMail;
use App\Models\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    public function __construct(protected WhatsAppService $whatsApp) {}

    public function uploadProof(Payment $payment, UploadedFile $file): Payment
    {
        if ($payment->proof_image) {
            Storage::disk('public')->delete($payment->proof_image);
        }

        $path = $file->store('payment-proofs', 'public');

        $payment->update([
            'proof_image' => $path,
            'status'      => 'uploaded',
        ]);

        return $payment->fresh();
    }

    public function verify(Payment $payment): Payment
    {
        $payment->update([
            'status'  => 'verified',
            'paid_at' => now()->toDateString(),
        ]);

        $payment->load('wedding.client');
        $this->sendNotification($payment, 'verified');

        return $payment;
    }

    public function reject(Payment $payment, ?string $reason = null): Payment
    {
        $payment->update([
            'status' => 'rejected',
            'notes'  => $reason,
        ]);

        $payment->load('wedding.client');
        $this->sendNotification($payment, 'rejected');

        return $payment;
    }

    public function notifyInvoiceCreated(Payment $payment): void
    {
        $payment->load('wedding.client');
        $this->sendNotification($payment, 'created');
    }

    public function getWeddingPaymentSummary(\App\Models\Wedding $wedding): array
    {
        $total    = (float) $wedding->total_price;
        $paid     = (float) $wedding->payments()->where('status', 'verified')->sum('amount');
        $pending  = (float) $wedding->payments()->whereIn('status', ['pending', 'uploaded'])->sum('amount');
        $remaining = max(0, $total - $paid);

        return compact('total', 'paid', 'pending', 'remaining');
    }

    protected function sendNotification(Payment $payment, string $event): void
    {
        $email = $payment->wedding->client->email ?? null;

        try {
            match($event) {
                'created'  => $email && Mail::to($email)->queue(new InvoiceCreatedMail($payment)),
                'verified' => $email && Mail::to($email)->queue(new PaymentVerifiedMail($payment)),
                'rejected' => $email && Mail::to($email)->queue(new PaymentRejectedMail($payment)),
                default    => null,
            };

            match($event) {
                'created'  => $this->whatsApp->sendInvoiceCreated($payment),
                'verified' => $this->whatsApp->sendPaymentVerified($payment),
                'rejected' => $this->whatsApp->sendPaymentRejected($payment),
                default    => null,
            };
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Notification failed: ' . $e->getMessage());
        }
    }
}
