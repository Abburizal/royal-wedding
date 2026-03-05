<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $featured   = Portfolio::where('is_featured', true)->orderBy('sort_order')->get();
        $portfolios = Portfolio::orderBy('sort_order')->paginate(9);
        return view('public.portfolio', compact('featured', 'portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        $others = Portfolio::where('id', '!=', $portfolio->id)->latest()->limit(3)->get();
        return view('public.portfolio-show', compact('portfolio', 'others'));
    }
}
