<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php 
$bulan_names = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
?>

<!-- ==============================================
     MOBILE REPORT VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Laporan Kas</h5>
            <div class="text-muted small"><?= $bulan_names[$bulan]; ?> <?= $tahun; ?></div>
        </div>
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3" style="font-size: 0.75rem;">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
    </div>

    <!-- Mobile Filter Form -->
    <div class="card card-custom p-3 mb-3">
        <form method="GET" action="<?= site_url('laporan'); ?>" class="row g-2">
            <div class="col-6">
                <select name="bulan" class="form-select form-select-sm">
                    <?php foreach ($bulan_names as $num => $nama): ?>
                        <option value="<?= $num; ?>" <?= $num == $bulan ? 'selected' : ''; ?>><?= $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6">
                <select name="tahun" class="form-select form-select-sm">
                    <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                        <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>>Tahun <?= $y; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-sm btn-primary w-100 rounded-pill">
                    <i class="bi bi-filter me-1"></i> Terapkan Periode
                </button>
            </div>
        </form>
    </div>

    <!-- Mobile Month Summary Card -->
    <div class="wallet-master-card mb-3">
        <div class="wallet-header">
            <span class="wallet-label">
                <i class="bi bi-calculator"></i> Arus Kas Periode Ini
            </span>
            <span class="badge <?= $selisih >= 0 ? 'bg-success' : 'bg-danger'; ?> text-white rounded-pill px-2 py-1" style="font-size: 0.68rem;">
                <?= $selisih >= 0 ? 'Surplus' : 'Defisit'; ?>
            </span>
        </div>
        <div class="wallet-balance <?= $selisih >= 0 ? 'text-white' : 'text-danger'; ?>">
            Rp <?= number_format($selisih, 0, ',', '.'); ?>
        </div>
        <div class="wallet-stats-row">
            <div class="stat-pill">
                <div class="stat-pill-icon bg-success bg-opacity-25 text-success">
                    <i class="bi bi-arrow-down-left"></i>
                </div>
                <div>
                    <div class="text-white-50" style="font-size: 0.62rem;">Masuk (<?= count($pemasukan_list); ?> item)</div>
                    <div class="fw-bold text-success small">Rp <?= number_format($total_in, 0, ',', '.'); ?></div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="stat-pill-icon bg-danger bg-opacity-25 text-danger">
                    <i class="bi bi-arrow-up-right"></i>
                </div>
                <div>
                    <div class="text-white-50" style="font-size: 0.62rem;">Keluar (<?= count($pengeluaran_list); ?> item)</div>
                    <div class="fw-bold text-danger small">Rp <?= number_format($total_out, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Accordion or Tabs for Pemasukan vs Pengeluaran -->
    <h6 class="fw-bold text-success mb-2"><i class="bi bi-arrow-up-circle-fill me-1"></i> Pemasukan Iuran (<?= count($pemasukan_list); ?>)</h6>
    <div class="mb-3">
        <?php if (empty($pemasukan_list)): ?>
            <div class="p-3 bg-white text-muted small rounded-3 border text-center">Tidak ada iuran masuk periode ini.</div>
        <?php else: ?>
            <?php foreach ($pemasukan_list as $in): ?>
            <div class="mobile-tile-card py-2 px-3 mb-2 d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold text-dark small"><?= html_escape($in->nama_lengkap); ?></div>
                    <div class="text-muted" style="font-size: 0.7rem;"><?= html_escape($in->no_blok); ?> • <?= date('d/m/Y', strtotime($in->tgl_bayar)); ?></div>
                </div>
                <div class="fw-bold text-success small">
                    +Rp <?= number_format($in->nominal, 0, ',', '.'); ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h6 class="fw-bold text-danger mb-2"><i class="bi bi-arrow-down-circle-fill me-1"></i> Pengeluaran Kas (<?= count($pengeluaran_list); ?>)</h6>
    <div class="mb-4">
        <?php if (empty($pengeluaran_list)): ?>
            <div class="p-3 bg-white text-muted small rounded-3 border text-center">Tidak ada pengeluaran periode ini.</div>
        <?php else: ?>
            <?php foreach ($pengeluaran_list as $out): ?>
            <div class="mobile-tile-card py-2 px-3 mb-2 d-flex justify-content-between align-items-center">
                <div style="max-width: 65%;">
                    <div class="fw-bold text-dark small text-truncate"><?= html_escape($out->keterangan); ?></div>
                    <div class="text-muted" style="font-size: 0.7rem;"><?= html_escape($out->nama_kategori); ?> • <?= date('d/m/Y', strtotime($out->tgl_pengeluaran)); ?></div>
                </div>
                <div class="fw-bold text-danger small text-end">
                    -Rp <?= number_format($out->nominal, 0, ',', '.'); ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ==============================================
     DESKTOP VIEW (>= 768px)
     ============================================== -->
<div class="d-none d-md-block">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Laporan Arus Kas Keuangan</h4>
            <p class="text-secondary small mb-0">Rekapitulasi pemasukan iuran warga vs pengeluaran operasional.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter Periode -->
    <div class="card card-custom p-3 mb-4 d-print-none">
        <form method="GET" action="<?= site_url('laporan'); ?>" class="row g-2 align-items-center">
            <div class="col-md-4">
                <label class="small text-muted mb-1">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <?php foreach ($bulan_names as $num => $nama): ?>
                        <option value="<?= $num; ?>" <?= $num == $bulan ? 'selected' : ''; ?>><?= $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="small text-muted mb-1">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                        <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>>Tahun <?= $y; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Financial Period Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="metric-card card-success">
                <div class="metric-title text-success">Total Pemasukan (<?= $bulan_names[$bulan]; ?> <?= $tahun; ?>)</div>
                <div class="metric-amount text-success">Rp <?= number_format($total_in, 0, ',', '.'); ?></div>
                <div class="small text-muted mt-1"><?= count($pemasukan_list); ?> transaksi iuran warga</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card card-danger">
                <div class="metric-title text-danger">Total Pengeluaran (<?= $bulan_names[$bulan]; ?> <?= $tahun; ?>)</div>
                <div class="metric-amount text-danger">Rp <?= number_format($total_out, 0, ',', '.'); ?></div>
                <div class="small text-muted mt-1"><?= count($pengeluaran_list); ?> item operasional</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card card-primary">
                <div class="metric-title">Surplus / Defisit Periode Ini</div>
                <div class="metric-amount <?= $selisih >= 0 ? 'text-primary' : 'text-danger'; ?>">
                    Rp <?= number_format($selisih, 0, ',', '.'); ?>
                </div>
                <div class="small text-muted mt-1">Saldo Kas Keseluruhan: <strong>Rp <?= number_format($saldo_kas_total, 0, ',', '.'); ?></strong></div>
            </div>
        </div>
    </div>

    <!-- Detail Tables: Pemasukan & Pengeluaran -->
    <div class="row g-4">
        <!-- Tabel Pemasukan Iuran -->
        <div class="col-lg-6">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold mb-3 text-success d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-up-circle-fill"></i> Rincian Pemasukan Iuran
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small text-muted">
                                <th>Tgl</th>
                                <th>Blok</th>
                                <th>Nama Warga</th>
                                <th class="text-end">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pemasukan_list)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data pemasukan pada periode ini.</td></tr>
                            <?php else: ?>
                                <?php foreach ($pemasukan_list as $in): ?>
                            <tr>
                                <td class="small"><?= date('d/m', strtotime($in->tgl_bayar)); ?></td>
                                <td class="small fw-semibold"><?= html_escape($in->no_blok); ?></td>
                                <td class="small text-truncate" style="max-width: 140px;"><?= html_escape($in->nama_lengkap); ?></td>
                                <td class="text-end fw-semibold text-success small">Rp <?= number_format($in->nominal, 0, ',', '.'); ?></td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Pengeluaran Operasional -->
        <div class="col-lg-6">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold mb-3 text-danger d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-down-circle-fill"></i> Rincian Pengeluaran Kas
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small text-muted">
                                <th>Tgl</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th class="text-end">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pengeluaran_list)): ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data pengeluaran pada periode ini.</td></tr>
                            <?php else: ?>
                                <?php foreach ($pengeluaran_list as $out): ?>
                            <tr>
                                <td class="small"><?= date('d/m', strtotime($out->tgl_pengeluaran)); ?></td>
                                <td class="small"><span class="badge bg-light text-dark border"><?= html_escape($out->nama_kategori); ?></span></td>
                                <td class="small text-truncate" style="max-width: 150px;" title="<?= html_escape($out->keterangan); ?>"><?= html_escape($out->keterangan); ?></td>
                                <td class="text-end fw-semibold text-danger small">Rp <?= number_format($out->nominal, 0, ',', '.'); ?></td>
                            </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
