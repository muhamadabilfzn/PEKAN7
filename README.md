# LaporBanjir — BPBD Kabupaten Bandung

Aplikasi Laravel 12 untuk menerima laporan banjir warga (dengan foto bukti) dan mengelolanya oleh petugas.

## Cara menjalankan
1. Buat database `db_laporbanjir` di phpMyAdmin (collation `utf8mb4_unicode_ci`).
2. `composer install` (jika folder `vendor` belum ada), lalu `copy .env.example .env` dan `php artisan key:generate` (jika `.env` belum ada).
3. Pastikan `.env`: `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=db_laporbanjir`, `DB_USERNAME=root`, `DB_PASSWORD=` (kosong untuk XAMPP bawaan).
4. `php artisan migrate --seed`
5. `php artisan storage:link`
6. `php artisan serve` → buka http://localhost:8000

## Akun petugas (seeder)
- Email: `petugas@bpbd.test`
- Kata sandi: `password` (ganti pada penggunaan nyata)

## Rute
| Akses | Method | URL | Keterangan |
|---|---|---|---|
| Warga | GET/POST | `/lapor` | Form & simpan laporan + foto |
| Petugas | GET | `/laporan` | Daftar (thumbnail + pagination 10/halaman) |
| Petugas | GET | `/laporan/{id}` | Detail |
| Petugas | GET/PUT | `/laporan/{id}/edit` | Edit data, ganti foto, ubah status |
| Petugas | DELETE | `/laporan/{id}` | Hapus laporan + file foto |

Semua rute `/laporan*` berada di dalam middleware `auth`.

## Alasan memilih cara manual (tanpa Breeze)
- Kebutuhan autentikasi hanya satu peran (petugas) tanpa registrasi, reset sandi, atau verifikasi email, sehingga Breeze menyertakan banyak file yang tidak terpakai.
- Pengerjaan manual memperlihatkan langsung alur inti tugas: migration, model, resource controller, `Route::resource`, upload `store()`, validasi, dan middleware `auth`.
- Kode lebih ringkas dan mudah dijelaskan/diuji; proteksi tetap dipenuhi dengan `AuthController` sederhana (`Auth::attempt`, regenerasi sesi, logout) dan middleware `auth`.
- Tidak membutuhkan Node/Vite sehingga lebih mudah dijalankan di komputer lab.

## Pengujian
`php vendor/bin/phpunit` (validasi foto, akses auth, update/ganti foto, hapus foto, pagination).
