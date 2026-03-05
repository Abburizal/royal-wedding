<?php

namespace App\Services;

use App\Models\Wedding;
use App\Models\ChecklistTask;
use App\Models\Payment;
use App\Models\WeddingMilestone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WeddingService
{
    /**
     * Create a new wedding with default checklist, DP invoice, and milestones.
     * Wrapped in a DB transaction to prevent partial/inconsistent data on failure.
     */
    public function create(array $data): Wedding
    {
        return DB::transaction(function () use ($data) {
            $wedding = Wedding::create($data);
            $this->generateDefaultChecklist($wedding);
            $this->generateDpPayment($wedding);
            $this->generateMilestones($wedding);
            return $wedding;
        });
    }

    protected function generateDefaultChecklist(Wedding $wedding): void
    {
        $tasks = config('wedding.default_checklist');

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
        $dpPercentage = config('wedding.dp_percentage', 0.30);
        $dueDays      = config('wedding.dp_due_days', 7);

        Payment::create([
            'wedding_id'     => $wedding->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount'         => $wedding->total_price * $dpPercentage,
            'type'           => 'dp',
            'status'         => 'pending',
            'due_date'       => now()->addDays($dueDays),
        ]);
    }

    protected function generateMilestones(Wedding $wedding): void
    {
        $wDate      = $wedding->wedding_date;
        $milestones = config('wedding.default_milestones');

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

