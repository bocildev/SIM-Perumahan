<!-- ==============================================
     MOBILE CARD-BASED MATRIX VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Matriks Iuran Warga</h5>
            <div class="text-muted small">Tahun Buku <?= $tahun; ?></div>
        </div>
        <form method="GET" action="<?= site_url('iuran'); ?>">
            <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                    <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>>Tahun <?= $y; ?></option>
                <?php endfor; ?>
            </select>
        </form>
    </div>

    <!-- Mobile Quick Status Badges -->
    <div class="d-flex align-items-center gap-2 mb-3 small text-muted bg-white p-2 rounded-3 border">
        <span class="d-inline-flex align-items-center gap-1"><span class="badge-matrix lunas" style="font-size: 0.65rem; min-width: auto; padding: 2px 6px;">Lunas</span> Selesai</span>
        <span class="d-inline-flex align-items-center gap-1"><span class="badge-matrix belum" style="font-size: 0.65rem; min-width: auto; padding: 2px 6px;">Belum</span> Belum Bayar</span>
    </div>

    <!-- Cards per Warga for Mobile -->
    <div class="mb-4">
        <?php foreach ($matriks as $row): $w = $row['warga']; ?>
        <div class="mobile-tile-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small fw-bold">
                        <?= html_escape($w->no_blok); ?>
                    </span>
                    <h6 class="fw-bold text-dark mt-1 mb-0"><?= html_escape($w->nama_lengkap); ?></h6>
                    <div class="text-muted" style="font-size: 0.72rem;"><?= ucfirst($w->status_hunian); ?> • <?= ucfirst($w->status_penghuni); ?></div>
                </div>
                <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                    <a href="<?= site_url('iuran/bayar?warga_id=' . $w->id_warga . '&tahun=' . $tahun); ?>" class="btn btn-sm btn-primary rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                        <i class="bi bi-plus me-1"></i> Bayar
                    </a>
                <?php endif; ?>
            </div>

            <!-- 12 Months Grid Chips -->
            <?php if ($w->status_hunian === 'kosong'): ?>
                <div class="p-2 bg-light text-muted small rounded text-center">
                    <i class="bi bi-house-x me-1"></i> Rumah Kosong (Tidak ada kewajiban iuran)
                </div>
            <?php else: ?>
                <div class="row g-1 text-center mt-2">
                    <?php 
                    $bln_short = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                    for ($b = 1; $b <= 12; $b++): 
                        $item = $row['bulan'][$b];
                    ?>
                    <div class="col-3 col-sm-2">
                        <div class="p-1 rounded <?= $item ? 'bg-success-subtle border border-success-subtle text-success' : 'bg-danger-subtle border border-danger-subtle text-danger'; ?>" style="font-size: 0.68rem; font-weight: 600;">
                            <div><?= $bln_short[$b]; ?></div>
                            <div style="font-size: 0.6rem;"><?= $item ? '✓ Lunas' : '✕ Belum'; ?></div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ==============================================
     DESKTOP TABLE VIEW (>= 768px)
     ============================================== -->
<div class="d-none d-md-block">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Matriks Rekap Iuran Warga</h4>
            <p class="text-secondary small mb-0">Status kepatuhan pembayaran iuran 12 bulan untuk seluruh warga.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form method="GET" action="<?= site_url('iuran'); ?>" class="d-flex align-items-center gap-2">
                <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                        <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>>Tahun <?= $y; ?></option>
                    <?php endfor; ?>
                </select>
            </form>

            <a href="<?= site_url('iuran/riwayat?tahun=' . $tahun); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-clock-history me-1"></i> Riwayat
            </a>

            <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                <a href="<?= site_url('iuran/bayar?tahun=' . $tahun); ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Input Pembayaran
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card card-custom p-4">
        <!-- Legend Status -->
        <div class="d-flex align-items-center gap-3 mb-3 small text-muted">
            <span class="fw-semibold text-dark">Keterangan:</span>
            <span class="d-inline-flex align-items-center gap-1">
                <span class="badge-matrix lunas">Lunas</span> Sudah Terbayar
            </span>
            <span class="d-inline-flex align-items-center gap-1">
                <span class="badge-matrix belum">Belum</span> Menunggak / Belum Bayar
            </span>
            <span class="d-inline-flex align-items-center gap-1">
                <span class="badge bg-light text-muted border">Kosong</span> Rumah Kosong
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center mb-0" style="font-size: 0.82rem;">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="min-width: 80px;">Blok</th>
                        <th class="text-start" style="min-width: 140px;">Nama Warga</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>Mei</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Agu</th>
                        <th>Sep</th>
                        <th>Okt</th>
                        <th>Nov</th>
                        <th>Des</th>
                        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                            <th style="min-width: 70px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matriks as $row): $w = $row['warga']; ?>
                    <tr>
                        <td class="text-start fw-semibold"><?= html_escape($w->no_blok); ?></td>
                        <td class="text-start">
                            <div class="fw-medium text-dark"><?= html_escape($w->nama_lengkap); ?></div>
                            <div class="text-muted" style="font-size: 0.72rem;">
                                <?= $w->status_hunian === 'kosong' ? 'Rumah Kosong' : ucfirst($w->status_penghuni); ?>
                            </div>
                        </td>
                        <?php for ($b = 1; $b <= 12; $b++): $item = $row['bulan'][$b]; ?>
                            <td>
                                <?php if ($w->status_hunian === 'kosong'): ?>
                                    <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">-</span>
                                <?php elseif ($item): ?>
                                    <span class="badge-matrix lunas" title="Lunas Rp <?= number_format($item->nominal, 0, ',', '.'); ?> pada <?= date('d/m/Y', strtotime($item->tgl_bayar)); ?>">
                                        Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge-matrix belum">
                                        Belum
                                    </span>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>

                        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                        <td>
                            <a href="<?= site_url('iuran/bayar?warga_id=' . $w->id_warga . '&tahun=' . $tahun); ?>" class="btn btn-sm btn-outline-primary py-1 px-2" title="Bayar Iuran">
                                <i class="bi bi-wallet2"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
