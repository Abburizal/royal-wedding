@extends('layouts.dashboard')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.users.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-luxury">
        + Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gold-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ivory-200 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-ivory-100">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium capitalize
                            {{ match($user->role) {
                                'super_admin'     => 'bg-purple-50 text-purple-700',
                                'wedding_planner' => 'bg-blue-50 text-blue-700',
                                'finance'         => 'bg-green-50 text-green-700',
                                'client'          => 'bg-gold-50 text-gold-700',
                                default           => 'bg-gray-100 text-gray-600'
                            } }}">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-gold-600 hover:text-gold-700 text-xs font-medium">Detail</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-700 text-xs font-medium">Edit</a>
                        @if($user->id !== auth()->id())
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $users->links() }}</div>
</div>
@endsection

