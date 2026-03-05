<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::with('package', 'handler')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $consultations = $query->paginate(20)->withQueryString();
        $stats = [
            'pending'   => Consultation::where('status', 'pending')->count(),
            'contacted' => Consultation::where('status', 'contacted')->count(),
            'converted' => Consultation::where('status', 'converted')->count(),
            'declined'  => Consultation::where('status', 'declined')->count(),
        ];

        return view('admin.consultations.index', compact('consultations', 'stats'));
    }

    public function show(Consultation $consultation)
    {
        return view('admin.consultations.show', compact('consultation'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pending,contacted,converted,declined',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $consultation->status;
        $validated['responded_at'] = now();
        $validated['handled_by']   = auth()->id();

        $consultation->update($validated);

        ActivityLog::record(
            'consultation_updated',
            "Konsultasi dari {$consultation->name} diubah status dari {$oldStatus} ke {$consultation->status}",
            $consultation
        );

        return back()->with('success', 'Status konsultasi diperbarui.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('admin.consultations.index')->with('success', 'Konsultasi dihapus.');
    }
}
