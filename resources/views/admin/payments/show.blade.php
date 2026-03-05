@extends('layouts.dashboard')
@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-2xl p-8 shadow-card border border-gold-100">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="font-serif text-2xl text-gray-800">{{ $payment->invoice_number }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $payment->wedding->couple_name }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $payment->status_badge_color }}">
                {{ ucfirst($payment->status) }}
            </span>
        </div>

        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-gray-400 text-xs uppercase tracking-wider mb-1">Klien</dt><dd class="font-medium">{{ $payment->wedding->client->name }}</dd></div>
            <div><dt class="text-gray-400 text-xs uppercase tracking-wider mb-1">Jumlah</dt><dd class="font-semibold text-xl font-serif text-gold-600">{{ $payment->formatted_amount }}</dd></div>
            <div><dt class="text-gray-400 text-xs uppercase tracking-wider mb-1">Tipe</dt><dd class="capitalize">{{ $payment->type }}</dd></div>
            <div><dt class="text-gray-400 text-xs uppercase tracking-wider mb-1">Jatuh Tempo</dt><dd>{{ $payment->due_date?->format('d M Y') ?? '-' }}</dd></div>
        </dl>

        @if($payment->proof_image)
        <div class="mt-6 pt-6 border-t border-gold-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Bukti Pembayaran</p>
            <img src="{{ Storage::url($payment->proof_image) }}" alt="Bukti" class="max-h-64 rounded-xl border border-gray-200">
        </div>
        @endif

        @if($payment->status === 'uploaded')
        <div class="mt-6 pt-6 border-t border-gold-100 flex gap-3">
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">✓ Verifikasi</button>
            </form>
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="reason" placeholder="Alasan penolakan..." class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-red-400">
                <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">✗ Tolak</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
