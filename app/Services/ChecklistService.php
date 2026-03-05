<?php

namespace App\Services;

use App\Models\ChecklistTask;
use App\Models\Wedding;

class ChecklistService
{
    public function updateStatus(ChecklistTask $task, string $status): ChecklistTask
    {
        $task->update(['status' => $status]);
        return $task;
    }

    public function getProgressByCategory(Wedding $wedding): array
    {
        return $wedding->checklistTasks()
            ->get()
            ->groupBy('category')
            ->map(function ($tasks) {
                $total = $tasks->count();
                $done  = $tasks->where('status', 'done')->count();
                return [
                    'total'    => $total,
                    'done'     => $done,
                    'percent'  => $total > 0 ? round(($done / $total) * 100) : 0,
                ];
            })
            ->toArray();
    }
}
