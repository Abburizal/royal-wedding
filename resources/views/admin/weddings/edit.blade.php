@extends('layouts.dashboard')
@section('title', 'Edit Wedding')
@section('page-title', 'Edit Wedding')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.weddings.update', $wedding) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100 space-y-5">
            <h3 class="font-serif text-lg text-gray-800 border-b border-gold-100 pb-3">
                Edit: {{ $wedding->couple_name }}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Pengantin Pria *</label>
                    <input type="text" name="groom_name" value="{{ old('groom_name', $wedding->groom_name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Pengantin Wanita *</label>
                    <input type="text" name="bride_name" value="{{ old('bride_name', $wedding->bride_name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Status *</label>
                    <select name="status" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        @foreach(['inquired'=>'Inquired','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $wedding->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Wedding Planner</label>
                    <select name="planner_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        <option value="">-- Belum Assigned --</option>
                        @foreach($planners as $planner)
                        <option value="{{ $planner->id }}" {{ old('planner_id', $wedding->planner_id) == $planner->id ? 'selected' : '' }}>{{ $planner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tanggal Pernikahan *</label>
                    <input type="date" name="wedding_date" value="{{ old('wedding_date', $wedding->wedding_date->format('Y-m-d')) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Jumlah Tamu Estimasi</label>
                    <input type="number" name="estimated_guests" value="{{ old('estimated_guests', $wedding->estimated_guests) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Venue</label>
                    <input type="text" name="venue_name" value="{{ old('venue_name', $wedding->venue_name) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Kota</label>
                    <input type="text" name="venue_city" value="{{ old('venue_city', $wedding->venue_city) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Alamat Venue</label>
                    <textarea name="venue_address" rows="2"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('venue_address', $wedding->venue_address) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Catatan Khusus</label>
                    <textarea name="special_notes" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">{{ old('special_notes', $wedding->special_notes) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-gold px-8 py-3">Simpan Perubahan</button>
            <a href="{{ route('admin.weddings.show', $wedding) }}" class="px-8 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection

