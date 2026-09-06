# Agent Instructions - SIM-Perumahan

Sistem Informasi Manajemen Perumahan (SIM-Perumahan) berbasis **CodeIgniter 3** (PHP 8.x compatible) dan MySQL / MariaDB.

## 📌 ATURAN WAJIB SEBELUM MEMULAI TUGAS (MANDATORY RULES)

Setiap kali agent menerima tugas pengembangan fitur, perbaikan bug, atau refactoring, **AGENT WAJIB MEMBACA & MEMATUHI DOKUMEN BERIKUT TERLEBIH DAHULU**:

1. **[docs/PRD.md](file:///c:/xampp/htdocs/SIM-Perumahan/docs/PRD.md)**:
   - Berisi deskripsi sistem, daftar modul fungsional (Warga, Kavling, Iuran, Keuangan, Surat, dsb.), dan alur proses bisnis.
   - *Jangan menambahkan fitur di luar scope PRD tanpa konfirmasi atau mencatatnya di PRD*.

2. **[docs/DESIGN.md](file:///c:/xampp/htdocs/SIM-Perumahan/docs/DESIGN.md)**:
   - Berisi arsitektur teknis CodeIgniter 3 MVC, struktur database/skema tabel, template antarmuka (UI/UX), dan konvensi penamaan (file, class, route).
   - *Patuhi pola pemisahan Controller, Model, dan View. Jangan letakkan raw business logic atau database queries di dalam Views*.

3. **[docs/SECURITY.md](file:///c:/xampp/htdocs/SIM-Perumahan/docs/SECURITY.md)**:
   - Standar keamanan aplikasi: pencegahan SQL Injection (Query Builder / Parameterized Query), validasi CSRF pada form, sanitasi input XSS, hashing password dengan `password_hash(..., PASSWORD_BCRYPT)`, dan otorisasi sesi (Role-Based Access Control).
   - *Dilarang keras menggunakan query string concat langsung `$this->db->query("... WHERE id = " . $id)`*.

---

## 📁 Ringkasan Struktur Folder
```text
SIM-Perumahan/
├── .agents/
│   └── rules/
│       └── project_guidelines.md    # Aturan otomatis Antigravity Agent
├── application/
│   ├── config/                      # Konfigurasi CI3 (config, database, autoload)
│   ├── controllers/                 # Logika controller (extends CI_Controller)
│   ├── models/                      # Logika query & data (extends CI_Model)
│   ├── views/                       # Tampilan UI HTML & layouts
│   └── libraries/                   # Library kustom sistem
├── docs/
│   ├── PRD.md                       # Product Requirements Document
│   ├── DESIGN.md                    # Technical & System Design
│   └── SECURITY.md                  # Security Guidelines & Checklists
├── system/                          # CodeIgniter 3 Core Engine (PHP 8.x patched)
├── AGENTS.md                        # Root guide untuk AI Agent
└── index.php                        # Main entry point
```
