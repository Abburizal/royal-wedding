@extends('layouts.app')
@section('title', 'Vendor Partner — The Royal Wedding by Ully Sjah')
@section('description', 'Temukan vendor pernikahan terpercaya pilihan The Royal Wedding by Ully Sjah.')

@section('content')
<div class="pt-20 pb-16 bg-ivory-100 min-h-screen">

    {{-- Hero --}}
    <div class="bg-gray-900 py-16 mb-10">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <p class="text-gold-400 text-xs uppercase tracking-[0.4em] mb-3">✦ Vendor Partner ✦</p>
            <h1 class="font-serif text-4xl md:text-5xl text-white font-bold mb-4">Vendor Terpercaya Kami</h1>
            <p class="text-gray-400 text-lg">Setiap vendor telah dikurasi & diverifikasi oleh tim The Royal Wedding</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filter --}}
        <form method="GET" action="{{ route('vendors.index') }}"
              class="bg-white rounded-2xl shadow-card border border-gold-100 p-5 mb-8 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Cari Vendor</label>
                <input name="search" value="{{ request('search') }}" placeholder="Nama vendor..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-1 focus:ring-gold-400 focus:border-gold-400">
            </div>
            <div class="min-w-48">
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Kategori</label>
                <select name="category" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-1 focus:ring-gold-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                        {{ ucfirst($cat) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="bg-gold-500 hover:bg-gold-400 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search','category']))
            <a href="{{ route('vendors.index') }}" class="text-sm text-gray-400 hover:text-gray-600 py-2">Reset</a>
            @endif
        </form>

        {{-- Vendor grid --}}
        @if($vendors->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🔍</p>
            <p class="text-lg">Tidak ada vendor ditemukan.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vendors as $vendor)
            <a href="{{ route('vendors.show', $vendor) }}"
               class="group bg-white rounded-2xl shadow-card border border-gray-100 hover:shadow-luxury hover:-translate-y-1 transition-all overflow-hidden">
                {{-- Card header --}}
                <div class="h-32 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center relative">
                    <span class="text-5xl">{{ explode(' ', $vendor->category_label)[0] }}</span>
                    <div class="absolute top-3 right-3">
                        <span class="text-xs px-2.5 py-1 bg-white/10 text-white rounded-full">
                            {{ explode(' ', $vendor->category_label, 2)[1] ?? $vendor->category }}
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-serif text-lg font-bold text-gray-900 group-hover:text-gold-600 transition-colors mb-1">
                        {{ $vendor->name }}
                    </h3>
                    {{-- Rating --}}
                    <div class="flex items-center gap-2 mb-3">
                        @php $avg = $vendor->avg_rating ?? 0; @endphp
                        <div class="flex">
                            @for($i=1; $i<=5; $i++)
                            <span class="{{ $i <= $avg ? 'text-gold-400' : 'text-gray-200' }} text-sm">★</span>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $avg > 0 ? number_format($avg,1) : '—' }}
                            ({{ $vendor->review_count }} ulasan)
                        </span>
                    </div>
                    @if($vendor->description)
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $vendor->description }}</p>
                    @endif
                    @if($vendor->base_price)
                    <p class="text-xs text-gold-600 font-semibold">
                        Mulai Rp {{ number_format($vendor->base_price, 0, ',', '.') }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $vendors->links() }}</div>
        @endif
    </div>
</div>
@endsection
