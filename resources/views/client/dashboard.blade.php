@extends('layouts.dashboard')
@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Pernikahan Saya')

@section('content')
<div class="space-y-8">

    {{-- ── COUNTDOWN ──────────────────────────────────────────────── --}}
    <div class="bg-gray-900 rounded-2xl p-8 text-white relative overflow-hidden shadow-luxury-lg">
        <div class="absolute top-0 right-0 w-80 h-80 bg-gold-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10">
            <p class="text-gold-400 text-xs uppercase tracking-[0.3em] mb-2">Menuju Hari Istimewa</p>
            <h2 class="font-serif text-3xl font-bold mb-1">{{ $wedding->couple_name }}</h2>
            <p class="text-gray-400 text-sm mb-8">
                {{ $wedding->wedding_date->isoFormat('dddd, D MMMM Y') }}
                @if($wedding->venue_name) · {{ $wedding->venue_name }} @endif
            </p>

            {{-- Countdown boxes --}}
            @php
                $days = $wedding->days_until_wedding;
                $months = floor($days / 30);
                $remainingDays = $days % 30;
            @endphp
            <div class="flex gap-4">
                @foreach([['val' => $months, 'label' => 'Bulan'], ['val' => $remainingDays, 'label' => 'Hari']] as $unit)
                <div class="bg-white/10 rounded-xl px-6 py-4 text-center backdrop-blur-sm border border-white/10">
                    <p class="font-serif text-5xl font-bold text-gold-400">{{ $unit['val'] }}</p>
                    <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ $unit['label'] }}</p>
                </div>
                @endforeach
                <div class="flex items-center ml-4">
                    <p class="text-2xl text-gray-300">lagi menuju<br><span class="text-gold-400 font-serif font-semibold">Hari Bahagia ✦</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STATS CARDS ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Package --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Paket</p>
            <p class="font-serif text-xl font-semibold text-gray-800">{{ $wedding->package->name }}</p>
            <span class="inline-block mt-2 px-2 py-0.5 {{ $wedding->package->tier_badge_color }} text-xs rounded-full capitalize font-medium">
                {{ $wedding->package->tier }}
            </span>
        </div>

        {{-- Total Price --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Biaya</p>
            <p class="font-serif text-xl font-semibold text-gray-800">
                Rp {{ number_format($paymentSummary['total'], 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">{{ $wedding->estimated_guests }} tamu estimasi</p>
        </div>

        {{-- Paid --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-green-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Sudah Dibayar</p>
            <p class="font-serif text-xl font-semibold text-green-700">
                Rp {{ number_format($paymentSummary['paid'], 0, ',', '.') }}
            </p>
            @php $paidPercent = $paymentSummary['total'] > 0 ? round(($paymentSummary['paid']/$paymentSummary['total'])*100) : 0; @endphp
            <div class="mt-2 bg-gray-100 rounded-full h-1.5">
                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $paidPercent }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">{{ $paidPercent }}% lunas</p>
        </div>

        {{-- Remaining --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-amber-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Sisa Pembayaran</p>
            <p class="font-serif text-xl font-semibold text-amber-700">
                Rp {{ number_format($paymentSummary['remaining'], 0, ',', '.') }}
            </p>
            <a href="{{ route('client.payments.index') }}" class="text-xs text-gold-600 hover:text-gold-700 mt-1 block">
                Lihat detail →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ── CHECKLIST PROGRESS ──────────────────────────────────── --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-serif text-lg text-gray-800">Progress Checklist</h3>
                <a href="{{ route('client.checklist.index') }}" class="text-xs text-gold-600 hover:text-gold-700">Lihat semua →</a>
            </div>

            {{-- Overall progress --}}
            @php $overall = $wedding->checklist_progress; @endphp
            <div class="mb-5">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Keseluruhan</span>
                    <span class="font-semibold text-gold-600">{{ $overall }}%</span>
                </div>
                <div class="bg-gray-100 rounded-full h-3">
                    <div class="bg-gradient-to-r from-gold-400 to-gold-600 h-3 rounded-full transition-all duration-500"
                         style="width: {{ $overall }}%"></div>
                </div>
            </div>

            {{-- Per category --}}
            <div class="space-y-3">
                @foreach($checklistProgress as $category => $data)
                <div>
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>{{ $category }}</span>
                        <span>{{ $data['done'] }}/{{ $data['total'] }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gold-400 h-1.5 rounded-full" style="width: {{ $data['percent'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── PAYMENT STATUS ───────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-serif text-lg text-gray-800">Status Pembayaran</h3>
                <a href="{{ route('client.payments.index') }}" class="text-xs text-gold-600 hover:text-gold-700">Kelola →</a>
            </div>

            <div class="space-y-3">
                @foreach($wedding->payments->take(4) as $payment)
                <div class="flex items-center justify-between p-3 bg-ivory-100 rounded-xl">
                    <div>
                        <p class="text-sm font-medium text-gray-800 capitalize">{{ $payment->type }} — {{ $payment->invoice_number }}</p>
                        <p class="text-xs text-gray-400">{{ $payment->formatted_amount }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->status_badge_color }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Contract & Messages row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

            {{-- Contract --}}
            @php $contract = $wedding->contracts->first(); @endphp
            @if($contract)
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
                    <h3 class="font-serif text-lg text-gray-800">📄 Kontrak Digital</h3>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $contract->status_color }}">{{ ucfirst($contract->status) }}</span>
                </div>
                <div class="px-6 py-4 space-y-3">
                    @if($contract->status === 'sent')
                    <p class="text-sm text-gray-600">Kontrak Anda sudah siap dan menunggu tanda tangan digital.</p>
                    <form method="POST" action="{{ route('client.contracts.sign', $contract) }}">
                        @csrf
                        <button class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl text-sm transition">
                            ✍️ Tanda Tangan Digital
                        </button>
                    </form>
                    @elseif($contract->status === 'signed')
                    <p class="text-sm text-green-600 font-medium">✅ Kontrak sudah ditandatangani pada {{ $contract->signed_at->format('d M Y') }}.</p>
                    @else
                    <p class="text-sm text-gray-400">Kontrak sedang disiapkan oleh tim kami.</p>
                    @endif
                    <a href="{{ route('admin.contracts.pdf', $contract) }}" target="_blank"
                       class="block text-center py-2 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition">
                        📥 Download PDF Kontrak
                    </a>
                </div>
            </div>
            @endif

            {{-- Messages --}}
            <div class="bg-white rounded-2xl shadow-card border border-blue-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-100 flex items-center justify-between">
                    <h3 class="font-serif text-lg text-gray-800">💬 Pesan</h3>
                    @php $unread = $wedding->messages->where('is_internal', false)->where('sender_id', '!=', auth()->id())->whereNull('read_at')->count(); @endphp
                    @if($unread > 0)
                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unread }} baru</span>
                    @endif
                </div>
                <div class="divide-y divide-gray-50 max-h-52 overflow-y-auto">
                    @forelse($wedding->messages->where('is_internal', false)->take(10) as $msg)
                    <div class="px-4 py-2.5 flex gap-2.5 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <div class="w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                            {{ $msg->sender_id === auth()->id() ? 'bg-gold-500 text-white' : 'bg-slate-600 text-white' }}">
                            {{ strtoupper(substr($msg->sender->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="{{ $msg->sender_id === auth()->id() ? 'items-end' : 'items-start' }} flex flex-col max-w-xs">
                            <div class="px-3 py-1.5 rounded-2xl text-xs
                                {{ $msg->sender_id === auth()->id() ? 'bg-gold-500 text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm' }}">
                                {{ $msg->message }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="px-4 py-5 text-xs text-gray-400 text-center">Belum ada pesan dari planner.</p>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('client.messages.store') }}"
                      class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex gap-2 items-end">
                    @csrf
                    <textarea name="message" rows="2" required placeholder="Kirim pesan ke planner..."
                        class="flex-1 border border-gray-200 rounded-xl px-2.5 py-1.5 text-xs focus:outline-none focus:border-blue-400 resize-none"></textarea>
                    <button class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition">Kirim</button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
