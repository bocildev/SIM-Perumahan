<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="mb-4">
    <a href="<?= site_url('users'); ?>" class="btn btn-outline-secondary btn-sm mb-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data User
    </a>
    <h4 class="fw-bold text-dark">Tambah Pengguna Baru</h4>
</div>

<div class="card card-custom p-4" style="max-width: 640px;">
    <?= form_open('users/create'); ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Misal: budi_blok_a" value="<?= set_value('username'); ?>" required autofocus>
                <?= form_error('username', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Role Akses <span class="text-danger">*</span></label>
                <select name="id_role" id="select_role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r->id_role; ?>" data-role="<?= strtolower($r->role_name); ?>" <?= set_select('id_role', $r->id_role); ?>>
                            <?= strtoupper($r->role_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('id_role', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-semibold text-secondary">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" name="password" id="input_password" class="form-control" placeholder="Minimal 6 karakter" value="<?= set_value('password'); ?>" required>
                    <button class="btn btn-outline-secondary" type="button" id="btnTogglePass" title="Tampilkan/Sembunyikan Password">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
                <?= form_error('password', '<div class="text-danger small mt-1">', '</div>'); ?>
                
                <div class="mt-2 d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success py-1 px-2 d-inline-flex align-items-center gap-1" id="btnDefaultWarga" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-check"></i> Set Default Warga (<code>WargaBaik1!</code>)
                    </button>
                </div>
                <div class="form-text text-muted small mt-1" id="defaultPassHint" style="display: none;">
                    <i class="bi bi-info-circle text-primary me-1"></i> Warga akan diminta langsung mengganti password secara pop-up setelah login.
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label small fw-semibold text-secondary">Hubungkan ke Data Warga (Opsional)</label>
                <select name="id_warga" class="form-select">
                    <option value="">-- Tidak Terhubung / Admin --</option>
                    <?php foreach ($warga_list as $w): ?>
                        <option value="<?= $w->id_warga; ?>" <?= set_select('id_warga', $w->id_warga); ?>>
                            <?= html_escape($w->no_blok); ?> - <?= html_escape($w->nama_lengkap); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text text-muted small">Pilih data warga jika user ini dibuat untuk warga komplek tertentu.</div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-person-check me-1"></i> Buat User
            </button>
            <a href="<?= site_url('users'); ?>" class="btn btn-light">Batal</a>
        </div>
    <?= form_close(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('select_role');
    const passInput = document.getElementById('input_password');
    const btnDefaultWarga = document.getElementById('btnDefaultWarga');
    const defaultHint = document.getElementById('defaultPassHint');
    const btnToggle = document.getElementById('btnTogglePass');
    const toggleIcon = document.getElementById('toggleIcon');

    function applyWargaDefault() {
        passInput.value = 'WargaBaik1!';
        passInput.type = 'text';
        toggleIcon.className = 'bi bi-eye';
        defaultHint.style.display = 'block';
    }

    if (btnDefaultWarga) {
        btnDefaultWarga.addEventListener('click', applyWargaDefault);
    }

    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            const selectedOpt = roleSelect.options[roleSelect.selectedIndex];
            const roleName = selectedOpt ? selectedOpt.getAttribute('data-role') : '';
            if (roleName === 'warga') {
                if (!passInput.value) {
                    applyWargaDefault();
                } else {
                    defaultHint.style.display = 'block';
                }
            } else {
                defaultHint.style.display = 'none';
            }
        });
    }

    if (btnToggle && passInput) {
        btnToggle.addEventListener('click', function() {
            if (passInput.type === 'password') {
                passInput.type = 'text';
                toggleIcon.className = 'bi bi-eye';
            } else {
                passInput.type = 'password';
                toggleIcon.className = 'bi bi-eye-slash';
            }
        });
    }
});
</script>
