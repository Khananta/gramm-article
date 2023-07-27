-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2023 at 04:13 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artikel`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'nadiv@gmail.com', 1, '2023-07-07 01:31:58', 1),
(2, '::1', 'nadiv@gmail.com', 1, '2023-07-07 01:32:53', 1),
(3, '::1', 'nadiv@gmail.com', 1, '2023-07-07 01:38:18', 1),
(4, '::1', 'nadiv@gmail.com', 1, '2023-07-07 01:52:35', 1),
(5, '::1', 'nadiv@gmail.com', 1, '2023-07-07 07:00:48', 1),
(6, '::1', 'nadiv@gmail.com', 1, '2023-07-07 07:43:02', 1),
(7, '::1', 'nadiv@gmail.com', 1, '2023-07-07 07:53:19', 1),
(8, '::1', 'nadiv@gmail.com', 1, '2023-07-07 08:15:02', 1),
(9, '::1', 'guest', NULL, '2023-07-10 01:28:39', 0),
(10, '::1', 'nadiv@gmail.com', 1, '2023-07-10 01:28:45', 1),
(11, '::1', 'nadiv@gmail.com', 1, '2023-07-10 03:13:24', 1),
(12, '::1', 'nadiv@gmail.com', 1, '2023-07-10 03:16:10', 1),
(13, '::1', 'guest', NULL, '2023-07-10 07:54:43', 0),
(14, '::1', 'guest', NULL, '2023-07-10 07:54:49', 0),
(15, '::1', 'nadiv@gmail.com', 1, '2023-07-10 07:54:57', 1),
(16, '::1', 'nadiv@gmail.com', 1, '2023-07-10 08:54:06', 1),
(17, '::1', 'nadiv@gmail.com', 1, '2023-07-11 02:14:26', 1),
(18, '::1', 'nadiv@gmail.com', 1, '2023-07-18 01:24:53', 1),
(19, '::1', 'nadiv@gmail.com', 1, '2023-07-18 01:25:05', 1),
(20, '::1', 'nadiv@gmail.com', 1, '2023-07-18 01:48:58', 1),
(21, '::1', 'nadiv@gmail.com', 1, '2023-07-18 01:59:04', 1),
(22, '::1', 'nadiv@gmail.com', 1, '2023-07-18 02:02:10', 1),
(23, '::1', 'nadiv@gmail.com', 1, '2023-07-18 02:24:37', 1),
(24, '::1', 'nadiv@gmail.com', 1, '2023-07-18 06:23:17', 1),
(25, '::1', 'nadiv@gmail.com', 1, '2023-07-18 06:56:50', 1),
(26, '::1', 'nadiv@gmail.com', 1, '2023-07-20 01:48:06', 1),
(27, '::1', 'nadiv@gmail.com', 1, '2023-07-20 07:11:00', 1),
(28, '::1', 'guest', NULL, '2023-07-20 07:11:19', 0),
(29, '::1', 'nadiv@gmail.com', 1, '2023-07-20 07:11:27', 1),
(30, '::1', 'nadiv@gmail.com', 1, '2023-07-20 07:35:03', 1),
(31, '::1', 'nadiv@gmail.com', 1, '2023-07-20 08:30:24', 1),
(32, '::1', 'nadiv@gmail.com', 1, '2023-07-21 02:23:00', 1),
(33, '::1', 'nadiv@gmail.com', 1, '2023-07-21 08:50:15', 1),
(34, '::1', 'nadiv@gmail.com', 1, '2023-07-23 04:49:25', 1),
(35, '::1', 'nadiv@gmail.com', 1, '2023-07-24 01:48:00', 1),
(36, '::1', 'nadiv@gmail.com', 1, '2023-07-24 06:07:58', 1),
(37, '::1', 'guest', NULL, '2023-07-25 01:48:43', 0),
(38, '::1', 'nadiv@gmail.com', 1, '2023-07-25 01:48:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1688693410, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_artikel`
--

CREATE TABLE `tb_artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_artikel`
--

INSERT INTO `tb_artikel` (`id`, `judul`, `konten`, `gambar`, `timestamp`) VALUES
(45, 'Panduan Dasar UI/UX untuk Meningkatkan Pengalaman Pengguna', '<p>Dalam era digital saat ini, User Interface (UI) dan User Experience (UX) telah menjadi elemen krusial dalam pengembangan produk dan layanan. UI dan UX mencakup desain tampilan antarmuka dan pengalaman pengguna yang berfokus pada kepuasan dan kenyamanan pengguna. Artikel ini akan membahas pengertian, pentingnya, dan beberapa prinsip dasar UI/UX yang dapat membantu meningkatkan pengalaman pengguna secara keseluruhan.</p>\r\n\r\n<p>Apa itu UI dan UX?</p>\r\n\r\n<p>User Interface (UI) merujuk pada segala elemen visual yang berhubungan langsung dengan interaksi pengguna, seperti tata letak, ikon, warna, font, dan elemen-elemen lainnya yang mewakili desain antarmuka. Sementara itu, User Experience (UX) mencakup semua aspek interaksi pengguna dengan produk atau layanan, termasuk aspek emosional, psikologis, dan kesan keseluruhan yang diperoleh pengguna selama menggunakan produk tersebut.</p>\r\n\r\n<p>Pentingnya UI/UX dalam Pengembangan Produk</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Peningkatan Retensi Pengguna: Dengan fokus pada desain yang baik dan pengalaman pengguna yang menyenangkan, produk atau layanan akan lebih mudah diingat oleh pengguna, sehingga meningkatkan tingkat retensi dan keterlibatan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Peningkatan Kepuasan Pengguna: Desain UI/UX yang baik dapat membuat pengguna merasa puas dan senang dalam menggunakan produk atau layanan, membantu membangun citra merek yang positif.</p>\r\n	</li>\r\n	<li>\r\n	<p>Pengurangan Tingkat Peninggalkan Pengguna (Churn): Dengan pengalaman pengguna yang menyenangkan, tingkat peninggalkan pengguna (churn) dapat ditekan. Pengguna akan cenderung lebih setia dan tidak beralih ke produk pesaing.</p>\r\n	</li>\r\n	<li>\r\n	<p>Peningkatan Efisiensi dan Produktivitas: Desain antarmuka yang baik dapat mempercepat tugas-tugas pengguna, meningkatkan efisiensi, dan produktivitas dalam menggunakan produk atau layanan.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Prinsip Dasar UI/UX</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Kesesuaian dengan Tujuan Produk: Desain UI/UX harus selalu disesuaikan dengan tujuan produk atau layanan. Jelas dan konsisten dalam menyajikan informasi yang dibutuhkan pengguna untuk mencapai tujuan mereka.</p>\r\n	</li>\r\n	<li>\r\n	<p>Simplicity (Kesederhanaan): Prinsip kesederhanaan adalah kunci dalam desain UI/UX. Menghindari tampilan yang rumit dan memastikan elemen antarmuka mudah dipahami dan digunakan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Konsistensi: Konsistensi dalam desain antarmuka membantu pengguna beradaptasi dengan cepat karena mereka sudah familiar dengan pola-pola yang sama dalam produk atau layanan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Responsif dan Adaptif: UI/UX harus dirancang agar responsif di berbagai perangkat dan ukuran layar. Pengguna seringkali mengakses produk dari perangkat yang berbeda, dan adaptabilitas akan meningkatkan pengalaman mereka.</p>\r\n	</li>\r\n	<li>\r\n	<p>Fokus pada Navigasi: Navigasi yang baik dan intuitif memastikan pengguna dapat dengan mudah menjelajahi produk atau layanan tanpa kehilangan arah atau merasa kebingungan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Feedback Pengguna: Menyediakan umpan balik yang tepat waktu dan informatif kepada pengguna tentang tindakan yang dilakukan mereka di antarmuka akan membantu mereka memahami proses dan mengurangi kebingungan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Tes Pengguna: Melakukan pengujian produk dengan pengguna nyata dapat membantu mengidentifikasi masalah potensial dalam UI/UX dan mengumpulkan masukan berharga untuk perbaikan lebih lanjut.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Kesimpulan</p>\r\n\r\n<p>UI/UX memainkan peran penting dalam menciptakan produk atau layanan yang sukses dan memuaskan pengguna. Dengan menerapkan prinsip dasar UI/UX, pengembang dapat memastikan desain antarmuka yang menarik dan pengalaman pengguna yang luar biasa. Ingatlah untuk selalu mengutamakan kebutuhan dan keinginan pengguna, karena pengalaman pengguna yang positif akan menjadi kunci kesuksesan produk di pasar yang kompetitif.</p>\r\n', '1689906891_15a9cefd4dda4ea62d92.png', '2023-07-21 02:34:51'),
(46, 'Coding: Menguak Kekuatan di Balik Pemrograman Modern', '<p>Coding, atau pemrograman, adalah proses membuat serangkaian instruksi yang dapat dijalankan oleh komputer untuk mencapai tujuan tertentu. Dalam era digital ini, coding telah menjadi elemen penting dalam hampir setiap aspek kehidupan kita, dari aplikasi dan situs web hingga perangkat elektronik dan kecerdasan buatan. Artikel ini akan mengulas pengertian coding, pentingnya, dan bagaimana pemrograman modern telah membuka peluang tak terbatas bagi kemajuan teknologi.</p>\r\n\r\n<p>Pengertian Coding</p>\r\n\r\n<p>Coding adalah proses menerjemahkan ide atau logika ke dalam bahasa pemrograman yang dapat dimengerti oleh komputer. Bahasa pemrograman adalah instruksi khusus yang digunakan untuk memberikan perintah dan mengatur perilaku komputer. Ada berbagai macam bahasa pemrograman, mulai dari bahasa tingkat rendah seperti Assembly hingga bahasa tingkat tinggi seperti Python, JavaScript, Java, dan banyak lainnya.</p>\r\n\r\n<p>Pentingnya Coding dalam Era Digital</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Penciptaan Aplikasi dan Perangkat Lunak: Coding memungkinkan pengembang untuk menciptakan berbagai jenis aplikasi dan perangkat lunak, termasuk aplikasi seluler, aplikasi web, perangkat lunak bisnis, perangkat lunak kesehatan, dan banyak lagi, yang membantu memenuhi berbagai kebutuhan masyarakat.</p>\r\n	</li>\r\n	<li>\r\n	<p>Inovasi dan Teknologi: Coding adalah kunci untuk inovasi teknologi. Dengan kode yang tepat, para pengembang dapat menciptakan teknologi baru yang dapat mempengaruhi cara kita hidup, bekerja, dan berinteraksi.</p>\r\n	</li>\r\n	<li>\r\n	<p>Pengembangan Web: Situs web yang kita nikmati setiap hari dibangun dengan bantuan coding. Dari tata letak hingga interaktivitas, coding memungkinkan pengembangan situs web modern yang menarik dan responsif.</p>\r\n	</li>\r\n	<li>\r\n	<p>Pengembangan Perangkat Keras (Hardware): Selain perangkat lunak, coding juga digunakan dalam pengembangan perangkat keras, seperti mikrokontroler dan perangkat Internet of Things (IoT).</p>\r\n	</li>\r\n	<li>\r\n	<p>Analisis Data dan Kecerdasan Buatan: Coding menjadi elemen inti dalam analisis data dan implementasi kecerdasan buatan. Algoritma yang ditulis dalam kode membantu komputer untuk mengolah data besar dan mengambil keputusan yang cerdas.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Pemrograman Modern dan Potensinya</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Framework dan Library: Pemrograman modern telah memperkenalkan berbagai framework dan library yang mempercepat proses pengembangan. Contohnya, React dan Angular untuk pengembangan frontend, Django dan Ruby on Rails untuk pengembangan backend, serta TensorFlow dan PyTorch untuk kecerdasan buatan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Mobile Development: Dengan berkembangnya pemrograman seluler, pengembang dapat menciptakan aplikasi mobile lintas platform menggunakan bahasa pemrograman seperti React Native dan Flutter.</p>\r\n	</li>\r\n	<li>\r\n	<p>Cloud Computing: Pemrograman modern telah menghadirkan teknologi cloud computing yang memungkinkan penyimpanan dan pemrosesan data di awan, memberikan skala dan kinerja yang tak terbatas bagi aplikasi dan layanan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Keamanan dan Privasi: Dalam pemrograman modern, kesadaran tentang keamanan dan privasi telah meningkat. Pengembang sekarang harus memperhatikan praktik terbaik untuk melindungi data pengguna dan melawan ancaman siber.</p>\r\n	</li>\r\n	<li>\r\n	<p>Kecerdasan Buatan dan Pembelajaran Mesin: Pemrograman modern telah memungkinkan kemajuan pesat dalam kecerdasan buatan dan pembelajaran mesin, yang mampu mengenali pola kompleks dan membuat prediksi berdasarkan data.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Kesimpulan</p>\r\n\r\n<p>Coding adalah fondasi dari revolusi digital yang kita alami saat ini. Melalui pemrograman, kita telah melihat kemajuan luar biasa dalam teknologi dan inovasi. Dengan pemrograman modern yang semakin kuat dan efisien, batas-batas potensi teknologi semakin berkembang. Bagi siapa pun yang tertarik untuk terlibat dalam dunia teknologi, coding menjadi keterampilan yang sangat berharga dan membuka pintu menuju kemungkinan tak terbatas dalam menciptakan solusi-solusi kreatif untuk berbagai masalah dunia nyata.</p>\r\n', '1689906954_acba1fce2c613a29e9b9.png', '2023-07-21 02:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`) VALUES
(4, 'Sport');

-- --------------------------------------------------------

--
-- Table structure for table `tb_klik`
--

CREATE TABLE `tb_klik` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) DEFAULT NULL,
  `jumlah_klik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'nadiv@gmail.com', 'guest', '$2y$10$hKlyc0sKj2aSEDdMz6ZxnulXMTA9ZZEbpVkOhtDYBpHXiiul16plu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-07-07 01:31:49', '2023-07-07 01:31:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_artikel`
--
ALTER TABLE `tb_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_klik`
--
ALTER TABLE `tb_klik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_artikel`
--
ALTER TABLE `tb_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_klik`
--
ALTER TABLE `tb_klik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_klik`
--
ALTER TABLE `tb_klik`
  ADD CONSTRAINT `tb_klik_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `tb_artikel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
