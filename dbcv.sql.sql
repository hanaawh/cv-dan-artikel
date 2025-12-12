-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Sep 2025 pada 06.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(2, 'Kehidupan Gen Z di Era Digital', '<p>Generasi Z atau sering disebut&nbsp;<strong>Gen Z</strong> adalah kelompok yang lahir antara tahun 1997 hingga 2012. Mereka tumbuh di tengah pesatnya perkembangan teknologi digital, internet, dan media sosial. Hal ini membuat pola pikir, cara berinteraksi, serta gaya hidup mereka sangat berbeda dibandingkan generasi sebelumnya.</p>\r\n<h2>1. Karakteristik Gen Z</h2>\r\n<p>Gen Z dikenal sebagai generasi yang melek teknologi. Sejak kecil mereka sudah akrab dengan smartphone, media sosial, dan platform digital. Informasi dapat diakses dengan cepat hanya melalui satu genggaman. Selain itu, Gen Z juga memiliki ciri:</p>\r\n<ul>\r\n<li>\r\n<p><strong>Multitasking</strong>: mampu melakukan beberapa hal sekaligus, misalnya belajar sambil mendengarkan musik dan berkomunikasi lewat media sosial.</p>\r\n</li>\r\n<li>\r\n<p><strong>Kreatif dan inovatif</strong>: terbiasa mengekspresikan diri lewat konten digital seperti video, podcast, maupun desain grafis.</p>\r\n</li>\r\n<li>\r\n<p><strong>Mandiri namun kolaboratif</strong>: mereka senang mengembangkan potensi diri, tetapi juga terbuka bekerja sama dalam komunitas.</p>\r\n</li>\r\n</ul>\r\n<h2>2. Kehidupan Sosial dan Media Digital</h2>\r\n<p>Media sosial menjadi bagian penting dalam kehidupan Gen Z. Platform seperti Instagram, TikTok, dan YouTube bukan hanya sarana hiburan, tetapi juga media untuk berbisnis, membangun personal branding, hingga mencari ilmu. Namun, di sisi lain, ketergantungan terhadap media sosial sering menimbulkan masalah seperti kecemasan, FOMO (fear of missing out), atau tekanan untuk tampil sempurna.</p>\r\n<h2>3. Pendidikan dan Karier</h2>\r\n<p>Dalam hal pendidikan, Gen Z lebih terbuka dengan metode belajar online. Mereka menyukai gaya belajar yang fleksibel, interaktif, dan praktis. Untuk karier, banyak dari mereka tidak hanya bercita-cita bekerja di kantor, tetapi juga menjadi freelancer, content creator, hingga entrepreneur muda. Fleksibilitas dan kebebasan waktu adalah hal yang sangat dihargai oleh Gen Z.</p>\r\n<h2>4. Tantangan yang Dihadapi</h2>\r\n<p>Meski terlihat canggih dan modern, Gen Z menghadapi berbagai tantangan, antara lain:</p>\r\n<ul>\r\n<li>\r\n<p><strong>Tekanan mental</strong> akibat persaingan di dunia digital.</p>\r\n</li>\r\n<li>\r\n<p><strong>Overload informasi</strong>, sehingga sulit membedakan mana berita benar dan mana yang hoaks.</p>\r\n</li>\r\n<li>\r\n<p><strong>Kurangnya interaksi nyata</strong>, karena komunikasi lebih banyak dilakukan melalui dunia maya.</p>\r\n</li>\r\n</ul>\r\n<h2>5. Harapan dan Masa Depan Gen Z</h2>\r\n<p>Gen Z memiliki potensi besar untuk menjadi agen perubahan. Dengan kreativitas, kepedulian sosial, dan keterampilan digital yang tinggi, mereka bisa mendorong lahirnya inovasi baru di berbagai bidang. Asalkan mampu mengelola waktu, menjaga kesehatan mental, dan menggunakan teknologi secara bijak, Gen Z dapat menjadi generasi yang berdaya saing dan memberi dampak positif bagi masyarakat.</p>', '68d37231ee177.jpg', '2025-09-24 04:23:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$8.f.114.E2j.6R.H8g7s3u5wz2.N.Z.f.Y.Z.X.Y.Z.X.Y.Z');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
