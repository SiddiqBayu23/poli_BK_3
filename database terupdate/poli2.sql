-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jan 2024 pada 14.57
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
-- Database: `poli2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(3, 'bejo', '$2y$10$Gv3C4thV4wuw6bkBQej8c.Yyz8psRwUtH6h7lkEdog3/mk1BOG6bG'),
(4, 'sindi', '$2y$10$dPr9DHJ79ilKumBC./1FP.5hjf91FIdbsdM6ROkmsVQNI9Xc7RyTm'),
(6, 'admin', '$2y$10$80f.zcoZK6nnBtDDIasOyuQn8S7Sfh.g3zAER5QO6bByqOXX3Cy82');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status_periksa` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `status_periksa`) VALUES
(1, 2, 1, 'Muntah', 1, 1),
(2, 3, 2, 'Sakit', 2, 1),
(3, 4, 3, 'Sakit Kepala', 3, 1),
(4, 4, 2, 'Batuk, pilek', 3, 0),
(5, 5, 2, 'telinga sakit', 4, 1),
(6, 6, 2, 'Sakit telinga', 5, 1),
(7, 7, 6, 'sakit pikiran karna mau wisuda', 1, 1),
(8, 4, 7, 'Sakit panas', 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(6, 1, 13),
(7, 2, 14),
(14, 5, 13),
(15, 5, 14),
(16, 6, 13),
(19, 7, 14),
(20, 8, 14),
(21, 9, 13),
(22, 10, 14),
(23, 11, 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `password`, `alamat`, `no_hp`, `id_poli`) VALUES
(1, 'dedi', '$2y$10$euw8.UjUmt2nSBf4XtUkWeY5e8kD/s/0JLFBHovEcEjU0NcX9b2TW', 'Semarang', '081392867839', 1),
(4, 'junet', '$2y$10$heUmNVyCSCMjxiiIyqigN.2trVUBX9YoW6hZb0iEL1teC.MTL.TL6', 'Kudus', '081392867839', 2),
(6, 'Farhan Adi', '$2y$10$fKAXj2X0qPyHQ2/1oMeWp.6bobGHZQBqjNi6momCqOXk4hBpkfs6C', 'Semarang', '0813', 1),
(7, 'Bayu', '$2y$10$wHdjd1KdkwVWasBrfWVfqOkblE410FBnjtg4dIHyjiYnj2lrTrby6', 'JL Kemayoran', '082211392227', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `aktif` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `aktif`) VALUES
(6, 7, 'Senin', '20:51:00', '21:51:00', 'N'),
(7, 7, 'Selasa', '21:54:00', '23:54:00', 'N'),
(8, 7, 'Rabu', '03:56:00', '06:56:00', 'N'),
(9, 7, 'Rabu', '20:56:00', '21:56:00', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(13, 'Paramex Pro', '200ml', 90000),
(14, 'Paracetamol Pro', '100ml', 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `password`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(2, 'Paijo', 'paijo', 'Semarang', '1231231231', '0823478589', '202305-001'),
(3, 'ndalio', 'ndalio', 'Sampangan', '237146234', '0823478589', '202305-002'),
(4, 'bayu', '$2y$10$YyBPXWXnSkIBMxmBsbusUu0QZKRzn3EogxUpGxvarODdhaLrzpKUK', 'Semarang', '9384791234', '087778883429', '202312-001'),
(5, 'rendi', '$2y$10$73p4522Z49HMVdfqfYVQ3Ot434pRsMApH0B48XK.4rxHLP/Vpy.6W', 'Jombang', '181093476342', '081231621214', '202312-002'),
(6, 'Dika Pranoto', '$2y$10$OYqBKuKrLBJTWDXxhlzofenug5O2ZhiDfZGQmvviul7gocCsjicEq', 'Solo', '123', '123', '202401-001'),
(7, 'fathur', '$2y$10$Cr4MelU3suen4FbFSyKkCOVyefNdkM3RZQVae2MEsxDI.Y2qNHfbK', 'JL Kemayoran', '33311928171702', '082211392227', '202401-002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 1, '2023-12-26 09:24:50', 'Minum obat', 300000),
(2, 2, '2023-12-26 12:03:35', 'Minum Obate maseeeh ben sehat', 120000),
(5, 6, '2024-01-04 18:46:00', 'Minum obat secara teratur ya', 120000),
(6, 5, '2024-01-04 18:47:00', 'Sering bersihkan telinga dan minum obatnya', 90000),
(7, 3, '2024-01-27 00:14:00', 'Catatan uPDATE', 30000),
(8, 2, '2024-01-10 17:22:00', 'Minum', 180000),
(9, 3, '2024-01-07 19:40:00', 'minum obat nya ya mas', 240000),
(10, 3, '2024-01-07 20:50:00', 'minum obat 5x1 ', 180000),
(11, 7, '2024-01-07 20:52:00', 'diminum obat nya ', 240000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poli Umum', 'Penyakit Umum'),
(2, 'Poli Telinga', 'Mengenai Telinga');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `id_periksa` (`id_periksa`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indeks untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_daftar_poli` (`id_daftar_poli`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `daftar_poli_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `detail_periksa_ibfk_1` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`),
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`);

--
-- Ketidakleluasaan untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD CONSTRAINT `poli_ibfk_1` FOREIGN KEY (`id`) REFERENCES `dokter` (`id_poli`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
