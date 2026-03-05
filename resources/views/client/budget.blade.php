@extends('layouts.dashboard')
@section('title', 'Budget Tracker')
@section('page-title', 'Budget Tracker')

@section('content')
<div class="space-y-6">

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-card border border-gold-100 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Estimasi</p>
            <p class="font-serif text-xl font-bold text-gray-800">Rp {{ number_format($summary['total_estimated'],0,',','.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card border border-gold-100 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Aktual</p>
            <p class="font-serif text-xl font-bold text-gray-800">Rp {{ number_format($summary['total_actual'],0,',','.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card border border-gold-100 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Sudah Dibayar</p>
            <p class="font-serif text-xl font-bold text-green-600">Rp {{ number_format($summary['total_paid'],0,',','.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card border border-gold-100 text-center">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Sisa Tagihan</p>
            <p class="font-serif text-xl font-bold {{ $summary['total_remaining'] > 0 ? 'text-red-500' : 'text-green-600' }}">
                Rp {{ number_format($summary['total_remaining'],0,',','.') }}
            </p>
        </div>
    </div>

    {{-- Variance alert --}}
    @if($summary['variance'] > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-3 text-sm text-amber-700 flex items-center gap-2">
        ⚠️ Aktual melebihi estimasi sebesar <strong>Rp {{ number_format($summary['variance'],0,',','.') }}</strong>
    </div>
    @elseif($summary['total_estimated'] > 0)
    <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-3 text-sm text-green-700 flex items-center gap-2">
        ✅ Budget masih dalam estimasi
    </div>
    @endif

    {{-- Add budget item --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100">
            <h3 class="font-semibold text-gray-700">➕ Tambah Item Budget</h3>
        </div>
        <form action="{{ route('client.budget.store') }}" method="POST" class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Kategori *</label>
                <select name="category" required class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-1 md:col-span-1">
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Item *</label>
                <input name="item_name" required placeholder="Nama item"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Estimasi (Rp)</label>
                <input name="estimated_amount" type="number" min="0" placeholder="0"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1 uppercase tracking-wider">Vendor</label>
                <input name="vendor_name" placeholder="Nama vendor"
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-1 focus:ring-gold-400">
            </div>
            <div class="col-span-2 md:col-span-4 flex justify-end">
                <button type="submit"
                        class="bg-gold-500 hover:bg-gold-400 text-white px-8 py-2 rounded-xl text-sm font-semibold transition-colors">
                    Tambah Item
                </button>
            </div>
        </form>
    </div>

    {{-- Budget table by category --}}
    @foreach($summary['by_category'] as $cat => $catSummary)
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-3 bg-ivory-200 border-b border-gold-100 flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">{{ $cat }}</h4>
            <div class="flex gap-6 text-xs text-gray-500">
                <span>Est: <strong class="text-gray-700">Rp {{ number_format($catSummary['estimated'],0,',','.') }}</strong></span>
                <span>Aktual: <strong class="text-gray-700">Rp {{ number_format($catSummary['actual'],0,',','.') }}</strong></span>
                <span>Dibayar: <strong class="text-green-600">Rp {{ number_format($catSummary['paid'],0,',','.') }}</strong></span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-400 bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Item</th>
                        <th class="px-4 py-2 text-left">Vendor</th>
                        <th class="px-4 py-2 text-right">Estimasi</th>
                        <th class="px-4 py-2 text-right">Aktual</th>
                        <th class="px-4 py-2 text-right">Dibayar</th>
                        <th class="px-4 py-2 text-right">Sisa</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($items->where('category', $cat) as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 font-medium text-gray-800">{{ $item->item_name }}</td>
                        <td class="px-4 py-2.5 text-gray-500">{{ $item->vendor_name ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-right text-gray-600">Rp {{ number_format($item->estimated_amount,0,',','.') }}</td>
                        <td class="px-4 py-2.5 text-right {{ $item->actual_amount > $item->estimated_amount ? 'text-red-500 font-medium' : 'text-gray-600' }}">
                            Rp {{ number_format($item->actual_amount,0,',','.') }}
                        </td>
                        <td class="px-4 py-2.5 text-right text-green-600">Rp {{ number_format($item->paid_amount,0,',','.') }}</td>
                        <td class="px-4 py-2.5 text-right {{ $item->remaining > 0 ? 'text-amber-600 font-medium' : 'text-gray-400' }}">
                            Rp {{ number_format($item->remaining,0,',','.') }}
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <form action="{{ route('client.budget.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Hapus item ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    @if($items->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center text-gray-400 shadow-card">
        <p class="text-4xl mb-3">💰</p>
        <p>Belum ada item budget. Mulai tambahkan rencana pengeluaran pernikahan Anda.</p>
    </div>
    @endif

</div>
@endsection
