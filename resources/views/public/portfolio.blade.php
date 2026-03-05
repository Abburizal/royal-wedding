@extends('layouts.app')
@section('title', 'Portfolio — The Royal Wedding by Ully Sjah')
@section('description', 'Koleksi karya terbaik kami — ratusan pernikahan mewah yang telah kami wujudkan dengan sepenuh hati.')

@section('content')

{{-- Hero --}}
<section class="relative h-72 md:h-96 flex items-center justify-center bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80')] bg-cover bg-center opacity-40"></div>
    <div class="relative z-10 text-center text-white px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-3">✦ Karya Kami ✦</p>
        <h1 class="font-serif text-4xl md:text-6xl font-bold">Portfolio</h1>
        <p class="text-gray-300 mt-3 text-sm md:text-base max-w-xl mx-auto">Setiap pernikahan adalah sebuah mahakarya — inilah kisah-kisah yang sudah kami tulis bersama.</p>
    </div>
</section>

{{-- Featured --}}
@if($featured->isNotEmpty())
<section class="py-20 bg-ivory-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-2">Unggulan</p>
            <h2 class="font-serif text-3xl md:text-4xl text-gray-900">Featured Weddings</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $item)
            <a href="{{ route('portfolio.show', $item) }}"
               class="group relative overflow-hidden rounded-2xl shadow-card hover:shadow-luxury-lg transition-all hover:-translate-y-1 aspect-[3/4] block">
                <img src="{{ $item->cover_url }}" alt="{{ $item->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                    <p class="text-gold-400 text-xs uppercase tracking-widest mb-1">{{ $item->location }}</p>
                    <h3 class="font-serif text-xl font-bold">{{ $item->couple_names }}</h3>
                    <p class="text-gray-300 text-sm italic mt-0.5">{{ $item->title }}</p>
                    @if($item->wedding_date)
                    <p class="text-xs text-gray-400 mt-1">{{ $item->wedding_date->isoFormat('D MMMM Y') }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- All Portfolios --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-serif text-3xl text-gray-900">Semua Karya</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolios as $item)
            <a href="{{ route('portfolio.show', $item) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-luxury transition-all hover:-translate-y-1 border border-gray-100">
                <div class="aspect-video overflow-hidden">
                    <img src="{{ $item->cover_url }}" alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5">
                    <p class="text-gold-500 text-xs uppercase tracking-widest mb-1">{{ $item->location }}</p>
                    <h3 class="font-serif text-lg text-gray-900 font-semibold">{{ $item->couple_names }}</h3>
                    <p class="text-gray-500 text-sm italic">{{ $item->title }}</p>
                    @if($item->description)
                    <p class="text-gray-400 text-xs mt-2 line-clamp-2">{{ $item->description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        @if($portfolios->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $portfolios->links() }}
        </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-gray-900 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-4">Selanjutnya, Giliran Anda</p>
        <h2 class="font-serif text-3xl md:text-4xl text-white mb-6">Jadikan Pernikahan Anda <span class="text-gold-400 italic">Karya Berikutnya</span></h2>
        <a href="{{ route('booking.create') }}"
           class="inline-block bg-gold-500 hover:bg-gold-400 text-white px-10 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:-translate-y-0.5">
            Konsultasi Gratis ✦
        </a>
    </div>
</section>

@endsection
