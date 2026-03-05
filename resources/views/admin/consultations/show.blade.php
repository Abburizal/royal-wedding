@extends('layouts.dashboard')
@section('page-title', 'Detail Konsultasi')

@section('content')
<div class="p-8 max-w-2xl">
    <a href="{{ route('admin.consultations.index') }}" class="text-xs text-gray-400 hover:text-gray-600 mb-4 inline-block">← Kembali</a>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gold-100">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="font-serif text-2xl text-gray-800">{{ $consultation->name }}</h2>
                    <p class="text-sm text-gray-400 mt-1">Dikirim {{ $consultation->created_at->isoFormat('D MMMM Y, HH:mm') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $consultation->status_color }}">
                    {{ ucfirst($consultation->status) }}
                </span>
            </div>
        </div>

        <div class="px-6 py-5 space-y-4">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-400 block text-xs">Email</span>{{ $consultation->email }}</div>
                <div><span class="text-gray-400 block text-xs">Telepon</span>{{ $consultation->phone }}</div>
                <div><span class="text-gray-400 block text-xs">Paket Diminati</span>{{ $consultation->package?->name ?? '-' }}</div>
                <div><span class="text-gray-400 block text-xs">Tanggal Event</span>{{ $consultation->event_date?->format('d M Y') ?? '-' }}</div>
            </div>

            @if($consultation->message)
            <div>
                <p class="text-xs text-gray-400 mb-1">Pesan</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-4">{{ $consultation->message }}</p>
            </div>
            @endif
        </div>

        <div class="px-6 py-5 bg-gray-50 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Update Status</p>
            <form method="POST" action="{{ route('admin.consultations.update', $consultation) }}" class="space-y-3">
                @csrf @method('PATCH')
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Status</label>
                        <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-400">
                            @foreach(['pending','contacted','converted','declined'] as $s)
                            <option value="{{ $s }}" {{ $consultation->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Catatan Internal</label>
                    <textarea name="admin_notes" rows="3"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-400 resize-none"
                        placeholder="Catatan follow-up...">{{ $consultation->admin_notes }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-semibold rounded-xl transition">
                        Simpan Perubahan
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $consultation->phone) }}"
                       target="_blank"
                       class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition">
                        💬 WhatsApp
                    </a>
                    <form method="POST" action="{{ route('admin.consultations.destroy', $consultation) }}" onsubmit="return confirm('Hapus konsultasi ini?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm rounded-xl transition">🗑</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
