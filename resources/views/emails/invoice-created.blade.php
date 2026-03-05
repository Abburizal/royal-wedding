<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body { font-family: 'Georgia', serif; background: #FAFAF7; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: #1a1a1a; padding: 40px 40px 30px; text-align: center; }
  .header h1 { color: #C6A75E; font-size: 26px; margin: 0; letter-spacing: 2px; }
  .header p { color: #888; font-size: 12px; margin: 8px 0 0; letter-spacing: 3px; text-transform: uppercase; }
  .body { padding: 40px; }
  .body h2 { color: #1a1a1a; font-size: 20px; margin: 0 0 16px; }
  .body p { color: #555; font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
  .invoice-box { background: #FAFAF7; border: 1px solid #F0DFA8; border-radius: 12px; padding: 24px; margin: 24px 0; }
  .invoice-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0ede4; font-size: 14px; }
  .invoice-row:last-child { border-bottom: none; font-weight: bold; color: #B08D44; font-size: 16px; }
  .invoice-row span:first-child { color: #888; }
  .btn { display: inline-block; background: #C6A75E; color: #fff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: bold; margin: 16px 0; letter-spacing: 1px; }
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
    <h2>Invoice Pembayaran Telah Dibuat 📄</h2>
    <p>Halo <strong>{{ $payment->wedding->client->name }}</strong>,</p>
    <p>Kami telah membuat invoice pembayaran untuk pernikahan <strong>{{ $payment->wedding->couple_name }}</strong>. Silakan lakukan pembayaran sebelum jatuh tempo.</p>

    <div class="invoice-box">
      <div class="invoice-row"><span>No. Invoice</span><span>{{ $payment->invoice_number }}</span></div>
      <div class="invoice-row"><span>Tipe</span><span class="capitalize">{{ strtoupper($payment->type) }}</span></div>
      <div class="invoice-row"><span>Jatuh Tempo</span><span>{{ $payment->due_date ? $payment->due_date->format('d M Y') : '-' }}</span></div>
      <div class="invoice-row"><span>Total</span><span>{{ $payment->formatted_amount }}</span></div>
    </div>

    <p>Setelah transfer, upload bukti pembayaran melalui dashboard Anda.</p>
    <a href="{{ config('app.url') }}/my-wedding/payments" class="btn">Lihat Dashboard →</a>
    <p style="color:#aaa;font-size:13px;">Jika ada pertanyaan, balas email ini atau hubungi tim kami.</p>
  </div>
  <div class="footer">
    © {{ date('Y') }} The Royal Wedding by Ully Sjah · Luxury Wedding Organizer
  </div>
</div>
</body>
</html>
