@php $l = $laporan ?? null; @endphp

<div class="field">
    <label for="nama_pelapor">Nama pelapor</label>
    <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor', $l?->nama_pelapor) }}" class="@error('nama_pelapor') is-invalid @enderror">
    @error('nama_pelapor') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="no_hp">Nomor HP</label>
    <input type="text" id="no_hp" name="no_hp" inputmode="tel" value="{{ old('no_hp', $l?->no_hp) }}" class="@error('no_hp') is-invalid @enderror">
    @error('no_hp') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="lokasi">Lokasi kejadian (alamat / patokan)</label>
    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $l?->lokasi) }}" class="@error('lokasi') is-invalid @enderror">
    @error('lokasi') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="field">
        <label for="kecamatan">Kecamatan</label>
        <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $l?->kecamatan) }}" class="@error('kecamatan') is-invalid @enderror">
        @error('kecamatan') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div class="field">
        <label for="tinggi_air">Tinggi air (cm)</label>
        <input type="number" id="tinggi_air" name="tinggi_air" min="1" value="{{ old('tinggi_air', $l?->tinggi_air) }}" class="@error('tinggi_air') is-invalid @enderror">
        @error('tinggi_air') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="field">
    <label for="keterangan">Keterangan (opsional)</label>
    <textarea id="keterangan" name="keterangan" rows="3" class="@error('keterangan') is-invalid @enderror">{{ old('keterangan', $l?->keterangan) }}</textarea>
    @error('keterangan') <div class="error">{{ $message }}</div> @enderror
</div>

@if ($l)
    <div class="field">
        <label>Foto saat ini</label>
        <img class="photo" style="max-height:180px" src="{{ asset('storage/' . $l->foto) }}" alt="Foto banjir">
    </div>
@endif

<div class="field">
    <label for="foto">{{ $l ? 'Ganti foto (kosongkan jika tidak diganti)' : 'Foto bukti kondisi banjir' }}</label>
    <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="@error('foto') is-invalid @enderror">
    <div class="hint">Format JPG, JPEG, atau PNG. Ukuran maksimal 2 MB.</div>
    @error('foto') <div class="error">{{ $message }}</div> @enderror
</div>
