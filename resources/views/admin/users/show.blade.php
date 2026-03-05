@extends('layouts.dashboard')
@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
        <div class="flex justify-between items-start mb-5">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gold-100 flex items-center justify-center text-gold-700 font-serif text-2xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-serif text-xl text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-gold-50 hover:bg-gold-100 text-gold-700 px-4 py-2 rounded-xl text-sm font-medium">Edit</a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Hapus pengguna ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-medium">Hapus</button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Role</p>
                <p class="font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $user->role) }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Telepon</p>
                <p class="font-semibold text-gray-800">{{ $user->phone ?? '-' }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <p class="font-semibold {{ $user->is_active ? 'text-green-700' : 'text-red-600' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Bergabung</p>
                <p class="font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        @if($user->address)
        <p class="text-sm text-gray-500 mt-4">📍 {{ $user->address }}</p>
        @endif
    </div>

    @if($user->isClient() && $user->weddings->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100">
            <h3 class="font-serif text-lg text-gray-800">Data Wedding ({{ $user->weddings->count() }})</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($user->weddings as $wedding)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $wedding->couple_name }}</p>
                    <p class="text-xs text-gray-400">{{ $wedding->package->name ?? '-' }} · {{ $wedding->wedding_date->format('d M Y') }}</p>
                </div>
                <a href="{{ route('admin.weddings.show', $wedding) }}" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Detail →</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <a href="{{ route('admin.users.index') }}" class="inline-block text-sm text-gold-600 hover:text-gold-700">← Kembali ke daftar pengguna</a>
</div>
@endsection

