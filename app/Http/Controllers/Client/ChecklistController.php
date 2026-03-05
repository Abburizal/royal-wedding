<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChecklistTask;
use App\Services\ChecklistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function __construct(protected ChecklistService $checklistService) {}

    public function index()
    {
        $wedding = Auth::user()->weddings()->with('checklistTasks')->latest()->firstOrFail();
        $tasks   = $wedding->checklistTasks()->orderBy('sort_order')->get()->groupBy('category');
        $progress = $this->checklistService->getProgressByCategory($wedding);
        return view('client.checklist', compact('wedding', 'tasks', 'progress'));
    }

    public function updateStatus(Request $request, ChecklistTask $task)
    {
        // Pastikan task milik wedding milik klien ini
        abort_unless($task->wedding->client_id === Auth::id(), 403);

        $request->validate(['status' => 'required|in:pending,in_progress,done']);
        $this->checklistService->updateStatus($task, $request->status);

        return back()->with('success', 'Status checklist diperbarui.');
    }
}
