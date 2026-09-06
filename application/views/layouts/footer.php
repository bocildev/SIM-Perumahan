</main>
</div> <!-- End app-wrapper -->

<!-- Mobile Bottom Navigation Bar (Fixed on Mobile Screens) -->
<nav class="mobile-bottom-nav">
    <a href="<?= site_url('dashboard'); ?>" class="bottom-nav-item <?= ($this->uri->segment(1) == 'dashboard' || empty($this->uri->segment(1))) ? 'active' : ''; ?>">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Beranda</span>
    </a>

    <a href="<?= site_url('warga'); ?>" class="bottom-nav-item <?= ($this->uri->segment(1) == 'warga') ? 'active' : ''; ?>">
        <i class="bi bi-people-fill"></i>
        <span>Warga</span>
    </a>

    <a href="<?= site_url('iuran'); ?>" class="bottom-nav-item <?= ($this->uri->segment(1) == 'iuran') ? 'active' : ''; ?>">
        <i class="bi bi-cash-stack"></i>
        <span>Iuran</span>
    </a>

    <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
    <a href="<?= site_url('pengeluaran'); ?>" class="bottom-nav-item <?= ($this->uri->segment(1) == 'pengeluaran') ? 'active' : ''; ?>">
        <i class="bi bi-arrow-down-circle-fill"></i>
        <span>Keluar</span>
    </a>
    <?php else: ?>
    <a href="<?= site_url('laporan'); ?>" class="bottom-nav-item <?= ($this->uri->segment(1) == 'laporan') ? 'active' : ''; ?>">
        <i class="bi bi-file-earmark-bar-graph-fill"></i>
        <span>Laporan</span>
    </a>
    <?php endif; ?>

    <a href="javascript:void(0)" class="bottom-nav-item" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas">
        <i class="bi bi-person-circle"></i>
        <span>Menu</span>
    </a>
</nav>

<!-- Mobile Menu Offcanvas Drawer (Bottom Sheet) -->
<div class="offcanvas offcanvas-bottom rounded-top-4 border-0 shadow-lg" tabindex="-1" id="mobileMenuOffcanvas" style="height: auto; max-height: 85vh; background: #ffffff;">
    <div class="offcanvas-header pb-2 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <div class="mobile-avatar" style="width: 44px; height: 44px; font-size: 1.1rem;">
                <?= strtoupper(substr($current_user['nama_warga'], 0, 1)); ?>
            </div>
            <div>
                <h6 class="offcanvas-title fw-bold text-dark mb-0"><?= html_escape($current_user['nama_warga']); ?></h6>
                <div class="small text-muted">Role: <span class="badge bg-secondary-subtle text-secondary text-uppercase" style="font-size: 0.65rem;"><?= html_escape($current_user['role_name']); ?></span></div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-3 pb-4">
        <div class="list-group list-group-flush rounded-3 border">
            <a href="<?= site_url('dashboard'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-grid-1x2 text-primary fs-5"></i>
                <span class="fw-medium">Dashboard Utama</span>
            </a>
            <a href="<?= site_url('warga'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-people text-info fs-5"></i>
                <span class="fw-medium">Data Warga & Rumah</span>
            </a>
            <a href="<?= site_url('iuran'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-cash-stack text-success fs-5"></i>
                <span class="fw-medium">Matriks Iuran Warga</span>
            </a>
            <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
            <a href="<?= site_url('pengeluaran'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-arrow-down-circle text-danger fs-5"></i>
                <span class="fw-medium">Pengeluaran Kas</span>
            </a>
            <?php endif; ?>
            <a href="<?= site_url('laporan'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-file-earmark-bar-graph text-warning fs-5"></i>
                <span class="fw-medium">Laporan Arus Kas</span>
            </a>
            <?php if ($current_user['role_name'] === 'admin'): ?>
            <a href="<?= site_url('users'); ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                <i class="bi bi-shield-lock text-dark fs-5"></i>
                <span class="fw-medium">Management User & Role</span>
            </a>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger w-100 py-2 fw-semibold rounded-3 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
            </a>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable default
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            language: {
                search: "Cari data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang cocok",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "&raquo;",
                    previous: "&laquo;"
                }
            },
            pageLength: 10,
            responsive: true
        });
    }
});
</script>
</body>
</html>
