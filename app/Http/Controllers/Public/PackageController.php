<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->with('items')->orderBy('sort_order')->get();
        return view('public.packages.index', compact('packages'));
    }

    public function show(string $slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->with('items')->firstOrFail();
        return view('public.packages.show', compact('package'));
    }
}
