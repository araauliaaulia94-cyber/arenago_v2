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

- [x] **Dashboard & Manajemen Venue (Owner)**:
  - [x] Form Tambah & Edit Lapangan (`FieldController@store`, `@update`) — divalidasi manual: pembuatan, edit, status publikasi, dan redirect owner berfungsi. UI sudah mengikuti Design System ArenaGo.
  - [x] Unggah Galeri Foto Lapangan (diintegrasikan ke `FieldController`, bukan controller terpisah) — mendukung multi-upload, pratinjau sebelum simpan, serta ganti/hapus foto per-item.
  - [x] Pengaturan Jam Operasional & Slot Waktu Lapangan (`ScheduleController`) — diuji manual di PostgreSQL; pengurutan hari, tambah, hapus, dan otorisasi kepemilikan berfungsi.
  - [x] Dashboard Pemilik (Kelola venue: ringkasan lapangan, slot jadwal, & kartu Pesanan Masuk) — seksi **Kelola venue** menjadi fokus utama dashboard; halaman **Pesanan Masuk** (`/owner/bookings`) hanya diakses dari dashboard (bukan dari navbar); dashboard menampilkan kartu *Lapangan saya*, *Slot jadwal*, dan *Pesanan masuk* yang membuka halaman khusus saat diklik; UI mengikuti Design System (header kontekstual, banner ringkasan, stat card, card-based mobile-first, CTA spesifik).
- [x] Halaman Pesanan Masuk Owner (Lihat & konfirmasi booking penyewa pada halaman khusus `/owner/bookings`) — konfirmasi mengubah booking dan payment secara atomik; UI mengikuti Design System (header kontekstual, banner ringkasan, stat card, daftar pesanan card-based mobile-first, status ramah pengguna, CTA konfirmasi spesifik, sticky aside); terverifikasi penuh.
- [x] **Eksplorasi & Pemesanan Lapangan (Penyewa)**:
  - [x] Halaman Katalog Lapangan (Pencarian & Filter berdasarkan Kota, Kategori Olahraga, Rentang Harga) — tersedia untuk field `available`; terverifikasi penuh.
  - [x] Penyelarasan hero Katalog Lapangan — satu section mobile-first dengan palet indigo/lime ArenaGo, ikon olahraga di sisi kanan desktop, dan filter tetap sebagai card terpisah.
  - [x] Animasi ikon bola hero Katalog Lapangan — gerak mengambang lembut dan lambat, dengan dukungan pengurangan gerakan sistem.
  - [x] Pembaruan copy hero Katalog Lapangan — headline eksplorasi, highlight lime, dan deskripsi booking diselaraskan dengan visual Dashboard ArenaGo.
  - [x] Redesign hero Katalog Lapangan menjadi full-viewport — layout 2 kolom desktop (teks kiri + bola kanan), badge, judul, deskripsi utama & pendukung, statistik (500+ Venue, 10.000+ Pengguna, 4.9/5 Rating), background gradient dark purple, responsive mobile 1 kolom dengan bola diperkecil, "Lapangan Tersedia" berada di bawah fold.
  - [x] Hero landing page ArenaGo — hero sports-tech desktop dengan CTA eksplorasi lapangan, statistik mitra, dan palet indigo/lime yang konsisten dengan Dashboard.
  - [x] Halaman Detail Lapangan (Info, Fasilitas, Foto, Lokasi, Rating, & Slot Jam) — tersedia; terverifikasi penuh.
  - [x] Form Booking Slot (Pilih Tanggal & Jam, Hitung Total Bayar) — tanggal dan kecocokan hari divalidasi; unique constraint mencegah double-booking; terverifikasi penuh.
- [x] **Sistem Pembayaran & Konfirmasi**:
  - [x] Halaman Instruksi Pembayaran & Form Unggah Bukti Bayar — tersedia untuk transfer bank, QRIS, dan e-wallet; terverifikasi penuh.
  - [x] Verifikasi Pembayaran oleh Owner/Admin (Ubah status booking menjadi Paid) — payment `successful`, `paid_at`, dan booking `paid` diperbarui bersama; terverifikasi penuh.
  - [x] Halaman "Pesanan Saya" (*My Bookings*) untuk penyewa — daftar dan halaman detail tersedia; halaman detail sudah dirombak mengikuti Design System (header kontekstual, banner intro, card section bernomor, status ramah pengguna, CTA spesifik, sticky aside); terverifikasi penuh.

---

## 📌 Phase 3: Sparring & Matchmaking System

- [x] **Pembuatan Post Sparring (Inisiator)**:
  - [x] Form Buat Jadwal Sparring (Kategori Olahraga, Lokasi/Kota, Tanggal, Jam, Nama Tim, Pilihan Lapangan, Estimasi Biaya, Kontak) — terverifikasi penuh.
- [x] **Pencarian & Matchmaking Sparring (Pencari Sparring)**:
  - [x] Halaman Cari Tim Sparring dengan Filter berdasarkan Lokasi/Kota, Cabang Olahraga, Tanggal, & Status — terverifikasi penuh.
  - [x] Halaman Detail Post Sparring (Info Pertandingan, Detail Tim Host, Venue & Kontak) — terverifikasi penuh.
- [x] **Pengajuan Tantangan Sparring (Sparring Invites)**:
  - [x] Form Ajukan Tantangan Sparring (*Send Invite*).
  - [x] Notifikasi Tantangan Masuk ke Inisiator Host.
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
- **Completed**: 26 (Seluruh Fase 1 dan Fase 2 terverifikasi selesai & berfungsi penuh)
- **In Progress**: 0
- **Pending**: 14 (Fase 3 dan Fase 4)
