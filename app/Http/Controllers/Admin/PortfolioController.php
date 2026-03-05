<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('sort_order')->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'couple_names' => 'required|string|max:200',
            'wedding_date' => 'nullable|date',
            'location'     => 'nullable|string|max:200',
            'description'  => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_featured'  => 'boolean',
            'sort_order'   => 'integer',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        Portfolio::create($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'couple_names' => 'required|string|max:200',
            'wedding_date' => 'nullable|date',
            'location'     => 'nullable|string|max:200',
            'description'  => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_featured'  => 'boolean',
            'sort_order'   => 'integer',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($portfolio->cover_image && !str_starts_with($portfolio->cover_image, 'http')) {
                Storage::disk('public')->delete($portfolio->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $portfolio->update($data);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->cover_image && !str_starts_with($portfolio->cover_image, 'http')) {
            Storage::disk('public')->delete($portfolio->cover_image);
        }
        $portfolio->delete();
        return back()->with('success', 'Portfolio dihapus.');
    }
}
