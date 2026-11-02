<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $override = []): array
    {
        return array_merge([
            'nama_pelapor' => 'Budi',
            'no_hp'        => '081234567890',
            'lokasi'       => 'Jl. Raya Dayeuhkolot No. 10',
            'kecamatan'    => 'Dayeuhkolot',
            'tinggi_air'   => 60,
            'keterangan'   => 'Air masuk rumah',
            'foto'         => UploadedFile::fake()->image('banjir.jpg', 600, 400)->size(500),
        ], $override);
    }

    public function test_warga_dapat_mengirim_laporan_dengan_foto(): void
    {
        Storage::fake('public');

        $this->post('/lapor', $this->payload())->assertRedirect('/lapor')->assertSessionHas('success');

        $l = Laporan::first();
        $this->assertSame('Menunggu', $l->status);
        Storage::disk('public')->assertExists($l->foto);
    }

    public function test_validasi_foto_dan_field_wajib(): void
    {
        Storage::fake('public');

        $this->post('/lapor', [])->assertSessionHasErrors(['nama_pelapor', 'no_hp', 'lokasi', 'kecamatan', 'tinggi_air', 'foto']);
        $this->post('/lapor', $this->payload(['foto' => UploadedFile::fake()->create('a.pdf', 100, 'application/pdf')]))->assertSessionHasErrors('foto');
        $this->post('/lapor', $this->payload(['foto' => UploadedFile::fake()->image('a.png')->size(3000)]))->assertSessionHasErrors('foto');
        $this->post('/lapor', $this->payload(['foto' => UploadedFile::fake()->image('a.gif')]))->assertSessionHasErrors('foto');
        $this->assertSame(0, Laporan::count());
    }

    public function test_halaman_petugas_wajib_login(): void
    {
        $l = Laporan::create(['nama_pelapor' => 'A', 'no_hp' => '0812345678', 'lokasi' => 'x', 'kecamatan' => 'y', 'tinggi_air' => 10, 'foto' => 'laporan/x.jpg']);

        $this->get('/laporan')->assertRedirect('/login');
        $this->get("/laporan/{$l->id}")->assertRedirect('/login');
        $this->delete("/laporan/{$l->id}")->assertRedirect('/login');
    }

    public function test_petugas_index_pagination_show_update_delete(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        for ($i = 0; $i < 12; $i++) {
            $this->post('/lapor', $this->payload(['nama_pelapor' => "Warga $i"]));
        }
        $this->assertSame(12, Laporan::count());

        $this->actingAs($user)->get('/laporan')->assertOk()->assertSee('Total: 12');
        $this->actingAs($user)->get('/laporan?page=2')->assertOk();

        $l = Laporan::first();
        $this->actingAs($user)->get("/laporan/{$l->id}")->assertOk()->assertSee($l->nama_pelapor);

        // update tanpa foto baru: foto lama tetap
        $lama = $l->foto;
        $this->actingAs($user)->put("/laporan/{$l->id}", $this->payload(['foto' => null, 'status' => 'Diproses']))
            ->assertRedirect("/laporan/{$l->id}")->assertSessionHas('success');
        $this->assertSame('Diproses', $l->fresh()->status);
        $this->assertSame($lama, $l->fresh()->foto);

        // update dengan foto baru: foto lama terhapus
        $this->actingAs($user)->put("/laporan/{$l->id}", $this->payload(['status' => 'Selesai']));
        $baru = $l->fresh()->foto;
        $this->assertNotSame($lama, $baru);
        Storage::disk('public')->assertMissing($lama);
        Storage::disk('public')->assertExists($baru);

        // status tidak valid ditolak
        $this->actingAs($user)->put("/laporan/{$l->id}", $this->payload(['foto' => null, 'status' => 'Ngawur']))->assertSessionHasErrors('status');

        // hapus: file ikut terhapus
        $this->actingAs($user)->delete("/laporan/{$l->id}")->assertRedirect('/laporan')->assertSessionHas('success');
        $this->assertModelMissing($l);
        Storage::disk('public')->assertMissing($baru);
    }

    public function test_halaman_form_edit_dan_login_tampil(): void
    {
        $l = Laporan::create(['nama_pelapor' => 'A', 'no_hp' => '0812345678', 'lokasi' => 'x', 'kecamatan' => 'y', 'tinggi_air' => 10, 'foto' => 'laporan/x.jpg']);
        $this->get('/lapor')->assertOk()->assertSee('Form Pelaporan Banjir');
        $this->get('/login')->assertOk();
        $this->actingAs(User::factory()->create())->get("/laporan/{$l->id}/edit")->assertOk()->assertSee('Status penanganan');
    }

    public function test_login_petugas(): void
    {
        $this->seed();
        $this->post('/login', ['email' => 'petugas@bpbd.test', 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->post('/login', ['email' => 'petugas@bpbd.test', 'password' => 'password'])->assertRedirect('/laporan');
        $this->assertAuthenticated();
    }
}
