<?php

namespace App\Console\Commands;

use App\Mail\WeddingReminderMail;
use App\Models\Wedding;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeddingReminders extends Command
{
    protected $signature   = 'weddings:send-reminders';
    protected $description = 'Kirim reminder H-30, H-7, H-1 ke klien wedding';

    public function __construct(protected WhatsAppService $whatsApp)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $reminderDays = [30, 7, 1];

        foreach ($reminderDays as $days) {
            $targetDate = now()->addDays($days)->toDateString();

            $weddings = Wedding::with(['client', 'checklistTasks'])
                ->whereIn('status', ['confirmed', 'in_progress'])
                ->whereDate('wedding_date', $targetDate)
                ->get();

            foreach ($weddings as $wedding) {
                $email = $wedding->client->email ?? null;

                try {
                    if ($email) {
                        Mail::to($email)->queue(new WeddingReminderMail($wedding, $days));
                    }
                    $this->whatsApp->sendWeddingReminder($wedding, $days);

                    $this->info("✓ Reminder H-{$days} dikirim ke {$wedding->couple_name}");
                } catch (\Throwable $e) {
                    $this->error("✗ Gagal kirim ke {$wedding->couple_name}: " . $e->getMessage());
                }
            }
        }

        $this->info('Selesai kirim reminder.');
    }
}
