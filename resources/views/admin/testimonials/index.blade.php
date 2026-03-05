@extends('layouts.dashboard')
@section('title', 'Testimoni')
@section('page-title', 'Testimoni Klien')

@section('content')
<div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <p class="text-sm text-gray-500">{{ $testimonials->count() }} testimoni</p>
        <a href="{{ route('admin.testimonials.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white text-sm px-4 py-2 rounded-xl">+ Tambah</a>
    </div>
    @if(session('success'))<div class="mx-6 mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>@endif
    <div class="divide-y divide-gray-50">
        @forelse($testimonials as $t)
        <div class="px-6 py-4 flex items-start gap-4">
            <img src="{{ $t->photo_url }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0 mt-0.5" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <p class="font-medium text-gray-800 text-sm">{{ $t->client_name }}</p>
                    @if($t->couple_names)<span class="text-xs text-gold-500">{{ $t->couple_names }}</span>@endif
                    <span class="text-xs text-yellow-400">{{ $t->stars }}</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5 line-clamp-1 italic">{{ $t->content }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                @if(!$t->is_published)<span class="text-xs bg-red-50 text-red-500 px-2 py-0.5 rounded-full">Tersembunyi</span>@endif
                <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg">Edit</a>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="text-xs px-3 py-1.5 bg-red-50 text-red-600 rounded-lg">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <p class="px-6 py-10 text-center text-gray-400">Belum ada testimoni.</p>
        @endforelse
    </div>
</div>
@endsection
