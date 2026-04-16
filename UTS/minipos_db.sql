-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Apr 2026 pada 13.42
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
-- Database: `minipos_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`) VALUES
(1, 'Espresso', 15000),
(2, 'Americano (Hot/Ice)', 20000),
(3, 'Cafe Latte', 25000),
(4, 'Cappuccino', 25000),
(5, 'Caramel Macchiato', 30000),
(6, 'Matcha Latte', 28000),
(7, 'Croissant Butter', 20000),
(8, 'Fudgy Brownie', 18000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `total_belanja` int(11) NOT NULL,
  `detail_pesanan` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `total_belanja`, `detail_pesanan`, `tanggal`) VALUES
(9, 161000, '1x Americano (Hot/Ice), 2x Cafe Latte, 1x Cappuccino, 1x Fudgy Brownie, 1x Croissant Butter, 1x Matcha Latte', '2026-04-04 06:49:53'),
(10, 192000, '2x Americano (Hot/Ice), 1x Cafe Latte, 1x Cappuccino, 3x Fudgy Brownie, 1x Croissant Butter, 1x Matcha Latte', '2026-04-04 07:42:25'),
(11, 206000, '1x Americano (Hot/Ice), 1x Cafe Latte, 1x Cappuccino, 4x Croissant Butter, 2x Matcha Latte', '2026-04-04 07:45:29'),
(12, 207000, '3x Matcha Latte, 2x Americano (Hot/Ice), 1x Cafe Latte, 2x Croissant Butter, 1x Fudgy Brownie', '2026-04-04 07:45:43'),
(13, 181000, '1x Espresso, 1x Americano (Hot/Ice), 1x Cafe Latte, 1x Cappuccino, 1x Caramel Macchiato, 1x Matcha Latte, 1x Croissant Butter, 1x Fudgy Brownie', '2026-04-04 07:45:58'),
(14, 513000, '3x Espresso, 3x Americano (Hot/Ice), 2x Cafe Latte, 2x Cappuccino, 3x Caramel Macchiato, 3x Matcha Latte, 4x Croissant Butter, 3x Fudgy Brownie', '2026-04-04 07:46:16'),
(15, 242000, '1x Americano (Hot/Ice), 1x Cafe Latte, 1x Cappuccino, 2x Fudgy Brownie, 1x Croissant Butter, 2x Matcha Latte, 2x Espresso, 1x Caramel Macchiato', '2026-04-04 07:46:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
