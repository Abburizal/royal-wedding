@extends('layouts.app')
@section('title', $vendor->name . ' — Vendor Partner The Royal Wedding')

@section('content')
<div class="pt-20 pb-16 bg-ivory-100 min-h-screen">

    {{-- Back --}}
    <div class="max-w-5xl mx-auto px-4 pt-8 pb-4">
        <a href="{{ route('vendors.index') }}" class="text-sm text-gold-600 hover:text-gold-500">← Kembali ke Daftar Vendor</a>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
                <div class="h-36 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                    <span class="text-6xl">{{ explode(' ', $vendor->category_label)[0] }}</span>
                </div>
                <div class="p-5">
                    <span class="text-xs text-gold-500 uppercase tracking-wider">{{ $vendor->category_label }}</span>
                    <h1 class="font-serif text-2xl font-bold text-gray-900 mt-1 mb-3">{{ $vendor->name }}</h1>
                    {{-- Rating summary --}}
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex">
                            @for($i=1; $i<=5; $i++)
                            <span class="{{ $i <= $avgRating ? 'text-gold-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                        <span class="font-serif text-lg font-bold text-gray-800">{{ $avgRating ?: '—' }}</span>
                        <span class="text-xs text-gray-400">({{ $reviews->count() }} ulasan)</span>
                    </div>
                    @if($vendor->base_price)
                    <div class="bg-gold-50 rounded-xl px-4 py-3 mb-3">
                        <p class="text-xs text-gray-500 mb-0.5">Harga Mulai</p>
                        <p class="font-serif text-lg font-bold text-gold-700">
                            Rp {{ number_format($vendor->base_price, 0, ',', '.') }}
                        </p>
                    </div>
                    @endif
                    @if($vendor->phone)
                    <p class="text-sm text-gray-600 mb-1">📞 {{ $vendor->phone }}</p>
                    @endif
                    @if($vendor->email)
                    <p class="text-sm text-gray-600 mb-1">✉️ {{ $vendor->email }}</p>
                    @endif
                    @if($vendor->address)
                    <p class="text-sm text-gray-600">📍 {{ $vendor->address }}</p>
                    @endif
                </div>
            </div>

            {{-- Rating distribution --}}
            @if($reviews->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-5">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm">Distribusi Rating</h3>
                @foreach(range(5,1) as $star)
                @php $count = $ratingDist->get($star, 0); $pct = $reviews->count() ? round($count / $reviews->count() * 100) : 0; @endphp
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-xs text-gray-500 w-4">{{ $star }}</span>
                    <span class="text-gold-400 text-xs">★</span>
                    <div class="flex-1 bg-gray-100 rounded-full h-2">
                        <div class="bg-gold-400 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 w-6 text-right">{{ $count }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Main content --}}
        <div class="md:col-span-2 space-y-6">
            {{-- Description --}}
            @if($vendor->description)
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-6">
                <h2 class="font-serif text-lg font-bold text-gray-900 mb-3">Tentang Vendor</h2>
                <p class="text-gray-600 leading-relaxed">{{ $vendor->description }}</p>
            </div>
            @endif

            {{-- Write review (clients only) --}}
            @auth
            @if(auth()->user()->role === 'client')
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 p-6">
                <h2 class="font-serif text-lg font-bold text-gray-900 mb-4">
                    {{ $userReview ? '✏️ Edit Ulasan Anda' : '✍️ Tulis Ulasan' }}
                </h2>
                @if(session('success'))
                <div class="bg-green-50 text-green-700 rounded-xl px-4 py-3 text-sm mb-4">{{ session('success') }}</div>
                @endif
                <form action="{{ route('vendors.reviews.store', $vendor) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2">Rating *</label>
                        <div class="flex gap-2" x-data="{ rating: {{ $userReview?->rating ?? 0 }} }">
                            @for($i=1; $i<=5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only"
                                       {{ ($userReview?->rating ?? 0) == $i ? 'checked' : '' }}>
                                <span class="text-3xl transition-colors hover:text-gold-400
                                    {{ ($userReview?->rating ?? 0) >= $i ? 'text-gold-400' : 'text-gray-200' }}">★</span>
                            </label>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Judul</label>
                        <input name="title" value="{{ $userReview?->title }}" placeholder="Singkat & informatif"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-1 focus:ring-gold-400 focus:border-gold-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Ulasan *</label>
                        <textarea name="review" rows="4" required placeholder="Ceritakan pengalaman Anda dengan vendor ini..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-1 focus:ring-gold-400 focus:border-gold-400 resize-none">{{ $userReview?->review }}</textarea>
                    </div>
                    <button type="submit"
                            class="bg-gold-500 hover:bg-gold-400 text-white px-8 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
            @endif
            @endauth

            {{-- Reviews list --}}
            <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
                <div class="px-6 py-4 bg-ivory-200 border-b border-gold-100">
                    <h2 class="font-semibold text-gray-700">💬 Ulasan ({{ $reviews->count() }})</h2>
                </div>
                @if($reviews->isEmpty())
                <div class="p-10 text-center text-gray-400">
                    <p class="text-4xl mb-2">💬</p>
                    <p class="text-sm">Belum ada ulasan. Jadilah yang pertama!</p>
                </div>
                @else
                <div class="divide-y divide-gray-50">
                    @foreach($reviews as $review)
                    <div class="px-6 py-5">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $review->user->name }}</p>
                                <div class="flex gap-0.5 mt-0.5">
                                    @for($i=1; $i<=5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-gold-400' : 'text-gray-200' }} text-sm">★</span>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $review->created_at->isoFormat('D MMM Y') }}</span>
                        </div>
                        @if($review->title)
                        <p class="font-medium text-gray-700 text-sm mb-1">{{ $review->title }}</p>
                        @endif
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->review }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
