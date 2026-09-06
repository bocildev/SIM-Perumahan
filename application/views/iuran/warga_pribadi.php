<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <?php if ($is_admin_view): ?>
        <a href="<?= site_url('iuran?tahun=' . $tahun); ?>" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Matriks Seluruh Warga
        </a>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-person-badge text-primary me-2"></i><?= $is_admin_view ? 'Rincian Iuran Warga' : 'Kartu Iuran Saya'; ?>
            </h4>
            <p class="text-secondary small mb-0">
                Data pembayaran iuran bulanan untuk <strong><?= html_escape($warga->nama_lengkap); ?></strong> &bull; <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold"><?= html_escape($warga->no_blok); ?></span>
            </p>
        </div>

        <!-- Filter Tahun -->
        <form method="GET" action="<?= $is_admin_view ? site_url('iuran/detail/' . $warga->id_warga) : site_url('iuran'); ?>" class="d-flex align-items-center gap-2">
            <label class="small text-muted mb-0 d-none d-sm-inline">Tahun:</label>
            <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 120px;">
                <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                    <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>><?= $y; ?></option>
                <?php endfor; ?>
            </select>
        </form>
    </div>
</div>

<!-- ==============================================
     RINGKASAN METRIK BULANAN
     ============================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="metric-card card-success py-3">
            <div class="metric-title"><i class="bi bi-check-circle-fill text-success me-1"></i> Bulan Terbayar</div>
            <div class="metric-amount text-success fs-3"><?= $total_lunas; ?> <span class="fs-6 text-muted fw-normal">/ 12 Bulan</span></div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="metric-card card-danger py-3">
            <div class="metric-title"><i class="bi bi-hourglass-split text-danger me-1"></i> Belum Bayar</div>
            <div class="metric-amount text-danger fs-3"><?= $total_belum; ?> <span class="fs-6 text-muted fw-normal">Bulan</span></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="metric-card card-primary py-3">
            <div class="metric-title"><i class="bi bi-cash-stack text-primary me-1"></i> Total Iuran Masuk (<?= $tahun; ?>)</div>
            <div class="metric-amount text-dark fs-3">Rp <?= number_format($total_nominal, 0, ',', '.'); ?></div>
        </div>
    </div>
</div>

<!-- ==============================================
     MOBILE LIST VIEW (< 768px)
     ============================================== -->
<div class="d-md-none mb-4">
    <h6 class="fw-bold text-dark mb-3">Rincian Per Bulan (Tahun <?= $tahun; ?>)</h6>
    
    <?php foreach ($detail as $b): ?>
    <div class="mobile-tile-card mb-2">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.75rem;">
                    Bulan #<?= $b['bulan_angka']; ?>
                </span>
                <strong class="text-dark fs-6"><?= $b['nama_bulan']; ?></strong>
            </div>

            <?php if ($b['is_lunas']): ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.72rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> Lunas
                </span>
            <?php else: ?>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.72rem;">
                    <i class="bi bi-x-circle-fill me-1"></i> Belum Bayar
                </span>
            <?php endif; ?>
        </div>

        <?php if ($b['is_lunas']): ?>
            <div class="bg-light p-2 rounded-3 mb-2" style="font-size: 0.8rem;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary"><i class="bi bi-calendar-event me-1"></i> Tanggal Bayar:</span>
                    <strong class="text-dark"><?= date('d F Y', strtotime($b['tgl_bayar'])); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary"><i class="bi bi-wallet2 me-1"></i> Nominal:</span>
                    <strong class="text-success">Rp <?= number_format($b['nominal'], 0, ',', '.'); ?></strong>
                </div>
                <?php if ($b['keterangan']): ?>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary"><i class="bi bi-chat-left-text me-1"></i> Catatan:</span>
                    <span class="text-dark"><?= html_escape($b['keterangan']); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($b['pencatat']): ?>
                <div class="d-flex justify-content-between">
                    <span class="text-muted" style="font-size: 0.72rem;">Diverifikasi oleh:</span>
                    <span class="text-muted" style="font-size: 0.72rem;"><?= html_escape($b['pencatat']); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($b['bukti_bayar']): ?>
                <a href="<?= base_url('uploads/bukti_bayar/' . $b['bukti_bayar']); ?>" target="_blank" class="btn btn-sm btn-outline-info w-100 py-1 rounded-pill" style="font-size: 0.75rem;">
                    <i class="bi bi-receipt me-1"></i> Lihat Bukti Bayar / Transfer
                </a>
            <?php endif; ?>

        <?php else: ?>
            <div class="text-muted small py-1" style="font-size: 0.78rem;">
                <i class="bi bi-info-circle me-1"></i> Belum ada catatan pembayaran untuk bulan <?= $b['nama_bulan']; ?> <?= $tahun; ?>.
            </div>
            <?php if ($is_admin_view): ?>
                <div class="mt-2 text-end">
                    <a href="<?= site_url('iuran/bayar?warga_id=' . $warga->id_warga . '&tahun=' . $tahun); ?>" class="btn btn-sm btn-primary py-1 px-3 rounded-pill" style="font-size: 0.75rem;">
                        <i class="bi bi-plus-circle me-1"></i> Bayar Sekarang
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- ==============================================
     DESKTOP TABLE VIEW (>= 768px)
     ============================================== -->
<div class="d-none d-md-block">
    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Bulan (Periode)</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Bukti Transfer</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail as $b): ?>
                    <tr>
                        <td class="text-muted small">#<?= $b['bulan_angka']; ?></td>
                        <td class="fw-semibold text-dark">
                            <?= $b['nama_bulan']; ?> <?= $tahun; ?>
                        </td>
                        <td>
                            <?php if ($b['is_lunas']): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                    <i class="bi bi-x-circle-fill me-1"></i> Belum Bayar
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['is_lunas']): ?>
                                <span class="fw-medium text-dark">
                                    <i class="bi bi-calendar-check text-success me-1"></i>
                                    <?= date('d/m/Y', strtotime($b['tgl_bayar'])); ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['is_lunas']): ?>
                                <span class="fw-bold text-success">
                                    Rp <?= number_format($b['nominal'], 0, ',', '.'); ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small">
                            <?php if ($b['is_lunas']): ?>
                                <?= html_escape($b['keterangan'] ? $b['keterangan'] : 'Iuran Kas Bulanan'); ?>
                            <?php else: ?>
                                <span class="text-muted small">Menunggu Pembayaran</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['is_lunas'] && $b['bukti_bayar']): ?>
                                <a href="<?= base_url('uploads/bukti_bayar/' . $b['bukti_bayar']); ?>" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2">
                                    <i class="bi bi-receipt me-1"></i> Bukti
                                </a>
                            <?php elseif ($b['is_lunas']): ?>
                                <span class="text-muted small">Tanpa Bukti</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted">
                            <?= html_escape($b['pencatat'] ?? '-'); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
