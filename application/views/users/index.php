<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ==============================================
     MOBILE LIST VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Manajemen User</h5>
            <div class="text-muted small">Total <?= count($users); ?> Pengguna</div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <?php if (!empty($total_tanpa_user) && $total_tanpa_user > 0): ?>
                <a href="<?= site_url('warga/generate_all_users'); ?>" class="btn btn-outline-success btn-sm rounded-pill px-2 py-1" style="font-size: 0.75rem;" onclick="return confirm('Buatkan akun login otomatis untuk SEMUA (<?= $total_tanpa_user; ?>) warga yang belum memiliki user? Password default: WargaBaik1!')" title="Buat User Semua Warga">
                    <i class="bi bi-people-fill me-1"></i> +Warga (<?= $total_tanpa_user; ?>)
                </a>
            <?php endif; ?>
            <a href="<?= site_url('users/create'); ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="bi bi-plus me-1"></i> User
            </a>
        </div>
    </div>

    <!-- Mobile User Cards -->
    <div class="mb-4">
        <?php foreach ($users as $u): ?>
        <div class="mobile-tile-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.9rem;">
                        <?= strtoupper(substr($u->username, 0, 1)); ?>
                    </div>
                    <div>
                        <div class="fw-bold text-dark lh-1"><?= html_escape($u->username); ?></div>
                        <span class="text-muted" style="font-size: 0.72rem;">#<?= $u->id_user; ?> &bull; <?= date('d/m/Y', strtotime($u->created_at)); ?></span>
                    </div>
                </div>

                <?php 
                $badge_class = 'bg-secondary';
                if ($u->role_name === 'admin') $badge_class = 'bg-dark';
                elseif ($u->role_name === 'pengurus') $badge_class = 'bg-primary';
                elseif ($u->role_name === 'warga') $badge_class = 'bg-success';
                ?>
                <span class="badge <?= $badge_class; ?> text-uppercase" style="font-size: 0.68rem;">
                    <?= html_escape($u->role_name); ?>
                </span>
            </div>

            <div class="bg-light p-2 rounded mb-2 d-flex justify-content-between align-items-center" style="font-size: 0.8rem;">
                <div>
                    <span class="text-secondary">Warga: </span>
                    <?php if ($u->nama_warga): ?>
                        <strong class="text-dark"><?= html_escape($u->nama_warga); ?> (<?= html_escape($u->no_blok); ?>)</strong>
                    <?php else: ?>
                        <span class="text-muted">Akun Sistem</span>
                    <?php endif; ?>
                </div>

                <div>
                    <?php if ($u->is_active == 1): ?>
                        <a href="<?= site_url('users/toggle_status/' . $u->id_user); ?>" class="badge bg-success-subtle text-success text-decoration-none">
                            <i class="bi bi-check-circle me-1"></i> Aktif
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('users/toggle_status/' . $u->id_user); ?>" class="badge bg-danger-subtle text-danger text-decoration-none">
                            <i class="bi bi-x-circle me-1"></i> Nonaktif
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                <?php $default_pass_txt = ($u->role_name === 'warga') ? 'WargaBaik1!' : 'password123'; ?>
                <a href="<?= site_url('users/reset_password/' . $u->id_user); ?>" class="btn btn-outline-warning btn-sm py-1 px-3 rounded-pill" onclick="return confirm('Reset password akun <?= html_escape($u->username); ?> menjadi <?= $default_pass_txt; ?>?')" style="font-size: 0.75rem;">
                    <i class="bi bi-key me-1"></i> Reset Password
                </a>
                <?php if ($u->id_user != $current_user['id_user']): ?>
                    <a href="<?= site_url('users/delete/' . $u->id_user); ?>" class="btn btn-outline-danger btn-sm py-1 px-2 rounded-pill" onclick="return confirm('Yakin hapus akun user ini?')" style="font-size: 0.75rem;">
                        <i class="bi bi-trash"></i>
                    </a>
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
            <h4 class="fw-bold mb-1 text-dark">Management User & Role</h4>
            <p class="text-secondary small mb-0">Kelola akun akses sistem, hak peran (RBAC), serta reset password pengguna.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if (!empty($total_tanpa_user) && $total_tanpa_user > 0): ?>
                <a href="<?= site_url('warga/generate_all_users'); ?>" class="btn btn-outline-success btn-sm" onclick="return confirm('Buatkan akun login otomatis untuk SEMUA (<?= $total_tanpa_user; ?>) warga yang belum memiliki akun login? Password default: WargaBaik1!')">
                    <i class="bi bi-people-fill me-1"></i> Buat User Semua Warga (<?= $total_tanpa_user; ?>)
                </a>
            <?php endif; ?>
            <a href="<?= site_url('users/create'); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle datatable">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Nama Terkait (Warga)</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="text-muted small">#<?= $u->id_user; ?></td>
                        <td class="fw-semibold text-dark">
                            <i class="bi bi-person-circle text-secondary me-1"></i>
                            <?= html_escape($u->username); ?>
                        </td>
                        <td>
                            <?php 
                            $badge_class = 'bg-secondary';
                            if ($u->role_name === 'admin') $badge_class = 'bg-dark';
                            elseif ($u->role_name === 'pengurus') $badge_class = 'bg-primary';
                            elseif ($u->role_name === 'warga') $badge_class = 'bg-success';
                            ?>
                            <span class="badge <?= $badge_class; ?> text-uppercase" style="font-size: 0.7rem;">
                                <?= html_escape($u->role_name); ?>
                            </span>
                        </td>
                        <td class="small">
                            <?php if ($u->nama_warga): ?>
                                <span class="text-dark fw-medium"><?= html_escape($u->nama_warga); ?></span>
                                <span class="badge bg-light text-secondary border ms-1"><?= html_escape($u->no_blok); ?></span>
                            <?php else: ?>
                                <span class="text-muted">- (Akun Sistem)</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u->is_active == 1): ?>
                                <a href="<?= site_url('users/toggle_status/' . $u->id_user); ?>" class="badge bg-success-subtle text-success text-decoration-none" title="Klik untuk nonaktifkan">
                                    <i class="bi bi-check-circle me-1"></i> Aktif
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('users/toggle_status/' . $u->id_user); ?>" class="badge bg-danger-subtle text-danger text-decoration-none" title="Klik untuk aktifkan">
                                    <i class="bi bi-x-circle me-1"></i> Nonaktif
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= date('d/m/Y', strtotime($u->created_at)); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <?php $default_pass_txt = ($u->role_name === 'warga') ? 'WargaBaik1!' : 'password123'; ?>
                                <a href="<?= site_url('users/reset_password/' . $u->id_user); ?>" class="btn btn-outline-warning" onclick="return confirm('Reset password akun <?= html_escape($u->username); ?> menjadi <?= $default_pass_txt; ?>?')" title="Reset Password ke default (<?= $default_pass_txt; ?>)">
                                    <i class="bi bi-key"></i> Reset
                                </a>
                                <?php if ($u->id_user != $current_user['id_user']): ?>
                                    <a href="<?= site_url('users/delete/' . $u->id_user); ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus akun user ini?')" title="Hapus User">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
