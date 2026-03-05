@extends('layouts.client')

@section('title', 'Live Chat – The Royal Wedding')

@section('content')
<div class="h-[calc(100vh-4rem)] flex flex-col" x-data="chatApp()" x-init="init()">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-4 flex-shrink-0 shadow-sm">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center shadow">
            <span class="text-white text-sm font-bold">WP</span>
        </div>
        <div class="flex-1">
            <h2 class="font-serif text-gray-900 font-semibold">Wedding Planner</h2>
            <div class="flex items-center gap-1.5 mt-0.5">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs text-gray-500">Online – membalas dalam hitungan menit</span>
            </div>
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-xs text-gray-400">Pernikahan</p>
            <p class="text-sm font-semibold text-gold-700">{{ $wedding->bride_name }} & {{ $wedding->groom_name }}</p>
        </div>
    </div>

    {{-- Messages Area --}}
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-4 bg-gradient-to-b from-gray-50 to-white"
         id="messages-container"
         x-ref="container">

        {{-- Welcome banner --}}
        <div class="text-center">
            <span class="inline-block bg-gold-100 text-gold-700 text-xs px-4 py-1.5 rounded-full font-medium">
                💍 Percakapan dengan Wedding Planner Anda
            </span>
        </div>

        {{-- Initial messages (server-rendered) --}}
        @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} gap-2.5">
                @if($msg->sender_id !== auth()->id())
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-auto">
                    {{ strtoupper(substr($msg->sender?->name ?? '?', 0, 1)) }}
                </div>
                @endif
                <div class="max-w-xs sm:max-w-md lg:max-w-lg">
                    @if($msg->sender_id !== auth()->id())
                    <p class="text-xs text-gray-500 mb-1 ml-1">{{ $msg->sender?->name }}</p>
                    @endif
                    <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed
                        {{ $msg->sender_id === auth()->id()
                            ? 'bg-gradient-to-br from-gold-500 to-gold-600 text-white rounded-br-sm shadow-md'
                            : 'bg-white text-gray-800 border border-gray-100 rounded-bl-sm shadow-sm' }}">
                        {{ $msg->message }}
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1 {{ $msg->sender_id === auth()->id() ? 'text-right mr-1' : 'ml-1' }}">
                        {{ $msg->created_at->format('H:i') }} · {{ $msg->created_at->isoFormat('D MMM') }}
                    </p>
                </div>
                @if($msg->sender_id === auth()->id())
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-auto">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <div class="text-4xl mb-3">💬</div>
                <p class="text-gray-400 text-sm">Belum ada pesan. Mulai percakapan dengan planner Anda!</p>
            </div>
        @endforelse

        {{-- Dynamic messages added by JS --}}
        <template x-for="msg in newMessages" :key="msg.id">
            <div :class="msg.mine ? 'flex justify-end gap-2.5' : 'flex justify-start gap-2.5'">
                <div x-show="!msg.mine" class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-auto" x-text="msg.avatar"></div>
                <div class="max-w-xs sm:max-w-md lg:max-w-lg">
                    <p x-show="!msg.mine" class="text-xs text-gray-500 mb-1 ml-1" x-text="msg.sender"></p>
                    <div :class="msg.mine
                        ? 'px-4 py-2.5 rounded-2xl text-sm leading-relaxed bg-gradient-to-br from-gold-500 to-gold-600 text-white rounded-br-sm shadow-md'
                        : 'px-4 py-2.5 rounded-2xl text-sm leading-relaxed bg-white text-gray-800 border border-gray-100 rounded-bl-sm shadow-sm'"
                         x-text="msg.message">
                    </div>
                    <p :class="msg.mine ? 'text-[11px] text-gray-400 mt-1 text-right mr-1' : 'text-[11px] text-gray-400 mt-1 ml-1'"
                       x-text="msg.time + ' · ' + msg.date"></p>
                </div>
                <div x-show="msg.mine" class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-auto">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </template>

        {{-- Typing / loading indicator --}}
        <div x-show="sending" class="flex justify-end gap-2.5">
            <div class="px-4 py-2.5 rounded-2xl bg-gold-100 text-gold-600 text-sm rounded-br-sm animate-pulse">
                Mengirim...
            </div>
        </div>

        {{-- Anchor for scroll-to-bottom --}}
        <div id="chat-bottom" x-ref="bottom"></div>
    </div>

    {{-- Input Area --}}
    <div class="bg-white border-t border-gray-100 px-4 py-3 flex-shrink-0 shadow-lg">
        <div class="flex items-end gap-3 max-w-4xl mx-auto">
            <div class="flex-1 bg-gray-50 rounded-2xl border border-gray-200 focus-within:border-gold-400 focus-within:ring-2 focus-within:ring-gold-100 transition-all overflow-hidden">
                <textarea
                    x-model="newMessage"
                    @keydown.enter.prevent="!$event.shiftKey && sendMessage()"
                    placeholder="Ketik pesan... (Enter untuk kirim, Shift+Enter baris baru)"
                    rows="1"
                    class="w-full bg-transparent px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none resize-none"
                    style="max-height: 120px; overflow-y: auto;"
                    @input="autoResize($event.target)">
                </textarea>
            </div>
            <button
                @click="sendMessage()"
                :disabled="!newMessage.trim() || sending"
                class="w-11 h-11 rounded-xl bg-gradient-to-br from-gold-500 to-gold-600 text-white flex items-center justify-center shadow-md hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0"
                title="Kirim (Enter)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.875L5.999 12zm0 0h7.5" />
                </svg>
            </button>
        </div>
        <p class="text-center text-[11px] text-gray-400 mt-2">Shift+Enter untuk baris baru • Pesan diperbarui otomatis setiap 3 detik</p>
    </div>
</div>

@push('scripts')
<script>
function chatApp() {
    return {
        newMessage: '',
        newMessages: [],
        sending: false,
        lastId: {{ $messages->last()?->id ?? 0 }},
        pollInterval: null,
        fetchUrl: '{{ route("client.messages.fetch") }}',
        storeUrl: '{{ route("client.messages.store") }}',
        csrfToken: document.querySelector('meta[name="csrf-token"]').content,

        init() {
            this.scrollToBottom(false);
            this.startPolling();
        },

        startPolling() {
            this.pollInterval = setInterval(() => this.poll(), 3000);
        },

        async poll() {
            try {
                const res = await fetch(`${this.fetchUrl}?after=${this.lastId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(m => {
                        this.newMessages.push(m);
                        this.lastId = Math.max(this.lastId, m.id);
                    });
                    this.$nextTick(() => this.scrollToBottom(true));
                }
            } catch (e) { /* silently ignore network errors */ }
        },

        async sendMessage() {
            const text = this.newMessage.trim();
            if (!text || this.sending) return;

            this.sending = true;
            this.newMessage = '';

            try {
                const res = await fetch(this.storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ message: text })
                });
                const msg = await res.json();
                if (msg.id) {
                    this.newMessages.push(msg);
                    this.lastId = Math.max(this.lastId, msg.id);
                    this.$nextTick(() => this.scrollToBottom(true));
                }
            } catch (e) {
                alert('Gagal mengirim pesan. Coba lagi.');
                this.newMessage = text;
            } finally {
                this.sending = false;
            }
        },

        scrollToBottom(smooth = true) {
            const el = document.getElementById('chat-bottom');
            if (el) el.scrollIntoView({ behavior: smooth ? 'smooth' : 'auto' });
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 120) + 'px';
        }
    }
}
</script>
@endpush
@endsection
