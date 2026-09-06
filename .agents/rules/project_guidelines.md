# Project Guidelines & Agent Rules

File ini dimuat otomatis oleh lingkungan Antigravity Agent. Setiap agen yang berinteraksi dengan workspace **SIM-Perumahan** WAJIB mengikuti instruksi di bawah ini:

## 1. Prioritas Dokumen Acuan (Prerequisites)
Sebelum membuat kode baru atau mengubah kode yang ada, periksa dokumen berikut di folder `docs/`:
- **PRD (`docs/PRD.md`)**: Pahami fungsionalitas dan use case yang sedang dikerjakan.
- **DESIGN (`docs/DESIGN.md`)**: Pahami skema database, pola routing, arsitektur Controller-Model-View, serta komponen UI.
- **SECURITY (`docs/SECURITY.md`)**: Pahami dan terapkan checklist keamanan tanpa kompromi.

---

## 2. Standar Pengembangan CodeIgniter 3
- **PHP Version**: Target PHP 8.2 / 8.3 (XAMPP). Hindari fungsi deprecated seperti `each()`, `create_function()`, dynamic property tanpa deklarasi, dll.
- **MVC Separation**:
  - **Controller**: Hanya menangani validasi input HTTP, memanggil Model terkait, dan melempar data ke View. Nama file berawalan huruf kapital (misal: `Warga.php`).
  - **Model**: Mengelola query database menggunakan CI3 Query Builder (`$this->db->get()`, `$this->db->insert()`, dll.). Jangan pernah merender HTML di Model.
  - **View**: Hanya berisi template presentasi HTML dan looping sederhana data PHP.
- **URL & Routing**: Menggunakan URL ramah SEO (tanpa `index.php`, dihandle via `.htaccess`). Konfigurasi rute eksplisit ditulis di `application/config/routes.php`.

---

## 3. Standar Keamanan Wajib (Non-Negotiable)
1. **SQL Injection**:
   - WAJIB gunakan Query Builder CI3 (`$this->db->where()`, `$this->db->insert()`) atau binding parameter `?`.
   - DILARANG melakukan string concatenation raw SQL dengan variabel input pengguna.
2. **CSRF Protection**:
   - Setiap form POST wajib menyertakan token CSRF (`<?= form_open() ?>` atau token hidden field).
3. **XSS Sanitization**:
   - Gunakan `html_escape()` saat mencetak data variabel ke dalam HTML.
   - Gunakan `$this->input->post('field', TRUE)` untuk filter XSS saat menerima input jika diperlukan.
4. **Password & Credential**:
   - Gunakan `password_hash($password, PASSWORD_BCRYPT)` dan `password_verify($password, $hash)`.
   - Jangan pernah menyimpan password plaintext atau MD5/SHA1 usang.
5. **Autentikasi & Otorisasi**:
   - Setiap Controller/Method terproteksi harus memeriksa status login sesi (`$this->session->userdata(...)`) dan level akses (Role-Based Access Control).
