@extends('layouts.app')
@section('title', 'Form Pelaporan Banjir')
@section('width', 'narrow')

@section('content')
<div class="panel">
    <h2>Form Pelaporan Banjir</h2>
    <p style="color:#555;font-size:14px;margin-top:-8px">Isi data berikut untuk melaporkan banjir di wilayah Anda, lengkap dengan foto kondisi sebagai bukti.</p>

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @include('partials.form-fields')
        <button type="submit" class="btn">Kirim Laporan</button>
    </form>
</div>
@endsection
