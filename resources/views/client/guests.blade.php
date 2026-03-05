@extends('layouts.dashboard')
@section('title', 'Daftar Tamu')
@section('page-title', 'Daftar Tamu & RSVP')

@section('content')
<div class="space-y-6">

    {{-- Stats cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach([
            ['label'=>'Total Tamu', 'val'=>$stats['total'], 'color'=>'gold'],
            ['label'=>'Konfirmasi', 'val'=>$stats['confirmed'], 'color'=>'green'],
            ['label'=>'Tidak Hadir', 'val'=>$stats['declined'], 'color'=>'red'],
            ['label'=>'Hadir',       'val'=>$stats['attended'], 'color'=>'blue'],
            ['label'=>'Menunggu',    'val'=>$stats['pending'],   'color'=>'yellow'],
        ] as $s)
        <div class="bg-white rounded-2xl p-4 shadow-card border border-gray-100 text-center">
            <p class="font-serif text-3xl font-bold text-{{ $s['color'] }}-500">{{ $s['val'] }}</p>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Add guest form --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100">
            <h3 class="font-semibold text-gray-700">➕ Tambah Tamu</h3>
        </div>
        <form action="{{ route('client.guests.store') }}" method="POST" class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            @csrf
            <div class="col-span-2 md:col-span-1">
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Nama *</label>
                <input name="name" required placeholder="Nama tamu"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400 focus:border-gold-400">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">No. HP</label>
                <input name="phone" placeholder="08xxx"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400 focus:border-gold-400">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Kategori</label>
                <select name="category" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
                    <option value="keluarga">Keluarga</option>
                    <option value="sahabat">Sahabat</option>
                    <option value="kolega">Kolega</option>
                    <option value="umum" selected>Umum</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Pihak</label>
                <select name="side" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
                    <option value="both" selected>Keduanya</option>
                    <option value="groom">Pria</option>
                    <option value="bride">Wanita</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Jml Tamu</label>
                <input name="pax" type="number" value="1" min="1" max="10"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">No. Meja</label>
                <input name="table_no" placeholder="A1"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
            </div>
            <div class="col-span-2 flex items-end">
                <button type="submit"
                        class="w-full bg-gold-500 hover:bg-gold-400 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-colors">
                    Tambah Tamu
                </button>
            </div>
        </form>
    </div>

    {{-- Guest table --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100 flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">📋 Daftar Tamu ({{ $guests->count() }} orang)</h3>
        </div>
        @if($guests->isEmpty())
        <div class="p-12 text-center text-gray-400">
            <p class="text-4xl mb-3">👥</p>
            <p>Belum ada tamu ditambahkan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-center">Pihak</th>
                        <th class="px-4 py-3 text-center">Pax</th>
                        <th class="px-4 py-3 text-center">Meja</th>
                        <th class="px-4 py-3 text-center">RSVP</th>
                        <th class="px-4 py-3 text-center">Link RSVP</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($guests as $guest)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $guest->name }}</td>
                        <td class="px-4 py-3 text-gray-500 capitalize">{{ $guest->category }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $guest->side === 'groom' ? 'bg-blue-50 text-blue-600' : ($guest->side === 'bride' ? 'bg-pink-50 text-pink-600' : 'bg-gray-50 text-gray-600') }}">
                                {{ $guest->side === 'groom' ? 'Pria' : ($guest->side === 'bride' ? 'Wanita' : 'Keduanya') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-600">{{ $guest->pax }}</td>
                        <td class="px-4 py-3 text-center text-gray-500">{{ $guest->table_no ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @php $colors = ['confirmed'=>'green','declined'=>'red','attended'=>'blue','pending'=>'yellow']; @endphp
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                bg-{{ $colors[$guest->rsvp_status] ?? 'gray' }}-100
                                text-{{ $colors[$guest->rsvp_status] ?? 'gray' }}-700">
                                {{ $guest->rsvp_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($guest->invitation_token)
                            <a href="{{ route('rsvp.show', $guest->invitation_token) }}" target="_blank"
                               class="text-xs text-gold-600 hover:text-gold-500 underline">Link RSVP</a>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('client.guests.destroy', $guest) }}" method="POST"
                                  onsubmit="return confirm('Hapus tamu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
