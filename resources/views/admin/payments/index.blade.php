@extends('layouts.dashboard')
@section('title', 'Kelola Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')
<div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gold-100">
    <div class="px-6 py-4 border-b border-gold-100">
        <h3 class="font-serif text-lg text-gray-800">Semua Pembayaran</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ivory-200 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Invoice</th>
                    <th class="px-6 py-3 text-left">Klien</th>
                    <th class="px-6 py-3 text-left">Jumlah</th>
                    <th class="px-6 py-3 text-left">Tipe</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($payments as $payment)
                <tr class="hover:bg-ivory-100">
                    <td class="px-6 py-4 font-medium">{{ $payment->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $payment->wedding->client->name }}</td>
                    <td class="px-6 py-4">{{ $payment->formatted_amount }}</td>
                    <td class="px-6 py-4 capitalize">{{ $payment->type }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->status_badge_color }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-gold-600 hover:text-gold-700 text-xs font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $payments->links() }}</div>
</div>
@endsection
