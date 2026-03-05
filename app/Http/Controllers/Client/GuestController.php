<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    private function wedding()
    {
        return Auth::user()->weddings()->latest()->firstOrFail();
    }

    public function index()
    {
        $wedding = $this->wedding();
        $guests  = $wedding->guests()->orderBy('category')->orderBy('name')->get();

        $stats = [
            'total'     => $guests->sum('pax'),
            'confirmed' => $guests->where('rsvp_status', 'confirmed')->sum('pax'),
            'declined'  => $guests->where('rsvp_status', 'declined')->sum('pax'),
            'attended'  => $guests->where('rsvp_status', 'attended')->sum('pax'),
            'pending'   => $guests->where('rsvp_status', 'pending')->sum('pax'),
        ];

        return view('client.guests', compact('wedding', 'guests', 'stats'));
    }

    public function store(Request $request)
    {
        $wedding = $this->wedding();

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:100',
            'category' => 'required|in:keluarga,sahabat,kolega,umum',
            'side'     => 'required|in:groom,bride,both',
            'pax'      => 'required|integer|min:1|max:10',
            'table_no' => 'nullable|string|max:20',
            'notes'    => 'nullable|string|max:500',
        ]);

        $validated['wedding_id']        = $wedding->id;
        $validated['invitation_token']  = Guest::generateToken();

        Guest::create($validated);

        return back()->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function update(Request $request, Guest $guest)
    {
        abort_unless($guest->wedding->client_id === Auth::id(), 403);

        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:100',
            'category'   => 'required|in:keluarga,sahabat,kolega,umum',
            'side'       => 'required|in:groom,bride,both',
            'pax'        => 'required|integer|min:1|max:10',
            'table_no'   => 'nullable|string|max:20',
            'rsvp_status'=> 'required|in:pending,confirmed,declined,attended',
            'notes'      => 'nullable|string|max:500',
        ]);

        $guest->update($validated);

        return back()->with('success', 'Data tamu diperbarui.');
    }

    public function destroy(Guest $guest)
    {
        abort_unless($guest->wedding->client_id === Auth::id(), 403);
        $guest->delete();
        return back()->with('success', 'Tamu dihapus.');
    }

    /** Public RSVP confirmation page */
    public function rsvpShow(string $token)
    {
        $guest = Guest::where('invitation_token', $token)->firstOrFail();
        return view('public.rsvp', compact('guest'));
    }

    public function rsvpSubmit(Request $request, string $token)
    {
        $guest = Guest::where('invitation_token', $token)->firstOrFail();

        $request->validate(['status' => 'required|in:confirmed,declined']);

        $guest->update([
            'rsvp_status'        => $request->status,
            'rsvp_responded_at'  => now(),
        ]);

        return view('public.rsvp-thankyou', compact('guest'));
    }
}
