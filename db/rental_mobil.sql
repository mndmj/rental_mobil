-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jul 2023 pada 22.57
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_user`
--

CREATE TABLE `detail_user` (
  `id_detail_user` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_user`
--

INSERT INTO `detail_user` (`id_detail_user`, `id_user`, `nik`, `nama`, `telepon`, `alamat`, `jk`) VALUES
(1, 2, '331332870820', 'Hartono', '08968746549', 'Krpdn', 'Laki-laki'),
(2, 3, '2524242424', 'aaa', '08979086055', 'aaa', 'Laki-laki'),
(3, 4, '1234567890123456', 'Wahyudi', '082992826252', 'Karanganyar', 'Laki-laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `merk` varchar(30) NOT NULL,
  `foto_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(10) NOT NULL,
  `th_keluaran` int(4) NOT NULL,
  `bahan_bakar` varchar(10) NOT NULL,
  `cc_mobil` varchar(8) NOT NULL,
  `warna_mobil` varchar(8) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `status` enum('Ada','Tidak Ada','Rusak') NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama`, `merk`, `foto_mobil`, `no_polisi`, `th_keluaran`, `bahan_bakar`, `cc_mobil`, `warna_mobil`, `harga_sewa`, `status`, `delete_at`) VALUES
(1, 'Avanza', 'Toyota', '1690393813_592f813b6e81cbf195cf.jpg', 'AD 7657 AJ', 2010, 'Bensin', '1200', 'Hitam', 300000, 'Ada', NULL),
(6, 'Xenia', 'Daihatsu', '', 'AD 4 SP', 2010, 'Bensin', '1000', 'Hitam', 200000, 'Ada', NULL),
(7, 'Gg', 'honda', '1690393452_f39ede9ec7738c301b5c.jpg', 'AD 4 DI', 2010, 'Udara', '90000', 'Hitam St', 300000, 'Ada', '2023-07-27 00:51:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'Pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sopir`
--

CREATE TABLE `sopir` (
  `id_sopir` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sopir`
--

INSERT INTO `sopir` (`id_sopir`, `nik`, `nama`, `alamat`, `telepon`, `delete_at`) VALUES
(1, '2147483647', 'Junet', 'Kulonprogo', '080976456708', NULL),
(2, '008098', 'q', 'q', 'q', '2023-07-10 19:20:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_kembali`
--

CREATE TABLE `transaksi_kembali` (
  `id_kembali` int(11) NOT NULL,
  `id_pinjam` int(11) NOT NULL,
  `tgl_kembali` datetime NOT NULL,
  `kondisi_mobil` text NOT NULL,
  `jml_denda` varchar(30) NOT NULL,
  `mobil_rusak` enum('Iya','Tidak') NOT NULL DEFAULT 'Tidak',
  `kerusakan` text DEFAULT NULL,
  `denda_kerusakan` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_kembali`
--

INSERT INTO `transaksi_kembali` (`id_kembali`, `id_pinjam`, `tgl_kembali`, `kondisi_mobil`, `jml_denda`, `mobil_rusak`, `kerusakan`, `denda_kerusakan`, `created_at`) VALUES
(4, 10, '2023-07-26 12:27:23', 'Baik', '0', 'Tidak', '', 0, '2023-07-26 12:27:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_pinjam`
--

CREATE TABLE `transaksi_pinjam` (
  `id_pinjam` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mobil` int(11) NOT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `status_pinjam` enum('Booking','Dipinjam','Kembali') NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_pesan` datetime NOT NULL,
  `tgl_kembali` datetime NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `jaminan` enum('KTP','SIM C','Passport','KK','Kendaraan Bermotor','BPKB') NOT NULL,
  `sopir` enum('Iya','Tidak') NOT NULL,
  `id_sopir` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_pinjam`
--

INSERT INTO `transaksi_pinjam` (`id_pinjam`, `id_user`, `id_mobil`, `nama_user`, `status_pinjam`, `tgl_pinjam`, `tgl_pesan`, `tgl_kembali`, `telepon`, `jaminan`, `sopir`, `id_sopir`, `created_at`) VALUES
(4, 2, 1, NULL, 'Booking', '2023-07-14 01:24:08', '2023-07-14 01:24:08', '2023-07-15 01:24:08', '', 'KTP', 'Iya', NULL, '2023-07-13 20:24:08'),
(9, NULL, 6, 'rtyu', 'Dipinjam', '2023-07-14 02:54:00', '2023-07-14 02:54:00', '0000-00-00 00:00:00', '08979098608', 'KTP', 'Iya', NULL, NULL),
(10, NULL, 1, 'Haris', 'Kembali', '2023-07-25 21:46:51', '2023-07-25 21:46:51', '2023-07-26 21:46:51', '092992828272', 'BPKB', 'Tidak', NULL, NULL),
(11, NULL, 1, 'Ikhsan', 'Dipinjam', '2023-08-04 10:00:00', '2023-07-26 16:42:53', '2023-08-05 10:00:00', '089790869759', 'KTP', 'Tidak', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `id_role`, `delete_at`) VALUES
(1, 'admin', '12345678', 'admin@gmail.com', 1, NULL),
(2, 'Hartono', '12345678', 'h@g.com', 2, NULL),
(3, 'aaa', '12345678', 'a@gmail.com', 2, NULL),
(4, 'yudist11', '12345678', 'wahyudist123@gma', 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_user`
--
ALTER TABLE `detail_user`
  ADD PRIMARY KEY (`id_detail_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `sopir`
--
ALTER TABLE `sopir`
  ADD PRIMARY KEY (`id_sopir`);

--
-- Indeks untuk tabel `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indeks untuk tabel `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_mobil` (`id_mobil`),
  ADD KEY `id_sopir` (`id_sopir`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_user`
--
ALTER TABLE `detail_user`
  MODIFY `id_detail_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sopir`
--
ALTER TABLE `sopir`
  MODIFY `id_sopir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_user`
--
ALTER TABLE `detail_user`
  ADD CONSTRAINT `detail_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `transaksi_kembali`
--
ALTER TABLE `transaksi_kembali`
  ADD CONSTRAINT `transaksi_kembali_ibfk_2` FOREIGN KEY (`id_pinjam`) REFERENCES `transaksi_pinjam` (`id_pinjam`);

--
-- Ketidakleluasaan untuk tabel `transaksi_pinjam`
--
ALTER TABLE `transaksi_pinjam`
  ADD CONSTRAINT `transaksi_pinjam_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`),
  ADD CONSTRAINT `transaksi_pinjam_ibfk_2` FOREIGN KEY (`id_sopir`) REFERENCES `sopir` (`id_sopir`),
  ADD CONSTRAINT `transaksi_pinjam_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
