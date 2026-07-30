# Skenario Testing Manual — Fase 2 ArenaGo v2

Dokumen ini dipakai untuk menguji alur venue, booking, dan pembayaran dari database kosong. Mulai dengan aplikasi berjalan dan buka `/register`.

## Prasyarat

- Migration sudah dijalankan: `php artisan migrate`.
- Aplikasi dapat dibuka melalui Laragon, misalnya `http://localhost/arenago_v2/public`.
- Gunakan **dua alamat email berbeda**: satu untuk owner dan satu untuk penyewa. Hal ini memudahkan pengujian otorisasi serta notifikasi.

## Data uji

| Peran | Nama | Email | Password |
| --- | --- | --- | --- |
| Owner | Budi Owner | `owner@arenago.test` | `password` |
| Penyewa | Rina Player | `renter@arenago.test` | `password` |
| Venue | Arena Futsal Senayan | — | — |
| Lapangan | Lapangan A | — | — |
| Slot | Monday, 19:00–20:00 | — | — |
| Tanggal booking | Senin berikutnya | — | — |

> Jangan memakai tanggal lampau. Tanggal booking harus jatuh pada hari yang sama dengan slot. Jika slot adalah `Monday`, pilih hari Senin yang akan datang.

---

## 1. Registrasi dan aktivasi owner

1. Buka `/register`.
2. Daftarkan akun **Budi Owner** menggunakan data uji di atas.
3. Setelah masuk, klik **Daftar Jadi Pemilik** di navbar, atau buka `/owner/register`.
4. Isi nama usaha `Arena Futsal Senayan`, kota misalnya `Jakarta Selatan`, lalu unggah foto opsional.
5. Klik **Daftar Sekarang**.

Hasil yang diharapkan:

- Akun owner berhasil dibuat dan langsung disetujui untuk mode development.
- Setelah submit, user diarahkan ke `/owner/fields` untuk menambahkan lapangan.
- Mengakses `/owner/fields` tidak lagi mengarahkan kembali ke halaman pendaftaran owner.

## 2. Tambah lapangan dan slot

1. Saat masih login sebagai owner, buka `/owner/fields`.
2. Klik tambah lapangan dan isi:
   - Nama: `Lapangan A`
   - Kategori: `Futsal`
   - Harga per jam: `150000`
   - Lokasi: `Jakarta Selatan`
   - Deskripsi: `Lapangan futsal indoor untuk testing.`
   - Status: `available`
   - Foto: opsional, tipe JPG/PNG di bawah 2 MB per foto. Saat foto dipilih, form menampilkan jumlah, nama, dan pratinjau sebelum disimpan. Untuk memilih beberapa file pada Windows, tahan `Ctrl` atau `Shift` saat memilih file.
3. Simpan lapangan.
4. Dari daftar lapangan owner, buka pengaturan jadwal untuk Lapangan A.
5. Tambahkan slot: `Monday`, `19:00`, `20:00`.

Hasil yang diharapkan:

- Lapangan muncul pada dashboard owner dan katalog publik `/fields`. Kartu owner menampilkan foto pertama serta jumlah total foto; seluruh galeri terlihat di halaman detail atau edit lapangan.
- Halaman pengaturan jadwal dapat dibuka di PostgreSQL; slot diurutkan dari Monday sampai Sunday, lalu berdasarkan jam mulai.
- Slot tampil pada detail lapangan dan hanya owner yang dapat mengubah atau menghapusnya.

### Uji pengelolaan foto individual

1. Buka **Edit** pada Lapangan A.
2. Di bagian **Kelola Foto Galeri**, pilih satu foto baru pada kartu foto yang ingin diganti, lalu klik **Ganti**.
3. Pastikan foto lain tidak berubah.
4. Uji tombol **Hapus foto** pada satu foto dan pastikan hanya foto tersebut yang hilang.

Hasil yang diharapkan: setiap foto dapat diganti atau dihapus secara terpisah. Aksi hanya tersedia untuk owner lapangan tersebut.

## 3. Registrasi penyewa dan membuat booking

1. Logout dari akun owner.
2. Buka `/register`, lalu daftarkan **Rina Player** dengan email `renter@arenago.test`.
3. Buka `/fields`, cari `Arena Futsal` atau filter kategori `Futsal`.
4. Buka detail `Lapangan A`, lalu klik slot `Monday 19:00–20:00`.
5. Pilih **Senin berikutnya** pada input tanggal booking.
6. Klik **Buat Pesanan**.

Hasil yang diharapkan:

- Pesanan tercatat di `/bookings` dengan status `pending`.
- Total harga adalah `Rp 150.000`.
- Detail pesanan menampilkan tanggal booking, jam slot, dan tombol **Lanjutkan Pembayaran**.

### Uji validasi booking

Lakukan pengecekan berikut sebelum melanjutkan pembayaran:

| Aksi | Hasil yang diharapkan |
| --- | --- |
| Pilih tanggal selain hari Senin | Pesan error bahwa tanggal tidak sesuai hari operasional slot. |
| Pilih tanggal lampau | Validasi tanggal ditolak. |
| Buat booking kedua memakai slot dan tanggal Senin yang sama | Pesan error bahwa slot sudah dipesan. |

## 4. Unggah bukti pembayaran

1. Pada detail pesanan penyewa, klik **Lanjutkan Pembayaran**.
2. Pilih `bank_transfer`, `qris`, atau `e_wallet`.
3. Unggah gambar bukti pembayaran (JPG/PNG, maksimal 2 MB).
4. Klik **Unggah Bukti Pembayaran**.

Hasil yang diharapkan:

- Sistem kembali ke detail booking.
- Status payment menjadi `pending`/menunggu konfirmasi.
- Tombol unggah tidak muncul lagi untuk booking yang sama.
- Owner menerima notifikasi database tentang bukti pembayaran baru.

## 5. Konfirmasi oleh owner

1. Logout dari penyewa dan login kembali sebagai **Budi Owner**.
2. Buka `/owner/bookings`.
3. Pastikan booking Rina dan tautan **Lihat** bukti pembayaran terlihat.
4. Klik **Konfirmasi**.

Hasil yang diharapkan:

- Booking berubah menjadi `paid`.
- Payment berubah menjadi `successful` dan mempunyai `paid_at`.
- Penyewa menerima notifikasi database bahwa pembayaran sudah dikonfirmasi.
- Setelah login sebagai Rina lagi, detail pesanan menampilkan status `paid`.

## 6. Uji otorisasi dasar

1. Login sebagai penyewa dan coba buka `/owner/fields` atau `/owner/bookings`.
2. Login sebagai owner dan coba akses URL detail booking milik penyewa jika ID booking diketahui.

Hasil yang diharapkan:

- Penyewa tanpa profil owner diarahkan untuk mendaftar sebagai owner ketika mengakses dashboard owner.
- Owner tidak dapat melihat detail booking sebagai penyewa; sistem menolak akses dengan HTTP 403.

## Catatan status pengujian

Skenario ini dapat dijalankan manual sekarang. Automated test dengan `php artisan test` belum dapat dijalankan di environment ini karena ekstensi PHP `pdo_sqlite` belum tersedia, sementara konfigurasi test memakai SQLite in-memory.
