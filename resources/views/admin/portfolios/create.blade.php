@extends('layouts.dashboard')
@section('title', 'Tambah Portfolio')
@section('page-title', 'Tambah Portfolio')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data"
      class="bg-white rounded-2xl shadow-card border border-gold-100 p-6 space-y-4">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Pasangan *</label>
            <input type="text" name="couple_names" value="{{ old('couple_names') }}" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Judul Wedding *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Lokasi</label>
            <input type="text" name="location" value="{{ old('location') }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Wedding</label>
            <input type="date" name="wedding_date" value="{{ old('wedding_date') }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Cover Image (maks 5MB)</label>
        <input type="file" name="cover_image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-amber-100 file:text-amber-700">
    </div>
    <div class="flex items-center gap-6">
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="is_featured" value="1" class="rounded"> Tampilkan sebagai Featured
        </label>
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Urutan</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-16 border border-gray-200 rounded-xl px-2 py-1 text-sm text-center">
        </div>
    </div>
    @if($errors->any())<div class="text-red-500 text-sm">{{ $errors->first() }}</div>@endif
    <div class="flex gap-3 pt-2">
        <a href="{{ route('admin.portfolios.index') }}" class="flex-1 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm text-center">Batal</a>
        <button type="submit" class="flex-1 py-2.5 bg-gold-500 hover:bg-gold-600 text-white rounded-xl text-sm font-semibold">Simpan</button>
    </div>
</form>
</div>
@endsection
