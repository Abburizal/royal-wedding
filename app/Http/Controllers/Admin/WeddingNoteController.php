<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Wedding;
use App\Models\WeddingNote;
use Illuminate\Http\Request;

class WeddingNoteController extends Controller
{
    public function store(Request $request, Wedding $wedding)
    {
        $request->validate(['content' => 'required|string|max:2000']);

        $wedding->notes()->create([
            'user_id'    => auth()->id(),
            'content'    => $request->content,
            'is_private' => true,
        ]);

        ActivityLog::record('created', 'Menambah catatan internal untuk wedding ' . $wedding->couple_name, $wedding);

        return back()->with('note_success', 'Catatan berhasil disimpan.');
    }

    public function destroy(Wedding $wedding, WeddingNote $note)
    {
        abort_unless($note->wedding_id === $wedding->id, 403);

        $note->delete();
        ActivityLog::record('deleted', 'Menghapus catatan internal wedding ' . $wedding->couple_name, $wedding);

        return back()->with('note_success', 'Catatan dihapus.');
    }
}
