<?php

namespace App\Services;

use App\Models\Wedding;
use App\Models\ChecklistTask;
use App\Models\Payment;
use App\Models\WeddingMilestone;
use Illuminate\Support\Str;

class WeddingService
{
    /**
     * Create a new wedding and generate default checklist + DP payment record.
     */
    public function create(array $data): Wedding
    {
        $wedding = Wedding::create($data);
        $this->generateDefaultChecklist($wedding);
        $this->generateDpPayment($wedding);
        $this->generateMilestones($wedding);
        return $wedding;
    }

    protected function generateDefaultChecklist(Wedding $wedding): void
    {
        $tasks = [
            ['category' => 'Persiapan', 'task_name' => 'Konfirmasi paket pernikahan'],
            ['category' => 'Persiapan', 'task_name' => 'Tentukan tanggal & venue'],
            ['category' => 'Vendor',    'task_name' => 'Konfirmasi vendor catering'],
            ['category' => 'Vendor',    'task_name' => 'Konfirmasi vendor dekorasi'],
            ['category' => 'Vendor',    'task_name' => 'Booking MUA (Make Up Artist)'],
            ['category' => 'Vendor',    'task_name' => 'Booking fotografer & videografer'],
            ['category' => 'Dokumen',   'task_name' => 'Urus surat nikah (KUA/Catatan Sipil)'],
            ['category' => 'Pakaian',   'task_name' => 'Fitting baju pengantin'],
            ['category' => 'Undangan',  'task_name' => 'Desain & cetak undangan'],
            ['category' => 'Undangan',  'task_name' => 'Kirim undangan tamu'],
            ['category' => 'H-7',       'task_name' => 'Final briefing semua vendor'],
            ['category' => 'H-1',       'task_name' => 'Gladi resik'],
        ];

        foreach ($tasks as $i => $task) {
            ChecklistTask::create([
                'wedding_id' => $wedding->id,
                'task_name'  => $task['task_name'],
                'category'   => $task['category'],
                'sort_order' => $i,
            ]);
        }
    }

    protected function generateDpPayment(Wedding $wedding): void
    {
        $dpAmount = $wedding->total_price * 0.3; // 30% DP
        Payment::create([
            'wedding_id'     => $wedding->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount'         => $dpAmount,
            'type'           => 'dp',
            'status'         => 'pending',
            'due_date'       => now()->addDays(7),
        ]);
    }

    protected function generateMilestones(Wedding $wedding): void
    {
        $wDate = $wedding->wedding_date;

        $milestones = [
            ['type' => 'dp_payment',        'title' => 'Pembayaran DP',             'days_before' => 90],
            ['type' => 'fitting',            'title' => 'Fitting Baju Pengantin',    'days_before' => 60],
            ['type' => 'technical_meeting',  'title' => 'Technical Meeting',         'days_before' => 30],
            ['type' => 'final_briefing',     'title' => 'Final Briefing Vendor',     'days_before' => 7],
            ['type' => 'rehearsal',          'title' => 'Gladi Resik',               'days_before' => 1],
            ['type' => 'wedding_day',        'title' => 'Hari Pernikahan',           'days_before' => 0],
        ];

        foreach ($milestones as $i => $m) {
            WeddingMilestone::create([
                'wedding_id'     => $wedding->id,
                'title'          => $m['title'],
                'milestone_type' => $m['type'],
                'milestone_date' => $wDate->copy()->subDays($m['days_before']),
                'sort_order'     => $i,
            ]);
        }
    }
}
