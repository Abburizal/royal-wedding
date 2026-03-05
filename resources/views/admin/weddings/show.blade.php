@extends('layouts.dashboard')
@section('title', 'Detail Wedding')
@section('page-title', 'Detail Wedding')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-card border border-gold-100">
        <div class="flex justify-between items-start mb-5">
            <div>
                <h2 class="font-serif text-2xl text-gray-800">{{ $wedding->couple_name }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $wedding->wedding_date->isoFormat('dddd, D MMMM Y') }}
                    @if($wedding->venue_name) · {{ $wedding->venue_name }} @endif
                </p>
            </div>
            <div class="flex gap-2 items-center">
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                    {{ match($wedding->status) {
                        'confirmed'   => 'bg-blue-50 text-blue-700',
                        'in_progress' => 'bg-amber-50 text-amber-700',
                        'completed'   => 'bg-green-50 text-green-700',
                        'cancelled'   => 'bg-red-50 text-red-600',
                        default       => 'bg-gray-100 text-gray-600'
                    } }}">
                    {{ ucfirst(str_replace('_', ' ', $wedding->status)) }}
                </span>
                <a href="{{ route('admin.weddings.edit', $wedding) }}" class="bg-gold-50 hover:bg-gold-100 text-gold-700 px-4 py-2 rounded-xl text-sm font-medium">Edit</a>
                <form action="{{ route('admin.weddings.destroy', $wedding) }}" method="POST"
                      onsubmit="return confirm('Hapus wedding ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-medium">Hapus</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Klien</p>
                <p class="font-semibold text-gray-800">{{ $wedding->client->name }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Planner</p>
                <p class="font-semibold text-gray-800">{{ $wedding->planner->name ?? 'Belum assigned' }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Paket</p>
                <p class="font-semibold text-gray-800">{{ $wedding->package->name }}</p>
            </div>
            <div class="bg-ivory-100 rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-1">Total Tamu</p>
                <p class="font-semibold text-gray-800">{{ $wedding->estimated_guests }} pax</p>
            </div>
        </div>

        @if($wedding->special_notes)
        <div class="mt-4 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-sm text-amber-800">
            📝 {{ $wedding->special_notes }}
        </div>
        @endif

        {{-- Assign planner --}}
        <div class="mt-5 border-t border-gold-100 pt-5">
            <form action="{{ route('admin.weddings.assign-planner', $wedding) }}" method="POST" class="flex gap-3 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Assign Planner</label>
                    <select name="planner_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-gold-400 outline-none">
                        <option value="">-- Pilih --</option>
                        @foreach(\App\Models\User::where('role','wedding_planner')->get() as $p)
                        <option value="{{ $p->id }}" {{ $wedding->planner_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2.5 rounded-xl text-sm font-medium">Assign</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Payments --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
                <h3 class="font-serif text-lg text-gray-800">Pembayaran</h3>
                <div class="text-xs text-gray-500">
                    Lunas: <span class="text-green-700 font-semibold">Rp {{ number_format($wedding->total_paid, 0, ',', '.') }}</span>
                    / Rp {{ number_format($wedding->total_price, 0, ',', '.') }}
                </div>
            </div>

            @if(session('payment_success'))
                <div class="mx-4 mt-3 p-2.5 bg-green-50 text-green-700 rounded-lg text-xs">{{ session('payment_success') }}</div>
            @endif

            <div class="divide-y divide-gray-50">
                @forelse($wedding->payments as $payment)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $payment->invoice_number }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ str_replace('_', ' ', $payment->type) }} · {{ $payment->formatted_amount }}</p>
                        @if($payment->due_date)
                            <p class="text-xs text-gray-400">Jatuh tempo: {{ $payment->due_date->format('d M Y') }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $payment->status_badge_color }}">{{ ucfirst($payment->status) }}</span>
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-xs text-gold-600 hover:text-gold-700 px-2 py-1 rounded border border-gold-200">Detail</a>
                        <a href="{{ route('admin.payments.pdf', $payment) }}" class="text-xs text-slate-600 hover:text-slate-800 px-2 py-1 rounded border border-slate-200">PDF</a>
                        @if(!in_array($payment->status, ['verified']))
                        <form method="POST" action="{{ route('admin.wedding-invoices.destroy', [$wedding, $payment]) }}" onsubmit="return confirm('Hapus invoice ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400 hover:text-red-600 px-1">✕</button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <p class="px-6 py-4 text-sm text-gray-400 text-center">Belum ada pembayaran.</p>
                @endforelse
            </div>

            {{-- Add Invoice Form --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">+ Buat Invoice Baru</p>
                <form method="POST" action="{{ route('admin.wedding-invoices.store', $wedding) }}" class="grid grid-cols-2 gap-3">
                    @csrf
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Jenis</label>
                        <select name="type" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                            <option value="down_payment">Down Payment</option>
                            <option value="installment">Cicilan</option>
                            <option value="full_payment">Pelunasan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Nominal (Rp)</label>
                        <input type="number" name="amount" min="1000" placeholder="5000000"
                            class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Jatuh Tempo</label>
                        <input type="date" name="due_date" min="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Catatan (opsional)</label>
                        <input type="text" name="notes" placeholder="Catatan invoice"
                            class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                    </div>
                    <div class="col-span-2">
                        <button type="submit" class="w-full py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg transition">
                            Buat Invoice & Kirim Notifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Checklist --}}
        <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
                <h3 class="font-serif text-lg text-gray-800">Checklist</h3>
                <span class="text-xs font-semibold text-gold-600">{{ $wedding->checklist_progress }}% selesai</span>
            </div>
            <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                @forelse($wedding->checklistTasks->take(10) as $task)
                <div class="px-6 py-2.5 flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full flex-shrink-0 {{ $task->status === 'done' ? 'bg-green-500' : ($task->status === 'in_progress' ? 'bg-amber-400' : 'bg-gray-200') }}"></div>
                    <span class="text-sm text-gray-700 {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">{{ $task->task_name }}</span>
                </div>
                @empty
                <p class="px-6 py-5 text-sm text-gray-400 text-center">Belum ada checklist.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Vendor Assignments --}}
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
            <h3 class="font-serif text-lg text-gray-800">Vendor Terlibat</h3>
            <span class="text-xs text-gray-400">{{ $wedding->vendorAssignments->count() }} vendor</span>
        </div>

        @if(session('vendor_success'))
            <div class="mx-4 mt-3 p-2.5 bg-green-50 text-green-700 rounded-lg text-xs">{{ session('vendor_success') }}</div>
        @endif
        @if(session('vendor_error'))
            <div class="mx-4 mt-3 p-2.5 bg-red-50 text-red-600 rounded-lg text-xs">{{ session('vendor_error') }}</div>
        @endif

        @if($wedding->vendorAssignments->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-ivory-100 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3 text-left">Vendor</th>
                        <th class="px-5 py-3 text-left">Kategori</th>
                        <th class="px-5 py-3 text-left">Harga Deal</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($wedding->vendorAssignments as $va)
                    <tr class="group hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium">{{ $va->vendor->name }}</td>
                        <td class="px-5 py-3 text-gray-500 capitalize">{{ $va->category }}</td>
                        <td class="px-5 py-3">Rp {{ number_format($va->agreed_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs
                                {{ match($va->status) {
                                    'confirmed'  => 'bg-green-50 text-green-700',
                                    'completed'  => 'bg-blue-50 text-blue-700',
                                    'cancelled'  => 'bg-red-50 text-red-600',
                                    default      => 'bg-amber-50 text-amber-700'
                                } }}">
                                {{ ucfirst($va->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                {{-- Quick status update --}}
                                <form method="POST" action="{{ route('admin.wedding-vendors.update', [$wedding, $va]) }}" class="inline-flex items-center gap-1">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="agreed_price" value="{{ $va->agreed_price }}">
                                    <input type="hidden" name="notes" value="{{ $va->notes }}">
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs border border-gray-200 rounded px-1.5 py-1 focus:outline-none focus:border-amber-400 bg-white">
                                        @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $va->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                <form method="POST" action="{{ route('admin.wedding-vendors.destroy', [$wedding, $va]) }}" onsubmit="return confirm('Hapus vendor ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-600 px-1.5 py-1 rounded hover:bg-red-50 transition">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="px-6 py-4 text-sm text-gray-400 text-center">Belum ada vendor di-assign.</p>
        @endif

        {{-- Add Vendor Form --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">+ Assign Vendor Baru</p>
            <form method="POST" action="{{ route('admin.wedding-vendors.store', $wedding) }}" class="grid grid-cols-2 gap-3">
                @csrf
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Vendor</label>
                    <select name="vendor_id" required class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($availableVendors as $v)
                        <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->category }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Kategori Layanan</label>
                    <input type="text" name="category" placeholder="Katering / Foto / Dekorasi" required
                        class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Harga Deal (Rp)</label>
                    <input type="number" name="agreed_price" min="0" required placeholder="0"
                        class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-amber-400">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full py-2 bg-slate-700 hover:bg-slate-600 text-white text-xs font-semibold rounded-lg transition">
                        Assign Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Timeline / Milestones --}}
    @if($wedding->milestones->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-serif text-lg text-gray-800">Timeline Milestones</h3>
            <span class="text-xs text-gray-400">{{ $wedding->milestones->where('status','done')->count() }}/{{ $wedding->milestones->count() }} selesai</span>
        </div>
        <div class="px-6 py-4 space-y-3">
            @foreach($wedding->milestones->sortBy('milestone_date') as $m)
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm {{ $m->status === 'done' ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $m->icon }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium {{ $m->status === 'done' ? 'line-through text-gray-400' : 'text-gray-800' }}">{{ $m->title }}</p>
                    @if($m->milestone_date)
                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($m->milestone_date)->isoFormat('D MMMM Y') }}</p>
                    @endif
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $m->status === 'done' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                    {{ $m->status === 'done' ? 'Selesai' : 'Upcoming' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Budget Breakdown --}}
    @if($wedding->vendorAssignments->isNotEmpty())
    @php
        $totalVendorCost = $wedding->vendorAssignments->sum('agreed_price');
        $revenue = (float) $wedding->total_price;
        $paidAmount = $wedding->payments->where('status','verified')->sum('amount');
        $profit = $revenue - $totalVendorCost;
        $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 1) : 0;
    @endphp
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-serif text-lg text-gray-800">Budget Breakdown</h3>
        </div>
        <div class="px-6 py-5 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div class="bg-blue-50 rounded-xl p-3">
                <p class="text-xs text-blue-500 mb-1">Harga Paket</p>
                <p class="font-bold text-blue-800">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 rounded-xl p-3">
                <p class="text-xs text-red-500 mb-1">Total Biaya Vendor</p>
                <p class="font-bold text-red-700">Rp {{ number_format($totalVendorCost, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 rounded-xl p-3">
                <p class="text-xs text-green-600 mb-1">Estimasi Laba Bersih</p>
                <p class="font-bold {{ $profit >= 0 ? 'text-green-700' : 'text-red-700' }}">Rp {{ number_format($profit, 0, ',', '.') }}</p>
            </div>
            <div class="bg-amber-50 rounded-xl p-3">
                <p class="text-xs text-amber-600 mb-1">Margin</p>
                <p class="font-bold text-amber-700">{{ $margin }}%</p>
            </div>
        </div>
        <div class="px-6 pb-5">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="pb-2">Vendor</th>
                        <th class="pb-2">Kategori</th>
                        <th class="pb-2 text-right">Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($wedding->vendorAssignments as $va)
                    <tr>
                        <td class="py-2 font-medium">{{ $va->vendor->name }}</td>
                        <td class="py-2 text-gray-500 capitalize">{{ $va->category }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($va->agreed_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-semibold border-t border-gray-200">
                        <td class="pt-2" colspan="2">Total</td>
                        <td class="pt-2 text-right">Rp {{ number_format($totalVendorCost, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Internal Notes --}}
    <div class="bg-white rounded-2xl shadow-card border border-yellow-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-yellow-100 flex items-center gap-2">
            <h3 class="font-serif text-lg text-gray-800">🔒 Catatan Internal</h3>
            <span class="text-xs text-gray-400">(tidak terlihat oleh klien)</span>
        </div>

        @if(session('note_success'))
            <div class="mx-6 mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">{{ session('note_success') }}</div>
        @endif

        {{-- Add note form --}}
        <form method="POST" action="{{ route('admin.wedding-notes.store', $wedding) }}" class="px-6 py-4 border-b border-yellow-50">
            @csrf
            <textarea name="content" rows="2" required placeholder="Tulis catatan internal..."
                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-amber-400 resize-none"></textarea>
            <div class="flex justify-end mt-2">
                <button type="submit" class="px-4 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-sm rounded-lg">Simpan Catatan</button>
            </div>
        </form>

        {{-- Note list --}}
        <div class="divide-y divide-gray-50">
            @forelse($wedding->notes as $note)
            <div class="px-6 py-4 flex items-start justify-between gap-4 group">
                <div class="flex-1">
                    <p class="text-sm text-gray-800">{{ $note->content }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $note->author->name ?? '—' }} &middot; {{ $note->created_at->diffForHumans() }}</p>
                </div>
                <form method="POST" action="{{ route('admin.wedding-notes.destroy', [$wedding, $note]) }}"
                      onsubmit="return confirm('Hapus catatan?')" class="opacity-0 group-hover:opacity-100 transition">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs px-2 py-1 rounded">✕</button>
                </form>
            </div>
            @empty
            <p class="px-6 py-4 text-sm text-gray-400">Belum ada catatan internal.</p>
            @endforelse
        </div>
    </div>

    {{-- Chat / Pesan dengan Klien --}}
    <div class="bg-white rounded-2xl shadow-card border border-blue-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-blue-100 flex items-center justify-between">
            <h3 class="font-serif text-lg text-gray-800">💬 Pesan dengan Klien</h3>
            @php $unreadCount = $wedding->messages->where('sender_id', $wedding->client_id)->whereNull('read_at')->count(); @endphp
            @if($unreadCount > 0)
            <span class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }} belum dibaca</span>
            @endif
        </div>

        @if(session('message_success'))
        <div class="mx-6 mt-3 p-2.5 bg-green-50 text-green-700 rounded-lg text-xs">{{ session('message_success') }}</div>
        @endif

        <div class="divide-y divide-gray-50 max-h-64 overflow-y-auto" id="message-thread">
            @forelse($wedding->messages->where('is_internal', false) as $msg)
            <div class="px-6 py-3 flex gap-3 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold
                    {{ $msg->sender_id === auth()->id() ? 'bg-slate-600 text-white' : 'bg-gold-100 text-gold-700' }}">
                    {{ strtoupper(substr($msg->sender->name ?? '?', 0, 1)) }}
                </div>
                <div class="{{ $msg->sender_id === auth()->id() ? 'items-end' : 'items-start' }} flex flex-col max-w-xs">
                    <div class="px-3 py-2 rounded-2xl text-sm
                        {{ $msg->sender_id === auth()->id() ? 'bg-slate-700 text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm' }}">
                        {{ $msg->message }}
                    </div>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $msg->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="px-6 py-6 text-sm text-gray-400 text-center">Belum ada pesan.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('admin.wedding-messages.store', $wedding) }}"
              class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3 items-end">
            @csrf
            <textarea name="message" rows="2" required placeholder="Tulis pesan ke klien..."
                class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-400 resize-none"></textarea>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                Kirim
            </button>
        </form>
    </div>

    {{-- Contract --}}
    @php $contract = $wedding->contracts->first(); @endphp
    <div class="bg-white rounded-2xl shadow-card border border-gold-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gold-100 flex justify-between items-center">
            <h3 class="font-serif text-lg text-gray-800">📄 Kontrak Digital</h3>
            @if($contract)
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $contract->status_color }}">{{ ucfirst($contract->status) }}</span>
            @endif
        </div>
        <div class="px-6 py-4 flex gap-3">
            <a href="{{ route('admin.weddings.contract.create', $wedding) }}"
               class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-semibold rounded-xl transition">
                {{ $contract ? '✏️ Edit Kontrak' : '➕ Buat Kontrak' }}
            </a>
            @if($contract)
            <a href="{{ route('admin.contracts.pdf', $contract) }}" target="_blank"
               class="px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-sm font-semibold rounded-xl transition">
                📄 Download PDF
            </a>
            @if($contract->status === 'signed')
            <p class="text-sm text-green-600 flex items-center gap-1">
                ✅ Ditandatangani oleh {{ $contract->signed_name }} — {{ $contract->signed_at->format('d M Y') }}
            </p>
            @endif
            @endif
        </div>
    </div>

    <a href="{{ route('admin.weddings.index') }}" class="inline-block text-sm text-gold-600 hover:text-gold-700">← Kembali ke daftar wedding</a>
</div>
@endsection

