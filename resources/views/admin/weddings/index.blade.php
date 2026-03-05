@extends('layouts.dashboard')
@section('title', 'Kelola Wedding')
@section('page-title', 'Data Wedding')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.weddings.create') }}" class="bg-gold-500 hover:bg-gold-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-luxury">
        + Tambah Wedding
    </a>
</div>

<div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gold-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ivory-200 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Pasangan</th>
                    <th class="px-6 py-3 text-left">Klien</th>
                    <th class="px-6 py-3 text-left">Paket</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($weddings as $wedding)
                <tr class="hover:bg-ivory-100">
                    <td class="px-6 py-4 font-medium">{{ $wedding->couple_name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $wedding->client->name }}</td>
                    <td class="px-6 py-4">{{ $wedding->package->name }}</td>
                    <td class="px-6 py-4">{{ $wedding->wedding_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium
                            {{ match($wedding->status) {
                                'confirmed'   => 'bg-blue-50 text-blue-700',
                                'in_progress' => 'bg-amber-50 text-amber-700',
                                'completed'   => 'bg-green-50 text-green-700',
                                'cancelled'   => 'bg-red-50 text-red-600',
                                default       => 'bg-gray-100 text-gray-600'
                            } }}">
                            {{ ucfirst(str_replace('_',' ',$wedding->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.weddings.show', $wedding) }}" class="text-gold-600 hover:text-gold-700 text-xs font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada wedding.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $weddings->links() }}</div>
</div>
@endsection
