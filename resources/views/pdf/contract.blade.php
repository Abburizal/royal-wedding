<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #2d2d2d; line-height: 1.6; }
    .page { padding: 40px 50px; }

    .header { text-align: center; border-bottom: 2px solid #c9a96e; padding-bottom: 20px; margin-bottom: 24px; }
    .company-name { font-size: 22px; font-weight: bold; color: #8b6914; letter-spacing: 2px; }
    .company-sub { font-size: 10px; color: #999; letter-spacing: 1px; margin-top: 4px; }
    .divider-gold { width: 60px; height: 2px; background: #c9a96e; margin: 8px auto; }
    .contract-title { font-size: 14px; font-weight: bold; text-align: center; margin-bottom: 6px; letter-spacing: 1px; }

    .info-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
    .info-table td { padding: 5px 8px; font-size: 10.5px; }
    .info-table td:first-child { width: 40%; color: #666; }
    .info-table td:last-child { font-weight: bold; }
    .info-box { background: #fdf8f0; border: 1px solid #e8d5a3; border-radius: 6px; padding: 12px 16px; margin: 14px 0; }

    .section-title { font-size: 11px; font-weight: bold; color: #8b6914; text-transform: uppercase; letter-spacing: 0.5px; margin: 16px 0 8px; border-bottom: 1px solid #e8d5a3; padding-bottom: 4px; }
    .body-text { font-size: 10.5px; white-space: pre-wrap; line-height: 1.8; }

    .signature-area { margin-top: 40px; }
    .sig-table { width: 100%; border-collapse: collapse; }
    .sig-table td { width: 50%; padding: 0 20px; vertical-align: top; text-align: center; }
    .sig-box { border-top: 1px solid #333; margin-top: 60px; padding-top: 8px; font-size: 10px; }

    .status-badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 9px; font-weight: bold; letter-spacing: 1px; }
    .status-signed  { background: #d1fae5; color: #065f46; }
    .status-sent    { background: #dbeafe; color: #1e3a8a; }
    .status-draft   { background: #f3f4f6; color: #374151; }

    .footer { margin-top: 40px; padding-top: 12px; border-top: 1px solid #e8d5a3; text-align: center; font-size: 9px; color: #aaa; }
</style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="company-name">✦ {{ strtoupper($companyName) }} ✦</div>
        <div class="divider-gold"></div>
        <div class="company-sub">LUXURY WEDDING ORGANIZER</div>
    </div>

    <div class="contract-title">SURAT PERJANJIAN KERJA SAMA</div>
    <div style="text-align:center; margin-bottom: 12px;">
        <span class="status-badge status-{{ $contract->status }}">
            STATUS: {{ strtoupper($contract->status) }}
        </span>
    </div>

    <div class="info-box">
        <table class="info-table">
            <tr><td>Nomor Kontrak</td><td>{{ $contract->wedding->wedding_code }}</td></tr>
            <tr><td>Nama Pengantin</td><td>{{ $contract->wedding->bride_name }} & {{ $contract->wedding->groom_name }}</td></tr>
            <tr><td>Paket</td><td>{{ $contract->wedding->package?->name ?? '-' }}</td></tr>
            <tr><td>Tanggal Pernikahan</td><td>{{ $contract->wedding->wedding_date?->format('d M Y') ?? '-' }}</td></tr>
            <tr><td>Lokasi</td><td>{{ $contract->wedding->venue_name }}, {{ $contract->wedding->venue_city }}</td></tr>
            <tr><td>Total Paket</td><td>Rp {{ number_format($contract->wedding->package?->price ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td>Dibuat Pada</td><td>{{ $contract->created_at->format('d M Y') }}</td></tr>
        </table>
    </div>

    <div class="section-title">Isi Perjanjian</div>
    <div class="body-text">{{ strip_tags($contract->contract_body) }}</div>

    @if($contract->status === 'signed')
    <div class="info-box" style="margin-top: 20px; background: #d1fae5; border-color: #6ee7b7;">
        <table class="info-table">
            <tr><td>Ditandatangani Oleh</td><td>{{ $contract->signed_name }}</td></tr>
            <tr><td>Tanggal Tanda Tangan</td><td>{{ $contract->signed_at->isoFormat('D MMMM Y, HH:mm') }}</td></tr>
            <tr><td>IP Address</td><td>{{ $contract->signed_ip }}</td></tr>
        </table>
    </div>
    @endif

    <div class="signature-area">
        <table class="sig-table">
            <tr>
                <td>
                    <div class="sig-box">
                        <strong>Pihak Penyedia Jasa</strong><br>
                        {{ $companyName }}
                    </div>
                </td>
                <td>
                    <div class="sig-box">
                        <strong>Pihak Klien</strong><br>
                        {{ $contract->wedding->bride_name }} & {{ $contract->wedding->groom_name }}
                        @if($contract->signed_at)
                        <br><em>(Ditandatangani Digital {{ $contract->signed_at->format('d/m/Y') }})</em>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dibuat secara digital oleh sistem {{ $companyName }} &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</div>
</body>
</html>
