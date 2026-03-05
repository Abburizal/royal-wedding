@php
    $clientLinks = [
        ['route' => 'client.dashboard',       'icon' => '◈', 'label' => 'Dashboard'],
        ['route' => 'client.payments.index',  'icon' => '◎', 'label' => 'Pembayaran'],
        ['route' => 'client.checklist.index', 'icon' => '◉', 'label' => 'Checklist'],
        ['route' => 'client.timeline.index',  'icon' => '📅', 'label' => 'Timeline'],
        ['route' => 'client.moodboard.index', 'icon' => '🎨', 'label' => 'Moodboard'],
    ];
@endphp
@foreach($clientLinks as $link)
<a href="{{ route($link['route']) }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
          {{ request()->routeIs($link['route'].'*') ? 'bg-gold-50 text-gold-700 font-semibold' : 'text-gray-600 hover:bg-ivory-200 hover:text-gray-900' }}">
    <span class="text-lg">{{ $link['icon'] }}</span>
    {{ $link['label'] }}
</a>
@endforeach
