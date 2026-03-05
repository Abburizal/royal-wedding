@extends('layouts.dashboard')
@section('page-title', 'Konsultasi')

@section('content')
<div class="p-8 space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        @foreach(['pending' => ['label'=>'Menunggu','color'=>'amber'], 'contacted' => ['label'=>'Dikontak','color'=>'blue'], 'converted' => ['label'=>'Jadi Client','color'=>'green'], 'declined' => ['label'=>'Ditolak','color'=>'red']] as $s => $cfg)
        <a href="{{ request()->fullUrlWithQuery(['status' => $s]) }}"
           class="bg-white rounded-2xl border {{ request('status') === $s ? 'border-'.$cfg['color'].'-400 ring-2 ring-'.$cfg['color'].'-100' : 'border-gray-100' }} p-4 text-center hover:shadow-md transition">
            <p class="text-2xl font-bold text-gray-800">{{ $stats[$s] }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $cfg['label'] }}</p>
        </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
            <h3 class="font-serif text-lg text-gray-800">Daftar Konsultasi</h3>
            @if(request('status'))
            <a href="{{ route('admin.consultations.index') }}" class="text-xs text-gold-600 hover:underline">Tampilkan semua</a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">Kontak</th>
                        <th class="px-5 py-3 text-left">Paket</th>
                        <th class="px-5 py-3 text-left">Tgl Event</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Masuk</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($consultations as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $c->name }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">
                            <div>{{ $c->email }}</div>
                            <div>{{ $c->phone }}</div>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $c->package?->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $c->event_date?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $c->status_color }}">{{ ucfirst($c->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $c->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.consultations.show', $c) }}"
                               class="text-xs text-gold-600 hover:underline font-medium">Lihat →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada konsultasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultations->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $consultations->links() }}</div>
        @endif
    </div>
</div>
@endsection
