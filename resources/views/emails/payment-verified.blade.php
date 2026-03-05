<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body { font-family: 'Georgia', serif; background: #FAFAF7; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: #1a1a1a; padding: 40px; text-align: center; }
  .header h1 { color: #C6A75E; font-size: 26px; margin: 0; letter-spacing: 2px; }
  .header p { color: #888; font-size: 12px; margin: 8px 0 0; letter-spacing: 3px; text-transform: uppercase; }
  .badge { display: inline-block; background: #d1fae5; color: #065f46; padding: 10px 24px; border-radius: 50px; font-size: 18px; font-weight: bold; margin: 24px 0 8px; }
  .body { padding: 40px; text-align: center; }
  .body h2 { color: #1a1a1a; font-size: 22px; margin: 0 0 16px; }
  .body p { color: #555; font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
  .detail-box { background: #FAFAF7; border: 1px solid #F0DFA8; border-radius: 12px; padding: 24px; margin: 24px 0; text-align: left; }
  .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0ede4; font-size: 14px; }
  .detail-row:last-child { border-bottom: none; font-weight: bold; color: #065f46; font-size: 15px; }
  .btn { display: inline-block; background: #C6A75E; color: #fff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: bold; margin: 16px 0; }
  .footer { background: #FAFAF7; padding: 24px 40px; text-align: center; color: #aaa; font-size: 12px; border-top: 1px solid #F0DFA8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>✦ The Royal Wedding by Ully Sjah</h1>
    <p>by Ully Sjah</p>
  </div>
  <div class="body">
    <div class="badge">✅ Pembayaran Dikonfirmasi!</div>
    <h2>Terima Kasih atas Pembayaran Anda</h2>
    <p>Halo <strong>{{ $payment->wedding->client->name }}</strong>,<br>
    Pembayaran Anda untuk pernikahan <strong>{{ $payment->wedding->couple_name }}</strong> telah berhasil diverifikasi oleh tim kami.</p>

    <div class="detail-box">
      <div class="detail-row"><span>No. Invoice</span><span>{{ $payment->invoice_number }}</span></div>
      <div class="detail-row"><span>Tipe</span><span>{{ strtoupper($payment->type) }}</span></div>
      <div class="detail-row"><span>Tanggal Verifikasi</span><span>{{ now()->format('d M Y') }}</span></div>
      <div class="detail-row"><span>Jumlah</span><span>{{ $payment->formatted_amount }}</span></div>
    </div>

    <p>Persiapan pernikahan Anda terus berjalan. Pantau progress melalui dashboard Anda.</p>
    <a href="{{ config('app.url') }}/my-wedding/dashboard" class="btn">Lihat Dashboard →</a>
  </div>
  <div class="footer">© {{ date('Y') }} The Royal Wedding by Ully Sjah</div>
</div>
</body>
</html>
