<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name'  => 'required|string|max:200',
            'couple_names' => 'nullable|string|max:200',
            'wedding_date' => 'nullable|date',
            'content'      => 'required|string',
            'rating'       => 'required|integer|min:1|max:5',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
            'sort_order'   => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'client_name'  => 'required|string|max:200',
            'couple_names' => 'nullable|string|max:200',
            'wedding_date' => 'nullable|date',
            'content'      => 'required|string',
            'rating'       => 'required|integer|min:1|max:5',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
            'sort_order'   => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');
        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
            Storage::disk('public')->delete($testimonial->photo);
        }
        $testimonial->delete();
        return back()->with('success', 'Testimoni dihapus.');
    }
}
