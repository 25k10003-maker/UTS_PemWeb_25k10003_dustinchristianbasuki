<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SiAkad-003') · SiAkad-003</title>
    <style>
        :root { 
            --bg:#f4f6f9; --card:#fff; --text:#1f2937; --muted:#6b7280; --line:#e5e7eb;
            --primary:#2563eb; --primary-d:#1d4ed8; --danger:#dc2626; --success:#16a34a; --warn:#d97706; 
        }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background:var(--bg); color:var(--text); }
        a { color: var(--primary); text-decoration: none; }
        nav { background:#111827; color:#fff; padding:12px 24px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; }
        nav .brand { font-weight:700; font-size:18px; margin-right:auto; }
        nav .brand span { color:#60a5fa; }
        nav form { margin:0; }
        .container { max-width: 1000px; margin: 28px auto; padding: 0 16px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:10px; padding:24px; box-shadow:0 1px 2px rgba(0,0,0,.04); }
        .narrow { max-width: 440px; margin: 60px auto; }
        h1 { font-size: 22px; margin: 0 0 18px; }
        label { display:block; font-size:14px; font-weight:600; margin: 14px 0 6px; }
        input, select { width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; }
        input:focus, select:focus { outline: 2px solid #bfdbfe; border-color: var(--primary); }
        .btn { display:inline-block; border:0; border-radius:8px; padding:9px 16px; font-size:14px; font-weight:600; cursor:pointer;
               background:var(--primary); color:#fff; }
        .btn:hover { background: var(--primary-d); }
        .btn-sm { padding:6px 11px; font-size:13px; }
        .btn-danger { background: var(--danger); } .btn-danger:hover { background:#b91c1c; }
        .btn-success { background: var(--success); } .btn-success:hover { background:#15803d; }
        .btn-gray { background:#6b7280; } .btn-gray:hover { background:#4b5563; }
        .btn-block { width:100%; margin-top:20px; padding:11px; }
        .alert { padding:12px 14px; border-radius:8px; margin-bottom:16px; font-size:14px; }
        .alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
        .alert-success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
        .field-error { color: var(--danger); font-size: 13px; margin-top: 4px; }
        table { width:100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 10px 12px; border-bottom: 1px solid var(--line); text-align:left; vertical-align: middle; }
        th { background:#f9fafb; font-size:12px; text-transform: uppercase; letter-spacing:.04em; color: var(--muted); }
        td.num, th.num { text-align:right; }
        .badge { display:inline-block; padding:3px 9px; border-radius:999px; font-size:12px; font-weight:700; text-transform:uppercase; }
        .badge-admin { background:#fde68a; color:#78350f; }
        .badge-operator { background:#bfdbfe; color:#1e3a8a; }
        .timer { font-size:13px; background:#1f2937; padding:5px 10px; border-radius:6px; font-variant-numeric: tabular-nums; }
        .timer.low { background: var(--danger); }
        .toolbar { display:flex; gap:10px; align-items:center; margin-bottom:16px; flex-wrap:wrap; }
        .toolbar form { display:flex; gap:8px; margin:0; }
        .toolbar input { width: 220px; }
        .inline { display:inline-flex; gap:6px; align-items:center; margin:0; }
        .inline input { width: 70px; padding:6px 8px; }
        .muted { color: var(--muted); font-size: 14px; }
        .stock-low { color: var(--danger); font-weight:700; }
        .table-wrap { overflow-x:auto; }
    </style>
</head>
<body>
@if (session('api_token'))
    <nav>
        <div class="brand">SiAkad-<span>003</span></div>
        <a href="{{ route('barang.index') }}" style="color:#fff">Data Barang</a>
        @if (session('api_user.role') === 'admin')
            <a href="{{ route('register') }}" style="color:#fff">Register User</a>
        @endif
        <span>{{ session('api_user.name') }}
            <span class="badge badge-{{ session('api_user.role') }}">{{ session('api_user.role') }}</span></span>
        <span class="timer" id="token-timer" data-expires="{{ session('api_expires_at') }}">Token: --</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-gray">Logout</button>
        </form>
    </nav>
@endif

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script>
    (function () {
        const el = document.getElementById('token-timer');
        if (!el || !el.dataset.expires) return;
        const expires = new Date(el.dataset.expires).getTime();
        function tick() {
            const sisa = Math.max(0, Math.round((expires - Date.now()) / 1000));
            el.textContent = 'Token: ' + sisa + ' dtk';
            el.classList.toggle('low', sisa <= 15);
            if (sisa <= 0) { clearInterval(t); window.location.reload(); }
        }
        const t = setInterval(tick, 1000);
        tick();
    })();
</script>
</body>
</html>