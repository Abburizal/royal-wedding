<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Wedding;
use App\Models\User;
use App\Models\Package;
use App\Services\WeddingService;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    public function __construct(protected WeddingService $weddingService) {}

    public function index()
    {
        $weddings = Wedding::with(['client', 'planner', 'package'])->latest()->paginate(15);
        return view('admin.weddings.index', compact('weddings'));
    }

    public function create()
    {
        $clients  = User::where('role', 'client')->where('is_active', true)->get();
        $planners = User::where('role', 'wedding_planner')->where('is_active', true)->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.weddings.create', compact('clients', 'planners', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'        => 'required|exists:users,id',
            'planner_id'       => 'nullable|exists:users,id',
            'package_id'       => 'required|exists:packages,id',
            'groom_name'       => 'required|string|max:100',
            'bride_name'       => 'required|string|max:100',
            'wedding_date'     => 'required|date|after:today',
            'venue_name'       => 'nullable|string|max:200',
            'venue_address'    => 'nullable|string',
            'venue_city'       => 'nullable|string|max:100',
            'estimated_guests' => 'nullable|integer|min:0',
            'total_price'      => 'required|numeric|min:0',
            'special_notes'    => 'nullable|string',
        ]);

        $validated['status'] = 'confirmed';
        $wedding = $this->weddingService->create($validated);
        ActivityLog::record('created', 'Membuat wedding baru: ' . $wedding->couple_name, $wedding);

        return redirect()->route('admin.weddings.show', $wedding)->with('success', 'Wedding berhasil dibuat!');
    }

    public function show(Wedding $wedding)
    {
        $wedding->load(['client', 'planner', 'package.items', 'payments', 'checklistTasks', 'vendorAssignments.vendor', 'milestones', 'notes.author', 'messages.sender', 'contracts']);
        $availableVendors = \App\Models\Vendor::orderBy('name')->get();
        return view('admin.weddings.show', compact('wedding', 'availableVendors'));
    }

    public function edit(Wedding $wedding)
    {
        $clients  = User::where('role', 'client')->get();
        $planners = User::where('role', 'wedding_planner')->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.weddings.edit', compact('wedding', 'clients', 'planners', 'packages'));
    }

    public function update(Request $request, Wedding $wedding)
    {
        $validated = $request->validate([
            'status'           => 'required|in:inquired,confirmed,in_progress,completed,cancelled',
            'planner_id'       => 'nullable|exists:users,id',
            'groom_name'       => 'required|string|max:100',
            'bride_name'       => 'required|string|max:100',
            'wedding_date'     => 'required|date',
            'venue_name'       => 'nullable|string|max:200',
            'venue_address'    => 'nullable|string',
            'venue_city'       => 'nullable|string|max:100',
            'special_notes'    => 'nullable|string',
            'estimated_guests' => 'nullable|integer|min:0',
        ]);

        $wedding->update($validated);
        ActivityLog::record('updated', 'Memperbarui data wedding: ' . $wedding->couple_name, $wedding);
        return redirect()->route('admin.weddings.show', $wedding)->with('success', 'Data wedding diperbarui.');
    }

    public function destroy(Wedding $wedding)
    {
        $wedding->delete();
        return redirect()->route('admin.weddings.index')->with('success', 'Wedding dihapus.');
    }

    public function assignPlanner(Request $request, Wedding $wedding)
    {
        $request->validate(['planner_id' => 'required|exists:users,id']);
        $wedding->update(['planner_id' => $request->planner_id]);
        return back()->with('success', 'Planner berhasil di-assign.');
    }
}
