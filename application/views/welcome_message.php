<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIM-Perumahan - Sistem Informasi Manajemen Perumahan</title>
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<style>
		body {
			font-family: 'Inter', sans-serif;
			background-color: #f4f6f9;
			color: #334155;
		}
		.hero-card {
			background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
			border-radius: 16px;
			color: #fff;
			padding: 40px;
			box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
		}
		.feature-card {
			background: #ffffff;
			border: 1px solid #e2e8f0;
			border-radius: 12px;
			padding: 24px;
			transition: all 0.2s ease-in-out;
		}
		.feature-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 12px 20px -8px rgba(0,0,0,0.08);
			border-color: #cbd5e1;
		}
		.badge-chip {
			background: rgba(255, 255, 255, 0.15);
			color: #38bdf8;
			font-weight: 500;
			font-size: 0.85rem;
			padding: 6px 14px;
			border-radius: 30px;
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}
		.icon-box {
			width: 44px;
			height: 44px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.25rem;
			margin-bottom: 16px;
		}
	</style>
</head>
<body>

<div class="container py-5">
	<!-- Header Section -->
	<div class="hero-card mb-5">
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
			<span class="badge-chip">
				<i class="bi bi-shield-check"></i> CodeIgniter 3.1.13 • PHP <?= phpversion(); ?> Ready
			</span>
			<span class="text-secondary small">
				<i class="bi bi-folder-check"></i> Workspace Antigravity Ready
			</span>
		</div>
		<h1 class="display-6 fw-bold mb-3">SIM-Perumahan</h1>
		<p class="lead text-light text-opacity-75 mb-4" style="max-width: 680px;">
			Sistem Informasi Manajemen Perumahan terintegrasi untuk pengelolaan data warga, kavling hunian, tagihan iuran berkala, laporan kas, dan layanan pengantar.
		</p>
		<div class="d-flex flex-wrap gap-2">
			<a href="#rules-section" class="btn btn-primary px-4 py-2 fw-medium rounded-pill">
				<i class="bi bi-file-earmark-code me-1"></i> Dokumentasi & Rules
			</a>
			<a href="https://codeigniter.com/userguide3/" target="_blank" class="btn btn-outline-light px-4 py-2 fw-medium rounded-pill">
				<i class="bi bi-book me-1"></i> Panduan CI3
			</a>
		</div>
	</div>

	<!-- Rules & Specifications Grid -->
	<div id="rules-section" class="row g-4 mb-5">
		<div class="col-12 mb-1">
			<h4 class="fw-bold text-dark mb-1">Dokumentasi & Standar Proyek</h4>
			<p class="text-muted">Agent AI secara otomatis telah dikonfigurasi untuk merujuk pada standar berikut sebelum memulai pengembangan fitur.</p>
		</div>

		<!-- PRD Card -->
		<div class="col-md-4">
			<div class="feature-card h-100">
				<div class="icon-box bg-primary-subtle text-primary">
					<i class="bi bi-file-earmark-text"></i>
				</div>
				<h5 class="fw-bold">docs/PRD.md</h5>
				<p class="text-muted small">
					Product Requirement Document berisi spesifikasi modul warga, kavling, iuran/billing, laporan kas keuangan, dan alur perizinan surat.
				</p>
				<span class="badge bg-primary-subtle text-primary">Fungsionalitas & Scope</span>
			</div>
		</div>

		<!-- DESIGN Card -->
		<div class="col-md-4">
			<div class="feature-card h-100">
				<div class="icon-box bg-success-subtle text-success">
					<i class="bi bi-diagram-3"></i>
				</div>
				<h5 class="fw-bold">docs/DESIGN.md</h5>
				<p class="text-muted small">
					Arsitektur sistem MVC CodeIgniter 3, skema tabel basis data MySQL (users, kavling, warga, iuran, kas), dan standar antarmuka UI/UX.
				</p>
				<span class="badge bg-success-subtle text-success">Arsitektur & Skema DB</span>
			</div>
		</div>

		<!-- SECURITY Card -->
		<div class="col-md-4">
			<div class="feature-card h-100">
				<div class="icon-box bg-danger-subtle text-danger">
					<i class="bi bi-shield-lock"></i>
				</div>
				<h5 class="fw-bold">docs/SECURITY.md</h5>
				<p class="text-muted small">
					Pedoman keamanan: perlindungan SQL Injection (Query Builder), token CSRF pada form, XSS output filtering, dan password hashing BCRYPT.
				</p>
				<span class="badge bg-danger-subtle text-danger">Standar Keamanan</span>
			</div>
		</div>
	</div>

	<!-- System Status Summary -->
	<div class="card border-0 shadow-sm rounded-4 p-4">
		<h5 class="fw-bold mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Status Konfigurasi Awal</h5>
		<div class="row g-3">
			<div class="col-md-6">
				<ul class="list-group list-group-flush small">
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">Framework:</span>
						<span class="fw-semibold">CodeIgniter 3.1.13</span>
					</li>
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">PHP Engine:</span>
						<span class="fw-semibold">PHP <?= phpversion(); ?> (Dynamic properties patched)</span>
					</li>
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">Clean URLs (.htaccess):</span>
						<span class="badge bg-success">Aktif (Tanpa index.php)</span>
					</li>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="list-group list-group-flush small">
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">Folder Rules Agent:</span>
						<span class="badge bg-primary">.agents/rules/</span>
					</li>
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">Agent Manifest:</span>
						<span class="badge bg-primary">AGENTS.md</span>
					</li>
					<li class="list-group-item px-0 py-2 d-flex justify-content-between">
						<span class="text-muted">Autoload Libraries:</span>
						<span class="fw-semibold">database, session, url, form, security</span>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<footer class="mt-5 text-center text-muted small">
		Rendered in <strong>{elapsed_time}</strong> seconds • SIM-Perumahan Starter Template
	</footer>
</div>

</body>
</html>
