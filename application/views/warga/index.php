<!-- ==============================================
     MOBILE LIST VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Data Warga & Rumah</h5>
            <div class="text-muted small">Total <?= count($warga_list); ?> Hunian</div>
        </div>
        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
            <a href="<?= site_url('warga/create'); ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-plus me-1"></i> Tambah
            </a>
        <?php endif; ?>
    </div>

    <!-- Mobile Cards List -->
    <div class="mb-4">
        <?php foreach ($warga_list as $w): ?>
        <div class="mobile-tile-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2 py-1">
                        <?= html_escape($w->no_blok); ?>
                    </span>
                    <span class="badge <?= $w->status_hunian === 'dihuni' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>" style="font-size: 0.68rem;">
                        <?= ucfirst($w->status_hunian); ?>
                    </span>
                </div>
                <span class="badge <?= $w->status_penghuni === 'pemilik' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning'; ?>" style="font-size: 0.68rem;">
                    <?= ucfirst($w->status_penghuni); ?>
                </span>
            </div>

            <h6 class="fw-bold text-dark mb-1"><?= html_escape($w->nama_lengkap); ?></h6>
            <?php if ($w->nik): ?>
                <div class="text-muted small mb-2"><i class="bi bi-card-text me-1"></i> NIK: <?= html_escape($w->nik); ?></div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $w->no_hp); ?>" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 text-decoration-none">
                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                </a>
                
                <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                <div class="btn-group btn-group-sm">
                    <a href="<?= site_url('warga/edit/' . $w->id_warga); ?>" class="btn btn-outline-secondary py-1 px-2" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <?php if ($current_user['role_name'] === 'admin'): ?>
                        <a href="<?= site_url('warga/delete/' . $w->id_warga); ?>" class="btn btn-outline-danger py-1 px-2" onclick="return confirm('Hapus data warga ini?')" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
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
            <h4 class="fw-bold mb-1 text-dark">Data Warga & Rumah</h4>
            <p class="text-secondary small mb-0">Daftar seluruh warga perumahan, nomor blok, serta status kepemilikan.</p>
        </div>
        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
            <a href="<?= site_url('warga/create'); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus me-1"></i> Tambah Warga
            </a>
        <?php endif; ?>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle datatable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nomor Blok</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>No. WhatsApp</th>
                        <th>Status Hunian</th>
                        <th>Status Penghuni</th>
                        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                            <th style="width: 100px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($warga_list as $w): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                                <?= html_escape($w->no_blok); ?>
                            </span>
                        </td>
                        <td class="fw-semibold text-dark"><?= html_escape($w->nama_lengkap); ?></td>
                        <td class="text-muted small"><?= html_escape($w->nik ?? '-'); ?></td>
                        <td>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $w->no_hp); ?>" target="_blank" class="text-success text-decoration-none small">
                                <i class="bi bi-whatsapp me-1"></i><?= html_escape($w->no_hp); ?>
                            </a>
                        </td>
                        <td>
                            <?php if ($w->status_hunian === 'dihuni'): ?>
                                <span class="badge bg-success-subtle text-success">Dihuni</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary">Kosong</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $w->status_penghuni === 'pemilik' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning'; ?>">
                                <?= ucfirst($w->status_penghuni); ?>
                            </span>
                        </td>
                        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= site_url('warga/edit/' . $w->id_warga); ?>" class="btn btn-outline-secondary" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <?php if ($current_user['role_name'] === 'admin'): ?>
                                    <a href="<?= site_url('warga/delete/' . $w->id_warga); ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data warga ini? Data iuran terkait juga akan terhapus.')" title="Hapus Data">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
