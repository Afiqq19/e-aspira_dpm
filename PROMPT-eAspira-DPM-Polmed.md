# PROMPT MASTER — e-Aspira DPM Polmed
### (Siap ditempel ke Antigravity)

> **Cara pakai:** Copy seluruh isi bagian **"PROMPT UNTUK AI AGENT"** di bawah dan tempel ke chat Antigravity sebagai instruksi awal proyek. Bagian sebelum itu (Ringkasan & Referensi) untuk bapak sendiri sebagai dokumentasi.

---

## 0. Ringkasan Proyek (untuk referensi bapak)

| Item | Keterangan |
|---|---|
| Nama Sistem | **e-Aspira DPM Polmed** |
| Instansi | Dewan Perwakilan Mahasiswa (DPM), Politeknik Negeri Medan |
| Tujuan | Wadah aspirasi & pengaduan mahasiswa (termasuk mode privasi/anonim untuk kasus sensitif seperti pelecehan), pengumuman resmi, dan kalender kegiatan kemahasiswaan |
| Stack | Laravel 11 + Livewire/Alpine.js + Tailwind CSS + MySQL/MariaDB |
| Role | Admin, Staff Dewan, HMPS, UKM, Mahasiswa |

---

## 1. PROMPT UNTUK AI AGENT

```
Kamu adalah AI software engineer yang akan membangun aplikasi web bernama
"e-Aspira DPM Polmed" menggunakan Laravel 11 + Livewire + Alpine.js + Tailwind CSS
+ MySQL. Bangun secara bertahap (per fase), jangan langsung generate semua file
sekaligus. Setelah tiap fase, tunggu konfirmasi sebelum lanjut ke fase berikutnya.

=====================================================================
KONTEKS PRODUK
=====================================================================
e-Aspira DPM Polmed adalah sistem informasi milik Dewan Perwakilan Mahasiswa (DPM)
Politeknik Negeri Medan yang menjadi kanal resmi untuk:
1. Aspirasi & pengaduan mahasiswa (termasuk mode privasi/anonim untuk kasus
   sensitif seperti pelecehan/kekerasan)
2. Pengumuman resmi dari DPM, HMPS, dan UKM
3. Kalender kegiatan kemahasiswaan terpadu

=====================================================================
ROLE & HAK AKSES (RBAC — gunakan spatie/laravel-permission)
=====================================================================
1. Admin
   - Kelola seluruh user & role
   - Konfigurasi sistem
   - Lihat log aktivitas (audit trail)
   - Backup data

2. Staff Dewan (setara admin fungsional, mengelola operasional harian DPM)
   - Kelola pengumuman & kegiatan DPM
   - Tinjau & tindak lanjuti seluruh pengaduan (status berjenjang)
   - Kelola akun HMPS/UKM (create/edit/nonaktifkan)
   - Buka/tutup status pengaduan
   - Sub-permission khusus "Penanganan Kasus Sensitif": HANYA staff dengan
     permission ini yang bisa membuka identitas asli pelapor anonim

3. HMPS (1 akun per Himpunan Mahasiswa Program Studi)
   - Publikasi pengumuman & kegiatan prodi
   - Kelola kalender internal HMPS
   - Lihat rekap aspirasi terkait prodinya (HANYA jika pelapor mengizinkan)

4. UKM (1 akun per Unit Kegiatan Mahasiswa)
   - Publikasi pengumuman & kegiatan UKM
   - Kelola kalender internal UKM

5. Mahasiswa
   - Kirim aspirasi/pengaduan (mode Umum atau Privasi/Anonim)
   - Lihat status pengaduan pribadi via nomor tiket
   - Lihat pengumuman & kalender kegiatan seluruh kampus

ATURAN PRIVASI KRITIS:
- Untuk kategori sensitif (Pelecehan/Kekerasan): identitas pelapor HANYA bisa
  dilihat oleh Staff Dewan yang punya permission "Penanganan Kasus Sensitif" —
  BUKAN seluruh Staff Dewan, BUKAN HMPS/UKM, BUKAN Admin biasa.
- Setiap akses ke identitas asli pelapor WAJIB tercatat di log aktivitas
  (siapa, kapan, untuk keperluan apa).

=====================================================================
MODUL & FITUR UTAMA
=====================================================================

### A. Modul Aspirasi & Pengaduan
- Form pengajuan dengan kategori: Akademik, Fasilitas, Kemahasiswaan/Organisasi,
  Pelecehan/Kekerasan, Lainnya
- Mode pengiriman:
  - Umum: identitas terlihat oleh Staff Dewan
  - Privasi/Anonim: identitas disamarkan dengan kode acak
    (contoh format: PLP-2026-0341), data asli disimpan terenkripsi (AES-256
    via Laravel Crypt), dipisah dari tabel pengaduan utama
- Lampiran bukti (foto/dokumen/screenshot), disimpan di disk 'private'
  (bukan public), dengan enkripsi untuk kategori sensitif
- Nomor tiket unik otomatis untuk pelacakan tanpa membuka identitas
- Status berjenjang: Diterima → Diverifikasi → Diproses → Ditindaklanjuti →
  Selesai/Ditolak
- Notifikasi in-app + email setiap status berubah (Laravel Notification)
- Riwayat komunikasi dua arah (mahasiswa ↔ Staff Dewan) dalam satu tiket,
  tanpa membocorkan identitas ke pihak tak berwenang
- Pengaduan kategori sensitif masuk ke antrean khusus, terpisah dari antrean umum

### B. Modul Pengumuman
- Publikasi oleh Staff Dewan (cakupan umum), HMPS (per-prodi), atau UKM (per-UKM)
- Kategori & tag, dukungan lampiran gambar/PDF
- Fitur pin/sematkan pengumuman penting di halaman utama
- Arsip pengumuman lama tetap bisa diakses (soft delete, bukan hard delete)

### C. Modul Kegiatan & Kalender
- Kalender terpadu (pakai FullCalendar.js via CDN) untuk semua kegiatan
  DPM/HMPS/UKM dengan filter per organisasi
- Detail kegiatan: waktu, lokasi, deskripsi, poster/flyer, kontak penanggung jawab
- Tampilan bulanan/mingguan + list view untuk mobile
- (Opsional fase lanjutan) Ekspor/sinkronisasi ke Google Calendar

### D. Modul Manajemen Pengguna & Organisasi
- Admin/Staff Dewan membuat & mengelola 1 akun resmi per HMPS dan per UKM
- Verifikasi akun mahasiswa via NIM/email kampus
- Pengaturan hak akses granular (misal siapa saja yang punya izin
  "Penanganan Kasus Sensitif")
- Log aktivitas (audit trail) wajib untuk seluruh aksi terkait data sensitif

=====================================================================
ALUR PENGADUAN MODE PRIVASI/ANONIM (implementasikan persis alur ini)
=====================================================================
1. Mahasiswa login → pilih "Ajukan Pengaduan" → pilih kategori + mode privasi
2. Jika mode Privasi/Anonim: sistem menyamarkan nama pelapor dengan kode acak
   di seluruh tampilan Staff Dewan biasa
3. Data identitas asli disimpan terenkripsi, hanya bisa didekripsi oleh akun
   dengan permission "Penanganan Kasus Sensitif"
4. Pengaduan masuk antrean khusus Staff Dewan berwenang, terpisah dari
   antrean pengaduan umum
5. Pelapor memantau status via nomor tiket tanpa perlu membuka ulang identitas
6. Setiap akses ke identitas asli tercatat di log aktivitas
7. Setelah kasus selesai, data bisa diarsipkan sesuai kebijakan retensi kampus

=====================================================================
SKEMA DATABASE (buat migration persis struktur ini, sesuaikan tipe data)
=====================================================================
- users: id, nim_nip, nama, email, password, role_id, organisasi_id, is_active
- roles: id, nama_role, deskripsi
- permissions: id, nama_permission  (pakai spatie/laravel-permission)
- organisasi: id, nama, tipe (enum: HMPS/UKM), prodi_terkait
- pengaduan: id, ticket_code, user_id (nullable jika anonim), kategori_id,
  isi, mode_privasi, status, penanganan_khusus
- kategori_pengaduan: id, nama_kategori, level_sensitivitas
- identitas_terenkripsi: id, pengaduan_id, data_terenkripsi, encrypted_key_ref
  (tabel TERPISAH dari pengaduan — jangan digabung)
- tanggapan_pengaduan: id, pengaduan_id, user_id, isi_tanggapan, created_at
- pengumuman: id, judul, isi, organisasi_id, kategori, is_pinned, lampiran
- kegiatan: id, judul, deskripsi, tanggal_mulai, tanggal_selesai, lokasi,
  organisasi_id, poster
- log_aktivitas: id, user_id, aksi, target_tabel, target_id, created_at
  (pakai spatie/laravel-activitylog, WAJIB untuk akses data sensitif)

=====================================================================
STRUKTUR FOLDER PROYEK (ikuti struktur ini)
=====================================================================
siap-dpm-polmed/
├─ app/
│  ├─ Http/
│  │  ├─ Controllers/
│  │  │  ├─ Admin/
│  │  │  ├─ StaffDewan/
│  │  │  ├─ Organisasi/        (HMPS & UKM)
│  │  │  ├─ Mahasiswa/
│  │  │  └─ Auth/
│  │  ├─ Middleware/
│  │  │  ├─ CheckRole.php
│  │  │  └─ CheckPenangananSensitif.php
│  │  └─ Requests/             (Form Request validasi per modul)
│  ├─ Models/
│  │  ├─ User.php
│  │  ├─ Organisasi.php
│  │  ├─ Pengaduan.php
│  │  ├─ KategoriPengaduan.php
│  │  ├─ IdentitasTerenkripsi.php
│  │  ├─ TanggapanPengaduan.php
│  │  ├─ Pengumuman.php
│  │  ├─ Kegiatan.php
│  │  └─ LogAktivitas.php
│  ├─ Policies/                (mis. PengaduanPolicy.php)
│  └─ Services/
│     ├─ EnkripsiIdentitasService.php
│     └─ NotifikasiService.php
├─ database/
│  ├─ migrations/
│  ├─ seeders/
│  │  ├─ RoleSeeder.php
│  │  └─ KategoriPengaduanSeeder.php
│  └─ factories/
├─ resources/
│  ├─ views/
│  │  ├─ layouts/
│  │  ├─ admin/
│  │  ├─ staff-dewan/
│  │  ├─ organisasi/
│  │  ├─ mahasiswa/
│  │  └─ components/           (kartu-pengumuman, kalender, dsb.)
│  └─ js/ & css/
├─ routes/
│  ├─ web.php
│  └─ api.php
├─ storage/
│  └─ app/private/lampiran-pengaduan/   (akses terbatas, tidak public)
└─ tests/
   ├─ Feature/
   └─ Unit/

=====================================================================
DAFTAR ROUTE UTAMA
=====================================================================
- guest: GET /login, POST /login, landing page pengumuman & kalender umum
- auth + role:mahasiswa: GET/POST /pengaduan/buat, POST /pengaduan,
  GET /pengaduan/{ticket}
- auth + role:staff_dewan: GET /dewan/pengaduan, PATCH /dewan/pengaduan/{id}/status,
  GET /dewan/pengaduan-sensitif (WAJIB permission khusus)
- auth + role:hmps,ukm: GET/POST /organisasi/kegiatan, POST /organisasi/pengumuman
- auth + role:admin: GET/POST /admin/users, GET /admin/log-aktivitas

=====================================================================
PACKAGE YANG WAJIB DIPAKAI
=====================================================================
- Autentikasi: Laravel Breeze
- Role & Permission: spatie/laravel-permission
- Kalender: FullCalendar.js (CDN) + Livewire
- Interaktivitas: Livewire + Alpine.js
- Styling: Tailwind CSS
- Enkripsi data sensitif: Laravel Crypt (AES-256)
- Notifikasi: Laravel Notification (database + mail channel)
- Upload lampiran sensitif: Laravel Filesystem, disk 'private'
- Audit log: spatie/laravel-activitylog
- Database: MySQL/MariaDB

=====================================================================
KEAMANAN & PRIVASI (wajib dipatuhi di semua fase)
=====================================================================
- Enkripsi at-rest untuk kolom identitas pelapor anonim, di tabel TERPISAH
- Kontrol akses berlapis: hanya permission khusus yang bisa membuka identitas
  sensitif, dan itu WAJIB tercatat di log aktivitas
- Validasi & sanitasi input di semua form (Form Request), cegah XSS/SQL Injection
- Rate limiting pada form pengaduan (cegah spam/penyalahgunaan)
- Kebijakan retensi data pengaduan sensitif (buat konfigurasi, jangan hardcode)
- HTTPS wajib di production; backup database terenkripsi berkala

=====================================================================
RENCANA FASE PENGERJAAN (kerjakan berurutan, konfirmasi tiap selesai fase)
=====================================================================
FASE 1 — Fondasi
  - Install Laravel 11, Breeze, Livewire, Alpine.js, Tailwind
  - Setup spatie/laravel-permission + RoleSeeder (5 role di atas)
  - Buat migration semua tabel di atas
  - Buat Model + relasi antar tabel

FASE 2 — Autentikasi & Manajemen User
  - Login multi-role, verifikasi via NIM/email kampus
  - Admin: CRUD user, assign role, buat akun HMPS/UKM (1 akun per organisasi)
  - Middleware CheckRole.php

FASE 3 — Modul Aspirasi & Pengaduan (PRIORITAS UTAMA)
  - Form pengaduan dengan pilihan kategori + mode privasi/anonim
  - EnkripsiIdentitasService untuk simpan identitas terenkripsi terpisah
  - Generate ticket_code otomatis (format PLP-2026-XXXX)
  - CheckPenangananSensitif middleware untuk buka identitas sensitif
  - Status berjenjang + riwayat komunikasi dua arah
  - Log setiap akses identitas sensitif ke LogAktivitas

FASE 4 — Modul Pengumuman
  - CRUD pengumuman per role (Staff Dewan/HMPS/UKM sesuai cakupan)
  - Fitur pin, arsip (soft delete), lampiran gambar/PDF

FASE 5 — Modul Kegiatan & Kalender
  - Integrasi FullCalendar.js, filter per organisasi
  - CRUD kegiatan dengan poster/flyer

FASE 6 — Notifikasi & Polish
  - Laravel Notification untuk perubahan status pengaduan
  - Dashboard ringkas per role
  - Testing (Feature test untuk alur pengaduan privasi — pastikan identitas
    tidak bocor ke role yang tidak berwenang)

Mulai dari FASE 1. Tampilkan dulu struktur migration dan hasil RoleSeeder
sebelum lanjut ke fase berikutnya.
```

---

## 2. Saran Tambahan (opsional, dari dokumen spesifikasi bapak sendiri)

Ini bagian "Saran Pengembangan Lanjutan" yang sudah ada di dokumen bapak — bisa ditambahkan ke prompt di atas kalau mau langsung dikerjakan sekalian:

- Dashboard statistik untuk Staff Dewan (jumlah pengaduan per kategori, rata-rata waktu penyelesaian)
- Fitur survei kepuasan setelah pengaduan selesai ditangani
- Integrasi bot WhatsApp/Telegram untuk notifikasi status
- Versi PWA agar mudah diakses dari HP
- Dukungan multi-bahasa (Indonesia/Inggris)

Saran tambahan dari saya, boleh dipertimbangkan:
- **Two-factor authentication (2FA)** khusus untuk akun dengan permission "Penanganan Kasus Sensitif" — karena ini akun paling sensitif di seluruh sistem
- **Auto-logout / session timeout** lebih pendek untuk halaman pengaduan sensitif
- **Watermark otomatis** pada lampiran bukti sensitif saat diunduh, supaya bisa dilacak kalau bocor

---

*Dibuat berdasarkan: SIAP-DPM_Polmed_Spesifikasi.docx*
