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
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Data Warga
            </button>
            <a href="<?= site_url('warga'); ?>" class="btn btn-light py-2 text-center">Batal</a>
        </div>
    <?= form_close(); ?>
</div>
