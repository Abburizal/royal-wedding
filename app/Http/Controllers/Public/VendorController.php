<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::withCount(['reviews as review_count'])
            ->withAvg(['reviews as avg_rating' => fn($q) => $q->where('is_published', true)], 'rating')
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $vendors    = $query->orderByDesc('avg_rating')->paginate(12)->withQueryString();
        $categories = Vendor::where('is_active', true)->distinct()->pluck('category');

        return view('public.vendors.index', compact('vendors', 'categories'));
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['reviews.user']);
        $reviews = $vendor->reviews()->with('user')->latest()->get();
        $avgRating  = round($reviews->avg('rating') ?? 0, 1);
        $ratingDist = $reviews->groupBy('rating')->map->count();

        $userReview = Auth::check()
            ? VendorReview::where('vendor_id', $vendor->id)->where('user_id', Auth::id())->first()
            : null;

        return view('public.vendors.show', compact('vendor', 'reviews', 'avgRating', 'ratingDist', 'userReview'));
    }

    public function storeReview(Request $request, Vendor $vendor)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'  => 'nullable|string|max:150',
            'review' => 'required|string|min:10|max:1000',
        ]);

        VendorReview::updateOrCreate(
            ['vendor_id' => $vendor->id, 'user_id' => Auth::id()],
            [
                'rating'     => $request->rating,
                'title'      => $request->title,
                'review'     => $request->review,
                'is_published' => false, // admin moderates
            ]
        );

        return back()->with('success', 'Review berhasil dikirim. Menunggu moderasi admin.');
    }
}
