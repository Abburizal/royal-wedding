@extends('layouts.dashboard')
@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <p class="text-sm text-gray-400">Semua aktivitas admin tercatat di sini.</p>
    </div>

    <div class="divide-y divide-gray-50">
        @forelse($logs as $log)
        <div class="px-6 py-4 flex items-start gap-4 hover:bg-gray-50 transition">
            <span class="mt-0.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $log->action_color }} whitespace-nowrap">
                {{ strtoupper($log->action) }}
            </span>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-800">{{ $log->description }}</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    <span class="font-medium">{{ $log->user->name ?? 'Sistem' }}</span>
                    &middot; {{ $log->subject_label }}
                    &middot; {{ $log->created_at->isoFormat('D MMM Y, HH:mm') }}
                    @if($log->ip_address)
                        &middot; {{ $log->ip_address }}
                    @endif
                </p>
            </div>
        </div>
        @empty
        <div class="px-6 py-16 text-center text-gray-400">
            <p class="text-3xl mb-2">📋</p>
            <p>Belum ada aktivitas tercatat.</p>
        </div>
        @endforelse
    </div>

    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
