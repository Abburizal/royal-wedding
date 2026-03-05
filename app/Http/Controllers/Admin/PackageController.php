<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::withCount('weddings')->orderBy('sort_order')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'tier'           => 'required|in:silver,gold,royal',
            'price'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'guest_capacity' => 'required|integer|min:0',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
            'items'          => 'nullable|array',
            'items.*.item_name' => 'required_with:items|string|max:200',
            'items.*.category'  => 'nullable|string|max:100',
            'items.*.quantity'  => 'nullable|integer|min:1',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $items = $validated['items'] ?? [];
        unset($validated['items']);

        $package = Package::create($validated);

        foreach ($items as $i => $item) {
            if (!empty($item['item_name'])) {
                PackageItem::create([
                    'package_id' => $package->id,
                    'item_name'  => $item['item_name'],
                    'category'   => $item['category'] ?? 'Umum',
                    'quantity'   => $item['quantity'] ?? 1,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.packages.show', $package)->with('success', 'Paket berhasil dibuat!');
    }

    public function show(Package $package)
    {
        $package->load('items');
        $package->loadCount('weddings');
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $package->load('items');
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'tier'           => 'required|in:silver,gold,royal',
            'price'          => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'guest_capacity' => 'required|integer|min:0',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $package->sort_order;

        $package->update($validated);

        return redirect()->route('admin.packages.show', $package)->with('success', 'Paket diperbarui.');
    }

    public function destroy(Package $package)
    {
        if ($package->weddings()->exists()) {
            return back()->with('error', 'Paket tidak bisa dihapus karena sudah digunakan oleh wedding.');
        }
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket dihapus.');
    }
}
