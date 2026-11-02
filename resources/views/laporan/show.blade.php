@extends('layouts.app')
@section('title', 'Detail Laporan #' . $laporan->id)
@section('width', 'narrow')

@section('content')
<div class="panel">
    <div class="head">
        <h2>Detail Laporan #{{ $laporan->id }}</h2>
        <span class="badge b-{{ $laporan->status }}">{{ $laporan->status }}</span>
    </div>

    <img class="photo" src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto kondisi banjir" style="margin-bottom:20px">

    <dl>
        <dt>Nama pelapor</dt><dd>{{ $laporan->nama_pelapor }}</dd>
        <dt>Nomor HP</dt><dd>{{ $laporan->no_hp }}</dd>
        <dt>Lokasi</dt><dd>{{ $laporan->lokasi }}</dd>
        <dt>Kecamatan</dt><dd>{{ $laporan->kecamatan }}</dd>
        <dt>Tinggi air</dt><dd>{{ $laporan->tinggi_air }} cm</dd>
        <dt>Keterangan</dt><dd>{{ $laporan->keterangan ?: '—' }}</dd>
        <dt>Dilaporkan</dt><dd>{{ $laporan->created_at->format('d/m/Y H:i') }}</dd>
        <dt>Diperbarui</dt><dd>{{ $laporan->updated_at->format('d/m/Y H:i') }}</dd>
    </dl>

    <div class="actions" style="margin-top:24px">
        <a class="btn" href="{{ route('laporan.edit', $laporan) }}">Edit / Ubah Status</a>
        <a class="btn btn-light" href="{{ route('laporan.index') }}">Kembali</a>
        <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger" type="submit">Hapus</button>
        </form>
    </div>
</div>
@endsection
