<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <a href="<?= site_url('pengeluaran'); ?>" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Pengeluaran
    </a>
    <h4 class="fw-bold text-dark">Catat Pengeluaran Kas Operasional</h4>
</div>

<div class="card card-custom p-4" style="max-width: 720px;">
    <?= form_open_multipart('pengeluaran/create'); ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Kategori Pengeluaran <span class="text-danger">*</span></label>
                <select name="id_kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $k): ?>
                        <option value="<?= $k->id_kategori; ?>" <?= set_select('id_kategori', $k->id_kategori); ?>>
                            <?= html_escape($k->nama_kategori); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_kategori', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                <input type="date" name="tgl_pengeluaran" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                <?= form_error('tgl_pengeluaran', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nominal Pengeluaran (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="nominal" class="form-control" placeholder="Misal: 500000" value="<?= set_value('nominal'); ?>" required>
                <?= form_error('nominal', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Upload Nota / Kwitansi / Struk (Opsional)</label>
                <input type="file" name="bukti_nota" class="form-control" accept="image/*,application/pdf">
                <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks 5MB). File dienkripsi acak.</div>
            </div>

            <div class="col-12">
                <label class="form-label small fw-semibold text-secondary">Keterangan / Rincian Pengeluaran <span class="text-danger">*</span></label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan kebutuhan pengeluaran secara lengkap..." required><?= set_value('keterangan'); ?></textarea>
                <?= form_error('keterangan', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold">
                <i class="bi bi-save me-1"></i> Simpan Pengeluaran
            </button>
            <a href="<?= site_url('pengeluaran'); ?>" class="btn btn-light py-2 text-center">Batal</a>
        </div>
    <?= form_close(); ?>
</div>
