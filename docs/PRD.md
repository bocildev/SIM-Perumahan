# PRODUCT REQUIREMENT DOCUMENT (PRD)
**Nama Sistem:** SIM-Komplek (Sistem Informasi Management & Keuangan Perumahan)  
**Backend Framework:** CodeIgniter 3 (PHP)  
**Database:** MySQL / MariaDB  

---

## 1. Ringkasan Produk
Aplikasi berbasis web untuk mencatat, mengelola, serta menyajikan laporan keuangan komplek perumahan secara transparan dan *real-time*. Sistem ini menangani iuran rutin warga, pengeluaran kas operasional (gaji satpam, wifi, kebersihan), serta menyajikan laporan keuangan dengan pembatasan hak akses berbasis peran (*Role-Based Access Control*).

## 2. Matriks Peran Pengguna (Role-Based Access Control)
* **Admin / Super User:** Full Access (Master User, Master Role, Master Data Warga & Rumah, Modul Keuangan, serta Settings Sistem).
* **Pengurus (Bendahara/Ketua):** Access Modul Keuangan (Input/Edit Iuran, Input/Edit Pengeluaran, Master Kategori Pengeluaran, View Dashboard, Export Laporan).
* **Warga:** Read-Only Access (View Dashboard Kas, View Matriks Rekap Iuran, View Laporan Pengeluaran, View Riwayat Pembayaran Pribadi).

## 3. Spesifikasi Fungsional

### 3.1. Dashboard Utama
* **Ringkasan Kas:** Total Saldo Kas (*Real-time*), Total Pemasukan & Pengeluaran Bulan Ini.
* **Widget & Visualisasi:** Chart Pemasukan vs Pengeluaran 12 bulan terakhir, Tabel Quick Status Iuran warga per blok.

### 3.2. Management User & Role (Admin Only)
* **Master Role & User:** CRUD role pengguna dan akun (Username, Password Hashed, Select Role, Relasi `id_warga`, Status Aktif). Termasuk fitur *Reset Password*.

### 3.3. Master Data Warga & Rumah
* Pencatatan Nomor Blok, Status Hunian (Dihuni/Kosong), Nama Lengkap, NIK, No. WhatsApp, dan Status Penghuni (Pemilik/Kontrak).

### 3.4. Modul Iuran Warga (Pemasukan)
* **Matriks Rekap Iuran (1 Tahun):** Tabel matriks 12 Bulan dengan indikator `Lunas` (Hijau) dan `Belum Lunas` (Merah).
* **Form Input Pembayaran:** Dukungan multi-bulan sekaligus, kalkulasi nominal otomatis, dan upload bukti bayar.
* **Export:** PDF dan Excel.

### 3.5. Modul Pengeluaran Kas
* **Master Kategori:** Kategori dinamis (Gaji Satpam, Biaya Wifi, dll).
* **Form Input Pengeluaran:** Tanggal, Kategori, Nominal, Keterangan, Upload Nota/Struk.
* **Laporan:** Filter rentang tanggal dan kategori, disertai fitur Export.

## 4. Skema Database Inti (MySQL)
1. `roles` (id_role, role_name)
2. `users` (id_user, username, password, id_role, is_active)
3. `warga` (id_warga, id_user, nama_lengkap, no_blok, no_hp, status_hunian)
4. `kategori_pengeluaran` (id_kategori, nama_kategori)
5. `pemasukan_iuran` (id_pemasukan, id_warga, bulan, tahun, nominal, tgl_bayar, bukti_bayar, created_by)
6. `pengeluaran_kas` (id_pengeluaran, id_kategori, nominal, tgl_pengeluaran, keterangan, bukti_nota, created_by)