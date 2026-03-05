<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $provider;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->provider = config('whatsapp.provider', 'fonnte');
        $this->apiKey   = config('whatsapp.api_key', '');
        $this->baseUrl  = $this->resolveBaseUrl();
    }

    protected function resolveBaseUrl(): string
    {
        return match($this->provider) {
            'wablas'  => 'https://my.wablas.com/api',
            'fonnte'  => 'https://api.fonnte.com',
            default   => 'https://api.fonnte.com',
        };
    }

    public function send(string $phone, string $message): bool
    {
        if (empty($this->apiKey)) {
            Log::warning('WhatsApp API key not configured. Message not sent.', ['phone' => $phone]);
            return false;
        }

        try {
            $phone = $this->normalizePhone($phone);

            if ($this->provider === 'fonnte') {
                return $this->sendFonnte($phone, $message);
            }

            return $this->sendWablas($phone, $message);

        } catch (\Throwable $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage(), ['phone' => $phone]);
            return false;
        }
    }

    protected function sendFonnte(string $phone, string $message): bool
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->post($this->baseUrl . '/send', [
            'target'  => $phone,
            'message' => $message,
            'delay'   => '2',
        ]);

        return $response->successful() && ($response->json('status') ?? false);
    }

    protected function sendWablas(string $phone, string $message): bool
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->post($this->baseUrl . '/send-message', [
            'phone'   => $phone,
            'message' => $message,
        ]);

        return $response->successful();
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }

    // ── Pesan Template ──────────────────────────────────────────────────────────

    public function sendInvoiceCreated(\App\Models\Payment $payment): bool
    {
        $client = $payment->wedding->client;
        if (!$client->phone) return false;

        $msg = "✨ *The Royal Wedding by Ully Sjah*\n\n"
             . "Halo *{$client->name}*! 👋\n\n"
             . "Invoice pembayaran baru telah dibuat:\n"
             . "📄 No: *{$payment->invoice_number}*\n"
             . "💰 Jumlah: *{$payment->formatted_amount}*\n"
             . "📅 Jatuh Tempo: *" . ($payment->due_date ? $payment->due_date->format('d M Y') : '-') . "*\n\n"
             . "Silakan upload bukti pembayaran di dashboard Anda:\n"
             . config('app.url') . "/my-wedding/payments";

        return $this->send($client->phone, $msg);
    }

    public function sendPaymentVerified(\App\Models\Payment $payment): bool
    {
        $client = $payment->wedding->client;
        if (!$client->phone) return false;

        $msg = "✅ *The Royal Wedding by Ully Sjah*\n\n"
             . "Halo *{$client->name}*!\n\n"
             . "Pembayaran Anda telah *dikonfirmasi* ✓\n"
             . "📄 Invoice: *{$payment->invoice_number}*\n"
             . "💰 Jumlah: *{$payment->formatted_amount}*\n\n"
             . "Terima kasih! Tim kami terus bekerja untuk hari istimewa Anda 💍";

        return $this->send($client->phone, $msg);
    }

    public function sendPaymentRejected(\App\Models\Payment $payment): bool
    {
        $client = $payment->wedding->client;
        if (!$client->phone) return false;

        $msg = "❌ *The Royal Wedding by Ully Sjah*\n\n"
             . "Halo *{$client->name}*,\n\n"
             . "Mohon maaf, bukti pembayaran untuk invoice *{$payment->invoice_number}* tidak dapat diproses.\n"
             . ($payment->notes ? "Alasan: _{$payment->notes}_\n\n" : "\n")
             . "Silakan upload ulang bukti pembayaran:\n"
             . config('app.url') . "/my-wedding/payments";

        return $this->send($client->phone, $msg);
    }

    public function sendWeddingReminder(\App\Models\Wedding $wedding, int $daysLeft): bool
    {
        $client = $wedding->client;
        if (!$client->phone) return false;

        $msg = "⏰ *The Royal Wedding by Ully Sjah*\n\n"
             . "Halo *{$client->name}*! 💍\n\n"
             . "Tinggal *{$daysLeft} hari* lagi menuju hari pernikahan\n"
             . "*{$wedding->couple_name}*\n"
             . "📅 " . $wedding->wedding_date->isoFormat('dddd, D MMMM Y') . "\n\n"
             . "Cek progress persiapan di:\n"
             . config('app.url') . "/my-wedding/dashboard";

        return $this->send($client->phone, $msg);
    }
}
