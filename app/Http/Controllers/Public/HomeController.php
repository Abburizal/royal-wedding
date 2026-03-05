<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Portfolio;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $packages     = Package::where('is_active', true)->orderBy('sort_order')->get();
        $featured     = Portfolio::where('is_featured', true)->orderBy('sort_order')->limit(3)->get();
        $testimonials = Testimonial::where('is_published', true)->orderBy('sort_order')->limit(3)->get();
        return view('public.home', compact('packages', 'featured', 'testimonials'));
    }
}
