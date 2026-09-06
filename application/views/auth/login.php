<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIM-Komplek</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #334155;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }
        .login-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 32px 30px;
            text-align: center;
        }
        .brand-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #38bdf8;
            margin-bottom: 12px;
        }
        .login-body {
            padding: 32px 30px;
        }
        .form-control:focus {
            border-color: #1e293b;
            box-shadow: 0 0 0 0.25rem rgba(30, 41, 59, 0.15);
        }
        .btn-primary-custom {
            background-color: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
            font-weight: 600;
            padding: 11px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
        }
        .demo-badge {
            font-size: 0.75rem;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            transition: 0.15s;
        }
        .demo-badge:hover {
            background-color: #e2e8f0;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">
            <i class="bi bi-houses-fill"></i>
        </div>
        <h4 class="fw-bold mb-1">SIM-Komplek</h4>
        <p class="text-white-50 small mb-0">Sistem Informasi Manajemen & Keuangan Perumahan</p>
    </div>

    <div class="login-body">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                <?= html_escape($this->session->flashdata('error')); ?>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i>
                <?= html_escape($this->session->flashdata('success')); ?>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= form_open('auth/login'); ?>
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autofocus value="<?= set_value('username'); ?>">
                </div>
                <?= form_error('username', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small fw-semibold text-secondary mb-0">Password</label>
                    <a href="javascript:void(0)" class="small text-decoration-none text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalGantiPasswordLogin" style="font-size: 0.78rem;">
                        <i class="bi bi-key-fill me-1"></i> Ganti Password Default?
                    </a>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary" type="button" id="btnToggleLoginPass" title="Lihat password">
                        <i class="bi bi-eye-slash" id="loginPassIcon"></i>
                    </button>
                </div>
                <?= form_error('password', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>
        <?= form_close(); ?>

        <!-- Quick Demo Switcher -->
        <div class="border-top pt-3 mt-3">
            <div class="text-muted small text-center mb-2">Akun Demo Cepat:</div>
            <div class="d-flex justify-content-between gap-1">
                <div class="demo-badge text-center flex-fill" onclick="setDemo('admin', 'password123')">
                    <div class="fw-semibold text-dark">Admin</div>
                    <div class="text-muted" style="font-size:10px;">Full Access</div>
                </div>
                <div class="demo-badge text-center flex-fill" onclick="setDemo('bendahara', 'password123')">
                    <div class="fw-semibold text-dark">Pengurus</div>
                    <div class="text-muted" style="font-size:10px;">Keuangan</div>
                </div>
                <div class="demo-badge text-center flex-fill" onclick="setDemo('warga', 'password123')">
                    <div class="fw-semibold text-dark">Warga</div>
                    <div class="text-muted" style="font-size:10px;">Read-Only</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password dari Halaman Login -->
<div class="modal fade" id="modalGantiPasswordLogin" tabindex="-1" aria-labelledby="modalGantiPasswordLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold" id="modalGantiPasswordLoginLabel">
                    <i class="bi bi-shield-lock me-2 text-warning"></i> Ganti Password Akun / Warga
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('auth/change_password_login'); ?>
            <div class="modal-body p-4">
                <div class="alert alert-info py-2 px-3 small rounded-3 mb-3">
                    <i class="bi bi-info-circle-fill me-1"></i> Khusus akun warga baru dengan password default (<code>WargaBaik1!</code>) atau user yang ingin memperbarui password.
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username Anda" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Password Lama / Default Saat Ini <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="current_password" class="form-control" placeholder="Misal: WargaBaik1!" required>
                    </div>
                    <div class="form-text small text-muted">Untuk warga baru yang dibuat oleh pengurus, password defaultnya adalah: <code>WargaBaik1!</code></div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Password Baru (Minimal 6 Karakter) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-check"></i></span>
                        <input type="password" name="new_password" class="form-control" placeholder="Buat password baru Anda" minlength="6" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-check2-circle"></i></span>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" minlength="6" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-check-circle me-1"></i> Simpan Password Baru
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setDemo(user, pass) {
    document.getElementById('username').value = user;
    document.getElementById('password').value = pass;
}

document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('btnToggleLoginPass');
    const passInput = document.getElementById('password');
    const passIcon = document.getElementById('loginPassIcon');

    if (btnToggle && passInput) {
        btnToggle.addEventListener('click', function() {
            if (passInput.type === 'password') {
                passInput.type = 'text';
                passIcon.className = 'bi bi-eye';
            } else {
                passInput.type = 'password';
                passIcon.className = 'bi bi-eye-slash';
            }
        });
    }
});
</script>
</body>
</html>
