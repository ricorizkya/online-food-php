-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 11 Jul 2025 pada 23.01
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinefoodphp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', '', '2022-05-27 13:21:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(1, 1, 'Bandeng Presto Pepes', 'Hasil inovasi dari bandeng duri lunak, pepes bandeng presto dengan perpaduan bumbu pedas rempah khas semarang.', 50000, 'pepes.jpg'),
(2, 1, 'Bandeng Presto', 'Bandeng isi tanpa duri dengan bumbu tambahan khas di dalamnya. Tanpa sambal', 50000, 'PRESTO.jpg'),
(3, 1, 'Nasi Tumpeng', 'Tumpengan sudah menjadi tradisi masyarakat Indonesia. Untuk perayaan dan event event tertentu tumpeng menjadi suatu simbolis. Nah., nggak mau ribet ribet masak?, sekarang kamu bisa custom order TUMPENG MINI disini untuk ev', 100000, '6782c9ac021b4.jpg'),
(4, 1, 'Otak Otak Bandeng', 'Kreasi menu otak-otak bandeng. Cocok disajikan untuk event tertentu', 25000, 'OTAK.jpg'),
(5, 1, 'Nugget Bandeng', 'OUR NEWEST PRODUCT!Siap siap merasakan renyah dan krispi NUGGET BANDENG produk terbaru hasil inovasi olahan ikan bandeng. Sangat praktis dan cocok disajikan untuk menu sahur dan berbuka puasa. Go get it now !', 25000, '6782c93fda642.jpg'),
(6, 1, 'Bandeng Presto Paket Lengkap', 'Bandeng isi tanpa duri dengan bumbu tambahan khas di dalamnya. Penyajian produk ini dilengkapi dengan sambal.', 60000, '6782c98ecff80.jpg'),
(17, 1, 'Sambal', 'Dari bahan bahan pilihan dan diracik dengan sedemikian rupa, jadilah sambal dengan kelezatan cita rasa khas. Pedasnya membuat kita ingin mencoba lagi dan lagi.', 5000, '6782c16360935.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 2, 'in process', 'none', '2022-05-01 05:17:49'),
(2, 3, 'in process', 'none', '2022-05-27 11:01:30'),
(3, 2, 'closed', 'thank you for your order!', '2022-05-27 11:11:41'),
(4, 3, 'closed', 'none', '2022-05-27 11:42:35'),
(5, 4, 'in process', 'none', '2022-05-27 11:42:55'),
(6, 1, 'rejected', 'none', '2022-05-27 11:43:26'),
(7, 7, 'in process', 'none', '2022-05-27 13:03:24'),
(8, 8, 'in process', 'none', '2022-05-27 13:03:38'),
(9, 9, 'rejected', 'thank you', '2022-05-27 13:03:53'),
(10, 7, 'closed', 'thank you for your ordering with us', '2022-05-27 13:04:33'),
(11, 8, 'closed', 'thanks ', '2022-05-27 13:05:24'),
(12, 5, 'closed', 'none', '2022-05-27 13:18:03'),
(13, 10, 'in process', 'dalam perjalanan', '2025-01-09 19:53:21'),
(14, 16, 'closed', 'barang dikemas', '2025-01-13 23:02:30'),
(15, 16, 'in process', 'perjalanan', '2025-01-13 23:02:46'),
(16, 22, 'in process', 'OTW', '2025-06-15 15:10:09'),
(17, 34, 'on the way', 'OTW GES', '2025-07-04 16:22:05'),
(18, 34, 'on the way', 'asdasda', '2025-07-04 16:23:29'),
(19, 34, 'on the way', 'OTW COK', '2025-07-04 16:29:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(1, 1, 'Bandeng Bu Darmono', 'minamakmurid@gmail.com', '08122842048', 'https://www.instagram.com/minamakmurid/', '7am', '9pm', 'mon-sat', 'Jl. Purwosari IV No. 17 Tambakrejo, Semarang, Indonesia 50174', 'TOKO.jpg', '2025-01-14 20:52:30'),
(5, 0, 'Segera Datang', 'Udminamakmur@gmail.com', '08122842048', 'https://www.instagram.com/minamakmurid/', '7am', '9pm', 'mon-sat', 'semarang', 'TOKO.jpg', '2025-01-13 20:59:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(1, 'Continental', '2022-05-27 08:07:35'),
(2, 'Italian', '2021-04-07 08:45:23'),
(3, 'Chinese', '2021-04-07 08:45:25'),
(4, 'American', '2021-04-07 08:45:28'),
(5, 'Bandeng Presto', '2025-01-13 22:47:07'),
(7, 'Makanan Khas jawa', '2025-01-14 13:40:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `city`, `province`, `address`, `status`, `date`) VALUES
(12, 'username', 'user', 'name', 'username@gmail.com', '082144285606', 'e3a05ffa5d0c9d0fd7e4a9e131295919', 'Yogyakarta', 'DI Yogyakarta', 'Jl. Kreteg Abang, Area Sawah, Sidoluhur, Kec. Godean, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55264', 1, '2025-07-01 13:25:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `items` text NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `name_shipping` varchar(255) NOT NULL,
  `phone_shipping` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `bukti_tf` varchar(255) DEFAULT NULL,
  `resi` varchar(155) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `items`, `ongkir`, `total`, `status`, `name_shipping`, `phone_shipping`, `shipping_address`, `date`, `payment_method`, `bank`, `bukti_tf`, `resi`, `catatan`) VALUES
(34, 12, '[{\"id\":1,\"title\":\"Bandeng Presto Pepes\",\"quantity\":2,\"price\":50000},{\"id\":17,\"title\":\"Sambal\",\"quantity\":1,\"price\":5000},{\"id\":5,\"title\":\"Nugget Bandeng\",\"quantity\":1,\"price\":25000}]', 25000, 155000, 'on the way', 'user name', '082144285606', 'Jl. Kreteg Abang, Area Sawah, Sidoluhur, Kec. Godean, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55264', '2025-07-04 16:29:17', 'COD', '', '', '', 'OTW COK'),
(36, 12, '[{\"id\":2,\"title\":\"Bandeng Presto\",\"quantity\":2,\"price\":50000},{\"id\":17,\"title\":\"Sambal\",\"quantity\":2,\"price\":5000}]', 25000, 135000, 'Menunggu Konfirmasi Pembayaran', 'user name', '082144285606', 'Jl. Kreteg Abang, Area Sawah, Sidoluhur, Kec. Godean, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55264', '2025-07-02 15:56:43', 'TF', 'adasda - 123123 - asdasassda', 'uploads/bukti_tf/bukti_tf_36_1751471803.png', '', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indeks untuk tabel `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indeks untuk tabel `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indeks untuk tabel `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indeks untuk tabel `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
