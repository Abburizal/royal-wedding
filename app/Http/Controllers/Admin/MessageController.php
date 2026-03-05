<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use App\Models\WeddingMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Wedding $wedding)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $msg = $wedding->messages()->create([
            'sender_id'   => auth()->id(),
            'message'     => $request->message,
            'is_internal' => $request->boolean('is_internal'),
        ]);

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

    public function fetch(Request $request, Wedding $wedding)
    {
        $after = $request->integer('after', 0);

        // Mark client messages as read
        $wedding->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        $messages = $wedding->messages()
            ->where('id', '>', $after)
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'          => $m->id,
                'message'     => $m->message,
                'sender_id'   => $m->sender_id,
                'sender'      => $m->sender?->name ?? 'Unknown',
                'avatar'      => strtoupper(substr($m->sender?->name ?? '?', 0, 1)),
                'mine'        => $m->sender_id === auth()->id(),
                'is_internal' => $m->is_internal,
                'time'        => $m->created_at->format('H:i'),
                'date'        => $m->created_at->isoFormat('D MMM'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    public function markRead(Wedding $wedding)
    {
        $wedding->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
