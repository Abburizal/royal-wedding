@extends('layouts.app')
@section('title', $portfolio->couple_names . ' — Portfolio The Royal Wedding by Ully Sjah')

@section('content')

{{-- Hero / Cover --}}
<section class="relative h-[70vh] flex items-end justify-start overflow-hidden">
    <img src="{{ $portfolio->cover_url }}" alt="{{ $portfolio->title }}"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
    <div class="relative z-10 p-8 md:p-16 max-w-3xl">
        <a href="{{ route('portfolio.index') }}" class="text-gold-400 text-xs uppercase tracking-widest hover:text-gold-300 mb-4 inline-block">← Kembali ke Portfolio</a>
        <h1 class="font-serif text-4xl md:text-6xl text-white font-bold leading-tight">{{ $portfolio->couple_names }}</h1>
        <p class="text-gold-400 text-lg italic mt-2">{{ $portfolio->title }}</p>
        <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-300">
            @if($portfolio->location) <span>📍 {{ $portfolio->location }}</span> @endif
            @if($portfolio->wedding_date) <span>📅 {{ $portfolio->wedding_date->isoFormat('D MMMM Y') }}</span> @endif
        </div>
    </div>
</section>

{{-- Description + Details --}}
<section class="py-16 bg-ivory-100">
    <div class="max-w-4xl mx-auto px-4">
        @if($portfolio->description)
        <div class="text-center mb-12">
            <span class="text-gold-500 text-2xl">✦</span>
            <p class="font-serif text-xl md:text-2xl text-gray-700 leading-relaxed italic mt-4">"{{ $portfolio->description }}"</p>
        </div>
        @endif
        {{-- Detail cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            @if($portfolio->location)
            <div class="bg-white rounded-2xl p-5 shadow-card">
                <div class="text-2xl mb-2">📍</div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Lokasi</p>
                <p class="font-serif text-sm text-gray-800 font-semibold">{{ $portfolio->location }}</p>
            </div>
            @endif
            @if($portfolio->wedding_date)
            <div class="bg-white rounded-2xl p-5 shadow-card">
                <div class="text-2xl mb-2">📅</div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Tanggal</p>
                <p class="font-serif text-sm text-gray-800 font-semibold">{{ $portfolio->wedding_date->isoFormat('D MMM Y') }}</p>
            </div>
            @endif
            <div class="bg-white rounded-2xl p-5 shadow-card">
                <div class="text-2xl mb-2">✨</div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Tema</p>
                <p class="font-serif text-sm text-gray-800 font-semibold">{{ $portfolio->title }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-card">
                <div class="text-2xl mb-2">💐</div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Oleh</p>
                <p class="font-serif text-sm text-gold-600 font-semibold">The Royal Wedding</p>
            </div>
        </div>
    </div>
</section>

{{-- Gallery (if images exist) --}}
@if(!empty($portfolio->gallery_urls))
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-serif text-2xl text-gray-900 mb-8 text-center">Galeri Foto</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($portfolio->gallery_urls as $img)
            <div class="aspect-square overflow-hidden rounded-xl group">
                <img src="{{ $img }}" alt="Gallery"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Other Portfolios --}}
@if($others->isNotEmpty())
<section class="py-16 bg-ivory-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-serif text-2xl text-gray-900 mb-8">Karya Lainnya</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($others as $item)
            <a href="{{ route('portfolio.show', $item) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-luxury transition-all hover:-translate-y-1">
                <div class="aspect-video overflow-hidden">
                    <img src="{{ $item->cover_url }}" alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4">
                    <h3 class="font-serif text-gray-900 font-semibold">{{ $item->couple_names }}</h3>
                    <p class="text-gold-500 text-xs">{{ $item->title }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 bg-gray-900 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <h2 class="font-serif text-3xl text-white mb-6">Ingin Pernikahan Seindah Ini? <span class="text-gold-400">✦</span></h2>
        <a href="{{ route('booking.create') }}"
           class="inline-block bg-gold-500 hover:bg-gold-400 text-white px-10 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:-translate-y-0.5">
            Konsultasi Gratis
        </a>
    </div>
</section>

@endsection
