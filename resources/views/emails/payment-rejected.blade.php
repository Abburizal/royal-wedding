<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body { font-family: 'Georgia', serif; background: #FAFAF7; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: #1a1a1a; padding: 40px; text-align: center; }
  .header h1 { color: #C6A75E; font-size: 26px; margin: 0; letter-spacing: 2px; }
  .header p { color: #888; font-size: 12px; margin: 8px 0 0; letter-spacing: 3px; text-transform: uppercase; }
  .body { padding: 40px; }
  .body h2 { color: #1a1a1a; font-size: 20px; margin: 0 0 12px; }
  .body p { color: #555; font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
  .alert-box { background: #fef2f2; border: 1px solid #fca5a5; border-radius: 12px; padding: 20px 24px; margin: 20px 0; }
  .alert-box p { color: #b91c1c; margin: 0; font-size: 14px; }
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
    <h2>❌ Bukti Pembayaran Perlu Diulang</h2>
    <p>Halo <strong>{{ $payment->wedding->client->name }}</strong>,</p>
    <p>Mohon maaf, bukti pembayaran untuk invoice <strong>{{ $payment->invoice_number }}</strong> tidak dapat kami proses.</p>

    @if($payment->notes)
    <div class="alert-box">
      <p><strong>Alasan:</strong> {{ $payment->notes }}</p>
    </div>
    @endif

    <p>Silakan upload ulang bukti pembayaran yang benar melalui dashboard Anda. Jika ada pertanyaan, segera hubungi tim kami.</p>
    <a href="{{ config('app.url') }}/my-wedding/payments" class="btn">Upload Ulang Bukti →</a>
  </div>
  <div class="footer">© {{ date('Y') }} The Royal Wedding by Ully Sjah</div>
</div>
</body>
</html>
