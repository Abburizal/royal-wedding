@extends('layouts.dashboard')
@section('page-title', 'Buat Kontrak')

@section('content')
<div class="p-8 max-w-3xl">
    <a href="{{ route('admin.weddings.show', $wedding) }}" class="text-xs text-gray-400 hover:text-gray-600 mb-4 inline-block">← Kembali ke Wedding</a>

    @if($existing)
    <div class="mb-4 p-4 bg-{{ $existing->status === 'signed' ? 'green' : 'blue' }}-50 border border-{{ $existing->status === 'signed' ? 'green' : 'blue' }}-200 rounded-xl flex justify-between items-center">
        <div>
            <p class="text-sm font-semibold text-{{ $existing->status === 'signed' ? 'green' : 'blue' }}-700">
                Kontrak sudah ada — Status: <span class="capitalize">{{ $existing->status }}</span>
                @if($existing->status === 'signed')
                — Ditandatangani oleh {{ $existing->signed_name }} pada {{ $existing->signed_at->isoFormat('D MMMM Y') }}
                @endif
            </p>
        </div>
        <a href="{{ route('admin.contracts.pdf', $existing) }}" target="_blank"
           class="text-xs bg-white border rounded-lg px-3 py-1.5 hover:bg-gray-50 transition">📄 Download PDF</a>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100">
            <h3 class="font-serif text-lg text-gray-800">
                Kontrak — {{ $wedding->bride_name }} & {{ $wedding->groom_name }}
            </h3>
            <p class="text-sm text-gray-400 mt-1">{{ $wedding->wedding_code }} · {{ $wedding->package?->name }}</p>
        </div>

        <form method="POST" action="{{ route('admin.weddings.contract.store', $wedding) }}" class="px-6 py-5 space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Isi Kontrak (HTML diperbolehkan)</label>
                <textarea name="contract_body" rows="20"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-mono focus:outline-none focus:border-amber-400 resize-y">{{ $existing?->contract_body ?? "SURAT PERJANJIAN KERJA SAMA\nPENYELENGGARAAN PERNIKAHAN\n\nAntara:\nThe Royal Wedding by Ully Sjah\n\nDengan:\nNama Pengantin    : {$wedding->bride_name} & {$wedding->groom_name}\nNomor Kontrak     : {$wedding->wedding_code}\nPaket             : {$wedding->package?->name}\nTanggal Pernikahan: ".($wedding->wedding_date ? $wedding->wedding_date->format('d M Y') : '-')."\nLokasi            : {$wedding->venue_name}, {$wedding->venue_city}\nHarga Paket       : Rp ".number_format($wedding->package?->price ?? 0, 0, ',', '.')."\n\n---\n\nKEWAJIBAN PENYEDIA JASA:\n1. Menyediakan tim wedding organizer profesional.\n2. Melaksanakan konsep pernikahan sesuai kesepakatan.\n3. Koordinasi vendor-vendor terkait.\n4. Technical meeting minimal 7 hari sebelum hari H.\n5. Hadir dan memimpin jalannya acara pada hari H.\n\nKEWAJIBAN KLIEN:\n1. Membayar Down Payment sebesar 30% dari total paket.\n2. Melunasi pembayaran minimal H-7 sebelum acara.\n3. Memberikan informasi yang diperlukan tepat waktu.\n4. Menghadiri semua sesi pertemuan yang dijadwalkan.\n\nSYARAT PEMBATALAN:\n- Pembatalan lebih dari 90 hari: DP dikembalikan 50%\n- Pembatalan 30-90 hari: DP hangus\n- Pembatalan kurang dari 30 hari: DP hangus + penalty 20%\n\nPerjanjian ini dibuat dan ditandatangani secara digital\ndengan persetujuan kedua belah pihak.\n\nThe Royal Wedding by Ully Sjah" }}</textarea>
            </div>

            <button type="submit"
                class="w-full py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition text-sm">
                📤 Buat & Kirim Kontrak ke Klien
            </button>
        </form>
    </div>
</div>
@endsection
