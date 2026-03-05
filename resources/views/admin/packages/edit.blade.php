@extends('layouts.dashboard')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Paket')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100 space-y-5">
            <h3 class="font-serif text-lg text-gray-800 border-b border-gold-100 pb-3">Informasi Paket</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Paket *</label>
                    <input type="text" name="name" value="{{ old('name', $package->name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tier *</label>
                    <select name="tier" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        @foreach(['silver' => 'Silver', 'gold' => 'Gold', 'royal' => 'Royal'] as $val => $label)
                        <option value="{{ $val }}" {{ old('tier', $package->tier) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $package->price) }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Kapasitas Tamu *</label>
                    <input type="number" name="guest_capacity" value="{{ old('guest_capacity', $package->guest_capacity) }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('description', $package->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-gold-500 rounded border-gray-300">
                <label for="is_active" class="text-sm text-gray-700">Paket aktif (tampil di website)</label>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl px-5 py-3 text-sm text-amber-700">
            ℹ️ Untuk mengubah item/layanan, hapus dan buat paket baru, atau hubungi developer.
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-gold px-8 py-3">Simpan Perubahan</button>
            <a href="{{ route('admin.packages.show', $package) }}" class="px-8 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection

