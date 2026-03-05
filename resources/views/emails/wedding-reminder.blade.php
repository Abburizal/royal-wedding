<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body { font-family: 'Georgia', serif; background: #FAFAF7; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: #1a1a1a; padding: 40px; text-align: center; }
  .header h1 { color: #C6A75E; font-size: 26px; margin: 0; letter-spacing: 2px; }
  .header p { color: #888; font-size: 12px; margin: 8px 0 0; letter-spacing: 3px; text-transform: uppercase; }
  .countdown { background: linear-gradient(135deg, #1a1a1a 0%, #2d2417 100%); padding: 32px 40px; text-align: center; }
  .countdown .days { font-size: 72px; font-weight: bold; color: #C6A75E; line-height: 1; }
  .countdown .label { color: #888; font-size: 14px; letter-spacing: 4px; text-transform: uppercase; margin-top: 8px; }
  .body { padding: 40px; }
  .body h2 { color: #1a1a1a; font-size: 20px; margin: 0 0 16px; }
  .body p { color: #555; font-size: 15px; line-height: 1.7; margin: 0 0 16px; }
  .checklist-box { background: #FAFAF7; border: 1px solid #F0DFA8; border-radius: 12px; padding: 20px 24px; margin: 20px 0; }
  .checklist-item { display: flex; align-items: center; gap: 12px; padding: 8px 0; color: #555; font-size: 14px; border-bottom: 1px solid #f0ede4; }
  .checklist-item:last-child { border-bottom: none; }
  .dot { width: 10px; height: 10px; border-radius: 50%; background: #C6A75E; flex-shrink: 0; }
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
  <div class="countdown">
    <div class="days">{{ $daysLeft }}</div>
    <div class="label">Hari Lagi Menuju Hari Istimewa</div>
  </div>
  <div class="body">
    <h2>Halo, {{ $wedding->client->name }}! 💍</h2>
    <p>Tinggal <strong>{{ $daysLeft }} hari</strong> lagi menuju hari pernikahan
    <strong>{{ $wedding->couple_name }}</strong> pada
    <strong>{{ $wedding->wedding_date->isoFormat('dddd, D MMMM Y') }}</strong>.</p>

    @php
      $pendingTasks = $wedding->checklistTasks->where('status', '!=', 'done');
    @endphp

    @if($pendingTasks->count() > 0)
    <p>Masih ada <strong>{{ $pendingTasks->count() }} task checklist</strong> yang belum selesai:</p>
    <div class="checklist-box">
      @foreach($pendingTasks->take(5) as $task)
      <div class="checklist-item"><div class="dot"></div>{{ $task->task_name }}</div>
      @endforeach
      @if($pendingTasks->count() > 5)
      <div class="checklist-item"><div class="dot"></div>...dan {{ $pendingTasks->count() - 5 }} lainnya</div>
      @endif
    </div>
    @else
    <p>🎉 Semua checklist sudah selesai! Tim kami siap memastikan hari istimewa Anda sempurna.</p>
    @endif

    <a href="{{ config('app.url') }}/my-wedding/dashboard" class="btn">Cek Dashboard Saya →</a>
    <p style="color:#aaa;font-size:13px;">Ada yang ingin didiskusikan? Hubungi wedding planner Anda.</p>
  </div>
  <div class="footer">© {{ date('Y') }} The Royal Wedding by Ully Sjah · Luxury Wedding Organizer</div>
</div>
</body>
</html>
