-- Skema Database SIM-Komplek
-- Sesuai dengan spesifikasi docs/PRD.md Bagian 4

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `id_role` INT NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_users_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `warga` (
  `id_warga` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NULL UNIQUE,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `no_blok` VARCHAR(20) NOT NULL,
  `no_hp` VARCHAR(20) NOT NULL,
  `status_hunian` ENUM('dihuni', 'kosong') NOT NULL DEFAULT 'dihuni',
  `status_penghuni` ENUM('pemilik', 'kontrak') NOT NULL DEFAULT 'pemilik',
  `nik` VARCHAR(25) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_warga_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kategori_pengeluaran` (
  `id_kategori` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_kategori` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pemasukan_iuran` (
  `id_pemasukan` INT AUTO_INCREMENT PRIMARY KEY,
  `id_warga` INT NOT NULL,
  `bulan` INT(2) NOT NULL,
  `tahun` INT(4) NOT NULL,
  `nominal` DECIMAL(12,2) NOT NULL,
  `tgl_bayar` DATE NOT NULL,
  `bukti_bayar` VARCHAR(255) NULL,
  `keterangan` VARCHAR(255) NULL,
  `created_by` INT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_iuran_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_iuran_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  UNIQUE KEY `uk_warga_bulan_tahun` (`id_warga`, `bulan`, `tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengeluaran_kas` (
  `id_pengeluaran` INT AUTO_INCREMENT PRIMARY KEY,
  `id_kategori` INT NOT NULL,
  `nominal` DECIMAL(12,2) NOT NULL,
  `tgl_pengeluaran` DATE NOT NULL,
  `keterangan` TEXT NOT NULL,
  `bukti_nota` VARCHAR(255) NULL,
  `created_by` INT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_pengeluaran_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pengeluaran` (`id_kategori`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pengeluaran_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Data: Roles
INSERT IGNORE INTO `roles` (`id_role`, `role_name`) VALUES
(1, 'admin'),
(2, 'pengurus'),
(3, 'warga');

-- Seed Data: Users (Password default: password123)
INSERT IGNORE INTO `users` (`id_user`, `username`, `password`, `id_role`, `is_active`) VALUES
(1, 'admin', '$2y$10$yBwPDlyRnm5Z8KWRNBxaWeIf3xLHLiF40oSA74KYWzAmRcRzoK872', 1, 1),
(2, 'bendahara', '$2y$10$yBwPDlyRnm5Z8KWRNBxaWeIf3xLHLiF40oSA74KYWzAmRcRzoK872', 2, 1),
(3, 'warga', '$2y$10$yBwPDlyRnm5Z8KWRNBxaWeIf3xLHLiF40oSA74KYWzAmRcRzoK872', 3, 1);

-- Seed Data: Kategori Pengeluaran
INSERT IGNORE INTO `kategori_pengeluaran` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Gaji Satpam & Keamanan'),
(2, 'Biaya Internet & Wifi Komplek'),
(3, 'Kebersihan & Angkut Sampah'),
(4, 'Perbaikan Lampu PJU & Listrik'),
(5, 'Pemeliharaan Jalan & Saluran Air'),
(6, 'Operasional Kas & Administrasi');

-- Seed Data: Warga Sampel
INSERT IGNORE INTO `warga` (`id_warga`, `id_user`, `nama_lengkap`, `no_blok`, `no_hp`, `status_hunian`, `status_penghuni`, `nik`) VALUES
(1, 3, 'Budi Santoso', 'Blok A-01', '081234567890', 'dihuni', 'pemilik', '3201123456780001'),
(2, NULL, 'Ahmad Fauzi', 'Blok A-02', '081298765432', 'dihuni', 'pemilik', '3201123456780002'),
(3, NULL, 'Siti Rahmawati', 'Blok B-01', '081345678901', 'dihuni', 'kontrak', '3201123456780003'),
(4, NULL, 'Hendro Wijaya', 'Blok B-02', '081398765432', 'kosong', 'pemilik', '3201123456780004'),
(5, NULL, 'Dewi Lestari', 'Blok C-01', '081512345678', 'dihuni', 'pemilik', '3201123456780005');

-- Seed Data: Pemasukan Iuran Sampel (Tahun 2026)
INSERT IGNORE INTO `pemasukan_iuran` (`id_warga`, `bulan`, `tahun`, `nominal`, `tgl_bayar`, `keterangan`, `created_by`) VALUES
(1, 1, 2026, 150000.00, '2026-01-05', 'Iuran Rutin Januari', 1),
(1, 2, 2026, 150000.00, '2026-02-04', 'Iuran Rutin Februari', 1),
(1, 3, 2026, 150000.00, '2026-03-05', 'Iuran Rutin Maret', 1),
(2, 1, 2026, 150000.00, '2026-01-07', 'Iuran Rutin Januari', 2),
(2, 2, 2026, 150000.00, '2026-02-10', 'Iuran Rutin Februari', 2),
(3, 1, 2026, 150000.00, '2026-01-12', 'Iuran Rutin Januari', 2);

-- Seed Data: Pengeluaran Kas Sampel
INSERT IGNORE INTO `pengeluaran_kas` (`id_kategori`, `nominal`, `tgl_pengeluaran`, `keterangan`, `created_by`) VALUES
(1, 2500000.00, '2026-01-30', 'Gaji 2 Petugas Satpam Shift Pagi & Malam Januari', 1),
(3, 300000.00, '2026-02-02', 'Iuran Retribusi Sampah DLH Bulan Januari', 2),
(2, 350000.00, '2026-02-05', 'Tagihan IndiHome Pos Satpam & CCTV Komplek', 2),
(4, 200000.00, '2026-02-15', 'Penggantian 2 unit bohlam LED PJU Blok A', 1);
