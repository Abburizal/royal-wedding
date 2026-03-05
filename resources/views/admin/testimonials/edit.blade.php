@extends('layouts.dashboard')
@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data"
      class="bg-white rounded-2xl shadow-card border border-gold-100 p-6 space-y-4">
    @csrf @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Klien *</label>
            <input type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Pasangan</label>
            <input type="text" name="couple_names" value="{{ old('couple_names', $testimonial->couple_names) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Wedding</label>
            <input type="date" name="wedding_date" value="{{ old('wedding_date', $testimonial->wedding_date?->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Rating *</label>
            <select name="rating" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
                @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ str_repeat('★',$i) }} ({{ $i }})</option>
                @endfor
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Isi Testimoni *</label>
        <textarea name="content" rows="4" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400">{{ old('content', $testimonial->content) }}</textarea>
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Foto Klien</label>
        @if($testimonial->photo)
        <img src="{{ $testimonial->photo_url }}" class="w-12 h-12 rounded-full object-cover mb-2">
        @endif
        <input type="file" name="photo" accept="image/*" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-amber-100 file:text-amber-700">
    </div>
    <label class="flex items-center gap-2 text-sm text-gray-600">
        <input type="checkbox" name="is_published" value="1" {{ $testimonial->is_published ? 'checked' : '' }} class="rounded"> Tampilkan di website
    </label>
    @if($errors->any())<div class="text-red-500 text-sm">{{ $errors->first() }}</div>@endif
    <div class="flex gap-3 pt-2">
        <a href="{{ route('admin.testimonials.index') }}" class="flex-1 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm text-center">Batal</a>
        <button type="submit" class="flex-1 py-2.5 bg-gold-500 hover:bg-gold-600 text-white rounded-xl text-sm font-semibold">Simpan</button>
    </div>
</form>
</div>
@endsection
