<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Resource controller untuk petugas BPBD (index, show, edit, update, destroy).
 * create/store dipakai warga lewat route publik di web.php.
 */
class LaporanController extends Controller
{
    private function rules(bool $fotoWajib, bool $denganStatus = false): array
    {
        $rules = [
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'no_hp'        => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
            'lokasi'       => ['required', 'string', 'max:255'],
            'kecamatan'    => ['required', 'string', 'max:100'],
            'tinggi_air'   => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan'   => ['nullable', 'string', 'max:1000'],
            'foto'         => [$fotoWajib ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        if ($denganStatus) {
            $rules['status'] = ['required', Rule::in(Laporan::STATUS)];
        }

        return $rules;
    }

    private function pesan(): array
    {
        return [
            'required'     => ':attribute wajib diisi.',
            'max.string'   => ':attribute maksimal :max karakter.',
            'integer'      => ':attribute harus berupa angka bulat.',
            'min.numeric'  => ':attribute minimal :min.',
            'max.numeric'  => ':attribute maksimal :max.',
            'no_hp.regex'  => 'Nomor HP hanya boleh berisi angka, spasi, tanda + atau -, 9-20 karakter.',
            'foto.image'   => 'File harus berupa gambar.',
            'foto.mimes'   => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max'     => 'Ukuran foto maksimal 2 MB.',
            'foto.uploaded' => 'Foto gagal diunggah. Pastikan ukurannya tidak lebih dari 2 MB.',
            'status.in'    => 'Status tidak valid.',
        ];
    }

    private function atribut(): array
    {
        return [
            'nama_pelapor' => 'Nama pelapor',
            'no_hp'        => 'Nomor HP',
            'lokasi'       => 'Lokasi',
            'kecamatan'    => 'Kecamatan',
            'tinggi_air'   => 'Tinggi air',
            'keterangan'   => 'Keterangan',
            'foto'         => 'Foto',
            'status'       => 'Status',
        ];
    }

    // ---------- Warga (publik) ----------

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(true), $this->pesan(), $this->atribut());

        $data['foto'] = $request->file('foto')->store('laporan', 'public');
        $data['status'] = 'Menunggu';

        Laporan::create($data);

        return redirect()->route('laporan.create')
            ->with('success', 'Laporan banjir berhasil dikirim. Terima kasih, petugas BPBD akan segera menindaklanjuti.');
    }

    // ---------- Petugas (auth) ----------

    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);

        return view('laporan.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $data = $request->validate($this->rules(false, true), $this->pesan(), $this->atribut());

        if ($request->hasFile('foto')) {
            // hapus foto lama dari storage, lalu simpan foto baru
            Storage::disk('public')->delete($laporan->foto);
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        } else {
            unset($data['foto']);
        }

        $laporan->update($data);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        // foto ikut terhapus bersama laporan
        Storage::disk('public')->delete($laporan->foto);
        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
