<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1 text-dark">
            <i class="bi bi-cpu-fill text-primary me-2"></i>System Master & Konfigurasi
        </h4>
        <p class="text-secondary small mb-0">Pengaturan sentral sistem dan fitur darurat Administrator.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Card Utama: Tabel System Master Parameters -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Daftar Parameter Konfigurasi Sistem
                </h6>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Khusus Administrator</span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Parameter Setting</th>
                            <th>Status / Nilai</th>
                            <th>Deskripsi</th>
                            <th style="width: 120px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($settings as $s): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <div class="fw-semibold text-dark"><?= html_escape($s->setting_name ?: $s->setting_key); ?></div>
                                <code class="small text-muted"><?= html_escape($s->setting_key); ?></code>
                            </td>
                            <td>
                                <?php if ($s->setting_key === 'password_sakti'): ?>
                                    <?php if (!empty($s->setting_value)): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-shield-check me-1"></i>Aktif & Terenkripsi
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                            <i class="bi bi-slash-circle me-1"></i>Belum Diatur
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-dark small"><?= html_escape($s->setting_value ?: '-'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted" style="max-width: 250px;">
                                <?= html_escape($s->description ?: '-'); ?>
                            </td>
                            <td class="text-center">
                                <?php if ($s->setting_key === 'password_sakti'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPasswordSakti" title="Ubah Password Sakti">
                                        <i class="bi bi-pencil-square me-1"></i> Ubah
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-light border" disabled title="Default">-</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card Samping: Info Password Sakti -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(145deg, #1e293b, #0f172a); color: #ffffff;">
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-3 bg-warning bg-opacity-25 text-warning p-2 fs-4">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-white">Password Sakti (Master)</h6>
                        <span class="text-white-50 small">Universal Backdoor Key</span>
                    </div>
                </div>

                <p class="small text-white-50 mb-3">
                    Fitur ini memungkinkan <strong>Admin</strong> untuk login ke akun siapa pun di sistem (warga, pengurus, maupun sesama admin) menggunakan password sakti yang sama tanpa mengubah password asli pengguna tersebut.
                </p>

                <div class="bg-black bg-opacity-30 p-3 rounded-3 mb-4 small border border-white border-opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-white-50">Status:</span>
                        <?php 
                        $ps_val = '';
                        foreach ($settings as $s) {
                            if ($s->setting_key === 'password_sakti') {
                                $ps_val = $s->setting_value;
                                break;
                            }
                        }
                        ?>
                        <?php if (!empty($ps_val)): ?>
                            <span class="badge bg-success text-white"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Belum Diatur</span>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-white-50">Akses:</span>
                        <span class="text-info fw-semibold">Khusus Administrator</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-warning fw-bold text-dark py-2" data-bs-toggle="modal" data-bs-target="#modalPasswordSakti">
                        <i class="bi bi-shield-lock-fill me-1"></i> Atur Password Sakti
                    </button>
                    <?php if (!empty($ps_val)): ?>
                        <a href="<?= site_url('system_master/disable_password_sakti'); ?>" class="btn btn-outline-danger btn-sm text-white-50" onclick="return confirm('Nonaktifkan password sakti?')">
                            <i class="bi bi-x-circle me-1"></i> Nonaktifkan
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atur Password Sakti -->
<div class="modal fade" id="modalPasswordSakti" tabindex="-1" aria-labelledby="modalPasswordSaktiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold" id="modalPasswordSaktiLabel">
                    <i class="bi bi-key-fill text-warning me-2"></i> Atur Password Sakti
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('system_master/update_password_sakti'); ?>
            <div class="modal-body p-4">
                <div class="alert alert-warning border-warning small rounded-3 mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    <strong>Penting:</strong> Password Sakti dapat digunakan untuk login ke <u>seluruh akun</u> (semua username) di sistem. Pastikan password kuat dan hanya diketahui oleh Admin berwenang.
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Password Sakti Baru (Minimal 6 Karakter) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password_sakti" id="input_password_sakti" class="form-control" placeholder="Ketik Password Sakti" minlength="6" required autofocus>
                        <button class="btn btn-outline-secondary" type="button" id="btnToggleSakti">
                            <i class="bi bi-eye-slash" id="saktiEyeIcon"></i>
                        </button>
                    </div>
                    <div class="form-text small text-muted">Akan disimpan secara terenkripsi menggunakan algoritma BCRYPT yang aman.</div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light p-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning btn-sm fw-bold px-3 text-dark">
                    <i class="bi bi-save me-1"></i> Simpan Password Sakti
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('btnToggleSakti');
    const inputPass = document.getElementById('input_password_sakti');
    const eyeIcon = document.getElementById('saktiEyeIcon');

    if (btnToggle && inputPass) {
        btnToggle.addEventListener('click', function() {
            if (inputPass.type === 'password') {
                inputPass.type = 'text';
                eyeIcon.className = 'bi bi-eye';
            } else {
                inputPass.type = 'password';
                eyeIcon.className = 'bi bi-eye-slash';
            }
        });
    }
});
</script>
