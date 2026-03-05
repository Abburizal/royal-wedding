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
        <div class="grid md:grid-cols-2 gap-10 lg:gap-16">

            {{-- Owner 1: Dr. Arifin Amiruddin --}}
            <div class="flex flex-col items-center text-center">
                <div class="relative mb-6">
                    <div class="w-44 h-44 rounded-full overflow-hidden ring-4 ring-gold-500 ring-offset-4 ring-offset-gray-900">
                        <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?w=400&q=80"
                             alt="Dr. Arifin Amiruddin" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gold-500 text-white rounded-full px-4 py-1 shadow-luxury whitespace-nowrap">
                        <p class="text-[10px] font-bold uppercase tracking-wider">Co-Founder</p>
                    </div>
                </div>
                <p class="text-gold-400 text-[10px] uppercase tracking-[0.3em] mb-2 mt-2">✦ Owner & Director ✦</p>
                <h2 class="font-serif text-3xl text-white font-bold mb-3">Dr. Arifin Amiruddin</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-5">
                    Visioner di balik konsep luxury wedding Indonesia. Dengan latar belakang manajemen bisnis dan passion mendalam terhadap seni, beliau membangun pondasi The Royal Wedding sebagai standar tertinggi industri pernikahan premium.
                </p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Business Strategy</span>
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Luxury Concepts</span>
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Brand Vision</span>
                </div>
            </div>

            {{-- Owner 2: Ully Sjah --}}
            <div class="flex flex-col items-center text-center">
                <div class="relative mb-6">
                    <div class="w-44 h-44 rounded-full overflow-hidden ring-4 ring-gold-500 ring-offset-4 ring-offset-gray-900">
                        <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400&q=80"
                             alt="Ully Sjah" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gold-500 text-white rounded-full px-4 py-1 shadow-luxury whitespace-nowrap">
                        <p class="text-[10px] font-bold uppercase tracking-wider">8+ Tahun</p>
                    </div>
                </div>
                <p class="text-gold-400 text-[10px] uppercase tracking-[0.3em] mb-2 mt-2">✦ Wedding Planner & Founder ✦</p>
                <h2 class="font-serif text-3xl text-white font-bold mb-3">Ully Sjah</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-5">
                    Dengan lebih dari 8 tahun pengalaman di industri pernikahan premium Indonesia, Ully telah membantu lebih dari 500 pasangan mewujudkan hari paling istimewa dalam hidup mereka. Dari pernikahan intimate hingga grand ballroom 1000 tamu — setiap detail adalah prioritas.
                </p>
                <div class="flex flex-wrap justify-center gap-2">
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Wedding Planning</span>
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Event Design</span>
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Vendor Curation</span>
                    <span class="px-3 py-1 bg-gold-500/20 text-gold-400 rounded-full text-xs border border-gold-500/30">✦ Luxury Events</span>
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
