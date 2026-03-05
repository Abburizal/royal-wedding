<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        $wedding = $this->payment->wedding;
        return [
            'type'    => 'payment',
            'icon'    => '💳',
            'title'   => 'Bukti Pembayaran Baru',
            'message' => "Bukti bayar dari {$wedding->client->name} menunggu verifikasi.",
            'url'     => route('admin.weddings.show', $wedding),
        ];
    }
}
