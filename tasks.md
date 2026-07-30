# Task Tracking — ArenaGo v2

Dokumen ini digunakan untuk melacak kemajuan pengerjaan proyek **ArenaGo v2** berdasarkan **PRD (prd_arenago.md)**.

Status Legend:
- `[x]` **Completed**: Selesai dikerjakan & diverifikasi.
- `[/]` **In Progress**: Sedang dalam proses pengerjaan.
- `[ ]` **Pending**: Direncanakan / belum dikerjakan.

## 🎨 UI Consistency Rule

Semua halaman baru atau halaman yang dirombak harus mengikuti **Design System & Pola Halaman ArenaGo** pada bagian 9 di `prd_arenago.md`. Acuan implementasi saat ini adalah `resources/views/owner/fields/create.blade.php`: header kontekstual, card section bernomor, upload dengan feedback/pratinjau, istilah status yang ramah pengguna, CTA spesifik, serta layout mobile-first. Tambahkan pemeriksaan pola UI ini pada setiap task halaman sebelum statusnya ditandai selesai.

---

## 📌 Phase 1: Foundations, Database & Core Auth

- [x] Instalasi Framework Laravel 11.x & Starter Kit (Breeze).
- [x] Pembuatan file Model awal (User, Field, Booking, Owner, SparringPost, dll).
- [x] Pembuatan file Migration awal.
- [x] **Standardisasi Naming & Bugfix File Model**:
  - [x] Rename `payment.php` -> `Payment.php` (PascalCase PSR-4 standard).
  - [x] Rename `nontification.php` -> `Notification.php` (Perbaikan typo).
  - [x] Perbaikan nama file `favorite.php` -> `Favorite.php`.
- [x] **Lengkapi Skema Tabel Migrasi Database**:
  - [x] Complete `fields` table (owner_id, field_name, sport_category, price_per_hour, location, status).
  - [x] Complete `bookings` table (user_id, schedule_id, booking_date, total_price, status).
  - [x] Complete `payments` table (booking_id, payment_method, amount, payment_status, proof_of_payment, paid_at).
  - [x] Complete `reviews` table (user_id, field_id, rating, comment).
  - [x] Complete `favorites` table (user_id, field_id).
  - [x] Complete `notifications` table (user_id, title, message, type, is_read).
  - [x] Complete `sparring_posts` table (user_id, title, sport_category, location, event_date, start_time, end_time, team_name, cost, contact, status).
  - [x] Complete `sparring_invites` table (sparring_post_id, sender_user_id, team_name, message, status).
- [x] **Definisi Relasi Eloquent Models**:
  - [x] Hubungkan `User` dengan `Owner`, `Booking`, `SparringPost`, `Favorite`, `Review`, `Notification`.
  - [x] Hubungkan `Field` dengan `Owner`, `PhotoOfField`, `Schedule`, `Review`.
  - [x] Hubungkan `Booking` dengan `User`, `Schedule`, `Payment`.
  - [x] Hubungkan `SparringPost` dengan `User`, `SparringMember`, `SparringInvite`.
- [x] **Dual-Role User Profile**:
  - [x] Form Pendaftaran Akun Pemilik Lapangan (*Owner Registration*).
  - [x] Navigasi kondisional (Beralih tampilan antara Penyewa & Pemilik Lapangan).

---

## 📌 Phase 2: Venue Management & Slot Booking System

**Konteks implementasi (30 Juli 2026):** Fase ini sedang diselesaikan di working tree. Schema telah dilengkapi dengan `fields.location`, `fields.description`, dan `bookings.booking_date`. Slot adalah template berulang per hari; booking memilih tanggal nyata yang harus sesuai dengan hari slot. Constraint unik `schedule_id + booking_date` mencegah double-booking pada level database. Validasi otomatis penuh masih tertahan karena PHP environment belum memiliki driver SQLite yang dipakai oleh test suite.

**Panduan uji manual:** lihat `testing_phase2.md`. Skenario tersebut dimulai dari database kosong dan registrasi pada `/register`, lalu menguji alur owner, penyewa, pembayaran, validasi, dan otorisasi.

- [/] **Dashboard & Manajemen Venue (Owner)**:
  - [x] Form Tambah & Edit Lapangan (`FieldController@store`, `@update`) — divalidasi manual: pembuatan, edit, status publikasi, dan redirect owner berfungsi. UI sudah mengikuti Design System ArenaGo.
  - [x] Unggah Galeri Foto Lapangan (diintegrasikan ke `FieldController`, bukan controller terpisah) — mendukung multi-upload, pratinjau sebelum simpan, serta ganti/hapus foto per-item.
  - [x] Pengaturan Jam Operasional & Slot Waktu Lapangan (`ScheduleController`) — diuji manual di PostgreSQL; pengurutan hari, tambah, hapus, dan otorisasi kepemilikan berfungsi.
  - [/] Dashboard Pesanan Masuk (Lihat & konfirmasi booking penyewa) — konfirmasi mengubah booking dan payment secara atomik; menunggu feature test.
- [/] **Eksplorasi & Pemesanan Lapangan (Penyewa)**:
  - [/] Halaman Katalog Lapangan (Pencarian & Filter berdasarkan Kota, Kategori Olahraga, Rentang Harga) — tersedia untuk field `available`; menunggu feature test.
  - [/] Halaman Detail Lapangan (Info, Fasilitas, Foto, Lokasi, Rating, & Slot Jam) — tersedia; indikator ketersediaan per tanggal akan diperkuat pada iterasi UI berikutnya.
  - [/] Form Booking Slot (Pilih Tanggal & Jam, Hitung Total Bayar) — tanggal dan kecocokan hari divalidasi; unique constraint mencegah double-booking; menunggu feature test.
- [/] **Sistem Pembayaran & Konfirmasi**:
  - [/] Halaman Instruksi Pembayaran & Form Unggah Bukti Bayar — tersedia untuk transfer bank, QRIS, dan e-wallet; menunggu feature test.
  - [/] Verifikasi Pembayaran oleh Owner/Admin (Ubah status booking menjadi Paid) — payment `successful`, `paid_at`, dan booking `paid` diperbarui bersama; menunggu feature test.
  - [/] Halaman "Pesanan Saya" (*My Bookings*) untuk penyewa — daftar dan halaman detail tersedia; menunggu feature test.

---

## 📌 Phase 3: Sparring & Matchmaking System

- [ ] **Pembuatan Post Sparring (Inisiator)**:
  - [ ] Form Buat Jadwal Sparring (Kategori Olahraga, Lokasi/Kota, Tanggal, Jam, Nama Tim, Estimasi Biaya, Kontak).
- [ ] **Pencarian & Matchmaking Sparring (Pencari Sparring)**:
  - [ ] Halaman Cari Tim Sparring dengan Filter berdasarkan Lokasi/Kota, Cabang Olahraga, & Tanggal.
  - [ ] Halaman Detail Post Sparring (Info Pertandingan, Detail Tim Host).
- [ ] **Pengajuan Tantangan Sparring (Sparring Invites)**:
  - [ ] Form Ajukan Tantangan Sparring (*Send Invite*).
  - [ ] Notifikasi Tantangan Masuk ke Inisiator Host.
  - [ ] Aksi Terima (*Accept*) / Tolak (*Reject*) Tantangan oleh Host.
  - [ ] Pembaruan Status Post Sparring menjadi `MATCHED`.
- [ ] **Partisipasi Anggota Sparring**:
  - [ ] Fitur bergabung sebagai anggota tim sparring (*Sparring Member*).

---

## 📌 Phase 4: Engagement, Reviews, Gamification & Notifications

- [ ] **Ulasan Venue & Favorit**:
  - [ ] Form Beri Ulasan & Rating Bintang (1-5) setelah booking selesai.
  - [ ] Tampilan Rata-rata Rating & Ulasan di Detail Lapangan.
  - [ ] Tombol Tambah/Hapus Lapangan Favorit (Bookmark).
- [ ] **Notifikasi Dalam Aplikasi**:
  - [ ] Halaman & Dropdown Notifikasi User.
  - [ ] Trigger otomatis notifikasi saat: Pembayaran berhasil, Tantangan Sparring masuk/diterima, Status Booking berubah.
- [ ] **Gamifikasi & Tracking**:
  - [ ] Modul Achievements (Badge otomatis untuk milestone *First Booking*, *5 Sparring Match*, dll).
  - [ ] Activity History (Log linimasa semua pemesanan, sparring, & pencapaian user).

---

## 📊 Project Progress Summary

- **Total Main Tasks**: 40
- **Completed**: 29 (26 fondasi + 3 subfitur owner Fase 2 yang telah diuji manual)
- **In Progress**: 7 (sisa subfitur Fase 2; implementasi tersedia tetapi belum seluruhnya diverifikasi end-to-end)
- **Pending**: 14 (Fase 3 dan Fase 4)
