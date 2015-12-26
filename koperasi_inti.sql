-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2014 at 05:30 AM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `koperasi_inti`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `gaji` int(11) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `id_jenis_anggota` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `id_jenis_anggota` (`id_jenis_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama`, `alamat`, `tanggal_masuk`, `gaji`, `foto`, `id_jenis_anggota`, `status`) VALUES
('ADM', 'ADM', 'ADM', '0000-00-00', 0, NULL, 'JANG-01', 1),
('ANG-0000000001', 'Angga mahendra', 'Ciamis', '2014-07-21', 5000000, '', 'JANG-01', 1),
('ANG-0000000002', 'Randi Saputra', 'Cimahi', '2014-07-21', 2000000, '', 'JANG-01', 1),
('ANG-0000000003', 'Latif Sitepu', 'Sukarno Hatta', '2014-08-12', 1500000, '', 'JANG-03', 1),
('ANG-0000000004', 'Dadang Sanjaya', 'Lengkong Besar', '2015-07-01', 1500000, '', 'JANG-03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE IF NOT EXISTS `angsuran` (
  `id_angsuran` varchar(200) NOT NULL,
  `id_pinjaman` varchar(200) NOT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `sisa_pembayaran` int(11) NOT NULL,
  PRIMARY KEY (`id_angsuran`),
  KEY `id_pinjaman` (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_beban_ditangguhkan`
--
CREATE TABLE IF NOT EXISTS `bb_beban_ditangguhkan` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_hasil_penjualan_bunga_bank`
--
CREATE TABLE IF NOT EXISTS `bb_hasil_penjualan_bunga_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_kas`
--
CREATE TABLE IF NOT EXISTS `bb_kas` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_kas_bank`
--
CREATE TABLE IF NOT EXISTS `bb_kas_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_pendapatan_ditangguhkan`
--
CREATE TABLE IF NOT EXISTS `bb_pendapatan_ditangguhkan` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_piutang_bank`
--
CREATE TABLE IF NOT EXISTS `bb_piutang_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_piutang_bunga_bank`
--
CREATE TABLE IF NOT EXISTS `bb_piutang_bunga_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_piutang_pokok`
--
CREATE TABLE IF NOT EXISTS `bb_piutang_pokok` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_piutang_reguler`
--
CREATE TABLE IF NOT EXISTS `bb_piutang_reguler` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_simpanan_pokok`
--
CREATE TABLE IF NOT EXISTS `bb_simpanan_pokok` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_simpanan_sukarela`
--
CREATE TABLE IF NOT EXISTS `bb_simpanan_sukarela` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_simpanan_wajib`
--
CREATE TABLE IF NOT EXISTS `bb_simpanan_wajib` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_utang_bank`
--
CREATE TABLE IF NOT EXISTS `bb_utang_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `bb_utang_bunga_bank`
--
CREATE TABLE IF NOT EXISTS `bb_utang_bunga_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
,`saldo` decimal(43,0)
);
-- --------------------------------------------------------

--
-- Table structure for table `coa`
--

CREATE TABLE IF NOT EXISTS `coa` (
  `no_referensi` varchar(10) NOT NULL,
  `detail` varchar(50) NOT NULL,
  PRIMARY KEY (`no_referensi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coa`
--

INSERT INTO `coa` (`no_referensi`, `detail`) VALUES
('1101', 'Kas'),
('1201', 'Kas Bank'),
('1202', 'Piutang Reguler'),
('1203', 'Piutang Bank'),
('1204', 'Piutang Bunga Bank'),
('1205', 'Piutang Pokok'),
('2201', 'Simpanan Pokok'),
('2202', 'Simpanan Wajib'),
('2203', 'Simpanan Sukarela'),
('2204', 'Utang Bank'),
('2205', 'Utang Bunga Bank'),
('4101', 'Hasil Penjualan Bunga Bank'),
('4102', 'Pendapatan Ditangguhkan'),
('5101', 'HPP Bank'),
('6101', 'Beban Ditangguhkan');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_anggota`
--

CREATE TABLE IF NOT EXISTS `jenis_anggota` (
  `id_jenis_anggota` varchar(10) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `id_jenis_simpanan` varchar(10) NOT NULL,
  `jumlah_simpanan` int(11) NOT NULL,
  PRIMARY KEY (`id_jenis_anggota`),
  KEY `id_jenis_simpanan` (`id_jenis_simpanan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_anggota`
--

INSERT INTO `jenis_anggota` (`id_jenis_anggota`, `jabatan`, `id_jenis_simpanan`, `jumlah_simpanan`) VALUES
('JANG-01', 'Direksi', 'JSMP-02', 200000),
('JANG-02', 'Ka. Div', 'JSMP-02', 100000),
('JANG-03', 'Ka. Bag', 'JSMP-02', 75000),
('JANG-04', 'Ka. Ur', 'JSMP-02', 50000),
('JANG-05', 'Staf', 'JSMP-02', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_angsuran`
--

CREATE TABLE IF NOT EXISTS `jenis_angsuran` (
  `id_jenis_angsuran` varchar(10) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `flat` double NOT NULL,
  `id_jenis_pinjaman` varchar(10) NOT NULL,
  `jumlah_angsuran` int(11) NOT NULL,
  PRIMARY KEY (`id_jenis_angsuran`),
  KEY `id_jenis_pinjaman` (`id_jenis_pinjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_angsuran`
--

INSERT INTO `jenis_angsuran` (`id_jenis_angsuran`, `periode`, `flat`, `id_jenis_pinjaman`, `jumlah_angsuran`) VALUES
('JANS-001', '1 Tahun', 9.73, 'JPIN-02', 12),
('JANS-002', '2 Tahun', 9.62, 'JPIN-02', 24),
('JANS-003', '3 Tahun', 9.75, 'JPIN-02', 36),
('JANS-004', '4 Tahun', 9.94, 'JPIN-02', 48),
('JANS-005', '5 Tahun', 10.15, 'JPIN-02', 60),
('JANS-006', '6 Tahun', 10.36, 'JPIN-02', 72),
('JANS-007', '7 Tahun', 10.94, 'JPIN-02', 84),
('JANS-008', '8 Tahun', 11.53, 'JPIN-02', 96),
('JANS-009', '5 Bulan', 12, 'JPIN-01', 5),
('JANS-010', '10 Bulan', 15, 'JPIN-01', 10),
('JANS-011', '12 Bulan', 17.4, 'JPIN-01', 12),
('JANS-012', '18 Bulan', 17.4, 'JPIN-01', 18),
('JANS-013', '24 Bulan', 17.4, 'JPIN-01', 24);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pinjaman`
--

CREATE TABLE IF NOT EXISTS `jenis_pinjaman` (
  `id_jenis_pinjaman` varchar(10) NOT NULL,
  `detail` varchar(100) NOT NULL,
  `jumlah_pinjaman` int(11) NOT NULL,
  PRIMARY KEY (`id_jenis_pinjaman`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_pinjaman`
--

INSERT INTO `jenis_pinjaman` (`id_jenis_pinjaman`, `detail`, `jumlah_pinjaman`) VALUES
('JPIN-01', 'Pinjaman Koperasi', 1000000),
('JPIN-02', 'Pinjaman Bank', 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_simpanan`
--

CREATE TABLE IF NOT EXISTS `jenis_simpanan` (
  `id_jenis_simpanan` varchar(10) NOT NULL,
  `detail` varchar(50) NOT NULL,
  `nominal` int(11) NOT NULL,
  PRIMARY KEY (`id_jenis_simpanan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`id_jenis_simpanan`, `detail`, `nominal`) VALUES
('JSMP-01', 'Simpanan Pokok', 150000),
('JSMP-02', 'Simpanan Wajib', 0),
('JSMP-03', 'Simpanan Sukarela', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE IF NOT EXISTS `jurnal` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `id_jurnal` varchar(50) NOT NULL,
  `id_anggota` varchar(100) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `no_ref` varchar(10) NOT NULL,
  `posisi` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `no_ref` (`no_ref`),
  KEY `keterangan` (`keterangan`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`no`, `id_jurnal`, `id_anggota`, `tanggal_transaksi`, `keterangan`, `deskripsi`, `no_ref`, `posisi`, `jumlah`) VALUES
(79, 'JNL-201407210001', 'ANG-0000000001', '2014-07-21', 'SMP-201407210001', 'Kas ANG-0000000001', '1101', 'Debit', 150000),
(80, 'JNL-201407210001', 'ANG-0000000001', '2014-07-21', 'SMP-201407210001', 'Simpanan Pokok ANG-0000000001', '2201', 'Kredit', 150000),
(81, 'JNL-201407210002', 'ANG-0000000002', '2014-07-21', 'SMP-201407210002', 'Kas ANG-0000000002', '1101', 'Debit', 150000),
(82, 'JNL-201407210002', 'ANG-0000000002', '2014-07-21', 'SMP-201407210002', 'Simpanan Pokok ANG-0000000002', '2201', 'Kredit', 150000),
(83, 'JNL-201408120001', 'ANG-0000000003', '2014-08-12', 'SMP-201408120001', 'Kas ANG-0000000003', '1101', 'Debit', 150000),
(84, 'JNL-201408120001', 'ANG-0000000003', '2014-08-12', 'SMP-201408120001', 'Simpanan Pokok ANG-0000000003', '2201', 'Kredit', 150000),
(85, 'JNL-201507010001', 'ANG-0000000004', '2015-07-01', 'SMP-201507010001', 'Kas ANG-0000000004', '1101', 'Debit', 150000),
(86, 'JNL-201507010001', 'ANG-0000000004', '2015-07-01', 'SMP-201507010001', 'Simpanan Pokok ANG-0000000004', '2201', 'Kredit', 150000),
(87, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Kas Bank ANG-0000000001', '1201', 'Debit', 2000000),
(88, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Utang Bank ANG-0000000001', '2204', 'Kredit', 2000000),
(89, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Beban Ditangguhkan ANG-0000000001', '6101', 'Debit', 100000),
(90, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Utang Bunga Bank ANG-0000000001', '2205', 'Kredit', 100000),
(91, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Piutang Reguler ANG-0000000001', '1202', 'Debit', 2000000),
(92, 'JNL-201407210003', 'ANG-0000000001', '2014-07-21', 'PIN-201407210001', 'Kas Bank ANG-0000000001', '1201', 'Kredit', 2000000),
(93, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Kas Bank ANG-0000000001', '1201', 'Debit', 1000000),
(94, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Utang Bank ANG-0000000001', '2204', 'Kredit', 1000000),
(95, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Beban Ditangguhkan ANG-0000000001', '6101', 'Debit', 50000),
(96, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Utang Bunga Bank ANG-0000000001', '2205', 'Kredit', 50000),
(97, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Piutang Reguler ANG-0000000001', '1202', 'Debit', 1000000),
(98, 'JNL-201407210004', 'ANG-0000000001', '2014-07-21', 'PIN-201407210003', 'Kas Bank ANG-0000000001', '1201', 'Kredit', 1000000);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_kas`
--
CREATE TABLE IF NOT EXISTS `jurnal_kas` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_kas_bank`
--
CREATE TABLE IF NOT EXISTS `jurnal_kas_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_piutang_bank`
--
CREATE TABLE IF NOT EXISTS `jurnal_piutang_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_piutang_bunga_bank`
--
CREATE TABLE IF NOT EXISTS `jurnal_piutang_bunga_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_piutang_pokok`
--
CREATE TABLE IF NOT EXISTS `jurnal_piutang_pokok` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_piutang_reguler`
--
CREATE TABLE IF NOT EXISTS `jurnal_piutang_reguler` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(11)
,`kredit` bigint(12)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_simpanan_pokok`
--
CREATE TABLE IF NOT EXISTS `jurnal_simpanan_pokok` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_simpanan_sukarela`
--
CREATE TABLE IF NOT EXISTS `jurnal_simpanan_sukarela` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_simpanan_wajib`
--
CREATE TABLE IF NOT EXISTS `jurnal_simpanan_wajib` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_utang_bank`
--
CREATE TABLE IF NOT EXISTS `jurnal_utang_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `jurnal_utang_bunga_bank`
--
CREATE TABLE IF NOT EXISTS `jurnal_utang_bunga_bank` (
`no` int(11)
,`id_jurnal` varchar(50)
,`id_anggota` varchar(100)
,`tanggal_transaksi` date
,`keterangan` varchar(100)
,`deskripsi` varchar(200)
,`no_ref` varchar(10)
,`posisi` varchar(10)
,`jumlah` int(11)
,`debit` bigint(12)
,`kredit` bigint(11)
,`saldo_awal` bigint(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id_level` varchar(10) NOT NULL,
  `detail` varchar(20) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `detail`) VALUES
('LVL-01', 'Admin'),
('LVL-02', 'Anggota');

-- --------------------------------------------------------

--
-- Table structure for table `penarikan`
--

CREATE TABLE IF NOT EXISTS `penarikan` (
  `id_penarikan` varchar(200) NOT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `jumlah_penarikan` int(11) NOT NULL,
  PRIMARY KEY (`id_penarikan`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_anggota_2` (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_level` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `username` (`username`),
  KEY `id_level` (`id_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `password`, `id_level`, `status`) VALUES
('ADM', '6fb4f22992a0d164b77267fde5477248', 'LVL-01', 1),
('ANG-0000000001', '67af1a838863bd066bb6647368ca6c52', 'LVL-02', 1),
('ANG-0000000002', 'e1b0d6edba2554e3301a2bea928af97c', 'LVL-02', 1),
('ANG-0000000003', '0b402c328b540852b08e02035c72b7cd', 'LVL-02', 1),
('ANG-0000000004', 'c41e0c2f4323fd7b2ceffe7a966355c0', 'LVL-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE IF NOT EXISTS `pinjaman` (
  `id_pinjaman` varchar(200) NOT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `id_jenis_pinjaman` varchar(10) NOT NULL,
  `id_jenis_angsuran` varchar(10) NOT NULL,
  `nominal_pinjaman` int(11) NOT NULL,
  `angsuran_pokok` int(11) NOT NULL,
  `angsuran_bunga` int(11) NOT NULL,
  `acc` int(11) NOT NULL,
  `status_pembayaran` tinyint(1) DEFAULT NULL,
  `tanggal_pembuatan` date NOT NULL,
  PRIMARY KEY (`id_pinjaman`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_anggota_2` (`id_anggota`),
  KEY `id_jenis_pinjaman` (`id_jenis_pinjaman`),
  KEY `id_jenis_angsuran` (`id_jenis_angsuran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id_pinjaman`, `id_anggota`, `id_jenis_pinjaman`, `id_jenis_angsuran`, `nominal_pinjaman`, `angsuran_pokok`, `angsuran_bunga`, `acc`, `status_pembayaran`, `tanggal_pembuatan`) VALUES
('PIN-201407210001', 'ANG-0000000001', 'JPIN-01', 'JANS-009', 2000000, 400000, 20000, 1, 0, '2014-07-21'),
('PIN-201407210002', 'ANG-0000000001', 'JPIN-02', 'JANS-001', 2147483647, 250000000, 24325000, 2, 2, '2014-07-21'),
('PIN-201407210003', 'ANG-0000000001', 'JPIN-01', 'JANS-009', 1000000, 200000, 10000, 0, 0, '2014-07-21'),
('PIN-201407210004', 'ANG-0000000002', 'JPIN-01', 'JANS-009', 2000000, 400000, 20000, 2, 2, '2014-07-21'),
('PIN-201407210005', 'ANG-0000000002', 'JPIN-01', 'JANS-009', 1000000, 200000, 10000, 2, 2, '2014-07-21'),
('PIN-201407210006', 'ANG-0000000003', 'JPIN-01', 'JANS-009', 1000000, 200000, 10000, 2, 2, '2014-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE IF NOT EXISTS `saldo` (
  `id_saldo` varchar(30) NOT NULL,
  `no_ref` varchar(10) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_saldo`),
  KEY `no_ref` (`no_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id_saldo`, `no_ref`, `jumlah`) VALUES
('SLD-01', '1201', 1000000000),
('SLD-02', '1101', 150000000),
('SLD-03', '1202', 0),
('SLD-04', '1203', 0),
('SLD-05', '1204', 0),
('SLD-06', '1205', 0),
('SLD-07', '2201', 0),
('SLD-08', '2202', 0),
('SLD-09', '2203', 0),
('SLD-10', '2204', 0),
('SLD-11', '2205', 0),
('SLD-12', '4101', 0),
('SLD-13', '4102', 0),
('SLD-14', '5101', 0),
('SLD-15', '6101', 0);

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE IF NOT EXISTS `simpanan` (
  `id_simpanan` varchar(200) NOT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `id_jenis_simpanan` varchar(10) NOT NULL,
  `id_jenis_anggota` varchar(10) NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `jumlah_simpanan` int(11) NOT NULL,
  `jenis_pembayaran` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_simpanan`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_jenis_simpanan` (`id_jenis_simpanan`),
  KEY `id_jenis_anggota` (`id_jenis_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id_simpanan`, `id_anggota`, `id_jenis_simpanan`, `id_jenis_anggota`, `tanggal_pembuatan`, `jumlah_simpanan`, `jenis_pembayaran`) VALUES
('SMP-201407210001', 'ANG-0000000001', 'JSMP-01', 'JANG-01', '2014-07-21', 150000, 'Tunai'),
('SMP-201407210002', 'ANG-0000000002', 'JSMP-01', 'JANG-01', '2014-07-21', 150000, 'Tunai'),
('SMP-201408120001', 'ANG-0000000003', 'JSMP-01', 'JANG-03', '2014-08-12', 150000, 'Tunai'),
('SMP-201507010001', 'ANG-0000000004', 'JSMP-01', 'JANG-03', '2015-07-01', 150000, 'Tunai');

-- --------------------------------------------------------

--
-- Structure for view `bb_beban_ditangguhkan`
--
DROP TABLE IF EXISTS `bb_beban_ditangguhkan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_beban_ditangguhkan` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '6101') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '6101')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '6101') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_hasil_penjualan_bunga_bank`
--
DROP TABLE IF EXISTS `bb_hasil_penjualan_bunga_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_hasil_penjualan_bunga_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '4101') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '4101')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '4101') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_kas`
--
DROP TABLE IF EXISTS `bb_kas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_kas` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_kas` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_kas` `a` where (`a`.`no_ref` = '1101') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_kas_bank`
--
DROP TABLE IF EXISTS `bb_kas_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_kas_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_kas_bank` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_kas_bank` `a` where (`a`.`no_ref` = '1201') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_pendapatan_ditangguhkan`
--
DROP TABLE IF EXISTS `bb_pendapatan_ditangguhkan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_pendapatan_ditangguhkan` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '4102') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '4102')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '4102') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_piutang_bank`
--
DROP TABLE IF EXISTS `bb_piutang_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_piutang_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_piutang_bank` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_piutang_bank` `a` where (`a`.`no_ref` = '1203') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_piutang_bunga_bank`
--
DROP TABLE IF EXISTS `bb_piutang_bunga_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_piutang_bunga_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_piutang_bunga_bank` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_piutang_bunga_bank` `a` where (`a`.`no_ref` = '1204') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_piutang_pokok`
--
DROP TABLE IF EXISTS `bb_piutang_pokok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_piutang_pokok` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_piutang_pokok` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_piutang_pokok` `a` where (`a`.`no_ref` = '1205') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_piutang_reguler`
--
DROP TABLE IF EXISTS `bb_piutang_reguler`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_piutang_reguler` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_piutang_reguler` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_piutang_reguler` `a` where (`a`.`no_ref` = '1202') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_simpanan_pokok`
--
DROP TABLE IF EXISTS `bb_simpanan_pokok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_simpanan_pokok` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_simpanan_pokok` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_simpanan_pokok` `a` where (`a`.`no_ref` = '2201') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_simpanan_sukarela`
--
DROP TABLE IF EXISTS `bb_simpanan_sukarela`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_simpanan_sukarela` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_simpanan_sukarela` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_simpanan_sukarela` `a` where (`a`.`no_ref` = '2203') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_simpanan_wajib`
--
DROP TABLE IF EXISTS `bb_simpanan_wajib`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_simpanan_wajib` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_simpanan_wajib` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_simpanan_wajib` `a` where (`a`.`no_ref` = '2202') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_utang_bank`
--
DROP TABLE IF EXISTS `bb_utang_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_utang_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_utang_bank` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_utang_bank` `a` where (`a`.`no_ref` = '2204') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `bb_utang_bunga_bank`
--
DROP TABLE IF EXISTS `bb_utang_bunga_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bb_utang_bunga_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,`a`.`debit` AS `debit`,`a`.`kredit` AS `kredit`,`a`.`saldo_awal` AS `saldo_awal`,(select sum(((`b`.`debit` + `b`.`kredit`) + `b`.`saldo_awal`)) from `jurnal_utang_bunga_bank` `b` where (`b`.`no` <= `a`.`no`)) AS `saldo` from `jurnal_utang_bunga_bank` `a` where (`a`.`no_ref` = '2205') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_kas`
--
DROP TABLE IF EXISTS `jurnal_kas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_kas` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1101') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1101')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1101') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_kas_bank`
--
DROP TABLE IF EXISTS `jurnal_kas_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_kas_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1201') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1201')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1201') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_piutang_bank`
--
DROP TABLE IF EXISTS `jurnal_piutang_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_piutang_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1203') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1203')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1203') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_piutang_bunga_bank`
--
DROP TABLE IF EXISTS `jurnal_piutang_bunga_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_piutang_bunga_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1204') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1204')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1204') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_piutang_pokok`
--
DROP TABLE IF EXISTS `jurnal_piutang_pokok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_piutang_pokok` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1205') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1205')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1205') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_piutang_reguler`
--
DROP TABLE IF EXISTS `jurnal_piutang_reguler`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_piutang_reguler` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then `a`.`jumlah` else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then -(`a`.`jumlah`) else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '1202') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '1202')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '1202') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_simpanan_pokok`
--
DROP TABLE IF EXISTS `jurnal_simpanan_pokok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_simpanan_pokok` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '2201') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '2201')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '2201') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_simpanan_sukarela`
--
DROP TABLE IF EXISTS `jurnal_simpanan_sukarela`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_simpanan_sukarela` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '2203') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '2203')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '2203') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_simpanan_wajib`
--
DROP TABLE IF EXISTS `jurnal_simpanan_wajib`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_simpanan_wajib` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '2202') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '2202')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '2202') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_utang_bank`
--
DROP TABLE IF EXISTS `jurnal_utang_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_utang_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '2204') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '2204')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '2204') group by `a`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `jurnal_utang_bunga_bank`
--
DROP TABLE IF EXISTS `jurnal_utang_bunga_bank`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jurnal_utang_bunga_bank` AS select `a`.`no` AS `no`,`a`.`id_jurnal` AS `id_jurnal`,`a`.`id_anggota` AS `id_anggota`,`a`.`tanggal_transaksi` AS `tanggal_transaksi`,`a`.`keterangan` AS `keterangan`,`a`.`deskripsi` AS `deskripsi`,`a`.`no_ref` AS `no_ref`,`a`.`posisi` AS `posisi`,`a`.`jumlah` AS `jumlah`,(case when (`a`.`posisi` = 'Debit') then -(`a`.`jumlah`) else 0 end) AS `debit`,(case when (`a`.`posisi` = 'Kredit') then `a`.`jumlah` else 0 end) AS `kredit`,(case when (`a`.`no` = (select `b`.`no` from `jurnal` `b` where (`b`.`no_ref` = '2205') order by `b`.`no` limit 1)) then (select `saldo`.`jumlah` from `saldo` where (`saldo`.`no_ref` = '2205')) else 0 end) AS `saldo_awal` from `jurnal` `a` where (`a`.`no_ref` = '2205') group by `a`.`no`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_jenis_anggota`) REFERENCES `jenis_anggota` (`id_jenis_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `angsuran`
--
ALTER TABLE `angsuran`
  ADD CONSTRAINT `angsuran_ibfk_1` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `angsuran_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jenis_anggota`
--
ALTER TABLE `jenis_anggota`
  ADD CONSTRAINT `jenis_anggota_ibfk_1` FOREIGN KEY (`id_jenis_simpanan`) REFERENCES `jenis_simpanan` (`id_jenis_simpanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jenis_angsuran`
--
ALTER TABLE `jenis_angsuran`
  ADD CONSTRAINT `jenis_angsuran_ibfk_1` FOREIGN KEY (`id_jenis_pinjaman`) REFERENCES `jenis_pinjaman` (`id_jenis_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`no_ref`) REFERENCES `coa` (`no_referensi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `penarikan_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`username`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengguna_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinjaman_ibfk_2` FOREIGN KEY (`id_jenis_pinjaman`) REFERENCES `jenis_pinjaman` (`id_jenis_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pinjaman_ibfk_3` FOREIGN KEY (`id_jenis_angsuran`) REFERENCES `jenis_angsuran` (`id_jenis_angsuran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saldo`
--
ALTER TABLE `saldo`
  ADD CONSTRAINT `saldo_ibfk_1` FOREIGN KEY (`no_ref`) REFERENCES `coa` (`no_referensi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `simpanan_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simpanan_ibfk_2` FOREIGN KEY (`id_jenis_anggota`) REFERENCES `jenis_anggota` (`id_jenis_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simpanan_ibfk_3` FOREIGN KEY (`id_jenis_simpanan`) REFERENCES `jenis_simpanan` (`id_jenis_simpanan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
