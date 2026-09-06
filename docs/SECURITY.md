# STANDAR KEAMANAN & ARSITEKTUR (CODEIGNITER 3)

## 1. Authentication & Role Middleware
* Seluruh controller internal wajib mengecek session login dan peran pengguna pada fungsi `__construct()`.
* Jika pengguna mencoba mengakses modul di luar haknya (misal Warga mengakses form Pengeluaran), sistem harus melempar error 403 atau me-redirect kembali ke Dashboard.

## 2. Password Hashing
* Wajib menggunakan fungsi bawaan PHP `password_hash()` dengan algoritma `PASSWORD_BCRYPT`.
* Hindari penggunaan MD5 atau SHA1 karena rentan dibobol. Saat login, gunakan `password_verify()`.

## 3. Pencegahan SQL Injection
* Seluruh interaksi database wajib menggunakan Active Record CodeIgniter 3 (`$this->db->get()`, `$this->db->insert()`) atau Query Binding (`?`).
* Dilarang keras menggabungkan string input user langsung ke dalam raw SQL query.

## 4. Proteksi Cross-Site Request Forgery (CSRF)
* Aktifkan proteksi CSRF di `application/config/config.php`:
  `$config['csrf_protection'] = TRUE;`
* Gunakan helper `form_open()` pada setiap form HTML agar token CSRF otomatis di-generate dan divalidasi.

## 5. XSS Filtering & Input Sanitization
* Aktifkan XSS Filter pada setiap penangkapan input: `$this->input->post('field', TRUE);`.
* Gunakan fungsi `html_escape()` saat menampilkan data teks dari database ke dalam View (UI) untuk mencegah injeksi script berbahaya.

## 6. Secure File Uploads
* Modul upload (Bukti Bayar & Nota Pengeluaran) harus membatasi tipe file yang diizinkan: `jpg|jpeg|png|pdf`.
* Aktifkan fitur enkripsi nama file (`$config['encrypt_name'] = TRUE;`) agar file yang terunggah memiliki nama acak untuk mencegah akses eksekusi langsung (Directory Traversal).