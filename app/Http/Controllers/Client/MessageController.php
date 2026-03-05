<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $wedding = auth()->user()->activeWedding;
        if (!$wedding) return back()->with('error', 'Wedding tidak ditemukan.');

        $wedding->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        // Mark admin messages as read when client replies
        $wedding->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update(['read_at' => now()]);

        return back()->with('success', 'Pesan terkirim.');
    }
}
