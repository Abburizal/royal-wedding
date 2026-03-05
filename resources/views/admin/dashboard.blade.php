@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">

    {{-- ── STATS CARDS ──────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach([
            ['label' => 'Total Wedding',    'value' => $stats['total_weddings'],                                          'color' => 'text-gray-800',    'icon' => '💍'],
            ['label' => 'Wedding Aktif',    'value' => $stats['active_weddings'],                                         'color' => 'text-blue-700',    'icon' => '🔄'],
            ['label' => 'Total Klien',      'value' => $stats['total_clients'],                                           'color' => 'text-purple-700',  'icon' => '👥'],
            ['label' => 'Bayar Pending',    'value' => $stats['pending_payments'],                                        'color' => 'text-amber-700',   'icon' => '⏳'],
            ['label' => 'Revenue Bulan Ini','value' => 'Rp '.number_format($stats['revenue_this_month'],0,',','.'),       'color' => 'text-green-700',   'icon' => '💰'],
            ['label' => 'Revenue Tahun Ini','value' => 'Rp '.number_format($stats['revenue_this_year'],0,',','.'),        'color' => 'text-emerald-700', 'icon' => '📈'],
        ] as $stat)
        <div class="bg-white rounded-2xl p-4 shadow-card border border-gold-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">{{ $stat['label'] }}</p>
            <p class="font-serif text-xl font-bold {{ $stat['color'] }} leading-tight">{{ $stat['value'] }}</p>
            <span class="text-xl">{{ $stat['icon'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- ── CHARTS ROW ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Revenue Chart --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5">
            <h3 class="font-serif text-gray-800 mb-4">Revenue 6 Bulan Terakhir</h3>
            <div id="chart-revenue"></div>
        </div>

        {{-- Wedding per month --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5">
            <h3 class="font-serif text-gray-800 mb-4">Wedding per Bulan</h3>
            <div id="chart-weddings"></div>
        </div>

    </div>

    {{-- ── PACKAGE & VENDOR STATS ──────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Package Popularity --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5">
            <h3 class="font-serif text-gray-800 mb-4">Paket Paling Diminati</h3>
            <div id="chart-packages"></div>
        </div>

        {{-- Vendor Usage --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5">
            <h3 class="font-serif text-gray-800 mb-4">Vendor Paling Sering Dipakai</h3>
            <div id="chart-vendors"></div>
        </div>

    </div>

    {{-- ── TABLES ROW ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Weddings --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
                <h3 class="font-serif text-lg text-gray-800">Wedding Terbaru</h3>
                <a href="{{ route('admin.weddings.index') }}" class="text-xs text-gold-600 hover:text-gold-700">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentWeddings as $wedding)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-ivory-100 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $wedding->couple_name }}</p>
                        <p class="text-xs text-gray-400">{{ $wedding->package->name }} · {{ $wedding->wedding_date->format('d M Y') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium
                        {{ match($wedding->status) {
                            'confirmed'   => 'bg-blue-50 text-blue-700',
                            'in_progress' => 'bg-amber-50 text-amber-700',
                            'completed'   => 'bg-green-50 text-green-700',
                            default       => 'bg-gray-100 text-gray-600'
                        } }}">
                        {{ ucfirst(str_replace('_', ' ', $wedding->status)) }}
                    </span>
                </div>
                @empty
                <p class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada wedding.</p>
                @endforelse
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="bg-white rounded-2xl shadow-card border border-amber-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-amber-100 flex justify-between items-center">
                <h3 class="font-serif text-lg text-gray-800">Pembayaran Perlu Verifikasi</h3>
                <a href="{{ route('admin.payments.index') }}" class="text-xs text-gold-600 hover:text-gold-700">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingPayments as $payment)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-ivory-100 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $payment->wedding->client->name }}</p>
                        <p class="text-xs text-gray-400">{{ $payment->invoice_number }} · {{ $payment->formatted_amount }}</p>
                    </div>
                    <a href="{{ route('admin.payments.show', $payment) }}"
                       class="text-xs bg-amber-50 text-amber-700 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors font-medium">
                        Verifikasi
                    </a>
                </div>
                @empty
                <p class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada pembayaran pending. ✓</p>
                @endforelse
            </div>
        </div>

        {{-- Pending Consultations --}}
        <div class="bg-white rounded-2xl shadow-card border border-blue-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                <h3 class="font-serif text-lg text-gray-800">💬 Konsultasi Baru</h3>
                <a href="{{ route('admin.consultations.index') }}" class="text-xs text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingConsultations as $c)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-blue-50/30 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $c->name }}</p>
                        <p class="text-xs text-gray-400">{{ $c->phone }} · {{ $c->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.consultations.show', $c) }}"
                       class="text-xs bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-colors font-medium">
                        Tindak Lanjut →
                    </a>
                </div>
                @empty
                <p class="px-6 py-8 text-center text-gray-400 text-sm">Tidak ada konsultasi pending. ✓</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ── ACTIVITY LOG ─────────────────────────────────────────────── --}}
    @if($recentActivity->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
            <h3 class="font-serif text-lg text-gray-800">Aktivitas Terkini</h3>
            <a href="{{ route('admin.activity-log') }}" class="text-xs text-gold-600 hover:text-gold-700">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($recentActivity as $log)
            <div class="px-6 py-3 flex items-start gap-4">
                <span class="mt-0.5 px-2 py-0.5 rounded text-xs font-semibold {{ $log->action_color }}">
                    {{ strtoupper($log->action) }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-800">{{ $log->description }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $log->user->name ?? 'Sistem' }} &middot; {{ $log->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- ApexCharts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const gold = '#B8860B';
const goldLight = '#D4A017';

// Revenue Chart
new ApexCharts(document.querySelector('#chart-revenue'), {
    chart: { type: 'area', height: 220, toolbar: { show: false }, fontFamily: 'inherit' },
    series: [{ name: 'Revenue', data: @json($revenueChart->pluck('revenue')) }],
    xaxis: { categories: @json($revenueChart->pluck('label')) },
    yaxis: { labels: { formatter: v => 'Rp ' + (v/1e6).toFixed(0) + 'jt' } },
    colors: [gold],
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
    stroke: { curve: 'smooth', width: 2 },
    dataLabels: { enabled: false },
    grid: { borderColor: '#f5f5f5' },
    tooltip: { y: { formatter: v => 'Rp ' + Number(v).toLocaleString('id-ID') } },
}).render();

// Wedding count chart
new ApexCharts(document.querySelector('#chart-weddings'), {
    chart: { type: 'bar', height: 220, toolbar: { show: false }, fontFamily: 'inherit' },
    series: [{ name: 'Wedding', data: @json($weddingChart->pluck('count')) }],
    xaxis: { categories: @json($weddingChart->pluck('label')) },
    colors: [goldLight],
    dataLabels: { enabled: false },
    plotOptions: { bar: { borderRadius: 6 } },
    grid: { borderColor: '#f5f5f5' },
}).render();

// Package chart
new ApexCharts(document.querySelector('#chart-packages'), {
    chart: { type: 'donut', height: 220, fontFamily: 'inherit' },
    series: @json($packageStats->pluck('count')),
    labels: @json($packageStats->pluck('label')),
    colors: ['#B8860B','#D4A017','#8B6914','#F5C842','#6B5300'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: true, formatter: (v, o) => o.w.config.series[o.seriesIndex] },
    plotOptions: { pie: { donut: { size: '55%' } } },
}).render();

// Vendor chart
new ApexCharts(document.querySelector('#chart-vendors'), {
    chart: { type: 'bar', height: 220, toolbar: { show: false }, fontFamily: 'inherit' },
    series: [{ name: 'Dipakai', data: @json($vendorStats->pluck('count')) }],
    xaxis: { categories: @json($vendorStats->pluck('label')) },
    colors: ['#8B6914'],
    dataLabels: { enabled: false },
    plotOptions: { bar: { borderRadius: 4, horizontal: true } },
    grid: { borderColor: '#f5f5f5' },
}).render();
</script>
@endsection
