<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Sidebar Navigation -->
<aside class="main-sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-wallet2 text-info"></i> Keuangan Komplek
    </div>

    <div class="nav-section-title">Menu Utama</div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="<?= site_url('dashboard'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'dashboard' || empty($this->uri->segment(1))) ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="<?= site_url('warga'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'warga') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill"></i>
                <span>Data Warga & Rumah</span>
            </a>
        </li>
    </ul>

    <div class="nav-section-title">Modul Kas & Iuran</div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="<?= site_url('iuran'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'iuran') ? 'active' : ''; ?>">
                <i class="bi bi-cash-stack"></i>
                <span><?= ($current_user['role_name'] === 'warga') ? 'Iuran Saya' : 'Iuran Warga'; ?></span>
            </a>
        </li>

        <?php if ($current_user['role_name'] === 'admin' || $current_user['role_name'] === 'pengurus'): ?>
        <li class="sidebar-item">
            <a href="<?= site_url('pengeluaran'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'pengeluaran') ? 'active' : ''; ?>">
                <i class="bi bi-arrow-down-circle-fill"></i>
                <span>Pengeluaran Kas</span>
            </a>
        </li>
        <?php endif; ?>

        <li class="sidebar-item">
            <a href="<?= site_url('laporan'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'laporan') ? 'active' : ''; ?>">
                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                <span>Laporan Kas</span>
            </a>
        </li>
    </ul>

    <?php if ($current_user['role_name'] === 'admin'): ?>
    <div class="nav-section-title">Sistem & Pengaturan</div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="<?= site_url('users'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'users') ? 'active' : ''; ?>">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Management User</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= site_url('system_master'); ?>" class="sidebar-link <?= ($this->uri->segment(1) == 'system_master') ? 'active' : ''; ?>">
                <i class="bi bi-cpu-fill"></i>
                <span>System Master</span>
            </a>
        </li>
    </ul>
    <?php endif; ?>

    <div class="mt-auto p-3">
        <div class="p-2 rounded bg-black bg-opacity-25 small text-center text-secondary">
            SIM-Komplek v1.0<br>
            <span class="text-white-50">Tahun Buku <?= date('Y'); ?></span>
        </div>
    </div>
</aside>

<!-- Main Content Container -->
<main class="main-content">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show small d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div><?= html_escape($this->session->flashdata('success')); ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show small d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div><?= html_escape($this->session->flashdata('error')); ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Peringatan Password Default Akun Warga -->
    <?php if ($this->session->userdata('is_default_password') && $current_user['role_name'] === 'warga'): ?>
        <div class="alert alert-warning border-warning alert-dismissible fade show p-3 mb-4 rounded-3 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-shield-exclamation fs-3 text-warning flex-shrink-0"></i>
                <div>
                    <strong class="text-dark">Keamanan Akun: Anda masih menggunakan password default!</strong>
                    <div class="small text-muted">Demi keamanan privasi data dan transparansi komplek, silakan ganti password default Anda.</div>
                </div>
            </div>
            <button type="button" class="btn btn-warning btn-sm fw-semibold text-dark text-nowrap" data-bs-toggle="modal" data-bs-target="#modalChangePasswordDefault">
                <i class="bi bi-key-fill me-1"></i> Ganti Password Sekarang
            </button>
        </div>
    <?php endif; ?>
