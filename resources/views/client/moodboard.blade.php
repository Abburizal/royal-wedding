@extends('layouts.client')

@section('title', 'Moodboard & Inspirasi')

@section('content')
@php
    $categories = [
        'color_palette'  => ['label' => 'Palet Warna',  'icon' => '🎨'],
        'decoration'     => ['label' => 'Dekorasi',     'icon' => '🌸'],
        'dress'          => ['label' => 'Busana',        'icon' => '👗'],
        'venue'          => ['label' => 'Venue',         'icon' => '🏛️'],
        'flowers'        => ['label' => 'Bunga',         'icon' => '💐'],
        'photography'    => ['label' => 'Foto/Video',   'icon' => '📷'],
        'general'        => ['label' => 'Lainnya',       'icon' => '✨'],
    ];
@endphp

<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-amber-400">🎨 Moodboard & Inspirasi</h1>
            <p class="text-slate-400 mt-1">Kumpulkan inspirasi wedding impian Anda di sini.</p>
        </div>

        {{-- Upload button --}}
        <button onclick="document.getElementById('upload-modal').classList.remove('hidden')"
            class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 text-white font-semibold rounded-xl transition flex items-center gap-2">
            <span>+ Upload Inspirasi</span>
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600/20 border border-green-500 rounded-lg text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($moodboards->isEmpty())
        <div class="text-center py-20 text-slate-500">
            <p class="text-5xl mb-4">🖼️</p>
            <p class="text-lg">Belum ada inspirasi. Mulai upload!</p>
            <button onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                class="mt-4 px-6 py-2 bg-amber-700/50 hover:bg-amber-700 text-amber-300 rounded-xl transition">
                Upload Pertama
            </button>
        </div>
    @else
        @foreach($categories as $key => $meta)
            @if(isset($moodboards[$key]) && $moodboards[$key]->isNotEmpty())
                <div class="mb-10">
                    <h2 class="text-lg font-semibold text-amber-300 mb-4 flex items-center gap-2">
                        <span>{{ $meta['icon'] }}</span> {{ $meta['label'] }}
                        <span class="text-slate-500 text-sm font-normal">({{ $moodboards[$key]->count() }})</span>
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($moodboards[$key] as $item)
                            <div class="group relative bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-amber-600 transition">
                                <div class="aspect-square overflow-hidden">
                                    <img src="{{ $item->imageUrl }}" alt="{{ $item->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <div class="p-3">
                                    <p class="text-white text-sm font-medium truncate">{{ $item->title }}</p>
                                    @if($item->notes)
                                        <p class="text-slate-500 text-xs mt-0.5 truncate">{{ $item->notes }}</p>
                                    @endif
                                </div>
                                {{-- Delete overlay --}}
                                <form method="POST" action="{{ route('client.moodboard.destroy', $item) }}"
                                      onsubmit="return confirm('Hapus inspirasi ini?')"
                                      class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                    @csrf @method('DELETE')
                                    <button class="w-7 h-7 bg-red-600 hover:bg-red-500 text-white rounded-full flex items-center justify-center text-xs">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>

{{-- Upload Modal --}}
<div id="upload-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4">
    <div class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-amber-400">Upload Inspirasi</h2>
            <button onclick="document.getElementById('upload-modal').classList.add('hidden')"
                class="text-slate-500 hover:text-white text-xl">&times;</button>
        </div>

        <form method="POST" action="{{ route('client.moodboard.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-slate-400 text-sm mb-1">Judul <span class="text-red-400">*</span></label>
                <input type="text" name="title" required placeholder="contoh: Dekor bunga putih"
                    class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
            </div>

            <div>
                <label class="block text-slate-400 text-sm mb-1">Kategori <span class="text-red-400">*</span></label>
                <select name="category" required
                    class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
                    @foreach($categories as $key => $meta)
                        <option value="{{ $key }}">{{ $meta['icon'] }} {{ $meta['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-400 text-sm mb-1">Gambar <span class="text-red-400">*</span> <span class="text-slate-500 text-xs">(max 5MB)</span></label>
                <input type="file" name="image" accept="image/*" required
                    class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-amber-700 file:text-white file:text-xs">
            </div>

            <div>
                <label class="block text-slate-400 text-sm mb-1">Catatan (opsional)</label>
                <textarea name="notes" rows="2" placeholder="Deskripsi singkat..."
                    class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500"></textarea>
            </div>

            @if($errors->any())
                <div class="text-red-400 text-xs">{{ $errors->first() }}</div>
            @endif

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')"
                    class="flex-1 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl text-sm transition">Batal</button>
                <button type="submit"
                    class="flex-1 py-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold rounded-xl text-sm transition">Upload</button>
            </div>
        </form>
    </div>
</div>

@if($errors->any())
    <script>document.getElementById('upload-modal').classList.remove('hidden');</script>
@endif
@endsection
