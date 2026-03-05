@php
    $adminLinks = [
        ['route' => 'admin.dashboard',           'icon' => '◈',  'label' => 'Dashboard'],
        ['route' => 'admin.weddings.index',       'icon' => '♡',  'label' => 'Wedding'],
        ['route' => 'admin.consultations.index',  'icon' => '💬', 'label' => 'Konsultasi'],
        ['route' => 'admin.users.index',          'icon' => '◉',  'label' => 'Pengguna'],
        ['route' => 'admin.packages.index',       'icon' => '◎',  'label' => 'Paket'],
        ['route' => 'admin.payments.index',       'icon' => '◈',  'label' => 'Pembayaran'],
        ['route' => 'admin.vendors.index',        'icon' => '◇',  'label' => 'Vendor'],
        ['route' => 'admin.portfolios.index',     'icon' => '🖼️',  'label' => 'Portfolio'],
        ['route' => 'admin.testimonials.index',   'icon' => '⭐',  'label' => 'Testimoni'],
        ['route' => 'admin.activity-log',         'icon' => '📋', 'label' => 'Log Aktivitas'],
        ['route' => 'admin.settings.index',       'icon' => '⚙️',  'label' => 'Pengaturan'],
    ];
@endphp
@php $pendingConsultations = \App\Models\Consultation::where('status','pending')->count(); @endphp
@foreach($adminLinks as $link)
<a href="{{ route($link['route']) }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
          {{ request()->routeIs($link['route'].'*') ? 'bg-gold-50 text-gold-700 font-semibold' : 'text-gray-600 hover:bg-ivory-200 hover:text-gray-900' }}">
    <span class="text-lg">{{ $link['icon'] }}</span>
    <span class="flex-1">{{ $link['label'] }}</span>
    @if($link['route'] === 'admin.consultations.index' && $pendingConsultations > 0)
    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $pendingConsultations }}</span>
    @endif
</a>
@endforeach
