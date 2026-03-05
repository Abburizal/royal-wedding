@extends('layouts.app')
@section('title', 'Testimoni Klien — The Royal Wedding by Ully Sjah')
@section('description', 'Kata mereka tentang pengalaman pernikahan bersama The Royal Wedding by Ully Sjah.')

@section('content')

{{-- Hero --}}
<section class="relative h-56 md:h-72 flex items-center justify-center bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1920&q=80')] bg-cover bg-center opacity-30"></div>
    <div class="relative z-10 text-center text-white px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-3">✦ Kata Mereka ✦</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold">Testimoni Klien</h1>
        <p class="text-gray-300 mt-3 text-sm max-w-lg mx-auto">Kebahagiaan klien adalah kebanggaan kami.</p>
    </div>
</section>

{{-- Testimonials Grid --}}
<section class="py-20 bg-ivory-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Summary stats --}}
        <div class="grid grid-cols-3 gap-6 mb-16 text-center">
            @foreach([
                ['value' => '500+', 'label' => 'Pasangan Bahagia'],
                ['value' => '98%', 'label' => 'Kepuasan Klien'],
                ['value' => '★★★★★', 'label' => 'Rating Rata-rata'],
            ] as $s)
            <div class="bg-white rounded-2xl p-6 shadow-card">
                <p class="font-serif text-3xl text-gold-500 font-bold">{{ $s['value'] }}</p>
                <p class="text-gray-500 text-sm mt-1">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($testimonials as $t)
            <div class="bg-white rounded-2xl p-6 shadow-card border border-gray-100 flex flex-col">
                {{-- Stars --}}
                <p class="text-gold-400 text-lg mb-3">{{ $t->stars }}</p>

                {{-- Quote --}}
                <p class="text-gray-700 text-sm leading-relaxed flex-1 italic">"{{ $t->content }}"</p>

                {{-- Author --}}
                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-100">
                    <img src="{{ $t->photo_url }}" alt="{{ $t->client_name }}"
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-gold-200">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $t->client_name }}</p>
                        @if($t->couple_names)
                        <p class="text-xs text-gold-500">{{ $t->couple_names }}</p>
                        @endif
                        @if($t->wedding_date)
                        <p class="text-xs text-gray-400">{{ $t->wedding_date->isoFormat('MMM Y') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-400 py-12">Belum ada testimoni.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-gray-900 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-4">Giliran Anda</p>
        <h2 class="font-serif text-3xl md:text-4xl text-white mb-6">Tuliskan Kisah <span class="text-gold-400 italic">Bahagia Anda</span> Bersama Kami</h2>
        <a href="{{ route('booking.create') }}"
           class="inline-block bg-gold-500 hover:bg-gold-400 text-white px-10 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:-translate-y-0.5">
            Mulai Konsultasi ✦
        </a>
    </div>
</section>

@endsection
