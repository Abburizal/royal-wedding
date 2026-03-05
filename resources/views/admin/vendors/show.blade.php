@extends('layouts.dashboard')
@section('title', 'Detail Vendor')
@section('page-title', 'Detail Vendor')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
        <div class="flex justify-between items-start mb-5">
            <div>
                <span class="inline-block px-2.5 py-0.5 bg-gold-50 text-gold-700 text-xs rounded-full font-medium mb-2">{{ $vendor->category_label }}</span>
                <h2 class="font-serif text-2xl text-gray-800">{{ $vendor->name }}</h2>
                @if($vendor->base_price > 0)
                <p class="text-gold-600 font-semibold mt-1">Rp {{ number_format($vendor->base_price, 0, ',', '.') }}</p>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="bg-gold-50 hover:bg-gold-100 text-gold-700 px-4 py-2 rounded-xl text-sm font-medium">Edit</a>
                <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST"
                      onsubmit="return confirm('Hapus vendor ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-medium">Hapus</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm mb-4">
            @if($vendor->phone)
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Telepon</p>
                <p class="font-medium text-gray-800">{{ $vendor->phone }}</p>
            </div>
            @endif
            @if($vendor->email)
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Email</p>
                <p class="font-medium text-gray-800">{{ $vendor->email }}</p>
            </div>
            @endif
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <p class="font-semibold {{ $vendor->is_active ? 'text-green-700' : 'text-gray-500' }}">{{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
        </div>

        @if($vendor->description)
        <p class="text-sm text-gray-600 leading-relaxed mb-3">{{ $vendor->description }}</p>
        @endif
        @if($vendor->portfolio_url)
        <a href="{{ $vendor->portfolio_url }}" target="_blank" class="text-sm text-blue-600 hover:underline">🔗 Lihat Portfolio</a>
        @endif
    </div>

    @if($vendor->vendorAssignments->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100">
            <h3 class="font-serif text-lg text-gray-800">Riwayat Penugasan ({{ $vendor->vendorAssignments->count() }})</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($vendor->vendorAssignments as $assignment)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $assignment->wedding->couple_name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $assignment->wedding->client->name ?? '-' }} · Rp {{ number_format($assignment->agreed_price, 0, ',', '.') }}</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                    {{ match($assignment->status) {
                        'confirmed'  => 'bg-blue-50 text-blue-700',
                        'completed'  => 'bg-green-50 text-green-700',
                        'cancelled'  => 'bg-red-50 text-red-600',
                        default      => 'bg-gray-100 text-gray-600'
                    } }}">
                    {{ ucfirst($assignment->status) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <a href="{{ route('admin.vendors.index') }}" class="inline-block text-sm text-gold-600 hover:text-gold-700">← Kembali ke daftar vendor</a>
</div>
@endsection

