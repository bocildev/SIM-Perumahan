<!-- ==============================================
     MOBILE LIST VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Pengeluaran Kas</h5>
            <div class="text-danger small fw-bold">Total: Rp <?= number_format($total_nominal, 0, ',', '.'); ?></div>
        </div>
        <div class="d-flex gap-1">
            <button class="btn btn-outline-secondary btn-sm rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalKategori" style="font-size: 0.75rem;">
                <i class="bi bi-tag"></i> Kategori
            </button>
            <a href="<?= site_url('pengeluaran/create'); ?>" class="btn btn-danger btn-sm rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                <i class="bi bi-plus"></i> Catat
            </a>
        </div>
    </div>

    <!-- Mobile Expenses Cards -->
    <div class="mb-4">
        <?php foreach ($pengeluaran_list as $p): ?>
        <div class="mobile-tile-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-secondary-subtle text-secondary border" style="font-size: 0.68rem;">
                    <?= html_escape($p->nama_kategori); ?>
                </span>
                <span class="text-muted small" style="font-size: 0.72rem;">
                    <?= date('d/m/Y', strtotime($p->tgl_pengeluaran)); ?>
                </span>
            </div>

            <div class="fw-bold text-danger fs-5 mb-1">
                - Rp <?= number_format($p->nominal, 0, ',', '.'); ?>
            </div>

            <p class="small text-secondary mb-2 lh-sm">
                <?= html_escape($p->keterangan); ?>
            </p>

            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <div>
                    <?php if ($p->bukti_nota): ?>
                        <a href="<?= base_url('uploads/nota/' . $p->bukti_nota); ?>" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                            <i class="bi bi-receipt me-1"></i> Nota
                        </a>
                    <?php else: ?>
                        <span class="text-muted small" style="font-size: 0.72rem;">Tanpa Nota</span>
                    <?php endif; ?>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted" style="font-size: 0.7rem;">Oleh: <?= html_escape($p->pencatat ?? '-'); ?></span>
                    <?php if ($current_user['role_name'] === 'admin'): ?>
                        <a href="<?= site_url('pengeluaran/delete/' . $p->id_pengeluaran); ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Hapus pengeluaran ini?')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
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
            <h4 class="fw-bold mb-1 text-dark">Pengeluaran Kas Operasional</h4>
            <p class="text-secondary small mb-0">Catatan biaya operasional komplek (Gaji Satpam, Listrik, Sampah, Internet, dll).</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalKategori">
                <i class="bi bi-tag me-1"></i> Tambah Kategori
            </button>
            <a href="<?= site_url('pengeluaran/create'); ?>" class="btn btn-danger btn-sm">
                <i class="bi bi-dash-circle me-1"></i> Catat Pengeluaran
            </a>
        </div>
    </div>

    <!-- Filter Box -->
    <div class="card card-custom p-3 mb-4">
        <form method="GET" action="<?= site_url('pengeluaran'); ?>" class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="small text-muted mb-1">Filter Kategori</label>
                <select name="id_kategori" class="form-select form-select-sm">
                    <option value="">-- Semua Kategori --</option>
                    <?php foreach ($kategori_list as $k): ?>
                        <option value="<?= $k->id_kategori; ?>" <?= ($filter['id_kategori'] == $k->id_kategori) ? 'selected' : ''; ?>>
                            <?= html_escape($k->nama_kategori); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-1">Dari Tanggal</label>
                <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="<?= html_escape($filter['tgl_mulai'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-1">Sampai Tanggal</label>
                <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="<?= html_escape($filter['tgl_selesai'] ?? ''); ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-fill">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="<?= site_url('pengeluaran'); ?>" class="btn btn-sm btn-light">Reset</a>
            </div>
        </form>
    </div>

    <!-- Total Summary Header -->
    <div class="alert alert-light border d-flex justify-content-between align-items-center py-2 px-3 mb-4">
        <span class="small text-secondary">Total Pengeluaran Sesuai Filter:</span>
        <span class="fs-5 fw-bold text-danger">Rp <?= number_format($total_nominal, 0, ',', '.'); ?></span>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle datatable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Nota / Struk</th>
                        <th>Pencatat</th>
                        <?php if ($current_user['role_name'] === 'admin'): ?>
                            <th style="width: 60px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pengeluaran_list as $p): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="small"><?= date('d/m/Y', strtotime($p->tgl_pengeluaran)); ?></td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border">
                                <?= html_escape($p->nama_kategori); ?>
                            </span>
                        </td>
                        <td class="fw-bold text-danger">
                            Rp <?= number_format($p->nominal, 0, ',', '.'); ?>
                        </td>
                        <td class="small text-dark" style="max-width: 250px;">
                            <?= html_escape($p->keterangan); ?>
                        </td>
                        <td>
                            <?php if ($p->bukti_nota): ?>
                                <a href="<?= base_url('uploads/nota/' . $p->bukti_nota); ?>" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2">
                                    <i class="bi bi-receipt"></i> Nota
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= html_escape($p->pencatat ?? '-'); ?></td>
                        <?php if ($current_user['role_name'] === 'admin'): ?>
                        <td>
                            <a href="<?= site_url('pengeluaran/delete/' . $p->id_pengeluaran); ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Hapus catatan pengeluaran ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
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

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Kategori Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('pengeluaran/kategori'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Kategori Baru</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Misal: Perbaikan Pompa Air" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
