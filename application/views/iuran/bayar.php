<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <a href="<?= site_url('iuran'); ?>" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Matriks
    </a>
    <h4 class="fw-bold text-dark">Form Pembayaran Iuran Warga</h4>
</div>

<div class="card card-custom p-4" style="max-width: 800px;">
    <?= form_open_multipart('iuran/bayar'); ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Pilih Warga & Rumah <span class="text-danger">*</span></label>
                <select name="id_warga" class="form-select" required>
                    <option value="">-- Pilih Warga --</option>
                    <?php foreach ($warga_list as $w): ?>
                        <option value="<?= $w->id_warga; ?>" <?= ($default_warga == $w->id_warga) ? 'selected' : ''; ?>>
                            <?= html_escape($w->no_blok); ?> - <?= html_escape($w->nama_lengkap); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_warga', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary">Tahun <span class="text-danger">*</span></label>
                <select name="tahun" class="form-select" required>
                    <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                        <option value="<?= $y; ?>" <?= $y == date('Y') ? 'selected' : ''; ?>><?= $y; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary">Tanggal Bayar <span class="text-danger">*</span></label>
                <input type="date" name="tgl_bayar" class="form-control" value="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="col-12">
                <label class="form-label small fw-semibold text-secondary d-block">Pilih Bulan Pembayaran (Multi-Bulan Sekaligus) <span class="text-danger">*</span></label>
                <div class="row g-2">
                    <?php 
                    $bulan_names = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                    foreach ($bulan_names as $num => $nama): 
                    ?>
                    <div class="col-4 col-sm-3 col-md-2">
                        <div class="form-check p-2 border rounded bg-light">
                            <input class="form-check-input check-bulan" type="checkbox" name="bulan[]" value="<?= $num; ?>" id="bln_<?= $num; ?>" onchange="calculateTotal()">
                            <label class="form-check-label small fw-medium text-dark" for="bln_<?= $num; ?>">
                                <?= substr($nama, 0, 3); ?>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?= form_error('bulan[]', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nominal Iuran Per Bulan (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="nominal_per_bulan" id="nominal_per_bulan" class="form-control" value="150000" required onkeyup="calculateTotal()" onchange="calculateTotal()">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Total Bayar Terkalkulasi</label>
                <div class="form-control bg-light fw-bold text-success fs-5" id="display_total">
                    Rp 0
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Upload Bukti Bayar / Transfer (Opsional)</label>
                <input type="file" name="bukti_bayar" class="form-control" accept="image/*,application/pdf">
                <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks 5MB). File akan dienkripsi acak.</div>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Transfer via BCA / Tunai di Pos Satpam">
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-check-circle me-1"></i> Simpan Pembayaran
            </button>
            <a href="<?= site_url('iuran'); ?>" class="btn btn-light py-2 text-center">Batal</a>
        </div>
    <?= form_close(); ?>
</div>

<script>
function calculateTotal() {
    let checkedCount = document.querySelectorAll('.check-bulan:checked').length;
    let nominalPerBulan = parseFloat(document.getElementById('nominal_per_bulan').value) || 0;
    let total = checkedCount * nominalPerBulan;
    document.getElementById('display_total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
}
window.addEventListener('load', calculateTotal);
</script>
