-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 29, 2016 at 03:18 PM
-- Server version: 5.7.13-log
-- PHP Version: 7.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `album`
--
CREATE DATABASE IF NOT EXISTS `album` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `album`;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `owner` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `name`, `owner`) VALUES
(2, '布拉格', 'jean'),
(1, '維也納', 'jean');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `comment` varchar(512) DEFAULT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `name`, `filename`, `comment`, `album_id`) VALUES
(148, 'IMG_0056.JPG', '57c4390716d20.jpg', '黃金小巷', 2),
(144, 'IMG_0030.JPG', '57c42d29b72f9.jpg', '聖維特教堂內部', 2),
(145, 'IMG_0049.JPG', '57c42d2a934f2.jpg', NULL, 2),
(143, 'IMG_0043.JPG', '57c42d28d7668.jpg', '聖維特教堂', 2),
(142, 'IMG_0084.JPG', '57be72b12fbb0.jpg', NULL, 1),
(141, 'IMG_0086.JPG', '57be71ce3b56c.jpg', '天文鐘', 2),
(140, 'IMG_0098 (3).JPG', '57be71cd6ddd7.jpg', NULL, 2),
(139, 'P_20160720_132256.jpg', '57be71ccbcb68.jpg', '布拉格查爾斯橋', 2),
(138, 'P_20160720_135641.jpg', '57be71cc1c0f3.jpg', NULL, 2),
(137, 'IMG_0152.JPG', '57be712335cc3.jpg', NULL, 1),
(136, 'IMG_0049 (2).JPG', '57be7122573b9.jpg', NULL, 1),
(135, 'IMG_0022.JPG', '57be71218d2d5.jpg', NULL, 1),
(134, 'IMG_0006.JPG', '57be71209a58f.jpg', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `account` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`account`, `password`, `name`) VALUES
('jdc', 'jdc', 'jdc'),
('jerry', 'jerry', 'Jerry');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`account`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
