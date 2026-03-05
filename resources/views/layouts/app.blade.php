<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Royal Wedding by Ully Sjah — Luxury Wedding Organizer')</title>
    <meta name="description" content="@yield('description', 'The Royal Wedding by Ully Sjah — Luxury Wedding Organizer. Mewujudkan pernikahan impian Anda dengan sentuhan keanggunan tak tertandingi.')">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon-180.png">
    <meta name="theme-color" content="#1a1f2e">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'The Royal Wedding by Ully Sjah')">
    <meta property="og:description" content="@yield('description', 'Luxury Wedding Organizer Indonesia')">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Preload logo for LCP optimization --}}
    <link rel="preload" as="image" href="/images/logo.webp" type="image/webp">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ivory-100 text-gray-800 font-sans antialiased">

    {{-- NAVBAR --}}
    <nav class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gold-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}"
                   class="site-logo-link flex items-center gap-2.5"
                   aria-label="The Royal Wedding by Ully Sjah — Halaman Utama">
                    <div class="leading-tight">
                        <p class="font-serif text-sm font-bold text-gold-700 tracking-wide">The Royal Wedding</p>
                        <p class="text-[10px] text-gold-500 tracking-widest uppercase">by Ully Sjah</p>
                    </div>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Beranda</a>
                    <a href="{{ route('portfolio.index') }}" class="text-sm {{ request()->routeIs('portfolio*') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Portfolio</a>
                    <a href="{{ route('packages.index') }}" class="text-sm {{ request()->routeIs('packages*') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Paket</a>
                    <a href="{{ route('vendors.index') }}" class="text-sm {{ request()->routeIs('vendors*') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Vendor</a>
                    <a href="{{ route('testimonials.index') }}" class="text-sm {{ request()->routeIs('testimonials*') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Testimoni</a>
                    <a href="{{ route('about') }}" class="text-sm {{ request()->routeIs('about') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Tentang</a>
                    <a href="{{ route('booking.create') }}" class="text-sm {{ request()->routeIs('booking*') ? 'text-gold-600 font-semibold' : 'text-gray-600 hover:text-gold-600' }} transition-colors">Konsultasi</a>
                </div>

                {{-- Auth (desktop only) --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route(auth()->user()->getDashboardRoute()) }}"
                           class="text-sm text-gold-600 font-medium hover:text-gold-700 transition-colors">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-gray-500 hover:text-red-500 transition-colors">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gold-600 transition-colors">Masuk</a>
                        <a href="{{ route('booking.create') }}"
                           class="bg-gold-500 hover:bg-gold-600 text-white text-sm px-5 py-2 rounded-full font-medium transition-all shadow-luxury hover:shadow-luxury-lg">
                            Konsultasi Gratis
                        </a>
                    @endauth
                </div>
                {{-- Mobile hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden flex flex-col gap-1.5 p-2"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <span class="w-5 h-0.5 bg-gray-600 block transition"></span>
                    <span class="w-5 h-0.5 bg-gray-600 block transition"></span>
                    <span class="w-5 h-0.5 bg-gray-600 block transition"></span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gold-100 bg-white/95 backdrop-blur-sm">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('home') ? 'text-gold-600 font-semibold bg-gold-50' : 'text-gray-600 hover:bg-gray-50' }}">Beranda</a>
                <a href="{{ route('portfolio.index') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('portfolio*') ? 'text-gold-600 font-semibold bg-gold-50' : 'text-gray-600 hover:bg-gray-50' }}">Portfolio</a>
                <a href="{{ route('packages.index') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('packages*') ? 'text-gold-600 font-semibold bg-gold-50' : 'text-gray-600 hover:bg-gray-50' }}">Paket</a>
                <a href="{{ route('testimonials.index') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('testimonials*') ? 'text-gold-600 font-semibold bg-gold-50' : 'text-gray-600 hover:bg-gray-50' }}">Testimoni</a>
                <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('about') ? 'text-gold-600 font-semibold bg-gold-50' : 'text-gray-600 hover:bg-gray-50' }}">Tentang</a>
                <a href="{{ route('booking.create') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-gold-600 hover:bg-gold-50">Konsultasi Gratis →</a>
                @auth
                    <div class="pt-2 border-t border-gray-100 flex gap-3">
                        <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="flex-1 text-center py-2 bg-gold-500 text-white rounded-xl text-sm font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button class="w-full py-2 bg-gray-100 text-gray-600 rounded-xl text-sm">Keluar</button>
                        </form>
                    </div>
                @else
                    <div class="pt-2 border-t border-gray-100">
                        <a href="{{ route('login') }}" class="block text-center py-2 bg-gray-100 text-gray-700 rounded-xl text-sm">Masuk</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="pt-16">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 py-16 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <a href="{{ route('home') }}"
                       class="site-logo-link inline-flex items-center gap-3 mb-4"
                       aria-label="The Royal Wedding by Ully Sjah">
                        <picture>
                            <source srcset="/images/logo.webp" type="image/webp">
                            <img src="/images/logo.png"
                                 alt=""
                                 width="64" height="64"
                                 loading="lazy"
                                 class="site-logo-footer flex-shrink-0 ring-2 ring-gold-700">
                        </picture>
                        <div class="leading-tight">
                            <p class="font-serif text-lg text-gold-400">The Royal Wedding</p>
                            <p class="text-xs text-gold-600 tracking-widest uppercase">by Ully Sjah</p>
                        </div>
                    </a>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Mewujudkan setiap detail pernikahan impian Anda dengan keanggunan, presisi, dan sentuhan mewah tak tertandingi.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Halaman</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('portfolio.index') }}" class="hover:text-gold-400 transition-colors">Portfolio</a></li>
                        <li><a href="{{ route('packages.index') }}" class="hover:text-gold-400 transition-colors">Paket Pernikahan</a></li>
                        <li><a href="{{ route('testimonials.index') }}" class="hover:text-gold-400 transition-colors">Testimoni Klien</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-gold-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('booking.create') }}" class="hover:text-gold-400 transition-colors">Konsultasi Gratis</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm">
                        <li>📞 +62 812-3456-7890</li>
                        <li>📧 info@theroyalwedding.id</li>
                        <li>📍 Jakarta, Indonesia</li>
                    </ul>
                    <a href="https://wa.me/6281234567890"
                       class="inline-flex items-center gap-2 mt-4 bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                        💬 WhatsApp
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-12 pt-6 text-center text-xs text-gray-500">
                © {{ date('Y') }} The Royal Wedding by Ully Sjah. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
