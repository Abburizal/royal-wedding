<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index()
    {
        $wedding = Auth::user()->weddings()->with('milestones')->latest()->firstOrFail();
        $milestones = $wedding->milestones;
        return view('client.timeline', compact('wedding', 'milestones'));
    }

    public function updateStatus(Request $request, WeddingMilestone $milestone)
    {
        abort_unless($milestone->wedding->client_id === Auth::id(), 403);

        $request->validate(['status' => 'required|in:upcoming,done']);
        $milestone->update(['status' => $request->status]);

        return back()->with('success', 'Milestone diperbarui.');
    }
}
