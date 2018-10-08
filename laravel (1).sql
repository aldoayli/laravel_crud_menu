-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2018 at 06:20 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_menu`
--

CREATE TABLE `assign_menu` (
  `id` int(11) NOT NULL,
  `assign_by` int(11) NOT NULL,
  `assign_to` int(11) NOT NULL,
  `menu_id` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_menu`
--

INSERT INTO `assign_menu` (`id`, `assign_by`, `assign_to`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '1,2,3', '2018-10-07 15:28:55', '0000-00-00 00:00:00'),
(2, 2, 3, '3,4', '2018-10-07 08:50:05', '2018-10-07 08:50:05'),
(5, 1, 4, '3,5', '2018-10-08 01:28:10', '2018-10-08 01:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `menu` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `menu`, `created_at`, `updated_at`) VALUES
(1, 0, 'Home', '2018-10-06 22:59:43', '2018-10-06 22:59:43'),
(2, 1, 'About', '2018-10-07 06:18:25', '2018-10-06 22:59:52'),
(3, 2, 'Products', '2018-10-07 06:18:36', '2018-10-06 23:00:00'),
(4, 0, 'Contact', '2018-10-06 23:00:11', '2018-10-06 23:00:11'),
(5, 2, 'Services', '2018-10-08 00:19:50', '2018-10-08 00:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aldo', 'aldo_hambali@yahoo.com', NULL, '$2y$10$oHJoEc6kujAWDspDQe0OXuZQ0qB2O.lcZV6HsMkL4N0yGRNsdm3je', '9djRlDbJqZUtsXdq5mL6Gy5im9D0yUxDWpSfy5XMMsDQPwDbB8eSnutDhksl', '2018-10-06 04:19:34', '2018-10-06 04:19:34'),
(2, 'test', 'test@test.com', NULL, '$2y$10$WyP6njmQlAgI5kuwmHgjpeP1xRX7/1WLI4bwFvrIXVfeMIf3xuLIW', 'H5OP51yvDYOD6LK3eTWT0AjP8e6eSSKvB3nSbsvkk2rawhyF87eLBqaMct5a', '2018-10-06 04:31:09', '2018-10-06 04:31:09'),
(3, 'test2', 'test2@test.com', NULL, '$2y$10$EZJPIhuokev9.QriKMTXbu16QivpAyoEF7LG4LmEspEOgXTskfz9G', 'RhfofDh0s5Agp0E6Sfi7vp96sJjMYbeso4u181o0OuGbYQCM5XzQJHyumqcO', '2018-10-06 04:33:40', '2018-10-06 04:33:40'),
(4, 'test3', 'test3@test.com', NULL, '$2y$10$KqpAMSKO3uzK5f/ESDwf5.ccnp0opHT6ezTJ3ni7Yu4kejMLpkYvu', 'GmMD84SSCVJV27S1QRPaFOfFJs14gPM05yaahq8eF3onnVrTUL0vfaQv0823', '2018-10-06 05:37:44', '2018-10-06 05:37:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_menu`
--
ALTER TABLE `assign_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_menu`
--
ALTER TABLE `assign_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
