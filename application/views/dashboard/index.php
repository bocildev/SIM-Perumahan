<!-- ==============================================
     MOBILE NATIVE VIEW (< 768px)
     ============================================== -->
<div class="d-md-none">
    <!-- Master Fintech Wallet Card -->
    <div class="wallet-master-card">
        <div class="wallet-header">
            <span class="wallet-label">
                <i class="bi bi-wallet2 text-info"></i> Saldo Kas Komplek
            </span>
            <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-2 py-1" style="font-size: 0.68rem;">
                <?= date('M Y'); ?>
            </span>
        </div>

        <div class="wallet-balance">
            Rp <?= number_format($saldo_kas, 0, ',', '.'); ?>
        </div>

        <div class="wallet-stats-row">
            <div class="stat-pill">
                <div class="stat-pill-icon bg-success bg-opacity-25 text-success">
                    <i class="bi bi-arrow-down-left"></i>
                </div>
                <div>
                    <div class="text-white-50" style="font-size: 0.62rem; text-transform: uppercase;">Masuk (Bulan Ini)</div>
                    <div class="fw-bold text-success small">Rp <?= number_format($in_bulan_ini, 0, ',', '.'); ?></div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="stat-pill-icon bg-danger bg-opacity-25 text-danger">
                    <i class="bi bi-arrow-up-right"></i>
                </div>
                <div>
                    <div class="text-white-50" style="font-size: 0.62rem; text-transform: uppercase;">Keluar (Bulan Ini)</div>
                    <div class="fw-bold text-danger small">Rp <?= number_format($out_bulan_ini, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Circle Grid (Gojek / E-Wallet Style) -->
    <div class="quick-actions-card">
        <div class="quick-action-grid">
            <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
            <a href="<?= site_url('iuran/bayar'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-success text-white">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <span class="quick-action-label">Bayar Iuran</span>
            </a>
            <a href="<?= site_url('pengeluaran/create'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-danger text-white">
                    <i class="bi bi-dash-circle-fill"></i>
                </div>
                <span class="quick-action-label">Catat Beban</span>
            </a>
            <?php else: ?>
            <a href="<?= site_url('iuran/riwayat'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-success text-white">
                    <i class="bi bi-receipt"></i>
                </div>
                <span class="quick-action-label">Iuran Saya</span>
            </a>
            <a href="<?= site_url('warga'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-info text-white">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="quick-action-label">Warga</span>
            </a>
            <?php endif; ?>

            <a href="<?= site_url('iuran'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-primary text-white">
                    <i class="bi bi-table"></i>
                </div>
                <span class="quick-action-label">Matriks</span>
            </a>

            <a href="<?= site_url('laporan'); ?>" class="quick-action-item">
                <div class="quick-action-circle bg-warning text-white">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                </div>
                <span class="quick-action-label">Laporan</span>
            </a>
        </div>
    </div>

    <!-- Mobile Quick Status Warga Tile List -->
    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
        <h6 class="fw-bold mb-0 text-dark">Status Iuran Bulan Ini</h6>
        <a href="<?= site_url('iuran'); ?>" class="text-primary small text-decoration-none fw-semibold">Lihat Semua &raquo;</a>
    </div>

    <div class="mb-4">
        <?php foreach ($quick_status as $w): ?>
        <div class="mobile-tile-card d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold small text-primary" style="width: 40px; height: 40px; background: #e0f2fe;">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark small mb-0"><?= html_escape($w->nama_lengkap); ?></div>
                    <div class="text-muted" style="font-size: 0.72rem;"><?= html_escape($w->no_blok); ?> • <?= ucfirst($w->status_hunian); ?></div>
                </div>
            </div>
            <div>
                <?php if ($w->status_hunian === 'kosong'): ?>
                    <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">Kosong</span>
                <?php elseif ($w->nominal !== NULL): ?>
                    <span class="badge-matrix lunas">Lunas</span>
                <?php else: ?>
                    <span class="badge-matrix belum">Belum</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Mobile Chart Card -->
    <div class="card card-custom p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0 text-dark">Grafik Tren Kas (<?= $tahun_ini; ?>)</h6>
            <span class="badge bg-light text-secondary border small">12 Bulan</span>
        </div>
        <div style="position: relative; height: 220px;">
            <canvas id="cashflowChartMobile"></canvas>
        </div>
    </div>
</div>

<!-- ==============================================
     DESKTOP / TABLET VIEW (>= 768px)
     ============================================== -->
<div class="d-none d-md-block">
    <!-- Page Title & Greeting -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Dashboard Keuangan Komplek</h3>
            <p class="text-secondary small mb-0">Ringkasan kondisi kas dan status pembayaran iuran warga perumahan.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-secondary border px-3 py-2">
                <i class="bi bi-calendar3 me-1"></i> <?= date('F Y'); ?>
            </span>
            <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
                <a href="<?= site_url('iuran/bayar'); ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Catat Iuran
                </a>
                <a href="<?= site_url('pengeluaran/create'); ?>" class="btn btn-sm btn-danger">
                    <i class="bi bi-dash-circle me-1"></i> Catat Pengeluaran
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Financial Metric Cards -->
    <div class="row g-3 mb-4">
        <!-- Card Total Kas -->
        <div class="col-md-4">
            <div class="metric-card card-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="metric-title">Total Saldo Kas Real-Time</div>
                    <i class="bi bi-wallet2 fs-3 text-secondary opacity-50"></i>
                </div>
                <div class="metric-amount <?= $saldo_kas < 0 ? 'text-danger' : 'text-primary'; ?>">
                    Rp <?= number_format($saldo_kas, 0, ',', '.'); ?>
                </div>
                <div class="small text-muted mt-2">
                    Akumulasi seluruh pemasukan dikurangi pengeluaran.
                </div>
            </div>
        </div>

        <!-- Card Pemasukan Bulan Ini -->
        <div class="col-md-4">
            <div class="metric-card card-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="metric-title text-success">Pemasukan Bulan Ini</div>
                    <i class="bi bi-arrow-up-circle-fill fs-3 text-success opacity-50"></i>
                </div>
                <div class="metric-amount text-success">
                    Rp <?= number_format($in_bulan_ini, 0, ',', '.'); ?>
                </div>
                <div class="small text-muted mt-2">
                    Total iuran masuk: Rp <?= number_format($total_in, 0, ',', '.'); ?> (Semua Periode)
                </div>
            </div>
        </div>

        <!-- Card Pengeluaran Bulan Ini -->
        <div class="col-md-4">
            <div class="metric-card card-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="metric-title text-danger">Pengeluaran Bulan Ini</div>
                    <i class="bi bi-arrow-down-circle-fill fs-3 text-danger opacity-50"></i>
                </div>
                <div class="metric-amount text-danger">
                    Rp <?= number_format($out_bulan_ini, 0, ',', '.'); ?>
                </div>
                <div class="small text-muted mt-2">
                    Total operasional keluar: Rp <?= number_format($total_out, 0, ',', '.'); ?> (Semua Periode)
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Quick Status Table -->
    <div class="row g-4 mb-4">
        <!-- Chart Tren 12 Bulan -->
        <div class="col-lg-8">
            <div class="card card-custom h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Tren Pemasukan vs Pengeluaran (Tahun <?= $tahun_ini; ?>)</h5>
                    <span class="badge bg-secondary-subtle text-secondary small">12 Bulan</span>
                </div>
                <div style="position: relative; height: 320px;">
                    <canvas id="cashflowChartDesktop"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Status Iuran Warga Bulan Ini -->
        <div class="col-lg-4">
            <div class="card card-custom h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Status Iuran Bulan Ini</h5>
                    <a href="<?= site_url('iuran'); ?>" class="small text-decoration-none">Lihat Semua &raquo;</a>
                </div>
                <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small text-muted">
                                <th>Blok</th>
                                <th>Warga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quick_status as $w): ?>
                            <tr>
                                <td class="fw-semibold small"><?= html_escape($w->no_blok); ?></td>
                                <td class="small text-truncate" style="max-width: 120px;">
                                    <?= html_escape($w->nama_lengkap); ?>
                                </td>
                                <td>
                                    <?php if ($w->status_hunian === 'kosong'): ?>
                                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">Rumah Kosong</span>
                                    <?php elseif ($w->nominal !== NULL): ?>
                                        <span class="badge-matrix lunas">Lunas</span>
                                    <?php else: ?>
                                        <span class="badge-matrix belum">Belum</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    const chartData = <?= json_encode($chart_data); ?>;
    
    function createChart(canvasId, isMobile) {
        const el = document.getElementById(canvasId);
        if (!el) return;
        const ctx = el.getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: chartData.pemasukan,
                        backgroundColor: '#10b981',
                        borderRadius: 4
                    },
                    {
                        label: 'Pengeluaran',
                        data: chartData.pengeluaran,
                        backgroundColor: '#ef4444',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: isMobile ? 10 : 14,
                            font: { size: isMobile ? 11 : 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { font: { size: isMobile ? 9 : 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: isMobile ? 9 : 11 },
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        }
                    }
                }
            }
        });
    }

    createChart('cashflowChartDesktop', false);
    createChart('cashflowChartMobile', true);
});
</script>
