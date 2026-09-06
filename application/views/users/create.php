<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <a href="<?= site_url('users'); ?>" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data User
    </a>
    <h4 class="fw-bold text-dark">Tambah Pengguna Baru</h4>
</div>

<div class="card card-custom p-4" style="max-width: 640px;">
    <?= form_open('users/create'); ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Misal: budi_blok_a" value="<?= set_value('username'); ?>" required autofocus>
                <?= form_error('username', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                <?= form_error('password', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Role Akses <span class="text-danger">*</span></label>
                <select name="id_role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r->id_role; ?>" <?= set_select('id_role', $r->id_role); ?>>
                            <?= strtoupper($r->role_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_role', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Hubungkan ke Data Warga (Opsional)</label>
                <select name="id_warga" class="form-select">
                    <option value="">-- Tidak Terhubung / Admin --</option>
                    <?php foreach ($warga_list as $w): ?>
                        <option value="<?= $w->id_warga; ?>" <?= set_select('id_warga', $w->id_warga); ?>>
                            <?= html_escape($w->no_blok); ?> - <?= html_escape($w->nama_lengkap); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-person-check me-1"></i> Buat User
            </button>
            <a href="<?= site_url('users'); ?>" class="btn btn-light">Batal</a>
        </div>
    <?= form_close(); ?>
</div>
