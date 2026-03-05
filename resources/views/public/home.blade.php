@extends('layouts.app')
@section('title', 'The Royal Wedding by Ully Sjah — Luxury Wedding Organizer')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">
    {{-- Background overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900/70 via-gray-900/50 to-gray-900/80 z-10"></div>
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80')] bg-cover bg-center"></div>

    {{-- Decorative gold lines --}}
    <div class="absolute inset-0 z-10 opacity-10">
        <div class="absolute top-1/4 left-0 right-0 h-px bg-gold-400"></div>
        <div class="absolute bottom-1/4 left-0 right-0 h-px bg-gold-400"></div>
    </div>

    {{-- Hero Logo (top-left branding) --}}
    <div style="position:absolute; top:80px; left:32px; z-index:20; display:flex; flex-direction:column; align-items:center; gap:8px; opacity:0.85;">
        <picture>
            <source srcset="/images/logo.webp" type="image/webp">
            <img src="/images/logo.png"
                 alt="The Royal Wedding by Ully Sjah"
                 style="width:88px; height:88px; object-fit:cover; object-position:center top; border-radius:50%; box-shadow:0 0 0 1px rgba(212,175,55,0.5), 0 4px 20px rgba(0,0,0,0.4);"
                 loading="eager">
        </picture>
        <div style="text-align:center; line-height:1.3;">
            <p style="font-family:'Playfair Display',serif; font-size:11px; font-weight:600; color:#d4af37; letter-spacing:0.08em;">The Royal Wedding</p>
            <p style="font-size:9px; color:rgba(212,175,55,0.7); letter-spacing:0.2em; text-transform:uppercase;">by Ully Sjah</p>
        </div>
    </div>

    <div class="relative z-20 text-center text-white px-4 max-w-4xl mx-auto">
        <p class="text-gold-400 text-sm uppercase tracking-[0.4em] mb-6 font-light">✦ Luxury Wedding Organizer ✦</p>

        <h1 class="font-serif text-5xl md:text-7xl font-bold leading-tight mb-6">
            Pernikahan <span class="text-gold-400 italic">Impian</span><br>
            Anda Dimulai Di Sini
        </h1>

        <p class="text-gray-300 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed font-light">
            Kami menghadirkan pengalaman pernikahan yang tak terlupakan — elegan, personal, dan sempurna dalam setiap detail.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking.create') }}"
               class="bg-gold-500 hover:bg-gold-400 text-white px-10 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:shadow-2xl hover:-translate-y-0.5">
                Konsultasi Gratis
            </a>
            <a href="{{ route('packages.index') }}"
               class="border border-white/40 hover:border-gold-400 text-white hover:text-gold-400 px-10 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all backdrop-blur-sm">
                Lihat Paket
            </a>
        </div>

        {{-- Stats --}}
        <div class="flex justify-center gap-12 mt-16 pt-12 border-t border-white/10">
            <div class="text-center">
                <p class="font-serif text-4xl text-gold-400 font-bold">500+</p>
                <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Pernikahan</p>
            </div>
            <div class="text-center">
                <p class="font-serif text-4xl text-gold-400 font-bold">8+</p>
                <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Tahun Pengalaman</p>
            </div>
            <div class="text-center">
                <p class="font-serif text-4xl text-gold-400 font-bold">98%</p>
                <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Kepuasan Klien</p>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
        <div class="w-0.5 h-12 bg-gold-400/60 mx-auto"></div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     WHY US SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-ivory-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-3">Mengapa Kami</p>
            <h2 class="font-serif text-4xl md:text-5xl text-gray-900">Standar Kemewahan<br><span class="text-gold-500">Tak Tertandingi</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon' => '👑', 'title' => 'Tim Profesional', 'desc' => 'Wedding planner berpengalaman dengan portofolio ratusan pernikahan mewah di seluruh Indonesia.'],
                ['icon' => '✨', 'title' => 'Detail Sempurna', 'desc' => 'Setiap elemen direncanakan dan dieksekusi dengan presisi — dari dekorasi hingga katering dan dokumentasi.'],
                ['icon' => '💎', 'title' => 'Vendor Terpilih', 'desc' => 'Jaringan vendor premium eksklusif yang telah melewati seleksi ketat standar kualitas kami.'],
            ] as $item)
            <div class="bg-white rounded-2xl p-8 shadow-card hover:shadow-luxury transition-shadow text-center">
                <div class="text-5xl mb-5">{{ $item['icon'] }}</div>
                <h3 class="font-serif text-xl text-gray-900 mb-3">{{ $item['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PACKAGES PREVIEW
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-ivory-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-3">Paket Kami</p>
            <h2 class="font-serif text-4xl md:text-5xl text-gray-900">Pilih Paket <span class="text-gold-500 italic">Sempurna</span> Anda</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($packages as $package)
            <div class="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-luxury-lg transition-all hover:-translate-y-1 {{ $package->tier === 'royal' ? 'ring-2 ring-gold-400' : '' }}">
                @if($package->tier === 'royal')
                <div class="bg-gold-500 text-white text-xs font-semibold uppercase tracking-widest text-center py-2">✦ Most Popular ✦</div>
                @endif
                <div class="p-8">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $package->tier_badge_color }} mb-4">
                        {{ ucfirst($package->tier) }}
                    </span>
                    <h3 class="font-serif text-2xl text-gray-900 mb-2">{{ $package->name }}</h3>
                    <p class="font-serif text-3xl text-gold-500 font-bold mb-4">{{ $package->formatted_price }}</p>
                    <p class="text-gray-500 text-sm mb-6">{{ $package->description }}</p>
                    <p class="text-xs text-gray-400 mb-6">👥 Hingga {{ number_format($package->guest_capacity) }} tamu</p>
                    <a href="{{ route('packages.show', $package->slug) }}"
                       class="block text-center bg-gray-900 hover:bg-gold-500 text-white py-3 rounded-xl text-sm font-semibold transition-all">
                        Lihat Detail →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('packages.index') }}" class="text-gold-600 hover:text-gold-700 text-sm font-semibold">
                Bandingkan semua paket →
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PORTFOLIO PREVIEW
═══════════════════════════════════════════════════════════════ --}}
@if($featured->isNotEmpty())
<section class="py-24 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-3">Karya Terbaik Kami</p>
            <h2 class="font-serif text-4xl md:text-5xl text-white">Real <span class="text-gold-400 italic">Weddings</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($featured as $i => $item)
            <a href="{{ route('portfolio.show', $item) }}"
               class="group relative overflow-hidden rounded-2xl {{ $i === 0 ? 'md:row-span-2 aspect-[3/4]' : 'aspect-video' }} block">
                <img src="{{ $item->cover_url }}" alt="{{ $item->couple_names }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-5 text-white">
                    <p class="font-serif text-lg font-bold">{{ $item->couple_names }}</p>
                    <p class="text-gold-400 text-xs">{{ $item->location }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('portfolio.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold border border-gold-400/40 hover:border-gold-400 px-6 py-2.5 rounded-full transition-all">
                Lihat Semua Portfolio →
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIALS PREVIEW
═══════════════════════════════════════════════════════════════ --}}
@if($testimonials->isNotEmpty())
<section class="py-24 bg-ivory-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-3">Kata Mereka</p>
            <h2 class="font-serif text-4xl md:text-5xl text-gray-900">Kebahagiaan <span class="text-gold-500 italic">Nyata</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-luxury transition-shadow">
                <p class="text-gold-400 text-xl mb-3">{{ $t->stars }}</p>
                <p class="text-gray-600 text-sm italic leading-relaxed">"{{ Str::limit($t->content, 160) }}"</p>
                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-100">
                    <img src="{{ $t->photo_url }}" alt="{{ $t->client_name }}"
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-gold-200">
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

{{-- ═══════════════════════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-gray-900 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full bg-gold-400 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 rounded-full bg-gold-400 blur-3xl"></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4">
        <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-4">Mulai Sekarang</p>
        <h2 class="font-serif text-4xl md:text-5xl mb-6">Wujudkan Hari Istimewa <br><span class="text-gold-400 italic">Bersama Kami</span></h2>
        <p class="text-gray-400 mb-10">Konsultasi gratis, tanpa komitmen. Tim kami siap membantu merencanakan pernikahan impian Anda.</p>
        <a href="{{ route('booking.create') }}"
           class="inline-block bg-gold-500 hover:bg-gold-400 text-white px-12 py-4 rounded-full text-sm font-semibold uppercase tracking-widest transition-all shadow-luxury-lg hover:-translate-y-0.5">
            Mulai Konsultasi Gratis ✦
        </a>
    </div>
</section>

@endsection
