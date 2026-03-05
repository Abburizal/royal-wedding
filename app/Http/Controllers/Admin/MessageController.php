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

        $wedding->messages()->create([
            'sender_id'   => auth()->id(),
            'message'     => $request->message,
            'is_internal' => $request->boolean('is_internal'),
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }

    public function markRead(Wedding $wedding)
    {
        // Mark all messages from client as read
        $wedding->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
