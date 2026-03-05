<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Portfolio;

class AboutController extends Controller
{
    public function index()
    {
        $stats = [
            'weddings'    => Portfolio::count() . '+',
            'years'       => '8+',
            'satisfaction'=> '98%',
            'vendors'     => '50+',
        ];
        $testimonials = Testimonial::where('is_published', true)->orderBy('sort_order')->limit(3)->get();
        return view('public.about', compact('stats', 'testimonials'));
    }
}
