-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2024 at 07:13 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainup`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_table`
--

DROP TABLE IF EXISTS `attendance_table`;
CREATE TABLE IF NOT EXISTS `attendance_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `course` varchar(180) NOT NULL,
  `reason` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_table`
--

INSERT INTO `attendance_table` (`id`, `name`, `course`, `reason`, `date`) VALUES
(2, 'kali', 'Accounting_ACFN24_C2L', 'acknowledged', '2024-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `marklist`
--

DROP TABLE IF EXISTS `marklist`;
CREATE TABLE IF NOT EXISTS `marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `course` varchar(170) NOT NULL,
  `mark` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` varchar(170) NOT NULL,
  `role` text NOT NULL,
  `password` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `role`, `password`) VALUES
(1, 'yorkabiel', 'yorki', 'admin', '2004');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
