@extends('layouts.app')
@section('title', 'Konsultasi Gratis — The Royal Wedding by Ully Sjah')

@section('content')
<section class="py-20 bg-ivory-100 min-h-screen">
    <div class="max-w-2xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-gold-500 text-xs uppercase tracking-[0.4em] mb-3">Gratis & Tanpa Komitmen</p>
            <h1 class="font-serif text-4xl text-gray-900 mb-3">Konsultasi Pernikahan</h1>
            <p class="text-gray-500">Ceritakan impian pernikahan Anda — tim kami siap membantu.</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-card border border-gold-100">
            <form action="{{ route('booking.store') }}" method="POST" class="space-y-5">
                @csrf
                @error('name')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required value="{{ old('name') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nomor WhatsApp</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Paket Yang Diminati</label>
                        <select name="package_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                            <option value="">Belum tahu</option>
                            @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" {{ $selectedPackage?->id == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Rencana Tanggal</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Ceritakan Impian Anda</label>
                    <textarea name="message" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-gold-400 outline-none resize-none" placeholder="Tema, venue impian, jumlah tamu...">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="w-full bg-gold-500 hover:bg-gold-600 text-white py-4 rounded-xl font-semibold text-sm uppercase tracking-widest transition-all shadow-luxury">
                    Kirim via WhatsApp ✦
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
