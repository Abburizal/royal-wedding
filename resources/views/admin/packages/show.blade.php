@extends('layouts.dashboard')
@section('title', 'Detail Paket')
@section('page-title', 'Detail Paket')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
        <div class="flex justify-between items-start mb-6">
            <div>
                <span class="inline-block px-2.5 py-0.5 {{ $package->tier_badge_color }} text-xs rounded-full font-medium capitalize mb-2">{{ $package->tier }}</span>
                <h2 class="font-serif text-2xl text-gray-800">{{ $package->name }}</h2>
                <p class="text-gold-600 font-semibold text-xl mt-1">{{ $package->formatted_price }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.packages.edit', $package) }}" class="bg-gold-50 hover:bg-gold-100 text-gold-700 px-4 py-2 rounded-xl text-sm font-medium transition-colors">Edit</a>
                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                      onsubmit="return confirm('Hapus paket ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-medium transition-colors">Hapus</button>
                </form>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 text-sm mb-4">
            <div class="bg-ivory-100 rounded-xl p-3 text-center">
                <p class="text-xs text-gray-400 mb-1">Kapasitas</p>
                <p class="font-semibold text-gray-800">{{ $package->guest_capacity }} tamu</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3 text-center">
                <p class="text-xs text-gray-400 mb-1">Digunakan</p>
                <p class="font-semibold text-gray-800">{{ $package->weddings_count }} wedding</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3 text-center">
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <p class="font-semibold {{ $package->is_active ? 'text-green-700' : 'text-gray-500' }}">{{ $package->is_active ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
        </div>
        @if($package->description)
        <p class="text-sm text-gray-600 leading-relaxed">{{ $package->description }}</p>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100">
            <h3 class="font-serif text-lg text-gray-800">Item & Layanan ({{ $package->items->count() }})</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($package->items->sortBy('sort_order') as $item)
            <div class="px-6 py-3 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $item->item_name }}</p>
                    <p class="text-xs text-gray-400">{{ $item->category }}</p>
                </div>
                <span class="text-xs text-gray-500">× {{ $item->quantity }}</span>
            </div>
            @empty
            <p class="px-6 py-6 text-center text-gray-400 text-sm">Belum ada item.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('admin.packages.index') }}" class="inline-block text-sm text-gold-600 hover:text-gold-700">← Kembali ke daftar paket</a>
</div>
@endsection

