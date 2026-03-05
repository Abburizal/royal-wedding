@extends('layouts.dashboard')
@section('title', 'Tambah Vendor')
@section('page-title', 'Tambah Vendor Baru')

@section('content')
@php
$categories = ['catering'=>'Catering','decoration'=>'Dekorasi','mua'=>'MUA','documentation'=>'Dokumentasi','entertainment'=>'Entertainment','venue'=>'Venue','other'=>'Lainnya'];
@endphp
<div class="max-w-2xl">
    <form action="{{ route('admin.vendors.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100 space-y-5">
            <h3 class="font-serif text-lg text-gray-800 border-b border-gold-100 pb-3">Data Vendor</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Vendor *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Kategori *</label>
                    <select name="category" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $val => $label)
                        <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Harga Dasar (Rp)</label>
                    <input type="number" name="base_price" value="{{ old('base_price', 0) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">URL Portfolio</label>
                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none" placeholder="https://...">
                    @error('portfolio_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Alamat</label>
                    <textarea name="address" rows="2"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('address') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" id="is_active" checked
                       class="w-4 h-4 text-gold-500 rounded border-gray-300">
                <label for="is_active" class="text-sm text-gray-700">Vendor aktif</label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-gold px-8 py-3">Simpan Vendor</button>
            <a href="{{ route('admin.vendors.index') }}" class="px-8 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection

