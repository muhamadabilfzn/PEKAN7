@if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error" role="alert">{{ session('error') }}</div>
@endif
@if ($errors->any() && !request()->routeIs('login'))
    <div class="alert alert-error" role="alert">Terdapat isian yang belum sesuai. Periksa pesan di bawah setiap kolom.</div>
@endif
