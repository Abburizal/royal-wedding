@extends('layouts.dashboard')
@section('title', 'Portfolio')
@section('page-title', 'Portfolio')

@section('content')
<div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <p class="text-sm text-gray-500">{{ $portfolios->count() }} portfolio</p>
        <a href="{{ route('admin.portfolios.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white text-sm px-4 py-2 rounded-xl">+ Tambah</a>
    </div>
    @if(session('success'))<div class="mx-6 mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>@endif
    <div class="divide-y divide-gray-50">
        @forelse($portfolios as $p)
        <div class="px-6 py-4 flex items-center gap-4">
            <img src="{{ $p->cover_url }}" class="w-16 h-12 object-cover rounded-lg flex-shrink-0" alt="">
            <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-800">{{ $p->couple_names }}</p>
                <p class="text-xs text-gray-400">{{ $p->title }} @if($p->location) · {{ $p->location }}@endif</p>
            </div>
            @if($p->is_featured)<span class="text-xs bg-gold-50 text-gold-700 px-2 py-0.5 rounded-full">Featured</span>@endif
            <div class="flex gap-2">
                <a href="{{ route('admin.portfolios.edit', $p) }}" class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg">Edit</a>
                <form method="POST" action="{{ route('admin.portfolios.destroy', $p) }}" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="text-xs px-3 py-1.5 bg-red-50 text-red-600 rounded-lg">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <p class="px-6 py-10 text-center text-gray-400">Belum ada portfolio.</p>
        @endforelse
    </div>
</div>
@endsection
