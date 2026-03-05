<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order')->get();
        return view('public.testimonials', compact('testimonials'));
    }
}
