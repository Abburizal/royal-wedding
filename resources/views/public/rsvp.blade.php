<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP — {{ $guest->wedding->couple_name ?? 'Pernikahan' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #1a1f2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: #fff; border-radius: 24px; max-width: 480px; width: 100%; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.4); }
        .card-header { background: linear-gradient(135deg, #1a1f2e 0%, #2d3748 100%); padding: 40px 32px; text-align: center; }
        .brand { font-family: 'Playfair Display', serif; font-size: 12px; color: #d4af37; letter-spacing: 0.3em; text-transform: uppercase; margin-bottom: 16px; }
        .couple-name { font-family: 'Playfair Display', serif; font-size: 32px; color: #fff; font-weight: 700; line-height: 1.2; }
        .gold-line { width: 60px; height: 1px; background: #d4af37; margin: 16px auto; }
        .invite-text { color: #9ca3af; font-size: 13px; }
        .card-body { padding: 32px; }
        .greeting { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
        .guest-name { font-family: 'Playfair Display', serif; font-size: 24px; color: #1f2937; font-weight: 700; margin-bottom: 24px; }
        .info-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; color: #4b5563; }
        .info-icon { font-size: 18px; width: 28px; text-align: center; }
        .rsvp-section { margin-top: 28px; }
        .rsvp-label { font-size: 13px; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px; }
        .btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn { padding: 14px; border-radius: 12px; border: none; cursor: pointer; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .btn-confirm { background: #d4af37; color: #fff; }
        .btn-confirm:hover { background: #b8972e; transform: translateY(-1px); }
        .btn-decline { background: #f9fafb; color: #6b7280; border: 2px solid #e5e7eb; }
        .btn-decline:hover { background: #fee2e2; color: #ef4444; border-color: #fca5a5; }
        .already-responded { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 16px; text-align: center; color: #15803d; font-size: 14px; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <p class="brand">✦ The Royal Wedding by Ully Sjah ✦</p>
            <h1 class="couple-name">{{ $guest->wedding->couple_name ?? 'Pernikahan Kami' }}</h1>
            <div class="gold-line"></div>
            <p class="invite-text">Mengundang kehadiran Anda</p>
        </div>
        <div class="card-body">
            <p class="greeting">Kepada Yth.</p>
            <p class="guest-name">{{ $guest->name }}</p>

            @if($guest->wedding->wedding_date)
            <div class="info-row">
                <span class="info-icon">📅</span>
                <span>{{ $guest->wedding->wedding_date->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
            @endif
            @if($guest->wedding->venue_name)
            <div class="info-row">
                <span class="info-icon">📍</span>
                <span>{{ $guest->wedding->venue_name }}{{ $guest->wedding->venue_city ? ', '.$guest->wedding->venue_city : '' }}</span>
            </div>
            @endif
            @if($guest->table_no)
            <div class="info-row">
                <span class="info-icon">🪑</span>
                <span>Meja No. {{ $guest->table_no }}</span>
            </div>
            @endif

            <div class="rsvp-section">
                @if($guest->rsvp_status !== 'pending' && $guest->rsvp_responded_at)
                <div class="already-responded">
                    ✅ Anda sudah konfirmasi: <strong>{{ $guest->rsvp_label }}</strong>
                    <br><small style="color:#6b7280">{{ $guest->rsvp_responded_at->isoFormat('D MMM Y') }}</small>
                </div>
                @else
                <p class="rsvp-label">Konfirmasi Kehadiran Anda</p>
                <div class="btn-group">
                    <form action="{{ route('rsvp.submit', $guest->invitation_token) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-confirm" style="width:100%">✓ Saya Hadir</button>
                    </form>
                    <form action="{{ route('rsvp.submit', $guest->invitation_token) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="declined">
                        <button type="submit" class="btn btn-decline" style="width:100%">✗ Tidak Hadir</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
