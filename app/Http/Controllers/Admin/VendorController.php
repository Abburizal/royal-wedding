<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::withCount('vendorAssignments')->latest()->paginate(20);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:200',
            'category'      => 'required|in:catering,decoration,mua,documentation,entertainment,venue,other',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:200',
            'address'       => 'nullable|string',
            'portfolio_url' => 'nullable|url|max:500',
            'description'   => 'nullable|string',
            'base_price'    => 'nullable|numeric|min:0',
            'is_active'     => 'boolean',
        ]);

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['base_price'] = $validated['base_price'] ?? 0;

        $vendor = Vendor::create($validated);

        return redirect()->route('admin.vendors.show', $vendor)->with('success', 'Vendor berhasil ditambahkan!');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('vendorAssignments.wedding.client');
        return view('admin.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:200',
            'category'      => 'required|in:catering,decoration,mua,documentation,entertainment,venue,other',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:200',
            'address'       => 'nullable|string',
            'portfolio_url' => 'nullable|url|max:500',
            'description'   => 'nullable|string',
            'base_price'    => 'nullable|numeric|min:0',
            'is_active'     => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $vendor->update($validated);

        return redirect()->route('admin.vendors.show', $vendor)->with('success', 'Data vendor diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        if ($vendor->vendorAssignments()->exists()) {
            return back()->with('error', 'Vendor tidak bisa dihapus karena sudah di-assign ke wedding.');
        }
        $vendor->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor dihapus.');
    }
}
