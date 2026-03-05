@extends('layouts.admin')
@section('title', 'Kalender Wedding')
@section('page-title', 'Kalender Wedding')

@section('content')
<div class="space-y-6">

    {{-- Month navigation --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5 flex items-center justify-between">
        <a href="{{ route('admin.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
           class="flex items-center gap-2 text-sm text-gray-500 hover:text-gold-600 transition-colors font-medium px-3 py-1.5 rounded-lg hover:bg-gold-50">
            ← {{ $prevMonth->isoFormat('MMMM YYYY') }}
        </a>
        <div class="text-center">
            <h2 class="font-serif text-2xl font-bold text-gray-900">{{ $start->isoFormat('MMMM YYYY') }}</h2>
            <p class="text-xs text-gray-400 mt-0.5">{{ $weddings->count() }} wedding · {{ $milestones->count() }} milestone</p>
        </div>
        <a href="{{ route('admin.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
           class="flex items-center gap-2 text-sm text-gray-500 hover:text-gold-600 transition-colors font-medium px-3 py-1.5 rounded-lg hover:bg-gold-50">
            {{ $nextMonth->isoFormat('MMMM YYYY') }} →
        </a>
    </div>

    {{-- Calendar grid --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        {{-- Day headers --}}
        <div class="grid grid-cols-7 bg-gray-900 text-white text-xs font-semibold uppercase tracking-widest">
            @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $day)
            <div class="px-3 py-3 text-center">{{ $day }}</div>
            @endforeach
        </div>

        {{-- Weeks --}}
        @foreach($weeks as $week)
        <div class="grid grid-cols-7 border-t border-gray-100">
            @foreach($week as $day)
            @php
                $key     = $day->format('Y-m-d');
                $isToday = $day->isToday();
                $inMonth = $day->month === $start->month;
                $dayWeddings   = $weddings->get($key, collect());
                $dayMilestones = $milestones->get($key, collect());
            @endphp
            <div class="min-h-[100px] p-2 border-r border-gray-100 last:border-r-0 {{ !$inMonth ? 'bg-gray-50/50' : '' }}">
                <div class="flex justify-end mb-1">
                    <span class="text-xs font-semibold w-7 h-7 flex items-center justify-center rounded-full
                        {{ $isToday ? 'bg-gold-500 text-white' : ($inMonth ? 'text-gray-700' : 'text-gray-300') }}">
                        {{ $day->day }}
                    </span>
                </div>
                {{-- Wedding events --}}
                @foreach($dayWeddings as $w)
                <a href="{{ route('admin.weddings.show', $w) }}"
                   class="block mb-1 px-1.5 py-0.5 rounded-md text-xs font-medium bg-gold-100 text-gold-800 hover:bg-gold-200 truncate transition-colors"
                   title="{{ $w->couple_name }}">
                    💍 {{ $w->couple_name }}
                </a>
                @endforeach
                {{-- Milestones --}}
                @foreach($dayMilestones as $m)
                <span class="block mb-1 px-1.5 py-0.5 rounded-md text-xs bg-blue-50 text-blue-700 truncate"
                      title="{{ $m->wedding->couple_name }}: {{ $m->title }}">
                    📌 {{ $m->title }}
                </span>
                @endforeach
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- Upcoming weddings this month --}}
    @if($weddings->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100">
            <h3 class="font-semibold text-gray-700">💍 Wedding Bulan Ini</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($weddings->flatten() as $w)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="font-medium text-gray-800">{{ $w->couple_name }}</p>
                    <p class="text-xs text-gray-500">{{ $w->wedding_date->isoFormat('dddd, D MMMM Y') }} · {{ $w->venue_name ?? 'Venue TBA' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                        {{ $w->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                        {{ ucfirst($w->status) }}
                    </span>
                    <a href="{{ route('admin.weddings.show', $w) }}"
                       class="text-xs text-gold-600 hover:text-gold-500 font-medium">Detail →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
