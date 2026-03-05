<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Package;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $packages = Package::where('is_active', true)->orderBy('sort_order')->get();
        $selectedPackage = $request->package ? Package::where('slug', $request->package)->first() : null;
        return view('public.booking', compact('packages', 'selectedPackage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
            'event_date' => 'nullable|date|after:today',
            'message'    => 'nullable|string|max:1000',
        ]);

        $consultation = Consultation::create($validated);

        // Notify all admins
        \App\Models\User::whereIn('role', ['super_admin', 'wedding_planner'])
            ->each(fn ($admin) => $admin->notify(new \App\Notifications\NewConsultationNotification($consultation)));

        return redirect()->route('booking.create')->with('success', 'Terima kasih! Tim kami akan menghubungi Anda dalam 1×24 jam.');
    }
}
