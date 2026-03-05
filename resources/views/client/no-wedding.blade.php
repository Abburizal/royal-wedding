@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="flex flex-col items-center justify-center h-full text-center py-20">
    <div class="text-6xl mb-6">💍</div>
    <h2 class="font-serif text-2xl text-gray-800 mb-3">Pernikahan Anda belum terdaftar</h2>
    <p class="text-gray-500 mb-8 max-w-md">
        Hubungi tim kami untuk mendaftarkan pernikahan Anda dan mulai merencanakan hari spesial Anda.
    </p>
    <a href="{{ route('booking.create') }}"
       class="bg-gold-500 hover:bg-gold-600 text-white px-8 py-3 rounded-full font-medium transition-all shadow-luxury">
        Konsultasi Sekarang ✦
    </a>
</div>
@endsection
