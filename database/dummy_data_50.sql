-- ============================================================
-- DUMMY DATA SQL - Sistem Penugasan PKL
-- 50 Data Pelaksana + Absensi Kosong + Tugas untuk Blackbox Testing
-- Hosting: InfinityFree (Import via phpMyAdmin)
-- Generated: 2026-06-01
-- ============================================================
-- Password untuk semua user: password
-- Bcrypt hash: $2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.
--
-- PENTING: Semua absensi berstatus "Belum Mengisi"
--          Semua tugas active memiliki submission "pending"
--          Sehingga pelaksana bisa mengisi sendiri saat blackbox testing.

-- ============================================================
-- LANGKAH 1: Nonaktifkan foreign key check
-- ============================================================
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- ============================================================
-- LANGKAH 2: Bersihkan data lama
-- ============================================================
DELETE FROM `submission_comments`;
DELETE FROM `task_submissions`;
DELETE FROM `task_assignees`;
DELETE FROM `task_files`;
DELETE FROM `tasks`;
DELETE FROM `attendance_assignees`;
DELETE FROM `attendances`;
DELETE FROM `users`;
DELETE FROM `divisi`;
DELETE FROM `roles`;

-- ============================================================
-- LANGKAH 3: Insert Roles
-- ============================================================
INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', NOW(), NOW()),
(2, 'pembimbing', NOW(), NOW()),
(3, 'pelaksana', NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = VALUES(`role`);

-- ============================================================
-- LANGKAH 4: Insert Divisi
-- ============================================================
INSERT INTO `divisi` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Divisi SSGS', NOW(), NOW()),
(2, 'Divisi BGES', NOW(), NOW()),
(3, 'Divisi HERO', NOW(), NOW())
ON DUPLICATE KEY UPDATE `nama` = VALUES(`nama`);

-- ============================================================
-- LANGKAH 5: Insert Users - 1 Admin + 5 Pembimbing + 50 Pelaksana
-- ============================================================

-- Admin
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `divisi_id`, `pembimbing_id`, `avatar`, `pkl_start`, `pkl_end`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 1, NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(57, 'Eko Dwi Nugroho, S.Kom., M.Cs.', 'eko.nugroho@if.itera.ac.id', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 1, NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(58, 'Muhammad Habib Algifari, S.Kom., M.TI.', 'muhammad.algifari@if.itera.ac.id', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 1, NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(59, 'Ilham Firman Ashari, S.Kom., M.T.', 'firman.ashari@if.itera.ac.id', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 1, NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(60, 'Meida Cahyo Untoro, S.Kom., M.Kom', 'cahyo.untoro@if.itera.ac.id', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 1, NULL, NULL, NULL, NULL, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Pembimbing (ID 2-6)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `divisi_id`, `pembimbing_id`, `avatar`, `pkl_start`, `pkl_end`, `created_at`, `updated_at`) VALUES
(2,  'Budi Santoso, S.T.',     'pembimbing1@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 2, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
(3,  'Siti Nurhaliza, M.Kom.', 'pembimbing2@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 2, 1, NULL, NULL, NULL, NULL, NOW(), NOW()),
(4,  'Ahmad Fauzi, S.Kom.',    'pembimbing3@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 2, 2, NULL, NULL, NULL, NULL, NOW(), NOW()),
(5,  'Dewi Kartika, M.T.',     'pembimbing4@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 2, 2, NULL, NULL, NULL, NULL, NOW(), NOW()),
(6,  'Rudi Hermawan, S.T.',    'pembimbing5@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 2, 3, NULL, NULL, NULL, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 50 Pelaksana (ID 7-56)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `divisi_id`, `pembimbing_id`, `avatar`, `pkl_start`, `pkl_end`, `created_at`, `updated_at`) VALUES
(7,  'Andi Pratama',       'pelaksana1@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(8,  'Budi Setiawan',      'pelaksana2@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(9,  'Citra Dewi',         'pelaksana3@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(10, 'Dimas Arya',         'pelaksana4@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(11, 'Eka Putri',          'pelaksana5@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(12, 'Fajar Nugroho',      'pelaksana6@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(13, 'Gita Anjani',        'pelaksana7@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(14, 'Hendra Wijaya',      'pelaksana8@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(15, 'Indah Permata',      'pelaksana9@penugasanpkl.com',  NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(16, 'Joko Susilo',        'pelaksana10@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(17, 'Kartika Sari',       'pelaksana11@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-02-10', '2026-08-10', NOW(), NOW()),
(18, 'Lukman Hakim',       'pelaksana12@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(19, 'Maya Sari',          'pelaksana13@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(20, 'Nanda Putra',        'pelaksana14@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(21, 'Olivia Rahma',       'pelaksana15@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(22, 'Putra Aditya',       'pelaksana16@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(23, 'Qori Amelia',        'pelaksana17@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(24, 'Rizki Maulana',      'pelaksana18@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(25, 'Sinta Maharani',     'pelaksana19@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(26, 'Taufik Hidayat',     'pelaksana20@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(27, 'Umar Faruq',         'pelaksana21@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-02-10', '2026-08-10', NOW(), NOW()),
(28, 'Vina Anggraeni',     'pelaksana22@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-02-10', '2026-08-10', NOW(), NOW()),
(29, 'Wahyu Firmansyah',   'pelaksana23@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(30, 'Xenia Putri',        'pelaksana24@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-01-06', '2026-06-30', NOW(), NOW()),
(31, 'Yoga Pratama',       'pelaksana25@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(32, 'Zahra Aulia',        'pelaksana26@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-02-01', '2026-07-31', NOW(), NOW()),
(33, 'Arief Rahman',       'pelaksana27@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(34, 'Bella Safitri',      'pelaksana28@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-01-13', '2026-07-13', NOW(), NOW()),
(35, 'Cahyo Wibowo',       'pelaksana29@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(36, 'Dian Puspita',       'pelaksana30@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-03-01', '2026-08-31', NOW(), NOW()),
(37, 'Erwin Saputra',      'pelaksana31@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(38, 'Fitri Handayani',    'pelaksana32@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(39, 'Galih Ramadhan',     'pelaksana33@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(40, 'Hani Mulyani',       'pelaksana34@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(41, 'Irfan Habibie',      'pelaksana35@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(42, 'Juni Lestari',       'pelaksana36@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(43, 'Kevin Anggara',      'pelaksana37@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(44, 'Lina Marlina',       'pelaksana38@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(45, 'Muhamad Ridwan',     'pelaksana39@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(46, 'Novia Rahmawati',    'pelaksana40@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-04-01', '2026-09-30', NOW(), NOW()),
(47, 'Oscar Darmawan',     'pelaksana41@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(48, 'Putri Wulandari',    'pelaksana42@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-04-14', '2026-10-14', NOW(), NOW()),
(49, 'Rian Saputra',       'pelaksana43@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(50, 'Sari Indah',         'pelaksana44@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 3, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(51, 'Tommy Kurniawan',    'pelaksana45@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(52, 'Ulfa Nazira',        'pelaksana46@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 5, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(53, 'Viktor Halim',       'pelaksana47@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(54, 'Winda Salsabila',    'pelaksana48@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 3, 6, NULL, '2026-05-01', '2026-10-31', NOW(), NOW()),
(55, 'Yusuf Maulana',      'pelaksana49@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 1, 2, NULL, '2026-05-12', '2026-11-12', NOW(), NOW()),
(56, 'Zara Amira',         'pelaksana50@penugasanpkl.com', NOW(), '$2y$12$0HoGJY6FEwVHTJg.oONIvOXmdJPC7sziARaw6C/EcC.rUSndvUQB.', 3, 2, 4, NULL, '2026-05-12', '2026-11-12', NOW(), NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- ============================================================
-- LANGKAH 6: Insert Attendances (1-30 Mei 2026 - hari kerja saja)
-- Semua sesi dibuat oleh Admin (id=1)
-- Deadline check-in: 08:30, Checkout mulai: 17:00
-- Total: 21 hari kerja
-- ============================================================
INSERT INTO `attendances` (`id`, `title`, `description`, `deadline`, `checkout_start`, `created_by`, `created_at`, `updated_at`) VALUES
(1,  'Absensi Harian 1 Mei 2026',  'Silakan isi absensi untuk hari Jumat',  '2026-05-01 08:30:00', '2026-05-01 17:00:00', 1, '2026-05-01 06:00:00', '2026-05-01 06:00:00'),
(2,  'Absensi Harian 4 Mei 2026',  'Silakan isi absensi untuk hari Senin',  '2026-05-04 08:30:00', '2026-05-04 17:00:00', 1, '2026-05-04 06:00:00', '2026-05-04 06:00:00'),
(3,  'Absensi Harian 5 Mei 2026',  'Silakan isi absensi untuk hari Selasa', '2026-05-05 08:30:00', '2026-05-05 17:00:00', 1, '2026-05-05 06:00:00', '2026-05-05 06:00:00'),
(4,  'Absensi Harian 6 Mei 2026',  'Silakan isi absensi untuk hari Rabu',   '2026-05-06 08:30:00', '2026-05-06 17:00:00', 1, '2026-05-06 06:00:00', '2026-05-06 06:00:00'),
(5,  'Absensi Harian 7 Mei 2026',  'Silakan isi absensi untuk hari Kamis',  '2026-05-07 08:30:00', '2026-05-07 17:00:00', 1, '2026-05-07 06:00:00', '2026-05-07 06:00:00'),
(6,  'Absensi Harian 8 Mei 2026',  'Silakan isi absensi untuk hari Jumat',  '2026-05-08 08:30:00', '2026-05-08 17:00:00', 1, '2026-05-08 06:00:00', '2026-05-08 06:00:00'),
(7,  'Absensi Harian 11 Mei 2026', 'Silakan isi absensi untuk hari Senin',  '2026-05-11 08:30:00', '2026-05-11 17:00:00', 1, '2026-05-11 06:00:00', '2026-05-11 06:00:00'),
(8,  'Absensi Harian 12 Mei 2026', 'Silakan isi absensi untuk hari Selasa', '2026-05-12 08:30:00', '2026-05-12 17:00:00', 1, '2026-05-12 06:00:00', '2026-05-12 06:00:00'),
(9,  'Absensi Harian 13 Mei 2026', 'Silakan isi absensi untuk hari Rabu',   '2026-05-13 08:30:00', '2026-05-13 17:00:00', 1, '2026-05-13 06:00:00', '2026-05-13 06:00:00'),
(10, 'Absensi Harian 14 Mei 2026', 'Silakan isi absensi untuk hari Kamis',  '2026-05-14 08:30:00', '2026-05-14 17:00:00', 1, '2026-05-14 06:00:00', '2026-05-14 06:00:00'),
(11, 'Absensi Harian 15 Mei 2026', 'Silakan isi absensi untuk hari Jumat',  '2026-05-15 08:30:00', '2026-05-15 17:00:00', 1, '2026-05-15 06:00:00', '2026-05-15 06:00:00'),
(12, 'Absensi Harian 18 Mei 2026', 'Silakan isi absensi untuk hari Senin',  '2026-05-18 08:30:00', '2026-05-18 17:00:00', 1, '2026-05-18 06:00:00', '2026-05-18 06:00:00'),
(13, 'Absensi Harian 19 Mei 2026', 'Silakan isi absensi untuk hari Selasa', '2026-05-19 08:30:00', '2026-05-19 17:00:00', 1, '2026-05-19 06:00:00', '2026-05-19 06:00:00'),
(14, 'Absensi Harian 20 Mei 2026', 'Silakan isi absensi untuk hari Rabu',   '2026-05-20 08:30:00', '2026-05-20 17:00:00', 1, '2026-05-20 06:00:00', '2026-05-20 06:00:00'),
(15, 'Absensi Harian 21 Mei 2026', 'Silakan isi absensi untuk hari Kamis',  '2026-05-21 08:30:00', '2026-05-21 17:00:00', 1, '2026-05-21 06:00:00', '2026-05-21 06:00:00'),
(16, 'Absensi Harian 22 Mei 2026', 'Silakan isi absensi untuk hari Jumat',  '2026-05-22 08:30:00', '2026-05-22 17:00:00', 1, '2026-05-22 06:00:00', '2026-05-22 06:00:00'),
(17, 'Absensi Harian 25 Mei 2026', 'Silakan isi absensi untuk hari Senin',  '2026-05-25 08:30:00', '2026-05-25 17:00:00', 1, '2026-05-25 06:00:00', '2026-05-25 06:00:00'),
(18, 'Absensi Harian 26 Mei 2026', 'Silakan isi absensi untuk hari Selasa', '2026-05-26 08:30:00', '2026-05-26 17:00:00', 1, '2026-05-26 06:00:00', '2026-05-26 06:00:00'),
(19, 'Absensi Harian 27 Mei 2026', 'Silakan isi absensi untuk hari Rabu',   '2026-05-27 08:30:00', '2026-05-27 17:00:00', 1, '2026-05-27 06:00:00', '2026-05-27 06:00:00'),
(20, 'Absensi Harian 28 Mei 2026', 'Silakan isi absensi untuk hari Kamis',  '2026-05-28 08:30:00', '2026-05-28 17:00:00', 1, '2026-05-28 06:00:00', '2026-05-28 06:00:00'),
(21, 'Absensi Harian 29 Mei 2026', 'Silakan isi absensi untuk hari Jumat',  '2026-05-29 08:30:00', '2026-05-29 17:00:00', 1, '2026-05-29 06:00:00', '2026-05-29 06:00:00');

-- ============================================================
-- LANGKAH 7: Insert Attendance Assignees - SEMUA KOSONG (Belum Mengisi)
-- 50 pelaksana × 21 hari = 1050 records
-- Semua berstatus "Belum Mengisi" agar bisa diisi manual saat testing
-- ============================================================

-- Absensi 1 (1 Mei) - Dengan berbagai variasi status
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 1, u.id, 
    CASE 
        WHEN u.id IN (7, 8, 9, 10) THEN 'Hadir'
        WHEN u.id IN (11, 12) THEN 'Terlambat'
        WHEN u.id = 13 THEN 'Izin'
        WHEN u.id = 14 THEN 'Sakit'
        ELSE 'Belum Mengisi'
    END as status,
    CASE 
        WHEN u.id IN (7, 8, 9, 10) THEN '2026-05-01 08:00:00'
        WHEN u.id IN (11, 12) THEN '2026-05-01 09:30:00'
        ELSE NULL
    END as check_in_time,
    CASE 
        WHEN u.id IN (7, 8, 9, 10) THEN '2026-05-01 17:05:00'
        WHEN u.id IN (11, 12) THEN '2026-05-01 17:10:00'
        ELSE NULL
    END as check_out_time,
    CASE 
        WHEN u.id = 13 THEN 'Keperluan keluarga'
        WHEN u.id = 14 THEN 'Sakit demam'
        ELSE NULL
    END as keterangan,
    CASE 
        WHEN u.id = 14 THEN 'surat_sakit/dummy.jpg'
        ELSE NULL
    END as photo_path,
    NULL as checkout_photo_path,
    '2026-05-01 06:00:00' as created_at,
    '2026-05-01 06:00:00' as updated_at
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- =============================================
-- MINGGU 1 (Absensi 2-6): Mayoritas Hadir, beberapa variasi
-- =============================================

-- Absensi 2 (4 Mei) - Mayoritas hadir
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 2, u.id,
    CASE
        WHEN u.id BETWEEN 7 AND 40 THEN 'Hadir'
        WHEN u.id IN (41, 42) THEN 'Terlambat'
        WHEN u.id = 43 THEN 'Sakit'
        WHEN u.id = 44 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id BETWEEN 7 AND 40 THEN '2026-05-04 08:10:00'
        WHEN u.id IN (41, 42) THEN '2026-05-04 09:15:00'
        WHEN u.id IN (43, 44) THEN NULL
        ELSE '2026-05-04 08:20:00'
    END,
    CASE
        WHEN u.id IN (43, 44) THEN NULL
        ELSE '2026-05-04 17:05:00'
    END,
    CASE
        WHEN u.id = 43 THEN 'Flu berat'
        WHEN u.id = 44 THEN 'Urusan kampus'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-04 06:00:00', '2026-05-04 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 3 (5 Mei) - Mayoritas hadir, 3 terlambat
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 3, u.id,
    CASE
        WHEN u.id IN (15, 16, 17) THEN 'Terlambat'
        WHEN u.id = 18 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (15, 16, 17) THEN '2026-05-05 09:00:00'
        WHEN u.id = 18 THEN NULL
        ELSE '2026-05-05 08:05:00'
    END,
    CASE
        WHEN u.id = 18 THEN NULL
        ELSE '2026-05-05 17:00:00'
    END,
    CASE WHEN u.id = 18 THEN 'Mengurus KRS di kampus' ELSE NULL END,
    NULL, NULL,
    '2026-05-05 06:00:00', '2026-05-05 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 4 (6 Mei) - Semua hadir kecuali 2 sakit
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 4, u.id,
    CASE
        WHEN u.id IN (29, 30) THEN 'Sakit'
        ELSE 'Hadir'
    END,
    CASE WHEN u.id IN (29, 30) THEN NULL ELSE '2026-05-06 07:55:00' END,
    CASE WHEN u.id IN (29, 30) THEN NULL ELSE '2026-05-06 17:10:00' END,
    CASE WHEN u.id = 29 THEN 'Demam tinggi' WHEN u.id = 30 THEN 'Sakit perut' ELSE NULL END,
    NULL, NULL,
    '2026-05-06 06:00:00', '2026-05-06 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 5 (7 Mei) - Ada yang terlambat dan izin
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 5, u.id,
    CASE
        WHEN u.id IN (7, 8) THEN 'Terlambat'
        WHEN u.id = 35 THEN 'Izin'
        WHEN u.id = 36 THEN 'Sakit'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (7, 8) THEN '2026-05-07 09:45:00'
        WHEN u.id IN (35, 36) THEN NULL
        ELSE '2026-05-07 08:15:00'
    END,
    CASE WHEN u.id IN (35, 36) THEN NULL ELSE '2026-05-07 17:00:00' END,
    CASE
        WHEN u.id = 35 THEN 'Ada acara keluarga'
        WHEN u.id = 36 THEN 'Radang tenggorokan'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-07 06:00:00', '2026-05-07 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 6 (8 Mei) - Mayoritas hadir
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 6, u.id,
    CASE
        WHEN u.id IN (23, 24, 25) THEN 'Terlambat'
        WHEN u.id = 26 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (23, 24, 25) THEN '2026-05-08 08:50:00'
        WHEN u.id = 26 THEN NULL
        ELSE '2026-05-08 08:00:00'
    END,
    CASE WHEN u.id = 26 THEN NULL ELSE '2026-05-08 17:05:00' END,
    CASE WHEN u.id = 26 THEN 'Pergi ke rumah sakit' ELSE NULL END,
    NULL, NULL,
    '2026-05-08 06:00:00', '2026-05-08 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- =============================================
-- MINGGU 2 (Absensi 7-11): Variasi lebih banyak
-- =============================================

-- Absensi 7 (11 Mei) - Sebagian hadir, banyak terlambat (hari Senin)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 7, u.id,
    CASE
        WHEN u.id IN (9, 10, 11, 20, 21, 37, 38) THEN 'Terlambat'
        WHEN u.id = 39 THEN 'Sakit'
        WHEN u.id = 40 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (9, 10, 11, 20, 21, 37, 38) THEN '2026-05-11 09:20:00'
        WHEN u.id IN (39, 40) THEN NULL
        ELSE '2026-05-11 08:10:00'
    END,
    CASE WHEN u.id IN (39, 40) THEN NULL ELSE '2026-05-11 17:00:00' END,
    CASE
        WHEN u.id = 39 THEN 'Vertigo kambuh'
        WHEN u.id = 40 THEN 'Mengurus surat di kelurahan'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-11 06:00:00', '2026-05-11 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 8 (12 Mei) - Mayoritas hadir
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 8, u.id,
    CASE
        WHEN u.id IN (45, 46) THEN 'Terlambat'
        WHEN u.id = 47 THEN 'Sakit'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (45, 46) THEN '2026-05-12 09:10:00'
        WHEN u.id = 47 THEN NULL
        ELSE '2026-05-12 08:05:00'
    END,
    CASE WHEN u.id = 47 THEN NULL ELSE '2026-05-12 17:10:00' END,
    CASE WHEN u.id = 47 THEN 'Tipes, perlu istirahat' ELSE NULL END,
    NULL, NULL,
    '2026-05-12 06:00:00', '2026-05-12 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 9 (13 Mei) - Semua hadir (hari sempurna)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 9, u.id, 'Hadir', '2026-05-13 08:00:00', '2026-05-13 17:00:00', NULL, NULL, NULL,
    '2026-05-13 06:00:00', '2026-05-13 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 10 (14 Mei) - Beberapa izin dan sakit
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 10, u.id,
    CASE
        WHEN u.id IN (12, 13) THEN 'Izin'
        WHEN u.id IN (48, 49) THEN 'Sakit'
        WHEN u.id = 50 THEN 'Terlambat'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (12, 13, 48, 49) THEN NULL
        WHEN u.id = 50 THEN '2026-05-14 09:30:00'
        ELSE '2026-05-14 08:10:00'
    END,
    CASE WHEN u.id IN (12, 13, 48, 49) THEN NULL ELSE '2026-05-14 17:05:00' END,
    CASE
        WHEN u.id = 12 THEN 'Wisuda saudara'
        WHEN u.id = 13 THEN 'Keperluan mendadak'
        WHEN u.id = 48 THEN 'Batuk parah'
        WHEN u.id = 49 THEN 'Alergi makanan'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-14 06:00:00', '2026-05-14 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 11 (15 Mei) - Hari Jumat, beberapa terlambat
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 11, u.id,
    CASE
        WHEN u.id IN (14, 15, 16, 17, 51) THEN 'Terlambat'
        WHEN u.id = 52 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (14, 15, 16, 17, 51) THEN '2026-05-15 09:05:00'
        WHEN u.id = 52 THEN NULL
        ELSE '2026-05-15 08:15:00'
    END,
    CASE WHEN u.id = 52 THEN NULL ELSE '2026-05-15 17:00:00' END,
    CASE WHEN u.id = 52 THEN 'Pulang kampung' ELSE NULL END,
    NULL, NULL,
    '2026-05-15 06:00:00', '2026-05-15 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- =============================================
-- MINGGU 3 (Absensi 12-15): Variasi realistis
-- =============================================

-- Absensi 12 (18 Mei) - Hari Senin, banyak terlambat
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 12, u.id,
    CASE
        WHEN u.id IN (7, 8, 9, 10, 11, 18, 19, 20, 33, 34) THEN 'Terlambat'
        WHEN u.id IN (53, 54) THEN 'Sakit'
        WHEN u.id = 55 THEN 'Izin'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (7, 8, 9, 10, 11, 18, 19, 20, 33, 34) THEN '2026-05-18 09:00:00'
        WHEN u.id IN (53, 54, 55) THEN NULL
        ELSE '2026-05-18 08:20:00'
    END,
    CASE WHEN u.id IN (53, 54, 55) THEN NULL ELSE '2026-05-18 17:05:00' END,
    CASE
        WHEN u.id = 53 THEN 'Demam'
        WHEN u.id = 54 THEN 'Sakit gigi'
        WHEN u.id = 55 THEN 'Ada jadwal kuliah'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-18 06:00:00', '2026-05-18 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 13 (19 Mei) - Mayoritas hadir
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 13, u.id,
    CASE
        WHEN u.id = 28 THEN 'Terlambat'
        WHEN u.id = 56 THEN 'Sakit'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id = 28 THEN '2026-05-19 08:45:00'
        WHEN u.id = 56 THEN NULL
        ELSE '2026-05-19 08:00:00'
    END,
    CASE WHEN u.id = 56 THEN NULL ELSE '2026-05-19 17:00:00' END,
    CASE WHEN u.id = 56 THEN 'Kecelakaan ringan' ELSE NULL END,
    NULL, NULL,
    '2026-05-19 06:00:00', '2026-05-19 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 14 (20 Mei) - Semua hadir
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 14, u.id, 'Hadir', '2026-05-20 08:05:00', '2026-05-20 17:00:00', NULL, NULL, NULL,
    '2026-05-20 06:00:00', '2026-05-20 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 15 (21 Mei) - Beberapa terlambat dan izin
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 15, u.id,
    CASE
        WHEN u.id IN (31, 32) THEN 'Terlambat'
        WHEN u.id = 22 THEN 'Izin'
        WHEN u.id = 27 THEN 'Sakit'
        ELSE 'Hadir'
    END,
    CASE
        WHEN u.id IN (31, 32) THEN '2026-05-21 09:10:00'
        WHEN u.id IN (22, 27) THEN NULL
        ELSE '2026-05-21 08:00:00'
    END,
    CASE WHEN u.id IN (22, 27) THEN NULL ELSE '2026-05-21 17:05:00' END,
    CASE
        WHEN u.id = 22 THEN 'Mengurus dokumen di kampus'
        WHEN u.id = 27 THEN 'Masuk angin'
        ELSE NULL
    END,
    NULL, NULL,
    '2026-05-21 06:00:00', '2026-05-21 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- =============================================
-- MINGGU 4 (Absensi 16-21): Tetap "Belum Mengisi" (absensi terbaru)
-- =============================================

-- Absensi 16 (22 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 16, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-22 06:00:00', '2026-05-22 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 17 (25 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 17, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-25 06:00:00', '2026-05-25 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 18 (26 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 18, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-26 06:00:00', '2026-05-26 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 19 (27 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 19, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-27 06:00:00', '2026-05-27 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 20 (28 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 20, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-28 06:00:00', '2026-05-28 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- Absensi 21 (29 Mei)
INSERT INTO `attendance_assignees` (`attendance_id`, `user_id`, `status`, `check_in_time`, `check_out_time`, `keterangan`, `photo_path`, `checkout_photo_path`, `created_at`, `updated_at`)
SELECT 21, u.id, 'Belum Mengisi', NULL, NULL, NULL, NULL, NULL, '2026-05-29 06:00:00', '2026-05-29 06:00:00'
FROM `users` u WHERE u.id BETWEEN 7 AND 56;

-- ============================================================
-- LANGKAH 8: Insert Tasks (20 tugas)
-- - 6 completed (sudah dinilai, ada riwayat)
-- - 10 active dengan submission PENDING (pelaksana bisa submit sendiri)
-- - 4 draft (belum dipublish)
-- ============================================================
INSERT INTO `tasks` (`id`, `judul`, `deskripsi`, `jenis_tugas`, `prioritas`, `divisi_id`, `deadline_date`, `deadline_time`, `catatan`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
-- Tugas Completed (ada riwayat nilai)
(1,  'Mapping Data Sekolah Bandar Lampung',       'Lakukan pemetaan data sekolah di wilayah Bandar Lampung untuk keperluan pemasaran produk edukasi. Kumpulkan informasi nama sekolah, alamat, jumlah siswa, dan kontak PIC.', 'kelompok', 'tinggi',  1, '2026-05-10', '17:00', 'Gunakan template yang sudah disediakan', 2, 'completed', '2026-05-01 08:00:00', '2026-05-10 17:00:00'),
(2,  'Rekapitulasi Tagihan Pelanggan Area Natar',  'Buat rekapitulasi tagihan pelanggan yang belum terbayar di area Natar. Pisahkan berdasarkan jenis layanan (Indihome, Astinet, dll).', 'individu', 'tinggi',  2, '2026-05-12', '15:00', 'Perhatikan data yang sudah expired', 4, 'completed', '2026-05-03 09:00:00', '2026-05-12 15:00:00'),
(3,  'Visiting Pelanggan Indihome Tunggakan',      'Lakukan kunjungan ke pelanggan Indihome yang memiliki tunggakan lebih dari 2 bulan. Catat hasil kunjungan dan komitmen pembayaran.', 'individu', 'sedang',  1, '2026-05-15', '16:00', NULL, 3, 'completed', '2026-05-05 10:00:00', '2026-05-15 16:00:00'),
(4,  'Input Data Prospek Sales B2B',               'Masukkan data calon pelanggan korporat (B2B) ke dalam sistem CRM. Pastikan data lengkap: nama perusahaan, PIC, kontak, kebutuhan layanan.', 'individu', 'rendah',  2, '2026-05-18', '14:00', NULL, 5, 'completed', '2026-05-08 08:30:00', '2026-05-18 14:00:00'),
(5,  'Update Database Perangkat Jaringan',         'Perbarui database inventaris perangkat jaringan (router, switch, ODP, ODC) di seluruh area operasional.', 'kelompok', 'tinggi',  3, '2026-05-20', '17:00', 'Koordinasi dengan teknisi lapangan', 6, 'completed', '2026-05-10 07:00:00', '2026-05-20 17:00:00'),
(6,  'Caring Pelanggan Prioritas VIP',             'Hubungi 50 pelanggan VIP untuk menanyakan kepuasan layanan dan menawarkan upgrade paket. Dokumentasikan setiap interaksi.', 'kelompok', 'tinggi',  1, '2026-05-22', '16:00', 'Gunakan script calling yang sudah disiapkan', 2, 'completed', '2026-05-12 09:00:00', '2026-05-22 16:00:00'),

-- Tugas Active - SEMUA SUBMISSION PENDING (pelaksana bisa submit sendiri)
(7,  'Survey Kepuasan Pelanggan (CSAT)',           'Lakukan survey kepuasan pelanggan menggunakan form online. Target: 200 responden dalam 2 minggu. Buat ringkasan laporan statistik.', 'proyek',   'sedang',  2, '2026-06-15', '17:00', 'Form survey sudah dikirim via email', 4, 'active', '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(8,  'Pengecekan ODP Area Kedaton',                'Cek kondisi ODP (Optical Distribution Point) di area Kedaton. Foto kondisi perangkat dan catat yang perlu perbaikan.', 'individu', 'tinggi',  3, '2026-06-10', '15:00', 'Bawa peralatan safety', 6, 'active', '2026-05-22 07:30:00', '2026-05-22 07:30:00'),
(9,  'Migrasi Data Layanan Telkomsel',             'Bantu proses migrasi data pelanggan layanan dari sistem lama ke sistem baru. Pastikan tidak ada data yang hilang.', 'kelompok', 'tinggi',  1, '2026-06-12', '17:00', 'Backup data sebelum migrasi', 3, 'active', '2026-05-25 09:00:00', '2026-05-25 09:00:00'),
(10, 'Follow Up Tiket Gangguan Internet',          'Tindaklanjuti tiket gangguan internet pelanggan yang masih open. Hubungi pelanggan dan koordinasi dengan teknisi.', 'individu', 'sedang',  2, '2026-06-10', '16:00', NULL, 5, 'active', '2026-05-25 10:00:00', '2026-05-25 10:00:00'),
(11, 'Pembuatan Laporan Kinerja Mingguan',         'Susun laporan kinerja mingguan yang mencakup: jumlah pelanggan baru, churn rate, revenue, dan pencapaian target.', 'individu', 'sedang',  1, '2026-06-08', '14:00', 'Template laporan ada di shared drive', 2, 'active', '2026-05-26 08:00:00', '2026-05-26 08:00:00'),
(12, 'Desain Materi Promosi Produk',               'Buat desain materi promosi untuk produk Indihome terbaru. Sediakan dalam format poster A3, banner web, dan story Instagram.', 'proyek',   'rendah',  3, '2026-06-15', '17:00', 'Gunakan brand guideline terbaru', 6, 'active', '2026-05-27 09:00:00', '2026-05-27 09:00:00'),
(13, 'Analisis Data Churn Rate',                   'Analisis data churn rate pelanggan selama 3 bulan terakhir. Identifikasi pola dan buat rekomendasi untuk menurunkan angka churn.', 'individu', 'tinggi',  2, '2026-06-12', '15:00', 'Data bisa diambil dari dashboard BI', 4, 'active', '2026-05-28 08:30:00', '2026-05-28 08:30:00'),
(14, 'Inventarisasi Aset Kantor',                  'Lakukan penghitungan dan pencatatan seluruh aset kantor termasuk komputer, meja, kursi, dan peralatan IT lainnya.', 'kelompok', 'rendah',  1, '2026-06-18', '17:00', NULL, 3, 'active', '2026-05-28 10:00:00', '2026-05-28 10:00:00'),
(15, 'Koordinasi dengan Teknisi Lapangan',         'Koordinasikan jadwal perbaikan jaringan dengan tim teknisi lapangan. Pastikan SLA terpenuhi untuk tiket prioritas tinggi.', 'individu', 'tinggi',  3, '2026-06-08', '12:00', 'Prioritaskan tiket pelanggan korporat', 6, 'active', '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(16, 'Review Dokumen SLA Pelanggan Korporat',      'Tinjau ulang dokumen SLA (Service Level Agreement) untuk 10 pelanggan korporat terbesar. Catat yang perlu diperbarui.', 'individu', 'sedang',  2, '2026-06-10', '17:00', NULL, 5, 'active', '2026-05-18 09:00:00', '2026-05-18 09:00:00'),

-- Tugas Draft (belum dipublish)
(17, 'Pemasaran Indihome Paket Jitu',              'Rencanakan dan eksekusi kampanye pemasaran untuk paket Indihome Jitu di area perumahan baru.', 'proyek',   'sedang',  1, '2026-06-20', '17:00', 'Masih menunggu approval budget', 2, 'draft', '2026-05-30 08:00:00', '2026-05-30 08:00:00'),
(18, 'Troubleshoot Jaringan FO Telkom Akses',      'Siapkan prosedur troubleshooting untuk gangguan jaringan fiber optik di Telkom Akses area Lampung.', 'kelompok', 'tinggi',  3, '2026-06-18', '15:00', 'Draft - belum dipublish', 6, 'draft', '2026-05-30 10:00:00', '2026-05-30 10:00:00'),
(19, 'Audit Keamanan Data Pelanggan',              'Lakukan audit terhadap keamanan penyimpanan data pelanggan sesuai standar ISO 27001.', 'proyek',   'tinggi',  2, '2026-06-25', '17:00', NULL, 4, 'draft', '2026-05-31 08:00:00', '2026-05-31 08:00:00'),
(20, 'Penyusunan Materi Briefing Pagi',            'Siapkan materi briefing pagi untuk minggu depan. Tema: pencapaian target bulanan dan rencana aksi.', 'individu', 'rendah',  1, '2026-06-22', '08:00', NULL, 3, 'draft', '2026-05-31 14:00:00', '2026-05-31 14:00:00');

-- ============================================================
-- LANGKAH 9: Insert Task Assignees (penugasan pelaksana ke tugas)
-- ============================================================
INSERT INTO `task_assignees` (`task_id`, `user_id`, `created_at`, `updated_at`) VALUES
-- Task 1 (completed, kelompok, divisi 1) - 5 pelaksana
(1, 7,  NOW(), NOW()), (1, 8,  NOW(), NOW()), (1, 9,  NOW(), NOW()), (1, 10, NOW(), NOW()), (1, 11, NOW(), NOW()),
-- Task 2 (completed, individu, divisi 2) - 3 pelaksana
(2, 18, NOW(), NOW()), (2, 19, NOW(), NOW()), (2, 20, NOW(), NOW()),
-- Task 3 (completed, individu, divisi 1) - 2 pelaksana
(3, 12, NOW(), NOW()), (3, 13, NOW(), NOW()),
-- Task 4 (completed, individu, divisi 2) - 2 pelaksana
(4, 21, NOW(), NOW()), (4, 22, NOW(), NOW()),
-- Task 5 (completed, kelompok, divisi 3) - 4 pelaksana
(5, 29, NOW(), NOW()), (5, 30, NOW(), NOW()), (5, 31, NOW(), NOW()), (5, 32, NOW(), NOW()),
-- Task 6 (completed, kelompok, divisi 1) - 5 pelaksana
(6, 14, NOW(), NOW()), (6, 15, NOW(), NOW()), (6, 16, NOW(), NOW()), (6, 17, NOW(), NOW()), (6, 37, NOW(), NOW()),

-- Task 7 (active, proyek, divisi 2) - 6 pelaksana → PENDING
(7, 23, NOW(), NOW()), (7, 24, NOW(), NOW()), (7, 25, NOW(), NOW()), (7, 26, NOW(), NOW()), (7, 27, NOW(), NOW()), (7, 28, NOW(), NOW()),
-- Task 8 (active, individu, divisi 3) - 3 pelaksana → PENDING
(8, 33, NOW(), NOW()), (8, 34, NOW(), NOW()), (8, 35, NOW(), NOW()),
-- Task 9 (active, kelompok, divisi 1) - 4 pelaksana → PENDING
(9, 38, NOW(), NOW()), (9, 39, NOW(), NOW()), (9, 49, NOW(), NOW()), (9, 55, NOW(), NOW()),
-- Task 10 (active, individu, divisi 2) - 3 pelaksana → PENDING
(10, 41, NOW(), NOW()), (10, 42, NOW(), NOW()), (10, 43, NOW(), NOW()),
-- Task 11 (active, individu, divisi 1) - 3 pelaksana → PENDING
(11, 44, NOW(), NOW()), (11, 50, NOW(), NOW()), (11, 40, NOW(), NOW()),
-- Task 12 (active, proyek, divisi 3) - 4 pelaksana → PENDING
(12, 45, NOW(), NOW()), (12, 46, NOW(), NOW()), (12, 47, NOW(), NOW()), (12, 48, NOW(), NOW()),
-- Task 13 (active, individu, divisi 2) - 3 pelaksana → PENDING
(13, 51, NOW(), NOW()), (13, 56, NOW(), NOW()), (13, 52, NOW(), NOW()),
-- Task 14 (active, kelompok, divisi 1) - 5 pelaksana → PENDING
(14, 7,  NOW(), NOW()), (14, 9,  NOW(), NOW()), (14, 11, NOW(), NOW()), (14, 37, NOW(), NOW()), (14, 49, NOW(), NOW()),
-- Task 15 (active, individu, divisi 3) - 3 pelaksana → PENDING
(15, 36, NOW(), NOW()), (15, 53, NOW(), NOW()), (15, 54, NOW(), NOW()),
-- Task 16 (active, individu, divisi 2) - 2 pelaksana → PENDING
(16, 20, NOW(), NOW()), (16, 27, NOW(), NOW()),

-- Task 17 (draft, proyek, divisi 1) - 3 pelaksana
(17, 8,  NOW(), NOW()), (17, 10, NOW(), NOW()), (17, 14, NOW(), NOW()),
-- Task 18 (draft, kelompok, divisi 3) - 3 pelaksana
(18, 29, NOW(), NOW()), (18, 33, NOW(), NOW()), (18, 45, NOW(), NOW()),
-- Task 19 (draft, proyek, divisi 2) - 2 pelaksana
(19, 18, NOW(), NOW()), (19, 26, NOW(), NOW()),
-- Task 20 (draft, individu, divisi 1) - 1 pelaksana
(20, 15, NOW(), NOW());

-- ============================================================
-- LANGKAH 10: Insert Task Submissions
-- - Completed tasks → graded (ada nilai, sudah di-review)
-- - Active tasks → SEMUA PENDING (pelaksana bisa submit sendiri!)
-- - Draft tasks → pending
-- ============================================================
INSERT INTO `task_submissions` (`task_id`, `user_id`, `status`, `file_nama`, `file_path`, `file_ukuran`, `nilai`, `komentar`, `submitted_at`, `created_at`, `updated_at`) VALUES

-- =============================================
-- COMPLETED TASKS (sudah dinilai - riwayat)
-- =============================================

-- Task 1 (completed) - semua graded
(1, 7,  'graded', 'laporan_mapping_001.pdf', 'submissions/laporan_mapping_001.pdf', 25600, 85, 'Kerja bagus, data cukup lengkap', '2026-05-09 14:30:00', '2026-05-01 08:00:00', '2026-05-10 10:00:00'),
(1, 8,  'graded', 'laporan_mapping_002.pdf', 'submissions/laporan_mapping_002.pdf', 31200, 90, 'Sangat detail dan rapi', '2026-05-09 16:00:00', '2026-05-01 08:00:00', '2026-05-10 10:30:00'),
(1, 9,  'graded', 'laporan_mapping_003.pdf', 'submissions/laporan_mapping_003.pdf', 18400, 78, 'Masih ada data yang kurang', '2026-05-10 08:00:00', '2026-05-01 08:00:00', '2026-05-10 11:00:00'),
(1, 10, 'graded', 'laporan_mapping_004.pdf', 'submissions/laporan_mapping_004.pdf', 22100, 82, NULL, '2026-05-09 10:00:00', '2026-05-01 08:00:00', '2026-05-10 11:30:00'),
(1, 11, 'graded', 'laporan_mapping_005.pdf', 'submissions/laporan_mapping_005.pdf', 27800, 88, 'Excellent work!', '2026-05-10 11:00:00', '2026-05-01 08:00:00', '2026-05-10 14:00:00'),

-- Task 2 (completed) - semua graded
(2, 18, 'graded', 'rekap_tagihan_natar.xlsx', 'submissions/rekap_tagihan_natar.xlsx', 45000, 92, 'Data sangat akurat', '2026-05-11 15:00:00', '2026-05-03 09:00:00', '2026-05-12 09:00:00'),
(2, 19, 'graded', 'rekap_tagihan_natar_2.xlsx', 'submissions/rekap_tagihan_natar_2.xlsx', 38500, 75, 'Beberapa kolom belum terisi', '2026-05-12 10:00:00', '2026-05-03 09:00:00', '2026-05-12 14:00:00'),
(2, 20, 'graded', 'rekap_tagihan_natar_3.xlsx', 'submissions/rekap_tagihan_natar_3.xlsx', 41200, 88, 'Bagus, lanjutkan', '2026-05-11 09:00:00', '2026-05-03 09:00:00', '2026-05-12 14:30:00'),

-- Task 3 (completed) - graded
(3, 12, 'graded', 'laporan_visiting.pdf', 'submissions/laporan_visiting.pdf', 15600, 80, 'Laporan kunjungan cukup baik', '2026-05-14 13:00:00', '2026-05-05 10:00:00', '2026-05-15 08:00:00'),
(3, 13, 'graded', 'laporan_visiting_2.pdf', 'submissions/laporan_visiting_2.pdf', 19300, 95, 'Sangat detail, komitmen pelanggan tercatat semua', '2026-05-13 16:00:00', '2026-05-05 10:00:00', '2026-05-15 09:00:00'),

-- Task 4 (completed) - graded
(4, 21, 'graded', 'data_prospek_b2b.csv', 'submissions/data_prospek_b2b.csv', 8900, 70, 'Data kurang lengkap, perbaiki lagi', '2026-05-17 11:00:00', '2026-05-08 08:30:00', '2026-05-18 10:00:00'),
(4, 22, 'graded', 'data_prospek_b2b_2.csv', 'submissions/data_prospek_b2b_2.csv', 12400, 86, NULL, '2026-05-16 15:00:00', '2026-05-08 08:30:00', '2026-05-18 10:30:00'),

-- Task 5 (completed) - graded
(5, 29, 'graded', 'database_perangkat.xlsx', 'submissions/database_perangkat.xlsx', 52000, 91, 'Data sangat lengkap', '2026-05-19 14:00:00', '2026-05-10 07:00:00', '2026-05-20 08:00:00'),
(5, 30, 'graded', 'database_perangkat_2.xlsx', 'submissions/database_perangkat_2.xlsx', 48700, 84, 'Ada beberapa perangkat yang belum tercatat', '2026-05-19 16:00:00', '2026-05-10 07:00:00', '2026-05-20 09:00:00'),
(5, 31, 'graded', 'database_perangkat_3.xlsx', 'submissions/database_perangkat_3.xlsx', 50100, 87, NULL, '2026-05-20 08:00:00', '2026-05-10 07:00:00', '2026-05-20 10:00:00'),
(5, 32, 'graded', 'database_perangkat_4.xlsx', 'submissions/database_perangkat_4.xlsx', 46300, 79, 'Kurang teliti di bagian ODC', '2026-05-18 17:00:00', '2026-05-10 07:00:00', '2026-05-20 10:30:00'),

-- Task 6 (completed) - graded
(6, 14, 'graded', 'caring_vip_report.pdf', 'submissions/caring_vip_report.pdf', 33000, 93, 'Sangat profesional!', '2026-05-21 15:00:00', '2026-05-12 09:00:00', '2026-05-22 08:00:00'),
(6, 15, 'graded', 'caring_vip_report_2.pdf', 'submissions/caring_vip_report_2.pdf', 29500, 88, 'Baik, pelanggan puas', '2026-05-22 10:00:00', '2026-05-12 09:00:00', '2026-05-22 14:00:00'),
(6, 16, 'graded', 'caring_vip_report_3.pdf', 'submissions/caring_vip_report_3.pdf', 31800, 76, 'Beberapa pelanggan belum terhubungi', '2026-05-21 17:00:00', '2026-05-12 09:00:00', '2026-05-22 14:30:00'),
(6, 17, 'graded', 'caring_vip_report_4.pdf', 'submissions/caring_vip_report_4.pdf', 27600, 85, NULL, '2026-05-22 08:00:00', '2026-05-12 09:00:00', '2026-05-22 15:00:00'),
(6, 37, 'graded', 'caring_vip_report_5.pdf', 'submissions/caring_vip_report_5.pdf', 35200, 90, 'Kerja sama tim yang baik', '2026-05-21 14:00:00', '2026-05-12 09:00:00', '2026-05-22 15:30:00'),

-- =============================================
-- ACTIVE TASKS - SEMUA PENDING (bisa diisi sendiri!)
-- =============================================

-- Task 7 (active) - beberapa sudah submit
(7, 23, 'submitted', 'hasil_kerja.pdf', 'submissions/hasil_kerja.pdf', 12000, NULL, NULL, '2026-05-21 10:00:00', '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(7, 24, 'submitted', 'hasil_kerja2.pdf', 'submissions/hasil_kerja2.pdf', 10500, NULL, NULL, '2026-05-21 11:30:00', '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(7, 25, 'late', 'hasil_kerja_telat.pdf', 'submissions/hasil_kerja_telat.pdf', 15000, NULL, NULL, '2026-05-22 14:00:00', '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(7, 26, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(7, 27, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(7, 28, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),

-- Task 8 (active) - variasi status
(8, 33, 'working', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-22 07:30:00', '2026-05-22 07:30:00'),
(8, 34, 'returned', NULL, NULL, 0, NULL, 'Laporan tidak sesuai format, harap perbaiki.', NULL, '2026-05-22 07:30:00', '2026-05-22 07:30:00'),
(8, 35, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-22 07:30:00', '2026-05-22 07:30:00'),

-- Task 9 (active) - semua pending
(9, 38, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 09:00:00', '2026-05-25 09:00:00'),
(9, 39, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 09:00:00', '2026-05-25 09:00:00'),
(9, 49, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 09:00:00', '2026-05-25 09:00:00'),
(9, 55, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 09:00:00', '2026-05-25 09:00:00'),

-- Task 10 (active) - semua pending
(10, 41, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 10:00:00', '2026-05-25 10:00:00'),
(10, 42, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 10:00:00', '2026-05-25 10:00:00'),
(10, 43, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-25 10:00:00', '2026-05-25 10:00:00'),

-- Task 11 (active) - semua pending
(11, 44, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-26 08:00:00', '2026-05-26 08:00:00'),
(11, 50, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-26 08:00:00', '2026-05-26 08:00:00'),
(11, 40, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-26 08:00:00', '2026-05-26 08:00:00'),

-- Task 12 (active) - semua pending
(12, 45, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-27 09:00:00', '2026-05-27 09:00:00'),
(12, 46, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-27 09:00:00', '2026-05-27 09:00:00'),
(12, 47, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-27 09:00:00', '2026-05-27 09:00:00'),
(12, 48, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-27 09:00:00', '2026-05-27 09:00:00'),

-- Task 13 (active) - semua pending
(13, 51, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 08:30:00', '2026-05-28 08:30:00'),
(13, 56, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 08:30:00', '2026-05-28 08:30:00'),
(13, 52, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 08:30:00', '2026-05-28 08:30:00'),

-- Task 14 (active) - semua pending
(14, 7,  'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 10:00:00', '2026-05-28 10:00:00'),
(14, 9,  'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 10:00:00', '2026-05-28 10:00:00'),
(14, 11, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 10:00:00', '2026-05-28 10:00:00'),
(14, 37, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 10:00:00', '2026-05-28 10:00:00'),
(14, 49, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-28 10:00:00', '2026-05-28 10:00:00'),

-- Task 15 (active) - semua pending
(15, 36, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(15, 53, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),
(15, 54, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-20 08:00:00', '2026-05-20 08:00:00'),

-- Task 16 (active) - semua pending
(16, 20, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-18 09:00:00', '2026-05-18 09:00:00'),
(16, 27, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-18 09:00:00', '2026-05-18 09:00:00'),

-- =============================================
-- DRAFT TASKS - semua pending
-- =============================================
(17, 8,  'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 08:00:00', '2026-05-30 08:00:00'),
(17, 10, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 08:00:00', '2026-05-30 08:00:00'),
(17, 14, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 08:00:00', '2026-05-30 08:00:00'),
(18, 29, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 10:00:00', '2026-05-30 10:00:00'),
(18, 33, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 10:00:00', '2026-05-30 10:00:00'),
(18, 45, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-30 10:00:00', '2026-05-30 10:00:00'),
(19, 18, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-31 08:00:00', '2026-05-31 08:00:00'),
(19, 26, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-31 08:00:00', '2026-05-31 08:00:00'),
(20, 15, 'pending', NULL, NULL, 0, NULL, NULL, NULL, '2026-05-31 14:00:00', '2026-05-31 14:00:00');

-- ============================================================
-- LANGKAH 11: Aktifkan kembali foreign key check
-- ============================================================
SET FOREIGN_KEY_CHECKS = 1;
-- ============================================================
-- RINGKASAN DATA YANG DI-INSERT:
-- ============================================================
-- Roles:                 3 records (admin, pembimbing, pelaksana)
-- Divisi:                3 records (SSGS, BGES, HERO)
-- Users:                60 records (5 Admin + 5 Pembimbing + 50 Pelaksana)
-- Attendances:          21 records (21 hari kerja: 1-29 Mei 2026)
-- Attendance Assignees: 1050 records (50 pelaksana × 21 hari)
-- Tasks:                20 records (6 completed, 10 active, 4 draft)
-- Task Assignees:       68 records
-- Task Submissions:     68 records (23 graded + variasi status)
-- ============================================================
-- 
-- STATUS DATA UNTUK PRESENTASI:
-- ============================================================
-- ✅ Absensi Hari 1-15:  TERISI dengan variasi (Hadir/Terlambat/Izin/Sakit)
-- ✅ Absensi Hari 16-21: KOSONG (Belum Mengisi) → untuk demo live
-- ✅ Tugas 1-6:   COMPLETED + GRADED (sudah dinilai, ada riwayat)
-- ✅ Tugas 7:     ACTIVE → 2 submitted, 1 late, 3 pending
-- ✅ Tugas 8:     ACTIVE → 1 working, 1 returned, 1 pending
-- ✅ Tugas 9-16:  ACTIVE → semua pending (bisa disubmit saat demo)
-- ✅ Tugas 17-20: DRAFT → untuk demo publish oleh pembimbing
--
-- AKUN LOGIN UNTUK TESTING:
-- ============================================================
-- Admin (Default):  admin@penugasanpkl.com                  / password
-- Admin (ITERA):    eko.nugroho@if.itera.ac.id              / password
-- Admin (ITERA):    muhammad.algifari@if.itera.ac.id        / password
-- Admin (ITERA):    firman.ashari@if.itera.ac.id            / password
-- Admin (ITERA):    cahyo.untoro@if.itera.ac.id             / password
-- Pembimbing 1-5:   pembimbing1@penugasanpkl.com dsk.       / password
-- Pelaksana 1-50:   pelaksana1@penugasanpkl.com dsk.        / password
-- ============================================================
