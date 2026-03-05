<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewConsultationNotification extends Notification
{
    use Queueable;

    public function __construct(public Consultation $consultation) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'consultation',
            'icon'    => '💬',
            'title'   => 'Konsultasi Baru',
            'message' => "{$this->consultation->name} mengirim permintaan konsultasi.",
            'url'     => route('admin.consultations.show', $this->consultation),
        ];
    }
}
