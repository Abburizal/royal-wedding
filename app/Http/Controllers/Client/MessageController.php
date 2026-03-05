<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $wedding = auth()->user()->activeWedding;
        if (!$wedding) return redirect()->route('client.dashboard')->with('error', 'Wedding tidak ditemukan.');

        // Mark all planner messages as read when opening chat
        $wedding->messages()
            ->where('is_internal', false)
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        $messages = $wedding->messages()
            ->where('is_internal', false)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('client.chat', compact('wedding', 'messages'));
    }

    public function fetch(Request $request)
    {
        $wedding = auth()->user()->activeWedding;
        if (!$wedding) return response()->json(['messages' => []]);

        $after = $request->integer('after', 0);

        // Mark new planner messages as read
        $wedding->messages()
            ->where('is_internal', false)
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        $messages = $wedding->messages()
            ->where('is_internal', false)
            ->where('id', '>', $after)
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'sender_id'  => $m->sender_id,
                'sender'     => $m->sender?->name ?? 'Unknown',
                'avatar'     => strtoupper(substr($m->sender?->name ?? '?', 0, 1)),
                'mine'       => $m->sender_id === auth()->id(),
                'time'       => $m->created_at->format('H:i'),
                'date'       => $m->created_at->isoFormat('D MMM'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $wedding = auth()->user()->activeWedding;
        if (!$wedding) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Wedding tidak ditemukan.'], 404)
                : back()->with('error', 'Wedding tidak ditemukan.');
        }

        $msg = $wedding->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        $wedding->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        if ($request->expectsJson()) {
            $msg->load('sender');
            return response()->json([
                'id'        => $msg->id,
                'message'   => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender'    => $msg->sender?->name ?? 'Unknown',
                'avatar'    => strtoupper(substr($msg->sender?->name ?? '?', 0, 1)),
                'mine'      => true,
                'time'      => $msg->created_at->format('H:i'),
                'date'      => $msg->created_at->isoFormat('D MMM'),
            ]);
        }

        return back()->with('success', 'Pesan terkirim.');
    }
}
