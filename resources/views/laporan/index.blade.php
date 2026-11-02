@extends('layouts.app')
@section('title', 'Daftar Laporan')

@section('content')
<div class="head">
    <h2>Daftar Laporan Banjir</h2>
    <span style="color:#666;font-size:14px">Total: {{ $laporans->total() }} laporan</span>
</div>

<div class="overflow">
<table>
    <thead>
        <tr>
            <th>#</th><th>Foto</th><th>Pelapor</th><th>Lokasi</th><th>Tinggi air</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($laporans as $i => $l)
        <tr>
            <td>{{ $laporans->firstItem() + $i }}</td>
            <td><img class="thumb" src="{{ asset('storage/' . $l->foto) }}" alt="Foto laporan {{ $l->id }}"></td>
            <td>{{ $l->nama_pelapor }}<br><small style="color:#777">{{ $l->created_at->format('d/m/Y H:i') }}</small></td>
            <td>{{ $l->lokasi }}<br><small style="color:#777">Kec. {{ $l->kecamatan }}</small></td>
            <td>{{ $l->tinggi_air }} cm</td>
            <td><span class="badge b-{{ $l->status }}">{{ $l->status }}</span></td>
            <td>
                <div class="actions">
                    <a class="btn btn-light btn-sm" href="{{ route('laporan.show', $l) }}">Detail</a>
                    <a class="btn btn-light btn-sm" href="{{ route('laporan.edit', $l) }}">Edit</a>
                    <form action="{{ route('laporan.destroy', $l) }}" method="POST" onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" style="text-align:center;color:#777;padding:28px">Belum ada laporan masuk.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="pagination">{{ $laporans->links('partials.pagination') }}</div>
@endsection
