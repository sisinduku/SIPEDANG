-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 05:48 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_sipedang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_pengelola`
--

CREATE TABLE IF NOT EXISTS `tbl_data_pengelola` (
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_data_pengelola`
--

INSERT INTO `tbl_data_pengelola` (`username`, `password`, `email`) VALUES
('administrator', '$2a$10$ds3jiEqNIM65u5Qu.wAhhOa6kD6TtLlHT59mZA0TbNCEdz93wmtPG', 'nurhardyanto@if.undip.ac.id');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_data_reservasi`
--

CREATE TABLE IF NOT EXISTS `tbl_data_reservasi` (
  `idReservasi` int(64) NOT NULL AUTO_INCREMENT,
  `kodeReservasi` varchar(64) NOT NULL,
  `namaTamu` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `kontak` varchar(16) NOT NULL,
  `kegiatan` varchar(128) NOT NULL,
  `gambar` varchar(256) DEFAULT NULL,
  `waktuMulaiPinjam` datetime NOT NULL,
  `waktuSelesaiPinjam` datetime NOT NULL,
  `waktuReservasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `penyelenggara` varchar(32) NOT NULL,
  `kategoriKegiatan` tinyint(8) NOT NULL,
  `deskripsiKegiatan` text,
  `statusReservasi` tinyint(8) NOT NULL DEFAULT '0' COMMENT '0:pending|1:expired|2:accepted|3:rejected',
  `expireTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`idReservasi`),
  UNIQUE KEY `kodeReservasi` (`kodeReservasi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_data_reservasi`
--

INSERT INTO `tbl_data_reservasi` (`idReservasi`, `kodeReservasi`, `namaTamu`, `email`, `kontak`, `kegiatan`, `gambar`, `waktuMulaiPinjam`, `waktuSelesaiPinjam`, `waktuReservasi`, `penyelenggara`, `kategoriKegiatan`, `deskripsiKegiatan`, `statusReservasi`, `expireTime`) VALUES
(1, '001pklseza', 'Seza Dio F.', 'seza.dio@gmail.com', '+6285729088683', 'Seminar PKL "Sistem Informasi kegiatan dan prestasi mahasiswa"', '/assets/uploads/poster/20150531-175826-a9301.jpg', '2015-06-03 10:00:00', '2015-06-03 12:00:00', '2015-05-24 08:31:22', 'Seza Dio F.', 1, 'Ini seminar', 1, NULL),
(2, '002pklucup', 'Yusuf Dwi Santoso', 'ucup@gmail.com', '+6285884848343', 'Seminar PKL "Sistem Informasi surat masuk keluar"', NULL, '2015-05-22 10:00:00', '2015-05-22 12:00:00', '2015-05-24 09:23:59', 'Yusuf Dwi Santoso', 1, 'Seminar PKL', 1, NULL),
(3, '003seminarhimpunan', 'Fikri M.', 'fikri@email.net', '+6285729088683', 'Workshop Gaming', NULL, '2015-05-28 08:00:00', '2015-05-28 16:30:00', '2015-05-25 04:26:53', 'HMIF', 2, 'Workshop pembuatan game.', 1, NULL),
(6, '0006-d1a4c', 'Indri Apriastuti', 'indri@gmail.com', '+627848596070', 'Seminar', '/assets/uploads/poster/20150531-175826-a9301.jpg', '2015-06-10 08:00:00', '2015-06-10 10:00:00', '2015-05-31 10:58:26', 'Indri', 1, '<p>Ini cuma testing doang!!</p>', 2, NULL),
(7, '0007-6fa7f', 'Khaerul Anam', 'anam@gmail.com', '+627774655345', 'Seminar', '/assets/uploads/poster/20150531-190317-3cc1b.jpg', '2015-06-10 10:10:00', '2015-06-10 12:00:00', '2015-05-31 12:03:17', 'Khaerul Anam', 1, '<p>Deskripsi kegiatan....</p>\r\n\r\n<p>Hahaha</p>', 0, 1433084597),
(8, '0008-c2e8a', 'Test', 'as@asd.net', '+627774655345', 'Workshop HM', NULL, '2015-06-05 10:00:00', '2015-06-07 14:00:00', '2015-05-31 12:23:40', 'Test', 4, '', 1, NULL),
(9, '0009-b9aae', 'Dosen', 'dosen@gmail.com', '+627774655345', 'Workshop Dosen', NULL, '2015-06-10 08:00:00', '2015-06-10 14:00:00', '2015-06-01 04:05:16', 'Jurusan', 3, '<p>Ini adalah kegiatan. Dipesan pada tanggal 1 Juni 2015, jam 11:05.</p>\r\n\r\n<p>==</p>', 1, NULL),
(10, '0010-c22a1', 'Nur Hardyanto', 'test@test.com', '+789547935', 'Seminar PKL', '/assets/uploads/poster/20150601-131056-8ffa0.jpg', '2015-06-22 08:00:00', '2015-06-22 10:00:00', '2015-06-01 06:10:56', 'Penyelenggara', 1, '<p>Deskripsi kegiatan di sini....</p>\r\n\r\n<p>&nbsp;</p>', 2, NULL),
(11, '0011-820de', 'Indri Apriastuti', 'test@test.com', '+789547935', 'Workshop Dosen', NULL, '2015-06-11 12:00:00', '2015-06-11 14:00:00', '2015-06-01 06:16:18', 'Jurusan', 1, '', 0, 1433150178);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
