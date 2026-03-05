@extends('layouts.dashboard')
@section('title', 'Pembayaran')
@section('page-title', 'Status Pembayaran')

@section('content')
<div class="space-y-6">
    {{-- Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-card border border-green-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Sudah Dibayar</p>
            <p class="font-serif text-2xl font-bold text-green-700">Rp {{ number_format($summary['paid'],0,',','.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card border border-amber-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Sisa</p>
            <p class="font-serif text-2xl font-bold text-amber-700">Rp {{ number_format($summary['remaining'],0,',','.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card border border-gold-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total</p>
            <p class="font-serif text-2xl font-bold text-gray-800">Rp {{ number_format($summary['total'],0,',','.') }}</p>
        </div>
    </div>

    {{-- Payment list --}}
    <div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gold-100">
        <div class="px-6 py-4 border-b border-gold-100">
            <h3 class="font-serif text-lg text-gray-800">Riwayat Pembayaran</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($payments as $payment)
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="font-medium text-gray-800">{{ $payment->invoice_number }}</p>
                        <p class="text-sm text-gray-500 capitalize">{{ $payment->type }} — {{ $payment->formatted_amount }}</p>
                        @if($payment->due_date)
                        <p class="text-xs text-gray-400 mt-1">Jatuh tempo: {{ $payment->due_date->format('d M Y') }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $payment->status_badge_color }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>

                @if(in_array($payment->status, ['pending', 'rejected']))
                <form action="{{ route('client.payments.upload', $payment) }}" method="POST" enctype="multipart/form-data"
                      class="mt-3 flex gap-3 items-center">
                    @csrf
                    <input type="file" name="proof" accept="image/*,.pdf"
                           class="text-xs text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gold-50 file:text-gold-700 hover:file:bg-gold-100">
                    <button type="submit"
                            class="bg-gold-500 hover:bg-gold-600 text-white text-xs px-4 py-2 rounded-lg font-medium transition-colors">
                        Upload Bukti
                    </button>
                </form>
                @endif

                @if($payment->proof_image)
                <div class="mt-2">
                    <a href="{{ Storage::url($payment->proof_image) }}" target="_blank"
                       class="text-xs text-blue-600 hover:underline">📎 Lihat bukti pembayaran</a>
                </div>
                @endif

                <div class="mt-2">
                    <a href="{{ route('client.payments.pdf', $payment) }}" target="_blank"
                       class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gold-600 hover:underline transition-colors">
                        📄 Download Invoice PDF
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
