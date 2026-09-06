# DESIGN STYLE GUIDE & UI SPECIFICATIONS
**Frontend Stack:** HTML5, CSS3, Bootstrap 4 / AdminLTE 3, jQuery, DataTables, Chart.js  

## 1. Prinsip Desain
* **Clean & Professional:** Tampilan bersih, kontras tinggi untuk memudahkan pembacaan angka laporan keuangan.
* **Mobile First & Responsive:** Nyaman diakses oleh warga via smartphone maupun pengurus melalui tablet/laptop.
* **Color-Coded Status:** Penggunaan warna intuitif (Pemasukan = Hijau, Pengeluaran = Merah).

## 2. Skema Warna (Color Palette)
* **Primary (Utama):** Deep Navy `#1E293B` (Top Navbar, Sidebar, Header)
* **Secondary:** Slate Gray `#64748B` (Sub-header, Text Muted)
* **Success (Pemasukan / Lunas):** Emerald Green `#10B981` (Card Pemasukan, Badge Lunas)
* **Danger (Pengeluaran / Belum):** Rose Red `#EF4444` (Card Pengeluaran, Badge Belum Bayar)
* **Warning (Pending/Info):** Amber Gold `#F59E0B` (Notification, Peringatan)
* **Background App:** Soft Gray `#F8FAFC` (Latar Belakang Konten Utama)
* **Card & Surface:** Pure White `#FFFFFF` (Latar Belakang Tabel & Modal)

## 3. Tipografi
* **Font Family Utama:** `'Inter', 'Segoe UI', Roboto, sans-serif`
* **Heading 1 (Page Title):** 24px, Bold
* **Heading 2 (Card Title):** 18px, Semi-Bold
* **Body Text (Tabel):** 14px, Regular
* **Financial Amount (Nominal):** 28px, Bold

## 4. Komponen UI
* **Dashboard Metric Cards:** Background putih dengan *soft shadow*, dilengkapi border kiri tebal (*accent border*) sesuai warna kategori (Primary/Success/Danger).
* **Matriks Badges:** Class `.badge-success` untuk Lunas dan `.badge-danger` untuk Belum Bayar.
* **Data Tables:** Menggunakan *Zebra Striping* (baris selang-seling warna) pada header tabel *Light Gray*, dilengkapi dengan fitur pencarian dan paginasi (DataTables).

## 5. Wireframe Structure (Dashboard Layout)
+-------------------------------------------------------------------+
| [LOGO] SIM-KOMPLEK         (Top Navbar - User Info & Logout)      |
+-----------------+-------------------------------------------------+
| SIDEBAR MENU    | MAIN CONTENT AREA                               |
|                 | Page Title: Dashboard Keuangan                  |
| - Dashboard     | +---------------+ +---------------+ +----------+|
| - Data Warga    | | Total Kas     | | Pemasukan     | |Pengeluar ||
| - Iuran Warga   | | Rp 45jt       | | Rp 5jt        | |Rp 2.5jt  ||
| - Pengeluaran   | +---------------+ +---------------+ +----------+|
| - Laporan       |                                                 |
| - Master User   | +-----------------------------------------------+|
| - Settings      | | Chart: Tren Pemasukan vs Pengeluaran (1 Tahun)| |
|                 | +-----------------------------------------------+|
|                 | +-----------------------------------------------+|
|                 | | Matriks Iuran Warga (Tabel Rekap Bulanan)     | |
|                 | +-----------------------------------------------+|
+-----------------+-------------------------------------------------+