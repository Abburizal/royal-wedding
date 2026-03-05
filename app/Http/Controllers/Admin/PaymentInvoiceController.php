<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payment;
use App\Models\Wedding;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentInvoiceController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function store(Request $request, Wedding $wedding)
    {
        $data = $request->validate([
            'type'        => 'required|in:down_payment,installment,full_payment,other',
            'amount'      => 'required|numeric|min:1000',
            'due_date'    => 'required|date|after_or_equal:today',
            'notes'       => 'nullable|string|max:500',
        ]);

        $payment = $wedding->payments()->create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'type'           => $data['type'],
            'amount'         => $data['amount'],
            'due_date'       => $data['due_date'],
            'notes'          => $data['notes'],
            'status'         => 'pending',
        ]);

        $this->paymentService->notifyInvoiceCreated($payment);

        ActivityLog::record(
            'created',
            'Buat invoice ' . $payment->invoice_number . ' (' . $payment->formatted_amount . ') untuk wedding ' . $wedding->couple_name,
            $payment
        );

        return back()->with('payment_success', 'Invoice berhasil dibuat dan notifikasi dikirim.');
    }

    public function destroy(Wedding $wedding, Payment $payment)
    {
        abort_unless($payment->wedding_id === $wedding->id, 403);
        abort_if(in_array($payment->status, ['verified']), 422, 'Invoice yang sudah terverifikasi tidak bisa dihapus.');

        $payment->delete();
        return back()->with('payment_success', 'Invoice dihapus.');
    }
}
