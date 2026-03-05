@extends('layouts.dashboard')
@section('title', 'Checklist Pernikahan')
@section('page-title', 'Checklist Pernikahan')

@section('content')
<div class="space-y-6">
    {{-- Overall progress --}}
    @php $overall = $wedding->checklist_progress; @endphp
    <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-serif text-lg text-gray-800">Progress Keseluruhan</h3>
            <span class="font-serif text-2xl font-bold text-gold-600">{{ $overall }}%</span>
        </div>
        <div class="bg-gray-100 rounded-full h-3">
            <div class="bg-gradient-to-r from-gold-400 to-gold-600 h-3 rounded-full transition-all duration-700"
                 style="width: {{ $overall }}%"></div>
        </div>
    </div>

    {{-- Tasks by category --}}
    @foreach($tasks as $category => $categoryTasks)
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100 flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">{{ $category }}</h4>
            <span class="text-xs text-gray-400">
                {{ $categoryTasks->where('status','done')->count() }}/{{ $categoryTasks->count() }} selesai
            </span>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($categoryTasks as $task)
            <div class="px-6 py-3 flex items-center gap-4">
                <div class="w-4 h-4 rounded-full border-2 flex-shrink-0 {{ $task->status === 'done' ? 'bg-green-500 border-green-500' : ($task->status === 'in_progress' ? 'bg-amber-400 border-amber-400' : 'border-gray-300') }}"></div>
                <span class="text-sm text-gray-700 flex-1 {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                    {{ $task->task_name }}
                </span>
                @if($task->due_date)
                <span class="text-xs text-gray-400">{{ $task->due_date->format('d M') }}</span>
                @endif
                <form action="{{ route('client.checklist.update-status', $task) }}" method="POST" class="flex gap-1">
                    @csrf @method('PATCH')
                    @if($task->status !== 'done')
                    <button name="status" value="{{ $task->status === 'pending' ? 'in_progress' : 'done' }}"
                            class="text-xs px-2.5 py-1 rounded-lg font-medium transition-colors
                                {{ $task->status === 'pending' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                        {{ $task->status === 'pending' ? 'Mulai' : 'Selesai ✓' }}
                    </button>
                    @else
                    <button name="status" value="pending"
                            class="text-xs px-2.5 py-1 rounded-lg font-medium bg-gray-50 text-gray-500 hover:bg-gray-100 transition-colors">
                        Batalkan
                    </button>
                    @endif
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection
