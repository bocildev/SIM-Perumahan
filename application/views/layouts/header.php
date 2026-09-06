<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? html_escape($page_title) . ' - ' : ''; ?>SIM-Komplek</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-navy: #1e293b;
            --primary-hover: #0f172a;
            --secondary-slate: #64748b;
            --accent-success: #10b981;
            --accent-danger: #ef4444;
            --accent-warning: #f59e0b;
            --accent-info: #0284c7;
            --bg-main: #f8fafc;
            --card-surface: #ffffff;
            --sidebar-width: 250px;
            --bottom-nav-height: 66px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-main);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-tap-highlight-color: transparent;
        }

        /* Topbar Desktop */
        .main-topbar {
            height: 62px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* App Shell */
        .app-wrapper {
            display: flex;
            flex: 1;
        }

        .main-sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-navy);
            color: #e2e8f0;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 62px);
            position: sticky;
            top: 62px;
            transition: all 0.3s;
        }

        .main-content {
            flex: 1;
            padding: 24px;
            overflow-x: hidden;
        }

        /* Sidebar Navigation */
        .sidebar-brand {
            padding: 18px 20px;
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #94a3b8;
            padding: 16px 20px 6px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 8px 12px;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.15s ease-in-out;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .sidebar-link.active {
            background-color: var(--accent-info);
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar-link i {
            font-size: 1.1rem;
        }

        /* Metric Cards (Desktop Default) */
        .metric-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 20px 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            position: relative;
            overflow: hidden;
        }

        .metric-card.card-primary {
            border-left: 5px solid var(--primary-navy);
        }
        .metric-card.card-success {
            border-left: 5px solid var(--accent-success);
        }
        .metric-card.card-danger {
            border-left: 5px solid var(--accent-danger);
        }

        .metric-title {
            font-size: 0.85rem;
            color: var(--secondary-slate);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 6px;
        }

        .metric-amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
        }

        /* Matrix Table Badges */
        .badge-matrix {
            font-size: 0.72rem;
            padding: 5px 8px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-block;
            min-width: 50px;
            text-align: center;
        }
        .badge-matrix.lunas {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-matrix.belum {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Table & Card Custom */
        .table-custom th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.82rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.03em;
            border-bottom: 2px solid #e2e8f0;
        }

        .card-custom {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        /* ===================================================
           MOBILE NATIVE APP STYLING (< 768px)
           =================================================== */
        @media (max-width: 767.98px) {
            body {
                background-color: #f1f5f9;
            }

            /* Sembunyikan topbar biasa & sidebar desktop pada mobile */
            .main-topbar {
                display: none !important;
            }
            .main-sidebar {
                display: none !important;
            }

            /* Container padding pada mobile */
            .main-content {
                padding: 16px 16px calc(var(--bottom-nav-height) + 24px) 16px !important;
            }

            /* Mobile Header (Sleek App Bar) */
            .mobile-app-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                padding: 12px 16px;
                background: #ffffff;
                border-bottom: 1px solid #e2e8f0;
                position: sticky;
                top: 0;
                z-index: 1010;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }

            .mobile-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: linear-gradient(135deg, #1e293b, #0f172a);
                color: #38bdf8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 0.95rem;
                border: 2px solid #e2e8f0;
            }

            /* Fintech / E-Wallet Master Card */
            .wallet-master-card {
                background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
                border-radius: 20px;
                padding: 24px 20px;
                color: #ffffff;
                box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25), 0 8px 10px -6px rgba(15, 23, 42, 0.15);
                position: relative;
                overflow: hidden;
                margin-bottom: 20px;
            }

            .wallet-master-card::after {
                content: '';
                position: absolute;
                top: -40px;
                right: -40px;
                width: 140px;
                height: 140px;
                background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(255,255,255,0) 70%);
                border-radius: 50%;
            }

            .wallet-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .wallet-label {
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #94a3b8;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .wallet-balance {
                font-size: 2.1rem;
                font-weight: 800;
                letter-spacing: -0.03em;
                line-height: 1.1;
                margin-bottom: 18px;
            }

            .wallet-stats-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                background: rgba(255, 255, 255, 0.07);
                backdrop-filter: blur(8px);
                border-radius: 12px;
                padding: 10px 14px;
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .stat-pill {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .stat-pill-icon {
                width: 28px;
                height: 28px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
            }

            /* Quick Action Grid (App Style) */
            .quick-actions-card {
                background: #ffffff;
                border-radius: 18px;
                padding: 16px 12px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04);
                margin-bottom: 20px;
                border: 1px solid #e2e8f0;
            }

            .quick-action-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
                text-align: center;
            }

            .quick-action-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: #334155;
                padding: 6px 2px;
                border-radius: 12px;
                transition: transform 0.15s, background-color 0.15s;
            }

            .quick-action-item:active {
                transform: scale(0.92);
                background-color: #f1f5f9;
            }

            .quick-action-circle {
                width: 48px;
                height: 48px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                margin-bottom: 6px;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            }

            .quick-action-label {
                font-size: 0.72rem;
                font-weight: 600;
                line-height: 1.2;
                color: #475569;
            }

            /* Mobile Tile / Card Row */
            .mobile-tile-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 16px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.03);
                border: 1px solid #e2e8f0;
                margin-bottom: 12px;
                transition: transform 0.1s;
            }

            .mobile-tile-card:active {
                background-color: #f8fafc;
            }

            /* Bottom Navigation Bar */
            .mobile-bottom-nav {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: var(--bottom-nav-height);
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-top: 1px solid #e2e8f0;
                z-index: 1040;
                padding-bottom: env(safe-area-inset-bottom);
                box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.05);
            }

            .bottom-nav-item {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                color: #64748b;
                font-size: 0.68rem;
                font-weight: 500;
                transition: all 0.15s ease-in-out;
                position: relative;
            }

            .bottom-nav-item i {
                font-size: 1.35rem;
                margin-bottom: 2px;
                transition: transform 0.15s;
            }

            .bottom-nav-item:active {
                transform: scale(0.90);
            }

            .bottom-nav-item.active {
                color: #0284c7;
                font-weight: 700;
            }

            .bottom-nav-item.active i {
                transform: translateY(-2px);
                color: #0284c7;
            }

            .bottom-nav-item.active::after {
                content: '';
                position: absolute;
                bottom: 4px;
                width: 16px;
                height: 3px;
                background-color: #0284c7;
                border-radius: 3px;
            }
        }

        /* Di layar desktop, sembunyikan elemen mobile app bar & bottom nav */
        @media (min-width: 768px) {
            .mobile-app-header {
                display: none !important;
            }
            .mobile-bottom-nav {
                display: none !important;
            }
            .mobile-only {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Native Header (Hanya muncul di Layar HP) -->
<header class="mobile-app-header">
    <div class="d-flex align-items-center gap-2">
        <div class="mobile-avatar">
            <?= strtoupper(substr($current_user['nama_warga'], 0, 1)); ?>
        </div>
        <div>
            <div class="fw-bold text-dark lh-sm" style="font-size: 0.95rem;">
                <?= html_escape($current_user['nama_warga']); ?>
            </div>
            <span class="badge bg-secondary-subtle text-secondary border text-uppercase" style="font-size: 0.62rem; padding: 2px 6px;">
                <i class="bi bi-shield-check me-1"></i><?= html_escape($current_user['role_name']); ?>
            </span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-light rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-label="Buka Menu">
            <i class="bi bi-grid-fill text-dark" style="font-size: 1rem;"></i>
        </button>
    </div>
</header>

<!-- Top Navigation Desktop (Hanya muncul di Tablet / Desktop) -->
<nav class="main-topbar d-flex align-items-center justify-content-between px-4">
    <div class="d-flex align-items-center gap-3">
        <div class="fw-bold fs-5 text-dark d-flex align-items-center gap-2">
            <i class="bi bi-houses text-primary"></i> SIM-Komplek
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="text-end d-none d-sm-block">
            <div class="fw-semibold text-dark small"><?= html_escape($current_user['nama_warga']); ?></div>
            <div class="badge bg-secondary-subtle text-secondary border text-uppercase" style="font-size: 0.68rem;">
                <?= html_escape($current_user['role_name']); ?>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" style="width: 38px; height: 38px;">
                <i class="bi bi-person-circle fs-5 text-secondary"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li class="px-3 py-2 border-bottom d-sm-none">
                    <div class="fw-bold small"><?= html_escape($current_user['nama_warga']); ?></div>
                    <div class="text-muted small"><?= html_escape($current_user['role_name']); ?></div>
                </li>
                <li><a class="dropdown-item small" href="<?= site_url('dashboard'); ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li>
                    <a class="dropdown-item small d-flex align-items-center justify-content-between" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalChangePasswordDefault">
                        <span><i class="bi bi-shield-lock me-2 text-primary"></i> Ganti Password</span>
                        <?php if ($this->session->userdata('is_default_password') && $current_user['role_name'] === 'warga'): ?>
                            <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">Default</span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item small text-danger" href="<?= site_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="app-wrapper">

