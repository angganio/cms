-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2015 at 04:47 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_articles`
--

CREATE TABLE IF NOT EXISTS `m_articles` (
  `id_artikel` int(11) NOT NULL,
  `catid` int(3) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` int(1) NOT NULL COMMENT '4= Draft, 3= Publish',
  `summary` varchar(225) NOT NULL,
  `content` text NOT NULL,
  `thumb` varchar(225) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `id_gallery` varchar(10) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `addby` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chby` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabel Artikel';

-- --------------------------------------------------------

--
-- Table structure for table `m_cat`
--

CREATE TABLE IF NOT EXISTS `m_cat` (
  `catid` int(3) NOT NULL COMMENT 'ID kategori',
  `pid` int(3) NOT NULL COMMENT 'Parent kategori',
  `desc` varchar(50) NOT NULL COMMENT 'Deskripsi',
  `slug` varchar(255) NOT NULL COMMENT 'URL SEO Friendly',
  `status` int(1) NOT NULL COMMENT 'Status',
  `addby` varchar(20) NOT NULL COMMENT 'Dibuat oleh',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Tgl buat',
  `chby` varchar(20) NOT NULL COMMENT 'Diubah oleh',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tgl ubah'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Tabel master kategori';

--
-- Dumping data for table `m_cat`
--

INSERT INTO `m_cat` (`catid`, `pid`, `desc`, `slug`, `status`, `addby`, `created_at`, `chby`, `updated_at`) VALUES
(4, 0, 'Artikel', 'artikel', 1, 'dian', '2015-09-23 01:33:33', '', '2015-09-23 01:33:33'),
(5, 0, 'Advertorial', 'advertorial', 1, 'dian', '2015-09-23 01:34:00', '', '2015-09-23 01:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_status`
--

CREATE TABLE IF NOT EXISTS `m_status` (
  `code` int(1) NOT NULL COMMENT 'Kode status',
  `desc` varchar(50) NOT NULL COMMENT 'Deskripsi status',
  `color` varchar(8) NOT NULL COMMENT 'Warna legenda',
  `addby` varchar(20) NOT NULL COMMENT 'Dibuat oleh',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Tgl buat',
  `chby` varchar(20) NOT NULL COMMENT 'Diubah oleh',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tgl Ubah'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Master Status';

--
-- Dumping data for table `m_status`
--

INSERT INTO `m_status` (`code`, `desc`, `color`, `addby`, `created_at`, `chby`, `updated_at`) VALUES
(0, 'Disable', '', 'imam', '2015-09-21 09:48:46', '', '2015-09-21 09:48:46'),
(1, 'Enable', '', 'imam', '2015-09-21 09:48:46', '', '2015-09-21 09:48:46'),
(3, 'Publish', '', 'imam', '2015-09-25 06:44:45', '', '2015-09-25 06:44:45'),
(4, 'Draft', '', 'imam', '2015-09-25 06:45:12', '', '2015-09-25 06:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE IF NOT EXISTS `m_user` (
  `usrid` varchar(20) NOT NULL COMMENT 'User ID',
  `id_grp` int(2) NOT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'Password',
  `dispname` varchar(100) DEFAULT NULL COMMENT 'Nama user',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email',
  `foto` varchar(225) NOT NULL COMMENT 'Foto user',
  `status` int(1) DEFAULT NULL COMMENT '0 = tidak aktif, 1 = aktif',
  `last_login` datetime NOT NULL COMMENT 'Login terakhir',
  `addby` varchar(20) NOT NULL COMMENT 'Dibuat oleh',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Tgl buat',
  `chby` varchar(20) NOT NULL COMMENT 'Diubah oleh',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tgl ubah',
  `remember_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel master user';

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`usrid`, `id_grp`, `password`, `dispname`, `email`, `foto`, `status`, `last_login`, `addby`, `created_at`, `chby`, `updated_at`, `remember_token`) VALUES
('dian', 1, '$2y$10$GHLfXfM85he5WHip1iyHw.EXojkfL74GRymgGiUOXxacWjWr8TDay', 'Dian', 'wiguna.imam@gmail.com', 'public/uploads/users/19092015143626.smlogo.png', 1, '0000-00-00 00:00:00', 'imam', '2015-09-19 15:39:12', 'imam', '2015-09-25 02:03:30', 'T3uOquFjTxqK1jqWzDcc6NxjFJ7hIg1Y5AOQxvInCH7iasYGf4pxhHBaEqO7'),
('imamwiguna', 1, '$2y$10$qPTLFikSrpxMzi4ifgQD0OM0Q.cb9T6ojWzEuAIKeeDUnPGf15gAS', 'Imam Wiguna1', 'imam@gmail.com', 'public/uploads/users/18092015161534.avatar.fw.png', 0, '0000-00-00 00:00:00', '', '2015-09-18 17:25:10', 'dian', '2015-09-22 22:14:46', ''),
('imamwiguna3', 1, '$2y$10$qyWyfXTLGWKE8NxHOqCwBux8iYxhextMkzCbbnh3TBHXLZfjwGf26', 'Imam Wiguna', 'imam@gmail.com', 'public/uploads/users/21092015082945.logoui.jpg', 0, '0000-00-00 00:00:00', 'imam', '2015-09-21 08:42:53', '', '2015-09-21 01:42:53', ''),
('yuan', 2, '$2y$10$tzZcAWdiQDuUZolzJbqzVeYATxweNUbynVsl9zvV7OdOeClNs5ENO', 'Yuan1', 'imam1@gmail.com', 'public/uploads/users/21092015081525.logo_baru_wgi_lengkap1.png', 0, '0000-00-00 00:00:00', 'imam', '2015-09-21 09:38:49', 'imam', '2015-09-21 08:05:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_grp`
--

CREATE TABLE IF NOT EXISTS `m_user_grp` (
  `id_grp` int(2) NOT NULL,
  `grp_desc` varchar(50) NOT NULL,
  `addby` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Tgl buat',
  `chby` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Tgl Ubah'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel.user group';

--
-- Dumping data for table `m_user_grp`
--

INSERT INTO `m_user_grp` (`id_grp`, `grp_desc`, `addby`, `created_at`, `chby`, `updated_at`) VALUES
(1, 'Administrator', 'imam', '2015-09-21 08:53:31', '', '0000-00-00 00:00:00'),
(2, 'Contributor', 'imam', '2015-09-21 08:54:19', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_articles`
--
ALTER TABLE `m_articles`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indexes for table `m_cat`
--
ALTER TABLE `m_cat`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `m_status`
--
ALTER TABLE `m_status`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`usrid`);

--
-- Indexes for table `m_user_grp`
--
ALTER TABLE `m_user_grp`
  ADD PRIMARY KEY (`id_grp`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_articles`
--
ALTER TABLE `m_articles`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m_cat`
--
ALTER TABLE `m_cat`
  MODIFY `catid` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID kategori',AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
