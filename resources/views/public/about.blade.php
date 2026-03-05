@extends('layouts.app')
@section('title', 'Tentang Ully Sjah — The Royal Wedding by Ully Sjah')
@section('description', 'Kenali Ully Sjah — Wedding Planner terbaik dengan 8+ tahun pengalaman mewujudkan pernikahan impian di seluruh Indonesia.')

@section('content')

{{-- Hero --}}
<section class="relative py-24 bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920&q=80')] bg-cover bg-center opacity-25"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section label --}}
        <div class="text-center mb-16">
            <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-3">✦ The Founders ✦</p>
            <h1 class="font-serif text-4xl md:text-5xl text-white font-bold">Di Balik The Royal Wedding</h1>
        </div>

        {{-- Two owners --}}
        <div style="display:flex; flex-wrap:wrap; gap:48px; justify-content:center; max-width:900px; margin:0 auto;">

            {{-- Owner 1: Dr. Arifin Amiruddin --}}
            <div style="flex:1; min-width:280px; max-width:380px; display:flex; flex-direction:column; align-items:center; text-align:center;">
                <img src="/images/arifin.jpg"
                     alt="Dr. Arifin Amiruddin"
                     style="width:120px; height:120px; border-radius:50%; object-fit:cover; object-position:top; border:3px solid #C6A75E; margin-bottom:16px; flex-shrink:0;">
                <p style="color:#C6A75E; font-size:10px; letter-spacing:0.25em; text-transform:uppercase; margin-bottom:6px;">✦ Owner & Director ✦</p>
                <h2 class="font-serif" style="color:white; font-size:1.5rem; font-weight:700; margin-bottom:12px;">Dr. Arifin Amiruddin</h2>
                <p style="color:#d1d5db; font-size:0.875rem; line-height:1.6; margin-bottom:16px;">
                    Visioner di balik konsep luxury wedding Indonesia. Dengan latar belakang manajemen bisnis dan passion mendalam terhadap seni, beliau membangun pondasi The Royal Wedding sebagai standar tertinggi industri pernikahan premium.
                </p>
                <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:8px;">
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Business Strategy</span>
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Luxury Concepts</span>
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Brand Vision</span>
                </div>
            </div>

            {{-- Divider vertical --}}
            <div style="width:1px; background:rgba(255,255,255,0.1); align-self:stretch; display:none;" class="md-divider"></div>

            {{-- Owner 2: Ully Sjah --}}
            <div style="flex:1; min-width:280px; max-width:380px; display:flex; flex-direction:column; align-items:center; text-align:center;">
                <img src="/images/ully.jpg"
                     alt="Ully Sjah"
                     style="width:120px; height:120px; border-radius:50%; object-fit:cover; object-position:top; border:3px solid #C6A75E; margin-bottom:16px; flex-shrink:0;">
                <p style="color:#C6A75E; font-size:10px; letter-spacing:0.25em; text-transform:uppercase; margin-bottom:6px;">✦ Wedding Planner & Founder ✦</p>
                <h2 class="font-serif" style="color:white; font-size:1.5rem; font-weight:700; margin-bottom:12px;">Ully Sjah</h2>
                <p style="color:#d1d5db; font-size:0.875rem; line-height:1.6; margin-bottom:16px;">
                    Dengan lebih dari 8 tahun pengalaman di industri pernikahan premium Indonesia, Ully telah membantu lebih dari 500 pasangan mewujudkan hari paling istimewa dalam hidup mereka.
                </p>
                <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:8px;">
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Wedding Planning</span>
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Event Design</span>
                    <span style="padding:4px 12px; background:rgba(198,167,94,0.15); color:#C6A75E; border:1px solid rgba(198,167,94,0.3); border-radius:9999px; font-size:11px;">Luxury Events</span>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-16 bg-gold-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white">
            @foreach([
                ['value' => $stats['weddings'], 'label' => 'Pernikahan Sukses'],
                ['value' => $stats['years'],    'label' => 'Tahun Pengalaman'],
                ['value' => $stats['satisfaction'], 'label' => 'Tingkat Kepuasan'],
                ['value' => $stats['vendors'],  'label' => 'Vendor Terpercaya'],
            ] as $s)
            <div>
                <p class="font-serif text-5xl font-bold">{{ $s['value'] }}</p>
                <p class="text-gold-100 text-sm mt-1 uppercase tracking-wider">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Story --}}
<section class="py-24 bg-ivory-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-2">The Story</p>
            <h2 class="font-serif text-4xl text-gray-900">Mengapa Saya Mulai Ini Semua</h2>
        </div>
        <div class="prose prose-lg max-w-none text-gray-600 text-center">
            <p class="text-xl leading-relaxed font-serif italic text-gray-700">
                "Saya jatuh cinta dengan dunia pernikahan bukan karena glamornya — tapi karena saya menyaksikan langsung bagaimana satu hari yang direncanakan dengan baik bisa mengubah hidup dua keluarga selamanya."
            </p>
        </div>
        <div class="mt-10 grid md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => '💛', 'title' => 'Penuh Dedikasi', 'desc' => 'Saya tidak hanya merencanakan — saya hadir di setiap langkah, dari pertama konsultasi hingga detik terakhir resepsi.'],
                ['icon' => '🎯', 'title' => 'Presisi & Detail', 'desc' => 'Tidak ada yang "cukup baik". Setiap elemen harus sempurna, karena hari ini tidak bisa diulang.'],
                ['icon' => '🌹', 'title' => 'Personal Touch', 'desc' => 'Setiap pernikahan mencerminkan kepribadian unik pasangannya — bukan template yang sama untuk semua orang.'],
            ] as $v)
            <div class="bg-white rounded-2xl p-6 shadow-card text-center">
                <p class="text-4xl mb-3">{{ $v['icon'] }}</p>
                <h3 class="font-serif text-lg text-gray-900 mb-2">{{ $v['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials Preview --}}
@if($testimonials->isNotEmpty())
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-2">Kata Mereka</p>
            <h2 class="font-serif text-4xl text-gray-900">Kepercayaan Adalah Segalanya</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="bg-ivory-100 rounded-2xl p-6 border border-gold-100">
                <p class="text-gold-400 text-lg mb-3">{{ $t->stars }}</p>
                <p class="text-gray-600 text-sm italic leading-relaxed">"{{ Str::limit($t->content, 150) }}"</p>
                <div class="flex items-center gap-3 mt-4 pt-3 border-t border-gold-100">
                    <img src="{{ $t->photo_url }}" alt="{{ $t->client_name }}"
                         class="w-9 h-9 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $t->client_name }}</p>
                        @if($t->couple_names)<p class="text-xs text-gold-500">{{ $t->couple_names }}</p>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('testimonials.index') }}" class="text-gold-600 hover:text-gold-700 text-sm font-semibold">
                Lihat semua testimoni →
            </a>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-24 bg-gray-900 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-4">✦ Mari Berkenalan ✦</p>
        <h2 class="font-serif text-4xl text-white mb-4">Ceritakan Impian Pernikahan Anda</h2>
        <p class="text-gray-400 mb-8">Saya dengan senang hati mendengarkan setiap detail mimpi Anda dan membantu mewujudkannya.</p>
        <a href="{{ route('booking.create') }}"
           class="inline-block bg-gold-500 hover:bg-gold-400 text-white px-12 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:-translate-y-0.5">
            Konsultasi dengan Ully ✦
        </a>
    </div>
</section>

@endsection
