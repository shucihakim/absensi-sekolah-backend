-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jun 2024 pada 17.40
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_murid` int(11) NOT NULL,
  `id_jurnal` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `keterangan` enum('H','S','I','A') NOT NULL,
  `foto` varchar(255) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `alamat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `id_murid`, `id_jurnal`, `id_kelas`, `keterangan`, `foto`, `waktu`, `alamat`, `created_at`, `updated_at`) VALUES
(21, 3, 9, 5, 'H', '1718119068_sample_profile.jpg', '2024-06-11 15:17:48', 'Cianjur, Jawa Barat, Jawa, 43211, Indonesia', '2024-06-11 15:17:48', '2024-06-11 15:17:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nip`, `nama`, `email`, `no_hp`, `password`, `gambar`, `active`, `created_at`, `updated_at`) VALUES
(1, '123', 'Admin Testa', 'admin@gmail.com', '092341', '$2y$12$HM3NVDLBedSqhRF02w7.geiFD31Y/feWP9XDpZKI.ta/CfGxTup06', NULL, 1, '2024-05-29 02:42:17', '2024-06-11 12:32:16'),
(2, '12345', 'Admin Test', 'admin@gmail.cit', '0923415', '$2y$12$V0li8YYky8v2qB6q16.S8eyRJrConxXpP3LUVeMSAFuoAhntY45Au', NULL, 1, '2024-06-01 05:51:03', '2024-06-01 05:51:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('lv:v3.10.1:file:17a55dff-laravel.log:ecf8427e:chunk:0', 'a:16:{i:1718041876;a:1:{s:5:\"ERROR\";a:1:{i:0;i:0;}}i:1718041903;a:1:{s:5:\"ERROR\";a:1:{i:1;i:7426;}}i:1718041911;a:1:{s:5:\"ERROR\";a:1:{i:2;i:14852;}}i:1718041938;a:1:{s:5:\"ERROR\";a:1:{i:3;i:22278;}}i:1718041950;a:1:{s:5:\"ERROR\";a:1:{i:4;i:29704;}}i:1718042008;a:1:{s:5:\"ERROR\";a:1:{i:5;i:37130;}}i:1718042019;a:1:{s:5:\"ERROR\";a:1:{i:6;i:44556;}}i:1718042049;a:1:{s:5:\"ERROR\";a:1:{i:7;i:51982;}}i:1718042086;a:1:{s:5:\"ERROR\";a:1:{i:8;i:59408;}}i:1718042117;a:1:{s:5:\"ERROR\";a:1:{i:9;i:66834;}}i:1718046000;a:1:{s:5:\"ERROR\";a:1:{i:10;i:74260;}}i:1718052813;a:1:{s:5:\"ERROR\";a:1:{i:11;i:80995;}}i:1718119470;a:1:{s:5:\"ERROR\";a:1:{i:12;i:97777;}}i:1718119622;a:1:{s:5:\"ERROR\";a:1:{i:13;i:104520;}}i:1718131623;a:1:{s:5:\"ERROR\";a:1:{i:14;i:119928;}}i:1718134109;a:1:{s:5:\"ERROR\";a:1:{i:15;i:127064;}}}', 1718713723),
('lv:v3.10.1:file:17a55dff-laravel.log:ecf8427e:metadata', 'a:9:{s:5:\"query\";N;s:10:\"identifier\";s:8:\"ecf8427e\";s:26:\"last_scanned_file_position\";i:133527;s:18:\"last_scanned_index\";i:16;s:24:\"next_log_index_to_create\";i:16;s:14:\"max_chunk_size\";i:50000;s:19:\"current_chunk_index\";i:0;s:17:\"chunk_definitions\";a:0:{}s:24:\"current_chunk_definition\";a:5:{s:5:\"index\";i:0;s:4:\"size\";i:16;s:18:\"earliest_timestamp\";i:1718041876;s:16:\"latest_timestamp\";i:1718134109;s:12:\"level_counts\";a:1:{s:5:\"ERROR\";i:16;}}}', 1718713723),
('lv:v3.10.1:file:17a55dff-laravel.log:metadata', 'a:8:{s:4:\"type\";s:7:\"laravel\";s:4:\"name\";s:11:\"laravel.log\";s:4:\"path\";s:60:\"E:\\Data\\Web\\absensi-sekolah-backend\\storage\\logs\\laravel.log\";s:4:\"size\";i:133527;s:18:\"earliest_timestamp\";i:1718041876;s:16:\"latest_timestamp\";i:1718134109;s:26:\"last_scanned_file_position\";i:133527;s:15:\"related_indices\";a:1:{s:8:\"ecf8427e\";a:2:{s:5:\"query\";N;s:26:\"last_scanned_file_position\";i:133527;}}}', 1718713723);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `email`, `no_hp`, `password`, `gambar`, `active`, `created_at`, `updated_at`) VALUES
(1, '51235123', 'Agus', 'agus1@gmail.com', '0812345671', '$2y$12$5xIVJYa5G6v6petAIDPvmuy11.kxAtYDGs//2cgdz7paLz83wUMjG', NULL, 1, '2024-05-29 04:12:11', '2024-05-29 04:12:11'),
(3, '1145', 'Senpai Dadang', 'dadang@gmail.com', '08123465798', '$2y$12$wE6YVTPwFIpJXpJ38oL0LetqYLUXIzHcpQiR4n3veWIzs.i/bQ8/2', 'b91a11af-8ea8-4790-8d46-b9ac100debdd.png', 1, '2024-06-07 09:29:25', '2024-06-07 09:29:25'),
(4, '666', 'GURU 123', 'guru@gmail.com', '123124123123', '$2y$12$3kzV1izKkYLgQx3IeC/KJuGBk2bH0I.1u6JcpQnt/UjJ.KDTSIy8.', 'b91a11af-8ea8-4790-8d46-b9ac100debdd.png', 1, '2024-06-07 14:27:04', '2024-06-11 12:17:20'),
(5, '12345678', 'Guru 1', 'guru1@gmail.com', '08123465791', '$2y$12$oJC7G21tstTPd4qf16fNK.2SeIDLHYqsO9UzjvAH0.N2iJ1Vr7lCm', '8af195ee-d772-4e56-a656-8d61fe9d1797.jpg', 1, '2024-06-10 14:18:57', '2024-06-11 11:56:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `materi` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id`, `id_semester`, `id_kelas`, `id_mapel`, `id_guru`, `jam_masuk`, `jam_keluar`, `materi`, `active`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 1, 1, '07:00:00', '08:40:00', 'Belajar Algoritma', 1, '2024-06-07 11:33:52', '2024-06-07 11:33:52'),
(4, 1, 2, 1, 1, '07:00:00', '08:40:00', 'Belajar Algoritma', 1, '2024-06-07 22:31:53', '2024-06-07 22:31:53'),
(9, 2, 5, 1, 4, '19:35:00', '22:35:00', 'Okelah', 1, '2024-06-11 13:23:51', '2024-06-10 13:35:43'),
(10, 2, 4, 5, 5, '20:21:00', '23:22:00', 'Logaritma', 1, '2024-06-10 14:22:11', '2024-06-10 14:22:22'),
(11, 5, 7, 6, 5, '20:34:00', '22:34:00', 'UUD 1945', 1, '2024-06-10 14:32:49', '2024-06-10 14:34:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_wali` int(11) DEFAULT NULL,
  `id_semester` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `id_wali`, `id_semester`, `nama`, `deskripsi`, `active`, `created_at`, `updated_at`) VALUES
(2, NULL, 1, 'Kelas 10-C', NULL, 1, '2024-05-29 03:34:43', '2024-05-29 03:34:43'),
(3, 3, 2, 'Kelas 10-E', NULL, 1, '2024-05-29 22:09:18', '2024-06-10 11:06:11'),
(4, 1, 2, '10 C', 'Oke', 1, '2024-06-10 10:42:41', '2024-06-10 11:14:30'),
(5, NULL, 2, '9F', NULL, 1, '2024-06-10 11:15:27', '2024-06-10 11:15:27'),
(7, 3, 5, '11-C', 'Kelas 11 C', 1, '2024-06-10 14:28:24', '2024-06-10 14:28:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `id_kelas`, `nama`, `deskripsi`, `jam_masuk`, `jam_keluar`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Pemrograman Dasar', NULL, '07:00:00', '08:40:00', 1, '2024-06-07 11:32:54', '2024-06-07 11:32:54'),
(5, NULL, 'Matematika', 'awdawdwa', '00:50:00', '01:51:00', 1, '2024-06-10 12:51:01', '2024-06-10 12:51:12'),
(6, NULL, 'Pendidikan Kewarganegaraan', NULL, '01:29:00', '04:29:00', 1, '2024-06-10 14:30:11', '2024-06-10 14:30:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_05_27_172206_create_sekolah_table', 1),
(5, '2024_05_27_172414_create_tentang_table', 1),
(6, '2024_05_27_172415_create_admin_table', 1),
(7, '2024_05_27_172415_create_guru_table', 1),
(8, '2024_05_27_172416_create_murid_table', 1),
(9, '2024_05_27_172416_create_ortu_table', 1),
(10, '2024_05_27_172417_create_semester_table', 1),
(15, '2024_05_27_181547_create_personal_access_tokens_table', 1),
(16, '2024_05_27_172418_create_kelas_table', 2),
(17, '2024_05_27_172422_create_jurnal_table', 3),
(19, '2024_05_27_172419_create_absensi_table', 4),
(20, '2024_05_27_172418_create_mapel_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `murid`
--

CREATE TABLE `murid` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `murid`
--

INSERT INTO `murid` (`id`, `id_kelas`, `nis`, `nama`, `email`, `no_hp`, `password`, `gambar`, `active`, `created_at`, `updated_at`) VALUES
(1, 5, '51235123', 'Agus', 'agus523@gmail.com', '0846465651', '$2y$12$qLje.h/28DCglch3CCHi2uDvN6gvWbjqsYMb5Q1kEddEjn7a.geeu', NULL, 1, '2024-05-29 03:35:25', '2024-06-11 12:50:49'),
(2, 5, '512351235', 'Agus2', 'agus5223@gmail.com', '08464656511', '$2y$12$0wdQL4Uu9Uu3NMSMNPkn1e7.oArVoBxgxil/VN6iYaWsI7.udQn1e', NULL, 1, '2024-05-29 03:36:48', '2024-06-11 12:50:45'),
(3, 5, '10216541654165', 'Usa', 'murid@gmail.com', '083516416', '$2y$12$7xH20O9Wz5YAkkRmY.nh0.8CQ0hCUDcQa.k3/Fm2KUm67qKn0CMjy', '749e568c-89f0-4575-8513-669debd2e1ae.jpeg', 1, '2024-06-07 22:47:44', '2024-06-11 12:50:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ortu`
--

CREATE TABLE `ortu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ortu`
--

INSERT INTO `ortu` (`id`, `nama`, `email`, `no_hp`, `password`, `gambar`, `active`, `created_at`, `updated_at`) VALUES
(7, 'Ortu 2', 'ortu2@gmail.com', '045646468468', '$2y$12$3wljhBcHDBazfsnfb18iT.v.j3jjqntgXY/jXBNYgWEO9tvUZcPn2', NULL, 1, '2024-06-10 14:25:55', '2024-06-10 14:25:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `garis_lintang` decimal(10,7) DEFAULT NULL,
  `garis_bujur` decimal(10,7) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `jarak` double DEFAULT 30,
  `id_semester_aktif` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama`, `deskripsi`, `logo`, `garis_lintang`, `garis_bujur`, `alamat`, `jarak`, `id_semester_aktif`, `created_at`, `updated_at`) VALUES
(2, 'SMAN LUWU', '123', NULL, -6.8120090, 107.1325202, 'Cianjur, Jawa Barat, Jawa, 43211, Indonesia', 257.7702702702705, 1, '2024-06-07 13:58:29', '2024-06-10 14:39:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `semester`
--

CREATE TABLE `semester` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `semester`
--

INSERT INTO `semester` (`id`, `nama`, `deskripsi`, `active`, `created_at`, `updated_at`) VALUES
(2, 'Genap 24/25', 'asd', 1, '2024-06-10 10:18:35', '2024-06-10 10:18:35'),
(5, 'Ganjil 23/24', NULL, 1, '2024-06-10 14:27:26', '2024-06-10 14:27:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8KgoAO9Hb44Zes60ViFLOWDZi8532c95mqod5pmq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzNKaDU0R204WTZEcFU1N2VxaG51QXZQMkY1YUh1b3U3U1NRdlZqSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1717441858),
('lJ3iyBeWEumuag7N4H5xBgfChVdpYFCGuS1o9g41', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicVJsdG1TQXhITmlQR2lMSG43SVZrdzVYYXV1YVBwZ0o1TjV2TWhuUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2ctdmlld2VyIjt9fQ==', 1718013296),
('zIyq5gXABvDHtqg0xca2Y6q8RuIvrdjYpprljYRR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVm5GTjNINXlmVUNjbnF6cFZSY3hRcEl6bktZczRQQm1hNm5lMnJyYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2ctdmlld2VyP2ZpbGU9MTdhNTVkZmYtbGFyYXZlbC5sb2ciO319', 1718108919);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tentang`
--

CREATE TABLE `tentang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `teks` text NOT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ortu`
--
ALTER TABLE `ortu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `murid`
--
ALTER TABLE `murid`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ortu`
--
ALTER TABLE `ortu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `semester`
--
ALTER TABLE `semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tentang`
--
ALTER TABLE `tentang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
