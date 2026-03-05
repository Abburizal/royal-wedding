@extends('layouts.app')
@section('title', 'Paket Pernikahan — The Royal Wedding by Ully Sjah')

@section('content')
<section class="py-20 bg-ivory-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-3">Pilihan Eksklusif</p>
            <h1 class="font-serif text-5xl text-gray-900 mb-4">Paket Pernikahan</h1>
            <p class="text-gray-500 max-w-xl mx-auto">Setiap paket dirancang untuk memenuhi kebutuhan Anda yang berbeda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($packages as $package)
            <div class="bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-luxury-lg transition-all {{ $package->tier === 'royal' ? 'ring-2 ring-gold-400 scale-105' : '' }}">
                @if($package->tier === 'royal')
                <div class="bg-gradient-to-r from-gold-500 to-gold-600 text-white text-xs font-semibold uppercase tracking-widest text-center py-2.5">✦ Most Exclusive ✦</div>
                @endif
                <div class="p-8">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $package->tier_badge_color }} mb-4">{{ ucfirst($package->tier) }}</span>
                    <h2 class="font-serif text-2xl text-gray-900 mb-2">{{ $package->name }}</h2>
                    <p class="font-serif text-4xl text-gold-500 font-bold mb-2">{{ $package->formatted_price }}</p>
                    <p class="text-xs text-gray-400 mb-4">👥 Hingga {{ number_format($package->guest_capacity) }} tamu</p>
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed">{{ $package->description }}</p>
                    <ul class="space-y-2 mb-8">
                        @foreach($package->items->take(5) as $item)
                        <li class="flex items-center gap-2 text-sm text-gray-600"><span class="text-gold-500">✓</span>{{ $item->item_name }}</li>
                        @endforeach
                        @if($package->items->count() > 5)<li class="text-xs text-gold-600 font-medium">+ {{ $package->items->count() - 5 }} layanan lainnya</li>@endif
                    </ul>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('packages.show', $package->slug) }}" class="block text-center bg-gray-900 hover:bg-gold-500 text-white py-3 rounded-xl text-sm font-semibold transition-all">Lihat Detail</a>
                        <a href="{{ route('booking.create', ['package' => $package->slug]) }}" class="block text-center border border-gold-400 text-gold-600 hover:bg-gold-50 py-3 rounded-xl text-sm font-semibold transition-all">Konsultasi</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
