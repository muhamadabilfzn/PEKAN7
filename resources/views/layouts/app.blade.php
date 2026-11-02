<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LaporBanjir') — BPBD Kabupaten Bandung</title>
    <style>
        :root { --bg:#EEF0EA; --ink:#1B2430; --paper:#fff; --water:#1E6E86; --alert:#BE6A2B; --line:#C7CCC2; --ok:#2F7D4F; --bad:#B3392F; }
        * { box-sizing: border-box; }
        body { margin:0; background:var(--bg); color:var(--ink); font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; line-height:1.5; }
        a { color:var(--water); }
        .masthead { background:var(--ink); color:#fff; border-bottom:4px solid var(--water); }
        .masthead .in { max-width:1000px; margin:0 auto; padding:20px 16px; display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; }
        .masthead small { display:block; color:#b9c2cb; font-size:13px; }
        .masthead h1 { margin:0; font-size:24px; font-family:Georgia,serif; }
        .masthead nav { display:flex; gap:14px; align-items:center; font-size:14px; }
        .masthead nav a, .masthead nav button { color:#fff; background:none; border:0; cursor:pointer; font:inherit; text-decoration:underline; padding:0; }
        .wrap { max-width:1000px; margin:0 auto; padding:28px 16px 48px; }
        .narrow { max-width:640px; }
        .panel { background:var(--paper); border:1px solid var(--line); padding:28px; }
        h2 { margin:0 0 16px; font-family:Georgia,serif; }
        .field { margin-bottom:20px; }
        label { display:block; font-size:13px; color:#4d5560; margin-bottom:6px; }
        input[type=text], input[type=email], input[type=password], input[type=number], select, textarea, input[type=file] {
            width:100%; border:1px solid var(--line); background:#fff; padding:9px 10px; font:inherit; color:var(--ink); }
        input:focus, select:focus, textarea:focus { outline:2px solid var(--water); outline-offset:0; }
        .is-invalid { border-color:var(--bad) !important; }
        .error { color:var(--bad); font-size:13px; margin-top:5px; }
        .hint { color:#777; font-size:12.5px; margin-top:5px; }
        .row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        @media (max-width:600px){ .row { grid-template-columns:1fr; } }
        .btn { display:inline-block; background:var(--ink); color:#fff; border:0; padding:10px 18px; font:inherit; font-weight:600; cursor:pointer; text-decoration:none; }
        .btn:hover { background:var(--water); }
        .btn-light { background:#fff; color:var(--ink); border:1px solid var(--line); }
        .btn-light:hover { background:#f3f4f0; }
        .btn-danger { background:var(--bad); }
        .btn-danger:hover { background:#8f2c24; }
        .btn-sm { padding:5px 10px; font-size:13px; }
        .alert { padding:12px 16px; margin-bottom:20px; border-left:4px solid; background:#fff; }
        .alert-success { border-color:var(--ok); color:#1d5a37; background:#eaf5ee; }
        .alert-error { border-color:var(--bad); color:#7d2820; background:#fbeceb; }
        table { width:100%; border-collapse:collapse; background:#fff; border:1px solid var(--line); }
        th, td { text-align:left; padding:10px 12px; border-bottom:1px solid var(--line); vertical-align:middle; font-size:14px; }
        th { background:#f6f7f3; font-size:12px; text-transform:uppercase; letter-spacing:.04em; color:#4d5560; }
        .thumb { width:72px; height:54px; object-fit:cover; border:1px solid var(--line); display:block; }
        .badge { display:inline-block; padding:2px 10px; font-size:12px; font-weight:600; border-radius:99px; }
        .b-Menunggu { background:#fdf0dc; color:#8a5314; }
        .b-Diproses { background:#dcecf2; color:#14566a; }
        .b-Selesai  { background:#dff1e5; color:#1d5a37; }
        .actions { display:flex; gap:6px; flex-wrap:wrap; }
        .overflow { overflow-x:auto; }
        dl { display:grid; grid-template-columns:150px 1fr; gap:10px 16px; margin:0; }
        dt { color:#4d5560; font-size:13px; }
        dd { margin:0; }
        @media (max-width:600px){ dl { grid-template-columns:1fr; gap:2px; } dd { margin-bottom:10px; } }
        .photo { max-width:100%; max-height:420px; border:1px solid var(--line); display:block; }
        .pagination { margin-top:18px; }
        .pg { display:flex; gap:4px; flex-wrap:wrap; list-style:none; padding:0; margin:0; }
        .pg a, .pg span { display:block; padding:6px 12px; border:1px solid var(--line); background:#fff; text-decoration:none; font-size:14px; color:var(--ink); }
        .pg .active span { background:var(--ink); color:#fff; border-color:var(--ink); }
        .pg .disabled span { color:#aaa; }
        .head { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px; }
        .head h2 { margin:0; }
    </style>
</head>
<body>
    <header class="masthead">
        <div class="in">
            <div>
                <small>Badan Penanggulangan Bencana Daerah — Kabupaten Bandung</small>
                <h1>LaporBanjir</h1>
            </div>
            <nav>
                @auth
                    <a href="{{ route('laporan.index') }}">Daftar Laporan</a>
                    <a href="{{ route('laporan.create') }}">Form Warga</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit">Keluar ({{ auth()->user()->name }})</button>
                    </form>
                @else
                    <a href="{{ route('laporan.create') }}">Lapor Banjir</a>
                    <a href="{{ route('login') }}">Login Petugas</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="wrap @yield('width')">
        @include('partials.flash')
        @yield('content')
    </main>
</body>
</html>
