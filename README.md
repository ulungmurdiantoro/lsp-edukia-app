# LSP Edukia — Website

Website publik dan panel admin [lspedukia.id](https://lspedukia.id): skema sertifikasi, jadwal,
daftar penerima sertifikat, blog, dan lowongan karier.

Laravel 12 · Filament 3 (panel admin di `/admin`) · PHP 8.2+ · MySQL (produksi) / SQLite (lokal)

## Menjalankan di lokal

```bash
composer setup        # install dependency, buat .env, key:generate, migrate, build aset
php artisan db:seed   # buat user admin — password acak ditampilkan sekali di terminal
composer dev          # server + queue + log + vite
```

Jalankan test dengan `composer test`.

## Panel admin

Hanya user dengan `is_admin = true` yang bisa masuk `/admin`. User admin awal dibuat oleh
`AdminSeeder` dari `ADMIN_EMAIL` / `ADMIN_PASSWORD` di `.env` (password kosong = dibuat acak).
Seeder tidak pernah menimpa password admin yang sudah ada.

## Data sertifikat

Halaman `/daftar-penerima-sertifikat` membaca tabel `sertifikats`, yang diisi dari dua sumber:

| Sumber | Cara | Keterangan |
|---|---|---|
| Database CBT | `php artisan sertifikat:sync-cbt` — otomatis tiap hari 02:00, atau tombol **Sync dari CBT** di admin | Sumber utama. Membaca view `v_sertifikasi_kelulusan` lewat koneksi `cbt` (`CBT_DB_*` di `.env`) dengan user MySQL **read-only**. |
| File Excel | Tombol **Import Excel** di admin, atau `php artisan sertifikat:import` | Data lama. File `database/*.xlsx` berisi data pribadi sehingga **tidak disimpan di git** — salin manual ke server bila perlu. |

Aturan sync CBT:

- Upsert berdasarkan nomor sertifikat. Baris CBT tanpa nomor sertifikat dilewati.
- Sertifikat yang disembunyikan admin (`tampil = false`) tetap tersembunyi setelah sync.
- Sertifikat lama milik orang yang sama untuk skema yang sama (terbit lebih awal) disembunyikan,
  bukan dihapus.

## Verifikasi sertifikat (QR code)

QR code di Sertifikat & SK yang diterbitkan CBT berisi
`https://verifikasi-sertifikat.lspedukia.id/{nomor_sertifikat}` dan `.../sk/{no_sk}`.
Aplikasi ini melayani subdomain tersebut (`VERIFIKASI_DOMAIN`, default
`verifikasi-sertifikat.lspedukia.id`) dan mengalihkannya (301) ke
`/verifikasi-sertifikat/{nomor}` dan `/verifikasi-sertifikat/sk/{no_sk}` di domain utama,
yang menampilkan data dari tabel `sertifikats` (hanya `tampil = true`). Sertifikat baru
muncul setelah ditandai terkirim di CBT dan tersinkron (harian 02:00 atau tombol Sync).

Agar subdomain aktif, di server:

1. DNS: record `A` `verifikasi-sertifikat` → IP VPS yang sama dengan `lspedukia.id`.
2. Web server: tambahkan subdomain ke vhost lspedukia.id — nginx: `server_name` (blok 80 & 443),
   Apache: `ServerAlias verifikasi-sertifikat.lspedukia.id`.
3. SSL: `sudo certbot --nginx -d lspedukia.id -d www.lspedukia.id -d verifikasi-sertifikat.lspedukia.id --expand`
   (ganti `--nginx` dengan `--apache` bila memakai Apache; sesuaikan daftar `-d` dengan sertifikat yang ada).
4. `php artisan config:cache && php artisan route:cache`.

## Lamaran karier

- Lowongan dikelola di admin: **Karir → Lowongan**.
- Dokumen pelamar (CV, ijazah, dll.) disimpan di disk privat `storage/app/private` dan hanya
  bisa diunduh admin lewat `/dokumen-lamaran/{id}/{jenis}`.
- Form dibatasi 5 kiriman/menit per IP dan memakai honeypot anti-bot.
- Setiap lamaran dikirim ke Google Sheets bila `GOOGLE_SHEETS_WEBHOOK_URL` diisi. Kode Apps
  Script dan cara setup-nya ada di [docs/google-apps-script.js](docs/google-apps-script.js).
  Token `GOOGLE_SHEETS_WEBHOOK_TOKEN` opsional.

## Deploy (VPS)

```bash
bash deploy.sh
```

Setup pertama: clone, salin `.env.production.example` → `.env`, migrate, cache.
Deploy berikutnya: maintenance mode → `git pull` → composer → migrate → cache → online lagi
(otomatis keluar dari maintenance mode bila ada langkah yang gagal).

**Wajib:** cron scheduler, supaya sync CBT harian berjalan:

```
* * * * * cd /var/www/lsp-edukia && php artisan schedule:run >> /dev/null 2>&1
```

## Struktur penting

| Lokasi | Isi |
|---|---|
| `app/Support/Skemas.php` | Master data 26 skema sertifikasi (sumber tunggal) |
| `app/Support/SertifikatExcelHelper.php` | Pencocokan skema, normalisasi nama, parser tanggal |
| `app/Console/Commands/` | `sertifikat:sync-cbt`, `sertifikat:import`, `blog:import-wordpress`, `blog:fix-ringkasan` |
| `routes/web.php` | Route blog `/{slug}` menangkap semua URL satu segmen — halaman statis baru **harus** ditambahkan ke daftar pengecualiannya (dijaga oleh `tests/Feature/RouteCatchAllTest.php`) |
| `docs/` | Blueprint frontend & SEO, prototipe desain, Apps Script |
