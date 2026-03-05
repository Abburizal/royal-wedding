<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingMoodboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MoodboardController extends Controller
{
    public function index()
    {
        $wedding    = Auth::user()->weddings()->latest()->firstOrFail();
        $moodboards = $wedding->moodboards()->get()->groupBy('category');
        return view('client.moodboard', compact('wedding', 'moodboards'));
    }

    public function store(Request $request)
    {
        $wedding = Auth::user()->weddings()->latest()->firstOrFail();

        $request->validate([
            'title'    => 'required|string|max:100',
            'category' => 'required|string',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'notes'    => 'nullable|string|max:500',
        ]);

        $path = $request->file('image')->store('moodboards', 'public');

        $wedding->moodboards()->create([
            'title'      => $request->title,
            'category'   => $request->category,
            'image_path' => $path,
            'notes'      => $request->notes,
        ]);

        return back()->with('success', 'Inspirasi berhasil ditambahkan!');
    }

    public function destroy(WeddingMoodboard $moodboard)
    {
        abort_unless($moodboard->wedding->client_id === Auth::id(), 403);

        Storage::disk('public')->delete($moodboard->image_path);
        $moodboard->delete();

        return back()->with('success', 'Inspirasi dihapus.');
    }
}
