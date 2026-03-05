<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih — RSVP</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#1a1f2e; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        .card { background:#fff; border-radius:24px; max-width:420px; width:100%; padding:48px 32px; text-align:center; box-shadow:0 25px 60px rgba(0,0,0,0.4); }
        .icon { font-size:64px; margin-bottom:20px; }
        .brand { font-family:'Playfair Display',serif; font-size:11px; color:#d4af37; letter-spacing:0.3em; text-transform:uppercase; margin-bottom:20px; }
        h1 { font-family:'Playfair Display',serif; font-size:28px; color:#1f2937; font-weight:700; margin-bottom:12px; }
        p { font-size:14px; color:#6b7280; line-height:1.7; }
        .status-badge { display:inline-block; margin:20px 0; padding:10px 24px; border-radius:999px; font-size:14px; font-weight:600; }
        .confirmed { background:#d1fae5; color:#065f46; }
        .declined { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body>
    <div class="card">
        <p class="brand">✦ The Royal Wedding by Ully Sjah ✦</p>
        <div class="icon">{{ $guest->rsvp_status === 'confirmed' ? '🎉' : '🙏' }}</div>
        <h1>{{ $guest->rsvp_status === 'confirmed' ? 'Terima Kasih!' : 'Pesan Tersampaikan' }}</h1>
        <div class="status-badge {{ $guest->rsvp_status }}">
            {{ $guest->rsvp_label }}
        </div>
        <p>
            @if($guest->rsvp_status === 'confirmed')
                Kami dengan senang hati menyambut kehadiran <strong>{{ $guest->name }}</strong> di hari istimewa kami.
                Sampai bertemu! 💐
            @else
                Kami sangat menghargai tanggapan <strong>{{ $guest->name }}</strong>.
                Semoga kita dapat berjumpa di lain kesempatan. 🌸
            @endif
        </p>
    </div>
</body>
</html>
