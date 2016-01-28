-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2016 at 02:52 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attend`
--

CREATE TABLE IF NOT EXISTS `attend` (
`id` int(10) unsigned NOT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `attend_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attend_h` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `calc_hour` int(11) NOT NULL,
  `calc_min` int(11) NOT NULL,
  `leave_h` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `late_h` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `break_h` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=95 ;

--
-- Dumping data for table `attend`
--

INSERT INTO `attend` (`id`, `day`, `user_id`, `shift_id`, `attend_date`, `attend_h`, `calc_hour`, `calc_min`, `leave_h`, `late_h`, `break_h`) VALUES
(59, 'Sunday', 1, 1, '2016-01-24', '12:35', 5, 33, '19:00', '1:10', '1:25');

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE IF NOT EXISTS `extra` (
`id` int(10) unsigned NOT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra_h` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `calc_hour` int(11) NOT NULL,
  `calc_min` int(11) NOT NULL,
  `leave_h` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `extra`
--

INSERT INTO `extra` (`id`, `day`, `user_id`, `status`, `extra_date`, `extra_h`, `calc_hour`, `calc_min`, `leave_h`) VALUES
(7, 'Thursday', 1, 'accepted', '11-01-2016', '14:40', 1, 0, '15:40');

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE IF NOT EXISTS `hours` (
`id` int(10) unsigned NOT NULL,
  `first_start` int(11) NOT NULL,
  `first_end` int(11) NOT NULL,
  `second_start` int(11) NOT NULL,
  `second_end` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id`, `first_start`, `first_end`, `second_start`, `second_end`) VALUES
(1, 10, 0, 0, 18),
(2, 13, 18, 20, 23);

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
('2014_10_12_100000_create_password_resets_table', 1),
('2015_11_09_093818_attend', 1),
('2015_11_09_093828_extra', 1),
('2015_11_09_094029_shift_groups', 1),
('2015_11_12_105004_hours', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `shift_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `shift_id`, `name`, `role`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'mohamed', 'admin', 'mohameds.tawfeek@gmail.com', '$2y$10$t7URoY0qnteNOJ19ZtqRSO/7AFCMvHhdch.KTox/z5xSzWbi0TQW.', 'VRzCJVhWuNIv06jSgtbLdxSskjEQw8LuR3I0eKK9FM5VSrJUpoTWTUQaOBif', '2015-12-03 15:58:02', '2016-01-27 14:03:01'),
(2, 2, 'Mohamed Sayed', '', 'genka5@gmail.com', '$2y$10$am5nG.ftkKFtTCFeDk6Uru4FfiEoi5gZ7Nt/O62ZYLUZ97nMCB382', 'Q5wsTSHrqiDZYebcXuYisSHnnbzuZ0V2Eyg39cwiwhJpBrGZiEznDVcSV3bD', '2016-01-26 09:21:20', '2016-01-26 13:06:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attend`
--
ALTER TABLE `attend`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra`
--
ALTER TABLE `extra`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attend`
--
ALTER TABLE `attend`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
