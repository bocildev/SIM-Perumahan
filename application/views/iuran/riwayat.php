<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1 text-dark">Riwayat Pembayaran Iuran</h4>
        <p class="text-secondary small mb-0">Log seluruh transaksi pembayaran iuran yang tercatat di sistem.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="<?= site_url('iuran'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-grid me-1"></i> Lihat Matriks
        </a>
        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
            <a href="<?= site_url('iuran/bayar'); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Input Pembayaran
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle datatable">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Tgl Bayar</th>
                    <th>Blok</th>
                    <th>Nama Warga</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Bukti</th>
                    <th>Keterangan</th>
                    <?php if ($current_user['role_name'] === 'admin'): ?>
                        <th style="width: 70px;">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                $bulan_names = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                $no = 1; 
                foreach ($riwayat as $r): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td class="small"><?= date('d/m/Y', strtotime($r->tgl_bayar)); ?></td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                            <?= html_escape($r->no_blok); ?>
                        </span>
                    </td>
                    <td class="fw-semibold text-dark"><?= html_escape($r->nama_lengkap); ?></td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            <?= $bulan_names[$r->bulan] ?? $r->bulan; ?> <?= $r->tahun; ?>
                        </span>
                    </td>
                    <td class="fw-bold text-success">
                        Rp <?= number_format($r->nominal, 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php if ($r->bukti_bayar): ?>
                            <a href="<?= base_url('uploads/bukti_bayar/' . $r->bukti_bayar); ?>" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2" title="Lihat Bukti">
                                <i class="bi bi-file-earmark-image"></i> Bukti
                            </a>
                        <?php else: ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="small text-muted"><?= html_escape($r->keterangan ?? '-'); ?></td>
                    <?php if ($current_user['role_name'] === 'admin'): ?>
                    <td>
                        <a href="<?= site_url('iuran/delete/' . $r->id_pemasukan); ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Hapus transaksi pembayaran ini?')" title="Hapus">
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
