@extends('layouts.app')
@section('title', $package->name.' — The Royal Wedding by Ully Sjah')

@section('content')
<section class="py-20 bg-ivory-100">
    <div class="max-w-4xl mx-auto px-4">
        <a href="{{ route('packages.index') }}" class="text-sm text-gold-600 hover:text-gold-700 mb-8 inline-block">← Kembali ke semua paket</a>

        <div class="bg-white rounded-2xl p-10 shadow-card border border-gold-100">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $package->tier_badge_color }} mb-4">{{ ucfirst($package->tier) }}</span>
            <h1 class="font-serif text-4xl text-gray-900 mb-2">{{ $package->name }}</h1>
            <p class="font-serif text-5xl text-gold-500 font-bold mb-4">{{ $package->formatted_price }}</p>
            <p class="text-gray-500 mb-2">👥 Hingga {{ number_format($package->guest_capacity) }} tamu undangan</p>
            <p class="text-gray-600 leading-relaxed mb-10">{{ $package->description }}</p>

            <h2 class="font-serif text-2xl text-gray-800 mb-6">Yang Termasuk dalam Paket:</h2>
            @php $grouped = $package->items->groupBy('category'); @endphp
            @foreach($grouped as $cat => $items)
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gold-600 uppercase tracking-wider mb-3">{{ $cat }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($items as $item)
                    <div class="flex items-start gap-2 text-sm text-gray-700">
                        <span class="text-gold-500 mt-0.5">✓</span>
                        <div>
                            <p class="font-medium">{{ $item->item_name }}</p>
                            @if($item->description)<p class="text-xs text-gray-400">{{ $item->description }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="border-t border-gold-100 pt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('booking.create', ['package' => $package->slug]) }}"
                   class="flex-1 text-center bg-gold-500 hover:bg-gold-600 text-white py-4 rounded-xl font-semibold transition-all shadow-luxury">
                    Pilih Paket Ini ✦
                </a>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya tertarik dengan '.$package->name) }}"
                   class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-semibold transition-all">
                    💬 Tanya via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
