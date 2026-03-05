@extends('layouts.dashboard')
@section('title', 'Kelola Paket')
@section('page-title', 'Paket Pernikahan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.packages.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-luxury">
        + Tambah Paket
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($packages as $package)
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gold-100 flex justify-between items-start">
            <div>
                <span class="inline-block px-2.5 py-0.5 {{ $package->tier_badge_color }} text-xs rounded-full font-medium capitalize mb-2">{{ $package->tier }}</span>
                <h3 class="font-serif text-lg text-gray-800">{{ $package->name }}</h3>
                <p class="text-gold-600 font-semibold text-sm mt-1">{{ $package->formatted_price }}</p>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $package->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div class="px-6 py-4 text-xs text-gray-500 space-y-1">
            <p>👥 Max {{ $package->guest_capacity }} tamu</p>
            <p>💍 Digunakan {{ $package->weddings_count }} wedding</p>
        </div>
        <div class="px-6 pb-5 flex gap-2">
            <a href="{{ route('admin.packages.show', $package) }}" class="flex-1 text-center text-xs bg-ivory-200 hover:bg-ivory-300 text-gray-700 py-2 rounded-lg transition-colors font-medium">Detail</a>
            <a href="{{ route('admin.packages.edit', $package) }}" class="flex-1 text-center text-xs bg-gold-50 hover:bg-gold-100 text-gold-700 py-2 rounded-lg transition-colors font-medium">Edit</a>
            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                  onsubmit="return confirm('Hapus paket {{ $package->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg transition-colors font-medium">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 bg-white rounded-2xl p-12 text-center text-gray-400 shadow-card border border-gold-100">
        Belum ada paket. <a href="{{ route('admin.packages.create') }}" class="text-gold-600 hover:underline">Tambah sekarang</a>
    </div>
    @endforelse
</div>
@endsection

