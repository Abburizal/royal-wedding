<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — The Royal Wedding by Ully Sjah</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon-180.png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ivory-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ─────────────────────────────────────────────────── --}}
    <aside class="w-64 bg-white border-r border-gold-100 flex flex-col shadow-card flex-shrink-0">
        {{-- Logo --}}
        <div class="h-16 flex items-center px-4 border-b border-gold-100">
            <a href="{{ route('home') }}"
               class="site-logo-link flex items-center gap-2.5"
               aria-label="The Royal Wedding by Ully Sjah">
                <picture>
                    <source srcset="/images/logo.webp" type="image/webp">
                    <img src="/images/logo.png"
                         alt=""
                         width="32" height="32"
                         loading="eager"
                         class="site-logo-sidebar flex-shrink-0 ring-1 ring-gold-300">
                </picture>
                <div class="leading-tight">
                    <p class="font-serif text-xs font-bold text-gold-700 tracking-wide">The Royal Wedding</p>
                    <p class="text-[9px] text-gold-500 tracking-widest uppercase">by Ully Sjah</p>
                </div>
            </a>
        </div>

        {{-- User info --}}
        <div class="px-6 py-5 border-b border-gold-100 bg-gold-50">
            <p class="text-xs text-gold-600 uppercase tracking-widest font-medium mb-1">Selamat datang</p>
            <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</p>
            <span class="inline-block mt-1 px-2 py-0.5 bg-gold-100 text-gold-700 text-xs rounded-full capitalize">
                {{ str_replace('_', ' ', auth()->user()->role) }}
            </span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            @if(auth()->user()->isClient())
                @include('layouts.partials.sidebar-client')
            @else
                @include('layouts.partials.sidebar-admin')
            @endif
        </nav>

        {{-- Logout --}}
        <div class="px-4 py-4 border-t border-gold-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-500 w-full px-3 py-2 rounded-lg hover:bg-red-50 transition-colors">
                    ⬡ Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN AREA ────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top bar --}}
        <header class="h-16 bg-white border-b border-gold-100 flex items-center justify-between px-8 flex-shrink-0">
            <h1 class="font-serif text-xl text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>

                {{-- Notification Bell --}}
                @php $unreadNotifs = auth()->user()->unreadNotifications->take(5); @endphp
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="relative p-2 rounded-xl hover:bg-gray-50 transition text-gray-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadNotifs->count() > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                            {{ $unreadNotifs->count() > 9 ? '9+' : $unreadNotifs->count() }}
                        </span>
                        @endif
                    </button>

                    <div x-show="open" x-transition
                         class="absolute right-0 top-12 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                            <p class="font-semibold text-sm text-gray-700">Notifikasi</p>
                            @if($unreadNotifs->count() > 0)
                            <form method="POST" action="{{ route('admin.notifications.read-all') }}">
                                @csrf
                                <button class="text-xs text-gold-600 hover:underline">Tandai semua dibaca</button>
                            </form>
                            @endif
                        </div>
                        <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                            @forelse(auth()->user()->notifications->take(8) as $notif)
                            <a href="{{ $notif->data['url'] ?? '#' }}"
                               class="flex gap-3 px-4 py-3 hover:bg-gray-50 transition {{ $notif->read_at ? 'opacity-60' : '' }}">
                                <span class="text-xl mt-0.5">{{ $notif->data['icon'] ?? '🔔' }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-800">{{ $notif->data['title'] ?? '' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $notif->data['message'] ?? '' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                                @unless($notif->read_at)
                                <span class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                                @endunless
                            </a>
                            @empty
                            <p class="px-4 py-6 text-xs text-gray-400 text-center">Tidak ada notifikasi</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-8 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            ✓ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mx-8 mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            ✗ {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>
    </div>

</div>

</body>
</html>
