-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2024 at 12:51 AM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arcade`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `thumbnailUrl` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_id`, `name`, `slug`, `description`, `thumbnailUrl`, `sort_order`, `visibility`) VALUES
(1, 'a46f6ba4-0fe9-419e-945c-12d4ab0cf582', 'Puzzles', 'puzzles', 'Train your braing playing the best free puzzle games online. Are you ready to test your puzzle mind? Play now on GamePix.', NULL, 0, 1),
(2, '5690a2a7-24a5-4ad5-80d0-289a7e53fd37', 'Strategy', 'strategy', 'Do you like strategy games? Here you can play the best strategy games online. Start now and use the brain!', NULL, 0, 1),
(3, '1f9c4256-9f5c-4463-b072-c4d2f266719e', 'Sports', 'sports', 'Are you a real sportsman? Test yourself on GamePix! You can play thousand free online sports games and become a champion!', NULL, 0, 1),
(4, '2342de2d-3d78-47eb-a864-bf20acb79091', 'Classics', 'classics', 'Do you want to be the best fighter on the web? Start training yourself on GamePix, There are a lot of free fighting games! Go play!', NULL, 0, 1),
(5, '13faf451-da07-432b-b7da-73bdbbe03a8b', 'Adventure', 'adventure', 'Start a new adventure with your avatar, try the best adventure games! Start your adventure now on GamePix.', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `categories` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `thumbnailUrl` varchar(255) DEFAULT NULL,
  `thumbnailUrl100` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `slugUrl` varchar(255) NOT NULL,
  `rkScore` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `orientation` varchar(50) DEFAULT NULL,
  `responsive` tinyint(1) DEFAULT NULL,
  `touch` tinyint(1) DEFAULT NULL,
  `hwcontrols` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `creation` datetime DEFAULT NULL,
  `lastUpdate` datetime DEFAULT NULL,
  `size` decimal(10,2) DEFAULT NULL,
  `min_android_version` varchar(50) DEFAULT NULL,
  `min_ios_version` varchar(50) DEFAULT NULL,
  `min_wp_version` varchar(50) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT 1,
  `game_plays` int(11) DEFAULT 0,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
