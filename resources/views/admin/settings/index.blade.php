@extends('layouts.dashboard')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="p-8 max-w-3xl">

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-xl text-sm">✓ {{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        @php
        $groups = [
            'general'      => ['label' => '🏢 Informasi Perusahaan', 'icon' => '🏢'],
            'branding'     => ['label' => '✨ Branding & Konten', 'icon' => '✨'],
            'social'       => ['label' => '📱 Media Sosial', 'icon' => '📱'],
            'notification' => ['label' => '🔔 Notifikasi', 'icon' => '🔔'],
        ];
        @endphp

        @foreach($groups as $groupKey => $groupInfo)
        @if(isset($settings[$groupKey]))
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gold-100">
                <h3 class="font-semibold text-gray-800">{{ $groupInfo['label'] }}</h3>
            </div>
            <div class="px-6 py-5 space-y-4">
                @foreach($settings[$groupKey] as $setting)
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1.5 block">{{ $setting['label'] }}</label>
                    @if($setting['type'] === 'textarea')
                    <textarea name="settings[{{ $setting['key'] }}]" rows="3"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400 resize-none">{{ $setting['value'] }}</textarea>
                    @else
                    <input type="{{ $setting['type'] === 'email' ? 'email' : ($setting['type'] === 'url' ? 'url' : 'text') }}"
                           name="settings[{{ $setting['key'] }}]"
                           value="{{ $setting['value'] }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-amber-400"
                           placeholder="{{ $setting['label'] }}">
                    @endif
                    @if($setting['type'] === 'phone')
                    <p class="text-xs text-gray-400 mt-1">Format: 628xxx (tanpa +, awali 62)</p>
                    @endif
                    @if($setting['key'] === 'notif_email_enabled' || $setting['key'] === 'notif_wa_enabled')
                    <p class="text-xs text-gray-400 mt-1">Isi 1 untuk aktif, 0 untuk nonaktif</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        <button type="submit"
            class="w-full py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-2xl transition text-sm">
            💾 Simpan Pengaturan
        </button>
    </form>
</div>
@endsection
