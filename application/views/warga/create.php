<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <a href="<?= site_url('warga'); ?>" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Warga
    </a>
    <h4 class="fw-bold text-dark">Tambah Data Warga & Rumah</h4>
</div>

<div class="card card-custom p-4" style="max-width: 720px;">
    <?= form_open('warga/create'); ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nomor Blok/Rumah <span class="text-danger">*</span></label>
                <input type="text" name="no_blok" class="form-control" placeholder="Misal: Blok A-01" value="<?= set_value('no_blok'); ?>" required>
                <?= form_error('no_blok', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Kepala Keluarga / Penghuni" value="<?= set_value('nama_lengkap'); ?>" required>
                <?= form_error('nama_lengkap', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" class="form-control" placeholder="16 digit NIK KTP" value="<?= set_value('nik'); ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="<?= set_value('no_hp'); ?>" required>
                <?= form_error('no_hp', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Status Hunian</label>
                <select name="status_hunian" class="form-select">
                    <option value="dihuni" <?= set_select('status_hunian', 'dihuni', TRUE); ?>>Dihuni</option>
                    <option value="kosong" <?= set_select('status_hunian', 'kosong'); ?>>Kosong</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Status Penghuni</label>
                <select name="status_penghuni" class="form-select">
                    <option value="pemilik" <?= set_select('status_penghuni', 'pemilik', TRUE); ?>>Pemilik Rumah</option>
                    <option value="kontrak" <?= set_select('status_penghuni', 'kontrak'); ?>>Penyewa / Kontrak</option>
                </select>
            </div>

            <!-- Bagian Buat Akun Login Warga Otomatis -->
            <div class="col-12 mt-3">
                <div class="card bg-light border p-3 rounded-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="auto_create_user" name="auto_create_user" value="1" <?= set_checkbox('auto_create_user', '1', TRUE); ?>>
                        <label class="form-check-label fw-bold text-dark" for="auto_create_user">
                            <i class="bi bi-person-check-fill text-primary me-1"></i> Buat Akun Login Warga Otomatis
                        </label>
                    </div>
                    <div id="user_account_fields">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Username Login</label>
                                <input type="text" name="username" id="input_username" class="form-control" placeholder="Misal: budi_a01" value="<?= set_value('username'); ?>">
                                <div class="form-text small text-muted">Otomatis dibuat dari nama & nomor blok jika dikosongkan.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Password Default</label>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-white fw-bold text-success" value="WargaBaik1!" readonly>
                                    <span class="input-group-text bg-white text-muted small"><i class="bi bi-lock-fill"></i></span>
                                </div>
                                <div class="form-text small text-muted">Warga akan diminta mengganti password ini setelah login pertama kali.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Data Warga & User
            </button>
            <a href="<?= site_url('warga'); ?>" class="btn btn-light py-2 text-center">Batal</a>
        </div>
    <?= form_close(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="nama_lengkap"]');
    const blockInput = document.querySelector('input[name="no_blok"]');
    const usernameInput = document.getElementById('input_username');
    const autoSwitch = document.getElementById('auto_create_user');
    const userFields = document.getElementById('user_account_fields');

    function updateSuggestedUsername() {
        if (!autoSwitch.checked) return;
        if (!usernameInput.dataset.manual && !usernameInput.value) {
            const namePart = (nameInput.value.trim().split(' ')[0] || '').toLowerCase().replace(/[^a-z0-9]/g, '');
            const blockPart = blockInput.value.trim().toLowerCase().replace(/[^a-z0-9]/g, '');
            if (namePart || blockPart) {
                usernameInput.value = (namePart && blockPart) ? `${namePart}_${blockPart}` : (namePart || blockPart);
            }
        }
    }

    if (nameInput) nameInput.addEventListener('input', updateSuggestedUsername);
    if (blockInput) blockInput.addEventListener('input', updateSuggestedUsername);
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.dataset.manual = "1";
            } else {
                delete this.dataset.manual;
            }
        });
    }

    if (autoSwitch && userFields) {
        autoSwitch.addEventListener('change', function() {
            userFields.style.display = this.checked ? 'block' : 'none';
            if (this.checked) updateSuggestedUsername();
        });
    }
});
</script>
