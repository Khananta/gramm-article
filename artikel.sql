-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Sep 2023 pada 11.19
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.11

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
-- Struktur dari tabel `datmin`
--

CREATE TABLE `datmin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `tipe` enum('superuser','admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `datmin`
--

INSERT INTO `datmin` (`id`, `nama`, `email`, `username`, `password`, `last_updated`, `status`, `tipe`) VALUES
(10, 'Omar', 'omar@gmail.com', 'papoi', '1234', '2023-09-07 03:08:29', 'aktif', 'superuser'),
(19, 'Khanif', 'khanif@gmail.com', 'guest', '5678', '2023-09-07 02:27:41', 'aktif', 'admin'),
(42, 'Abyan', 'abyan@gmail.com', 'yanra', '9123', '2023-09-07 03:11:53', 'aktif', 'superuser'),
(43, 'Farel', 'shafa@gmail.com', 'syafa', '4567', '2023-09-14 02:04:30', 'aktif', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_artikel`
--

CREATE TABLE `tb_artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_kategori` int(11) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  `pembuat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_artikel`
--

INSERT INTO `tb_artikel` (`id`, `judul`, `konten`, `gambar`, `timestamp`, `id_kategori`, `status`, `last_updated`, `pembuat`) VALUES
(160, 'b', '<p>nnjn</p>\r\n', '1695265780_694d39ae5ea93852a7d1.jpg', '2023-09-21 03:09:40', 178, 'aktif', '2023-09-21 03:09:40', 'Omar'),
(161, 's', '<p>kjk</p>\r\n', '1695272043_0337a2882d7839229fe1.png', '2023-09-21 04:54:03', 168, 'aktif', '2023-09-21 04:54:02', 'Omar'),
(162, 'mml', '<p>kmnkm</p>\r\n', '1695272062_7fef589cab0e674d6da9.jpg', '2023-09-21 04:54:22', 168, 'aktif', '2023-09-21 04:54:22', 'Omar'),
(163, 'desa', '<p>huunj</p>\r\n', '1695272112_25816f0726d355e0d2fd.jpg', '2023-09-21 04:55:12', 168, 'aktif', '2023-09-21 04:55:12', 'Omar'),
(164, 'Abyan Rahman', '<p>Hamba</p>\r\n', '1695279380_add139d724ba7c25f862.jpg', '2023-09-21 06:56:20', 169, 'aktif', '2023-09-21 06:56:20', 'Omar'),
(165, 'Apa itu Kecerdasan Buatan?', '<p>Kecerdasan Buatan (Artificial Intelligence atau AI) adalah bidang ilmu komputer yang bertujuan untuk menciptakan sistem komputer yang dapat melakukan tugas yang biasanya memerlukan kecerdasan manusia. Tujuan utama dari AI adalah untuk mengembangkan algoritma dan model komputer yang mampu belajar dari data, membuat keputusan, memecahkan masalah, dan mengeksekusi tugas-tugas yang umumnya memerlukan pemahaman, penalaran, adaptasi, dan pemrosesan informasi kompleks.</p>\r\n\r\n<p>Ada beberapa pendekatan dalam pengembangan kecerdasan buatan, termasuk:</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Pembelajaran Mesin (Machine Learning): Ini adalah salah satu pendekatan utama dalam AI di mana komputer dilatih untuk belajar dari data. Ini mencakup teknik seperti pengklasifikasi (classification), regresi (regression), pengelompokan (clustering), dan pembelajaran mendalam (deep learning) untuk mengenali pola, membuat prediksi, dan mengambil keputusan.</p>\r\n	</li>\r\n	<li>\r\n	<p>Pengolahan Bahasa Alami (Natural Language Processing atau NLP): NLP adalah subdomain AI yang fokus pada pemahaman dan penghasilan bahasa manusia. Ini digunakan untuk mengembangkan sistem yang dapat berkomunikasi dengan manusia melalui bahasa alami, menerjemahkan bahasa, dan memahami konten teks.</p>\r\n	</li>\r\n	<li>\r\n	<p>Penglihatan Komputer (Computer Vision): Ini adalah bidang AI yang berfokus pada pengembangan sistem yang dapat &quot;melihat&quot; dan memahami dunia visual, seperti pengenalan wajah, pengenalan objek, pengolahan gambar, dan analisis video.</p>\r\n	</li>\r\n	<li>\r\n	<p>Robotika: AI juga digunakan dalam pengembangan robot cerdas yang dapat berinteraksi dengan lingkungan fisik mereka, membuat keputusan berdasarkan data sensor, dan melaksanakan tugas-tugas fisik.</p>\r\n	</li>\r\n	<li>\r\n	<p>Kecerdasan Buatan Kuat (Strong AI): Ini adalah tujuan jangka panjang dalam pengembangan AI, di mana sistem komputer akan memiliki kemampuan intelektual yang sama dengan manusia, termasuk pemahaman bahasa, penalaran, dan kesadaran diri.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>AI memiliki banyak aplikasi di berbagai industri, termasuk otomotif, perbankan, kesehatan, perawatan medis, industri manufaktur, periklanan, dan banyak lagi. Pengembangan AI terus berlanjut dengan cepat, dan teknologi ini memiliki potensi untuk mengubah cara kita bekerja, berkomunikasi, dan menjalani kehidupan sehari-hari.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1695280921_7e79d95ad432e82419da.png', '2023-09-21 07:22:01', 168, 'aktif', '2023-09-21 07:22:01', 'Omar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(500) NOT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `last_updated`, `status`) VALUES
(168, 'Alam', '2023-09-20 04:31:20', 'aktif'),
(169, 'Sport', '2023-09-20 06:35:03', 'aktif'),
(170, 'Pendidikan', '2023-09-20 06:35:11', 'aktif'),
(171, 'Teknologi', '2023-09-20 06:35:18', 'aktif'),
(172, 'Fashion', '2023-09-21 02:38:36', 'aktif'),
(173, 'Religi', '2023-09-20 06:35:32', 'aktif'),
(174, 'Wisata', '2023-09-20 06:35:41', 'aktif'),
(175, 'Olahraga', '2023-09-20 06:35:51', 'aktif'),
(176, 'Kesehatan', '2023-09-20 06:52:49', 'aktif'),
(177, 'Travel', '2023-09-20 06:53:07', 'aktif'),
(178, 'Bisnis', '2023-09-21 03:11:11', 'aktif'),
(189, 'halo', '2023-09-21 03:11:51', 'aktif'),
(190, 'hai', '2023-09-21 03:23:14', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_klik`
--

CREATE TABLE `tb_klik` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) DEFAULT NULL,
  `jumlah_klik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `datmin`
--
ALTER TABLE `datmin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_artikel`
--
ALTER TABLE `tb_artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `tb_klik`
--
ALTER TABLE `tb_klik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `datmin`
--
ALTER TABLE `datmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `tb_artikel`
--
ALTER TABLE `tb_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT untuk tabel `tb_klik`
--
ALTER TABLE `tb_klik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_klik`
--
ALTER TABLE `tb_klik`
  ADD CONSTRAINT `tb_klik_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `tb_artikel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
