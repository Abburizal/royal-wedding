@extends('layouts.client')

@section('title', 'Timeline Wedding')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-amber-400">✨ Timeline Wedding</h1>
        <p class="text-slate-400 mt-1">
            {{ $wedding->couple_name }} &mdash;
            {{ $wedding->wedding_date ? \Carbon\Carbon::parse($wedding->wedding_date)->isoFormat('D MMMM Y') : '—' }}
        </p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600/20 border border-green-500 rounded-lg text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($milestones->isEmpty())
        <div class="text-center py-16 text-slate-500">
            <p class="text-4xl mb-3">📅</p>
            <p>Timeline belum tersedia. Hubungi planner Anda.</p>
        </div>
    @else
        <div class="relative">
            {{-- Vertical line --}}
            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-amber-800/40"></div>

            <div class="space-y-6">
                @foreach($milestones->sortBy('milestone_date') as $milestone)
                    @php
                        $isDone      = $milestone->status === 'done';
                        $isPast      = $milestone->milestone_date && \Carbon\Carbon::parse($milestone->milestone_date)->isPast();
                        $isToday     = $milestone->milestone_date && \Carbon\Carbon::parse($milestone->milestone_date)->isToday();
                        $daysLeft    = $milestone->milestone_date
                            ? (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($milestone->milestone_date)->startOfDay(), false)
                            : null;
                    @endphp

                    <div class="relative flex items-start gap-6 group">
                        {{-- Circle dot --}}
                        <div class="relative z-10 flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center border-2
                            {{ $isDone ? 'bg-amber-500 border-amber-400' : ($isToday ? 'bg-amber-700 border-amber-400 animate-pulse' : 'bg-slate-800 border-slate-600') }}">
                            <span class="text-xl">{{ $milestone->icon }}</span>
                        </div>

                        {{-- Card --}}
                        <div class="flex-1 bg-slate-800/70 border {{ $isToday ? 'border-amber-500' : ($isDone ? 'border-slate-600' : 'border-slate-700') }} rounded-xl p-4 pb-3">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h3 class="font-semibold {{ $isDone ? 'text-slate-400 line-through' : 'text-white' }}">
                                        {{ $milestone->title }}
                                    </h3>
                                    @if($milestone->milestone_date)
                                        <p class="text-sm text-slate-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($milestone->milestone_date)->isoFormat('dddd, D MMMM Y') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- Countdown badge --}}
                                    @if($daysLeft !== null && !$isDone)
                                        @if($isToday)
                                            <span class="px-2 py-0.5 bg-amber-500 text-black text-xs font-bold rounded-full">HARI INI 🎉</span>
                                        @elseif($daysLeft > 0)
                                            <span class="px-2 py-0.5 bg-slate-700 text-amber-300 text-xs rounded-full">H-{{ $daysLeft }}</span>
                                        @elseif($isPast)
                                            <span class="px-2 py-0.5 bg-red-900/50 text-red-300 text-xs rounded-full">Terlewat</span>
                                        @endif
                                    @elseif($isDone)
                                        <span class="px-2 py-0.5 bg-green-900/50 text-green-300 text-xs rounded-full">✓ Selesai</span>
                                    @endif

                                    {{-- Toggle button --}}
                                    <form method="POST" action="{{ route('client.timeline.update-status', $milestone) }}">
                                        @csrf @method('PATCH')
                                        @if($isDone)
                                            <input type="hidden" name="status" value="upcoming">
                                            <button class="text-xs px-3 py-1 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-lg transition">
                                                Batalkan
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="done">
                                            <button class="text-xs px-3 py-1 bg-amber-600 hover:bg-amber-500 text-white rounded-lg transition">
                                                Tandai Selesai
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            @if($milestone->notes)
                                <p class="mt-2 text-sm text-slate-500 italic">{{ $milestone->notes }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Progress summary --}}
        @php
            $total    = $milestones->count();
            $done     = $milestones->where('status', 'done')->count();
            $progress = $total > 0 ? round(($done / $total) * 100) : 0;
        @endphp
        <div class="mt-10 bg-slate-800/60 border border-slate-700 rounded-xl p-5">
            <div class="flex justify-between text-sm text-slate-400 mb-2">
                <span>Progress Timeline</span>
                <span>{{ $done }}/{{ $total }} milestone selesai</span>
            </div>
            <div class="w-full bg-slate-700 rounded-full h-2">
                <div class="bg-amber-500 h-2 rounded-full transition-all" style="width: {{ $progress }}%"></div>
            </div>
            <p class="text-right text-amber-400 font-bold mt-1 text-sm">{{ $progress }}%</p>
        </div>
    @endif
</div>
@endsection
