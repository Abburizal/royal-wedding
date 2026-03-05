<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #2d2d2d; background: #fff; }

.header { background: #1a1a2e; color: #fff; padding: 32px 40px; }
.brand { font-size: 22px; font-weight: bold; color: #D4A017; letter-spacing: 2px; }
.brand-sub { font-size: 10px; color: #aaa; letter-spacing: 3px; margin-top: 2px; }
.invoice-title { font-size: 32px; font-weight: bold; color: #D4A017; float: right; margin-top: -30px; }

.gold-line { height: 2px; background: #D4A017; margin: 0; }

.body { padding: 32px 40px; }

.meta-grid { display: table; width: 100%; margin-bottom: 28px; }
.meta-left, .meta-right { display: table-cell; width: 50%; vertical-align: top; }
.meta-right { text-align: right; }
.meta-label { font-size: 9px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
.meta-value { font-size: 13px; font-weight: bold; color: #1a1a2e; }
.meta-sub { font-size: 11px; color: #666; margin-top: 2px; }

.section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #999; margin-bottom: 8px; border-bottom: 1px solid #f0f0f0; padding-bottom: 6px; }

.info-box { background: #fafaf8; border: 1px solid #ede8d8; border-left: 3px solid #D4A017; padding: 14px 18px; margin-bottom: 24px; border-radius: 4px; }
.info-row { display: table; width: 100%; margin-bottom: 6px; }
.info-label { display: table-cell; width: 140px; color: #777; font-size: 11px; }
.info-data { display: table-cell; font-weight: bold; font-size: 11px; }

.amount-box { background: #1a1a2e; color: #fff; padding: 20px 24px; border-radius: 4px; margin-bottom: 24px; }
.amount-label { font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; }
.amount-value { font-size: 28px; font-weight: bold; color: #D4A017; margin-top: 4px; }
.amount-type { font-size: 11px; color: #aaa; margin-top: 2px; }

.status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
.status-pending  { background: #fff8e1; color: #e65100; border: 1px solid #ffcc02; }
.status-uploaded { background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9; }
.status-verified { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
.status-rejected { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

.notes-box { background: #fffdf5; border: 1px solid #f0e9c8; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 11px; color: #666; }

.footer { border-top: 1px solid #f0e9c8; padding: 20px 40px; text-align: center; }
.footer-brand { font-size: 13px; font-weight: bold; color: #D4A017; margin-bottom: 4px; }
.footer-info { font-size: 10px; color: #999; line-height: 1.6; }

.clearfix::after { content: ''; display: table; clear: both; }
</style>
</head>
<body>

<div class="header clearfix">
    <div class="brand">✦ THE ROYAL WEDDING</div>
    <div class="brand-sub">BY ULLY SJAH — LUXURY WEDDING ORGANIZER</div>
    <div class="invoice-title">INVOICE</div>
</div>
<div class="gold-line"></div>

<div class="body">

    {{-- Invoice Meta --}}
    <div class="meta-grid" style="margin-top:24px; margin-bottom:28px;">
        <div class="meta-left">
            <div class="meta-label">No. Invoice</div>
            <div class="meta-value">{{ $payment->invoice_number }}</div>
            <div class="meta-sub">Tanggal dibuat: {{ $payment->created_at->format('d M Y') }}</div>
        </div>
        <div class="meta-right">
            <div class="meta-label">Status</div>
            <span class="status-badge status-{{ $payment->status }}">
                {{ strtoupper($payment->status) }}
            </span>
            @if($payment->due_date)
            <div class="meta-sub" style="margin-top:6px;">Jatuh tempo: {{ $payment->due_date->format('d M Y') }}</div>
            @endif
            @if($payment->paid_at)
            <div class="meta-sub">Dibayar: {{ $payment->paid_at->format('d M Y') }}</div>
            @endif
        </div>
    </div>

    {{-- Client Info --}}
    <div class="section-title">Informasi Klien</div>
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nama Klien</div>
            <div class="info-data">{{ $payment->wedding->client->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-data">{{ $payment->wedding->client->email }}</div>
        </div>
        @if($payment->wedding->client->phone)
        <div class="info-row">
            <div class="info-label">No. HP</div>
            <div class="info-data">{{ $payment->wedding->client->phone }}</div>
        </div>
        @endif
    </div>

    {{-- Wedding Info --}}
    <div class="section-title">Informasi Pernikahan</div>
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Pasangan</div>
            <div class="info-data">{{ $payment->wedding->couple_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Paket</div>
            <div class="info-data">{{ $payment->wedding->package->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Pernikahan</div>
            <div class="info-data">{{ $payment->wedding->wedding_date->format('d M Y') }}</div>
        </div>
        @if($payment->wedding->venue_name)
        <div class="info-row">
            <div class="info-label">Venue</div>
            <div class="info-data">{{ $payment->wedding->venue_name }}@if($payment->wedding->venue_city), {{ $payment->wedding->venue_city }}@endif</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Total Paket</div>
            <div class="info-data">Rp {{ number_format($payment->wedding->total_price, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Amount --}}
    <div class="amount-box">
        <div class="amount-label">
            {{ match($payment->type) {
                'down_payment' => 'Down Payment (DP)',
                'installment'  => 'Cicilan',
                'full_payment' => 'Pelunasan',
                default        => 'Pembayaran',
            } }}
        </div>
        <div class="amount-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
        @php $pct = $payment->wedding->total_price > 0 ? round(($payment->amount / $payment->wedding->total_price) * 100) : 0; @endphp
        <div class="amount-type">{{ $pct }}% dari total nilai kontrak</div>
    </div>

    {{-- Notes --}}
    @if($payment->notes)
    <div class="notes-box">
        <strong>Catatan:</strong> {{ $payment->notes }}
    </div>
    @endif

    {{-- Payment Summary --}}
    @php
        $verified = $payment->wedding->payments->where('status','verified')->sum('amount');
        $remaining = max(0, $payment->wedding->total_price - $verified);
    @endphp
    <div class="section-title">Ringkasan Pembayaran</div>
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Total Nilai Kontrak</div>
            <div class="info-data">Rp {{ number_format($payment->wedding->total_price, 0, ',', '.') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Total Sudah Dibayar</div>
            <div class="info-data" style="color: #2e7d32;">Rp {{ number_format($verified, 0, ',', '.') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Sisa Pembayaran</div>
            <div class="info-data" style="color: {{ $remaining > 0 ? '#c62828' : '#2e7d32' }}; font-size:14px;">
                Rp {{ number_format($remaining, 0, ',', '.') }}
            </div>
        </div>
    </div>

</div>

<div class="footer">
    <div class="footer-brand">✦ The Royal Wedding by Ully Sjah</div>
    <div class="footer-info">
        📞 +62 812-3456-7890 &nbsp;|&nbsp; 📧 info@theroyalwedding.id &nbsp;|&nbsp; 📍 Jakarta, Indonesia<br>
        Invoice ini diterbitkan secara resmi oleh The Royal Wedding by Ully Sjah.<br>
        Dokumen ini sah tanpa tanda tangan basah.
    </div>
</div>

</body>
</html>
