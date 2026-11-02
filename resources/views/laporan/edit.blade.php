@extends('layouts.app')
@section('title', 'Edit Laporan #' . $laporan->id)
@section('width', 'narrow')

@section('content')
<div class="panel">
    <h2>Edit Laporan #{{ $laporan->id }}</h2>

    <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf @method('PUT')

        <div class="field">
            <label for="status">Status penanganan</label>
            <select id="status" name="status" class="@error('status') is-invalid @enderror">
                @foreach (\App\Models\Laporan::STATUS as $s)
                    <option value="{{ $s }}" @selected(old('status', $laporan->status) === $s)>{{ $s }}</option>
                @endforeach
            </select>
            @error('status') <div class="error">{{ $message }}</div> @enderror
        </div>

        @include('partials.form-fields')

        <div class="actions">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a class="btn btn-light" href="{{ route('laporan.show', $laporan) }}">Batal</a>
        </div>
    </form>
</div>
@endsection
