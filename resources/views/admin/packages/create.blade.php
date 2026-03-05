@extends('layouts.dashboard')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket Baru')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100 space-y-5">
            <h3 class="font-serif text-lg text-gray-800 border-b border-gold-100 pb-3">Informasi Paket</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Paket *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tier *</label>
                    <select name="tier" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        <option value="">-- Pilih Tier --</option>
                        @foreach(['silver' => 'Silver', 'gold' => 'Gold', 'royal' => 'Royal'] as $val => $label)
                        <option value="{{ $val }}" {{ old('tier') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tier')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Kapasitas Tamu *</label>
                    <input type="number" name="guest_capacity" value="{{ old('guest_capacity', 0) }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', '1') ? 'checked' : '' }}
                       class="w-4 h-4 text-gold-500 rounded border-gray-300">
                <label for="is_active" class="text-sm text-gray-700">Paket aktif (tampil di website)</label>
            </div>
        </div>

        {{-- Items --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100" x-data="{ items: [{}] }">
            <div class="flex justify-between items-center border-b border-gold-100 pb-3 mb-4">
                <h3 class="font-serif text-lg text-gray-800">Item / Layanan Paket</h3>
                <button type="button" @click="items.push({})"
                        class="text-xs bg-gold-50 hover:bg-gold-100 text-gold-700 px-3 py-1.5 rounded-lg font-medium">
                    + Tambah Item
                </button>
            </div>
            <template x-for="(item, i) in items" :key="i">
                <div class="flex gap-3 mb-3 items-center">
                    <input type="text" :name="`items[${i}][item_name]`" placeholder="Nama layanan"
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    <input type="text" :name="`items[${i}][category]`" placeholder="Kategori"
                           class="w-32 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    <input type="number" :name="`items[${i}][quantity]`" placeholder="Qty" min="1" value="1"
                           class="w-20 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    <button type="button" @click="items.splice(i, 1)" x-show="items.length > 1"
                            class="text-red-400 hover:text-red-600 text-lg leading-none px-1">×</button>
                </div>
            </template>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-gold px-8 py-3">Simpan Paket</button>
            <a href="{{ route('admin.packages.index') }}" class="px-8 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script src="//unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
@endsection

