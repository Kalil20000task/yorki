-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2024 at 11:47 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

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
-- Table structure for table `acfns`
--

DROP TABLE IF EXISTS `acfns`;
CREATE TABLE IF NOT EXISTS `acfns` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `course` varchar(56) NOT NULL,
  `term1` int NOT NULL,
  `term2` int NOT NULL,
  `term3` int NOT NULL,
  `total` int NOT NULL,
  `average` double NOT NULL,
  `setby` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `acfns`
--

INSERT INTO `acfns` (`id`, `name`, `course`, `term1`, `term2`, `term3`, `total`, `average`, `setby`, `date`) VALUES
(1, 'kali', 'acfns', 23, 43, 54, 120, 40, '', '2024-11-26');

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
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_table`
--

INSERT INTO `attendance_table` (`id`, `name`, `course`, `reason`, `date`) VALUES
(8, 'Issak Amanuel', 'Accounting_ACFN24_C3L', 'notprovided', '2024-11-11'),
(7, 'Soliyana Zeragabr', 'Accounting_ACFN24_C3L', 'notprovided', '2024-11-11'),
(9, 'Abdelkerim', 'ENG24_B1-C1L', 'notprovided', '2024-11-11'),
(10, 'Hodan Mursal', 'ENG24_A0-C1L', 'busy', '2024-11-11'),
(11, ' Merhawi Fitsum', 'ENG24_A2-C4L', 'notprovided', '2024-11-11'),
(12, 'Makda Temesgen', 'ENG24_A1-C5L', 'busy', '2024-11-11'),
(13, 'Betiel Tekle', 'ENG24_A2-C4L', 'pending', '2024-11-11'),
(17, 'Betiel Tekle', 'ENG24_A2-C4L', 'busy', '2024-11-13'),
(18, 'Merhawi Fitsum', 'ENG24_A1-C5L', 'busy', '2024-11-13'),
(19, 'Tedros Kibreab', 'PLMB_C1L', 'busy', '2024-11-13'),
(20, 'Nahom Fissehaye', 'PLMB_C1L', 'notprovided', '2024-11-13'),
(21, 'Adiam Berihu', 'ENG24_A0-C1L', 'couldnot contact', '2024-11-14'),
(22, 'Rahwa Hadgu', 'Nursing_CNA24_C6L', 'notprovided', '2024-11-14'),
(23, 'Amanuel Paulos', 'ENG24_A0-C1L', 'notprovided', '2024-11-14'),
(24, 'Mohamed Hussen', 'ENG24_B1-C1L', 'notprovided', '2024-11-14'),
(25, 'Elizabeth Achol', 'IT_IT24_C4L', 'pending', '2024-11-14'),
(26, 'Siem Tesfariam', 'BM24_C1L', 'busy', '2024-11-16'),
(27, 'Asha Diriye', 'BM24_C1L', 'sick', '2024-11-16'),
(29, 'Nahom Fssehaye', 'PLMB_C1L', 'busy', '2024-11-18'),
(30, 'Adiam Berihu', 'ENG24_A0-C1L', 'couldnot contact', '2024-11-18'),
(31, 'Tesfalem Tekleab', 'ENG24_A0-C1L', 'couldnot contact', '2024-11-18'),
(32, 'Marwa Adam', 'ENG24_A0-C4L', 'notprovided', '2024-11-18'),
(33, 'Timnit Fitwi', 'ENG24_A2-C4L', 'couldnot contact', '2024-11-18'),
(34, 'Rejoice John', 'Accounting_ACFN24_C3L', 'couldnot contact', '2024-11-18'),
(35, 'Natnael Kibreab', 'Accounting_ACFN24_C3L', 'sick', '2024-11-18'),
(36, 'Yoel Tesfu', 'CB24_C4L', 'busy', '2024-11-18'),
(37, 'Yordanos Goitom', 'Accounting_ACFN24_C6L', 'busy', '2024-11-18'),
(38, 'Mihreteab Goytom', 'ENG24_A1-C6L', 'appointment', '2024-11-18'),
(39, 'Meron Tesfalem', 'ENG24_A1-C6L', 'notprovided', '2024-11-18'),
(40, 'Siem Hagos', 'AM24_C1L', 'acknowledged', '2024-11-18'),
(44, 'Reem Fsehaye', 'ENG24_A0-C1L', 'busy', '2024-11-19'),
(45, 'Kisanet samuel ', 'ENG24_A0-C1L', 'couldnot contact', '2024-11-19'),
(46, 'Siem Tesfamariam', 'BM24_C1L', 'busy', '2024-11-19'),
(47, 'Kisanet Ghebru', 'ENG24_A0-C1L', 'busy', '2024-11-20'),
(48, 'Adam Suleman', 'ENG24_A0-C1L', 'busy', '2024-11-20'),
(49, 'Meron Russom', 'ENG24_A2-C4L', 'couldnot contact', '2024-11-20'),
(50, 'Rejoice Jhon ', 'ENG24_A2-C4L', 'couldnot contact', '2024-11-20'),
(51, 'Soliyana Alem', 'ENG24_A1-C5L', 'busy', '2024-11-20'),
(52, 'Ramzi salih', 'ENG24_A1-C5L', 'notprovided', '2024-11-20'),
(53, 'shahanza Mohammed', 'ENG24_A1-C5L', 'notprovided', '2024-11-20'),
(54, 'Ahmed Abdurahman ', 'ENG24_A0-C1L', 'busy', '2024-11-21'),
(55, 'Smret Mehari', 'ENG24_A0-C1L', 'busy', '2024-11-21'),
(56, 'Segel Okbamariam', 'Accounting_ACFN24_C2L', 'busy', '2024-11-21'),
(57, 'Zerai Amanel', 'Accounting_ACFN24_C2L', 'sick', '2024-11-21'),
(58, 'Senedos Zeray', 'Accounting_ACFN24_C2L', 'couldnot contact', '2024-11-21'),
(59, 'Yosab Haile', 'Accounting_ACFN24_C2L', 'notprovided', '2024-11-21'),
(60, 'Helen T/mariam', 'ENG24_B2-C1L', 'busy', '2024-11-21'),
(61, 'Rahwa Hadgu', 'Accounting_ACFN24_C3L', 'couldnot contact', '2024-11-21'),
(62, 'Adiam Gebrezgi', 'Accounting_ACFN24_C3L', 'notprovided', '2024-11-21'),
(63, 'Soliana Matiwos', 'ENG24_A2-C4L', 'sick', '2024-11-21'),
(64, 'Ruta', 'ENG24_A2-C4L', 'couldnot contact', '2024-11-21'),
(65, 'Saron Michael', 'Digital Marketing_DMA24_C1L', 'sick', '2024-11-21'),
(66, 'Benhur Bemnmet', 'Digital Marketing_DMA24_C1L', 'couldnot contact', '2024-11-21'),
(67, 'Anwar Abdullah', 'ENG24_B1-C1L', 'couldnot contact', '2024-11-21'),
(68, 'Silvana Tekeste', 'Accounting_ACFN24_C3L', 'Couldnot contact', '2024-11-22'),
(69, 'Benhur Ghebru', 'Accounting_ACFN24_C3L', 'Notprovided', '2024-11-22'),
(70, 'Tmnit Fitwi', 'ENG24_A2-C4L', 'Couldnot contact', '2024-11-22'),
(71, 'Selam Girmay', 'ENG24_A1-C6L', 'Notprovided', '2024-11-22'),
(72, 'Harena Fqadu', 'Digital Marketing_DMA24_C2L', 'Notprovided', '2024-11-22'),
(73, 'Measho Abay', 'ENG24_A0-C4L', 'Sick', '2024-11-25'),
(74, 'Nazriet Kflom', 'Accounting_ACFNS24_C5L', 'Busy', '2024-11-25'),
(75, 'Sadia Abdirashied', 'Nursing_CNA24_C4L', 'Rain', '2024-11-25'),
(76, 'Timnit Fitwi', 'ENG24_A2-C4L', 'Rain', '2024-11-25'),
(77, 'Soliyana Matiwos', 'ENG24_A2-C4L', 'Rain', '2024-11-25'),
(78, 'zekaria', 'ENG24_A2-C4L', 'Rain', '2024-11-25'),
(79, 'Nahom Habteab', 'ENG24_A2-C4L', 'Rain', '2024-11-25'),
(80, 'Kebron Medhanie', 'ENG24_A1-C5L', 'Rain', '2024-11-25'),
(81, 'Merhawi Fitsum', 'ENG24_A1-C5L', 'Rain', '2024-11-25'),
(82, 'Abdisalam Ibrahim', 'ENG24_B2-C1L', 'Rain', '2024-11-25'),
(83, 'Yonathan Mengsteab', 'IT_IT24_C5L', 'Rain', '2024-11-25'),
(84, 'Fnan Hadish ', 'IT_IT24_C5L', 'Rain', '2024-11-25'),
(85, 'Helden Habte', 'IT_IT24_C5L', 'Rain', '2024-11-25'),
(86, 'Feruz Kahsay', 'Accounting_ACFN24_C6L', 'Rain', '2024-11-25'),
(87, 'Filmon Andebrhan', 'Accounting_ACFN24_C6L', 'Rain', '2024-11-25'),
(88, 'Merih Nguse', 'PLMB_C2L', 'Appointment', '2024-11-26'),
(89, 'Hana Miaghnaw', 'Nursing_CNA24_C5L', 'Couldnot contact', '2024-11-26'),
(90, 'Adiam Ghebrezgi', 'Nursing_CNA24_C5L', 'Sick', '2024-11-26'),
(91, 'Abeba Kidane', 'ENG24_B1-C1L', 'Pending', '2024-11-26'),
(92, 'Wegahta Eyom', 'ENG24_B1-C1L', 'Busy', '2024-11-26'),
(94, 'Tedros teklehaymanot', 'PLMB_C1L', 'Notprovided', '2024-11-29'),
(95, 'Kisanet Samuel', 'ENG24_A0-C1L', 'Drop out', '2024-11-29'),
(96, 'Adam Suleman', 'ENG24_A0-C1L', 'Notprovided', '2024-11-29'),
(97, 'Ibrahim Abdi', 'ENG24_A1-C6L', 'Notprovided', '2024-11-29'),
(98, 'Meron Tesfalem', 'ENG24_A0-C4L', 'Notprovided', '2024-11-29'),
(99, 'Ibrahim ', 'ENG24_A1-C6L', 'Busy', '2024-11-29'),
(101, 'ibrahim', 'Accounting_ACFN24_C3L', 'Sick', '2024-12-11'),
(127, 'cc', 'Accounting_ACFN24_C3L', 'Notprovided', '2024-12-11'),
(126, 're', 'Accounting_ACFN24_C3L', 'Notprovided', '2024-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `classacfn24c3`
--

DROP TABLE IF EXISTS `classacfn24c3`;
CREATE TABLE IF NOT EXISTS `classacfn24c3` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL COMMENT 'classname',
  `coursename` int NOT NULL COMMENT 'classname',
  `classname` int NOT NULL COMMENT 'classname',
  `levelname` varchar(45) NOT NULL COMMENT 'classname',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfn24c3`
--

INSERT INTO `classacfn24c3` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'kilj', 0, 3, ''),
(2, 'Daniel Fitwi', 0, 3, ''),
(3, 'Daniel Fitwi', 0, 3, ''),
(4, 'Soliyana Zeragaber', 0, 3, ''),
(5, 'Yoel Habteab', 0, 3, ''),
(6, 'Kisanet Tesfaldet', 0, 3, ''),
(7, 'Feven Abraham', 0, 3, ''),
(8, 'Issak Amanuel', 0, 3, ''),
(9, 'Natalia Achol', 0, 3, ''),
(10, 'Natalia Achol', 0, 3, ''),
(11, 'Feven Afewerki', 0, 3, ''),
(12, 'Yonas Brhan', 0, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `classacfn24c4`
--

DROP TABLE IF EXISTS `classacfn24c4`;
CREATE TABLE IF NOT EXISTS `classacfn24c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfn24c4`
--

INSERT INTO `classacfn24c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Sergel Okbamichael', 'ACFN24', 4, ''),
(2, 'Zeray Amanuel', 'ACFN24', 4, ''),
(3, 'Senedos Zerimariam', 'ACFN24', 4, ''),
(4, 'Yosan Alem', 'ACFN24', 4, ''),
(5, 'Kedija Idris', 'ACFN24', 4, ''),
(6, 'Sofanit Berhe', 'ACFN24', 4, ''),
(7, 'Yohanna Fshatsion', 'ACFN24', 4, ''),
(8, 'Samrawit Misghina', 'ACFN24', 4, ''),
(9, 'Saron Estifanos', 'ACFN24', 4, ''),
(10, 'Rawan Abdelhamid', 'ACFN24', 4, ''),
(11, 'Helen Isayas', 'ACFN24', 4, ''),
(12, 'Yosab Haile', 'ACFN24', 4, ''),
(13, 'Timnit Gebru', 'ACFN24', 4, ''),
(14, 'Yohana Goitom', 'ACFN24', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `classacfn24c5`
--

DROP TABLE IF EXISTS `classacfn24c5`;
CREATE TABLE IF NOT EXISTS `classacfn24c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfn24c5`
--

INSERT INTO `classacfn24c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Fieruz Pawlos', 'ACFN24', 5, ''),
(2, 'Silvana Tekeste', 'ACFN24', 5, ''),
(3, 'Rahel Gebreyesus', 'ACFN24', 5, ''),
(4, 'Benhur Ghebru', 'ACFN24', 5, ''),
(5, 'Tigisti Kahsay', 'ACFN24', 5, ''),
(6, 'Berhe Mehari', 'ACFN24', 5, ''),
(7, 'Samuel Afewerki', 'ACFN24', 5, ''),
(8, 'Hana Samuel ', 'ACFN24', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `classacfn24c6`
--

DROP TABLE IF EXISTS `classacfn24c6`;
CREATE TABLE IF NOT EXISTS `classacfn24c6` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfn24c6`
--

INSERT INTO `classacfn24c6` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Sham Tesfay', 'ACFN24', 6, ''),
(2, 'Bighta Isaias', 'ACFN24', 6, ''),
(3, 'Hermela Zeray', 'ACFN24', 6, ''),
(4, 'Ezahel Amanuel', 'ACFN24', 6, ''),
(5, 'Filmon Andbrhan', 'ACFN24', 6, ''),
(6, 'Yordanos Goitom', 'ACFN24', 6, ''),
(7, 'Ksanet Teklemariam', 'ACFN24', 6, ''),
(8, 'Samarawit Yomane', 'ACFN24', 6, ''),
(9, 'Lihem Tensiow', 'ACFN24', 6, ''),
(10, 'Kisanet Teame', 'ACFN24', 6, ''),
(11, 'Feruz Kahsay', 'ACFN24', 6, ''),
(12, 'Joel Yohannes', 'ACFN24', 6, ''),
(13, 'Meron Zeremariam', 'ACFN24', 6, ''),
(14, 'Meron Zeremariam', 'ACFN24', 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `classacfns24c5`
--

DROP TABLE IF EXISTS `classacfns24c5`;
CREATE TABLE IF NOT EXISTS `classacfns24c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(120) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfns24c5`
--

INSERT INTO `classacfns24c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'kaleabteame', 'ACFNs24', 5, '0'),
(2, 'kali', 'ACFNs24', 5, '0'),
(3, 'kali', 'ACFNs24', 5, '0'),
(4, 'kill', 'ACFNs24', 5, ''),
(5, 'Rahel Yirgalem', 'ACFNs24', 5, ''),
(6, 'Nazriet Kflom', 'ACFNs24', 5, ''),
(7, 'Nardos Mengis', 'ACFNs24', 5, ''),
(8, 'Lidya Adisalem', 'ACFNs24', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `classacfns24c5marklist`
--

DROP TABLE IF EXISTS `classacfns24c5marklist`;
CREATE TABLE IF NOT EXISTS `classacfns24c5marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) DEFAULT NULL,
  `course_name` varchar(178) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `class` int NOT NULL,
  `term` varchar(100) DEFAULT NULL,
  `classwork1` int NOT NULL,
  `classwork2` int NOT NULL,
  `test1` int NOT NULL,
  `test2` int NOT NULL,
  `group_assignment1` int NOT NULL,
  `group_assignment2` int NOT NULL,
  `participation` int NOT NULL,
  `attendance` int NOT NULL,
  `final_exam` int NOT NULL,
  `total` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student_term` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfns24c5marklist`
--

INSERT INTO `classacfns24c5marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `classwork1`, `classwork2`, `test1`, `test2`, `group_assignment1`, `group_assignment2`, `participation`, `attendance`, `final_exam`, `total`, `date`) VALUES
(57, 'Nardos Mengis', 'ACFNs24', 5, '1', 7, 0, 0, 0, 0, 0, 0, 0, 0, 7, '2024-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `classacfns24c6`
--

DROP TABLE IF EXISTS `classacfns24c6`;
CREATE TABLE IF NOT EXISTS `classacfns24c6` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(89) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(65) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classacfns24c6`
--

INSERT INTO `classacfns24c6` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'try2', 'ACFNs24', 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `classam24c1`
--

DROP TABLE IF EXISTS `classam24c1`;
CREATE TABLE IF NOT EXISTS `classam24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classam24c1`
--

INSERT INTO `classam24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Siem Hagos', 'AM24', 1, ''),
(2, 'Muluezghi Hagos', 'AM24', 1, ''),
(3, 'Muluezghi Hagos', 'AM24', 1, ''),
(4, 'Filmon Gebrezgabiher', 'AM24', 1, ''),
(5, 'Yoel Negasi', 'AM24', 1, ''),
(6, 'Awet Daynom', 'AM24', 1, ''),
(7, 'Aman Brhane', 'AM24', 1, ''),
(8, 'Semere Tekle', 'AM24', 1, ''),
(9, 'Aron Abraham', 'AM24', 1, ''),
(10, 'Tomas Tkabo', 'AM24', 1, ''),
(11, 'Andebrhane Teklu', 'AM24', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `classam24c1marklist`
--

DROP TABLE IF EXISTS `classam24c1marklist`;
CREATE TABLE IF NOT EXISTS `classam24c1marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `classwork` int DEFAULT '0',
  `homework` int DEFAULT '0',
  `exam` int DEFAULT '0',
  `engine_practical` int DEFAULT '0',
  `garage` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classam24c1marklist`
--

INSERT INTO `classam24c1marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `classwork`, `homework`, `exam`, `engine_practical`, `garage`, `total`, `date`) VALUES
(1, 'task', 'AM24', '1', '1', 8, 0, 0, 0, 0, 8, '2024-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `classam24c2`
--

DROP TABLE IF EXISTS `classam24c2`;
CREATE TABLE IF NOT EXISTS `classam24c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classbm24c1`
--

DROP TABLE IF EXISTS `classbm24c1`;
CREATE TABLE IF NOT EXISTS `classbm24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classbm24c1`
--

INSERT INTO `classbm24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'task', 'bm24', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `classbm24c1marklist`
--

DROP TABLE IF EXISTS `classbm24c1marklist`;
CREATE TABLE IF NOT EXISTS `classbm24c1marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `test1` int DEFAULT '0',
  `test2` int DEFAULT '0',
  `businessplanassignment` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classbm24c1marklist`
--

INSERT INTO `classbm24c1marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `test1`, `test2`, `businessplanassignment`, `finalexam`, `total`, `date`) VALUES
(1, 'task', 'BM24', '1', '1', 30, 20, 24, 25, 99, '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `classbm24c2`
--

DROP TABLE IF EXISTS `classbm24c2`;
CREATE TABLE IF NOT EXISTS `classbm24c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(89) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classbm24c2`
--

INSERT INTO `classbm24c2` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'try3', 'BM24', 2, ''),
(2, 'Siem Tesfamariam', 'BM24', 2, ''),
(3, 'Bruk Harnet ', 'BM24', 2, ''),
(4, 'Yonatan Samuel', 'BM24', 2, ''),
(5, 'Abraham Afwerki', 'BM24', 2, ''),
(6, 'Asha Diriye', 'BM24', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcb24c4`
--

DROP TABLE IF EXISTS `classcb24c4`;
CREATE TABLE IF NOT EXISTS `classcb24c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcb24c4`
--

INSERT INTO `classcb24c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(2, 'Meron Russom', 'CB24', 4, ''),
(3, 'Henos Samuel', 'CB24', 4, ''),
(4, 'Danait Yemane', 'CB24', 4, ''),
(5, 'Yoel Tesfu', 'CB24', 4, ''),
(6, 'Yohannes Gebrelibanos', 'CB24', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcb24c4marklist`
--

DROP TABLE IF EXISTS `classcb24c4marklist`;
CREATE TABLE IF NOT EXISTS `classcb24c4marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `homework1` int DEFAULT '0',
  `homework2` int DEFAULT '0',
  `homework3` int DEFAULT '0',
  `homework4` int DEFAULT '0',
  `quiz` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcb24c4marklist`
--

INSERT INTO `classcb24c4marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `homework1`, `homework2`, `homework3`, `homework4`, `quiz`, `attendance`, `finalexam`, `total`, `date`) VALUES
(1, 'trial', 'CB24', '4', '1', 9, 9, 9, 9, 19, 9, 29, 93, '2024-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `classcb24c5`
--

DROP TABLE IF EXISTS `classcb24c5`;
CREATE TABLE IF NOT EXISTS `classcb24c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcb24c5`
--

INSERT INTO `classcb24c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Fiori Kesete', 'CB24', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c4`
--

DROP TABLE IF EXISTS `classcna24c4`;
CREATE TABLE IF NOT EXISTS `classcna24c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcna24c4`
--

INSERT INTO `classcna24c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Winta Teweldemedhin', 'CNA24', 4, ''),
(2, 'Nagawa Shadia', 'CNA24', 4, ''),
(3, 'Lidya Yakob', 'CNA24', 4, ''),
(4, 'Sofia Yemane', 'CNA24', 4, ''),
(5, 'Yodit Ghirmai', 'CNA24', 4, ''),
(6, 'Ebsam Samson', 'CNA24', 4, ''),
(7, 'Rahwa Fetile', 'CNA24', 4, ''),
(8, 'Rahel Mehari', 'CNA24', 4, ''),
(9, 'Shushan  Petros', 'CNA24', 4, ''),
(10, 'Rahel Teklu', 'CNA24', 4, ''),
(11, 'Samrawit Tesfalem', 'CNA24', 4, ''),
(12, 'Feven Russom', 'CNA24', 4, ''),
(13, 'Helen Zemlu', 'CNA24', 4, ''),
(14, 'Suad Abdi', 'CNA24', 4, ''),
(15, 'Sadia Abdireshed', 'CNA24', 4, ''),
(16, 'Helen Simon Hayelom', 'CNA24', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c4marklist`
--

DROP TABLE IF EXISTS `classcna24c4marklist`;
CREATE TABLE IF NOT EXISTS `classcna24c4marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `test1` float DEFAULT '0',
  `test2` float DEFAULT '0',
  `Assignment1` float DEFAULT '0',
  `Assignment2` float DEFAULT '0',
  `Assignment3` float DEFAULT '0',
  `Assignment4` float DEFAULT '0',
  `Assignment5` float DEFAULT '0',
  `groupdiscussion` float DEFAULT '0',
  `total` float DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c5`
--

DROP TABLE IF EXISTS `classcna24c5`;
CREATE TABLE IF NOT EXISTS `classcna24c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcna24c5`
--

INSERT INTO `classcna24c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Fithawit Gebretnsae', 'CNA24', 5, ''),
(2, 'Hana Misegnaw', 'CNA24', 5, ''),
(3, 'Adiam Ghebrezghi', 'CNA24', 5, ''),
(4, 'Samrawit Gebremedhin', 'CNA24', 5, ''),
(5, 'Samrawit Gebremedhin', 'CNA24', 5, ''),
(6, 'Akberet Eyob', 'CNA24', 5, ''),
(7, 'Lula Bockretsion', 'CNA24', 5, ''),
(8, 'Amanuel Mengisteab', 'CNA24', 5, ''),
(9, 'Arhiet Berhane', 'CNA24', 5, ''),
(10, 'Feven Gebretnsai', 'CNA24', 5, ''),
(11, 'Merhawit Tesfay', 'CNA24', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c5marklist`
--

DROP TABLE IF EXISTS `classcna24c5marklist`;
CREATE TABLE IF NOT EXISTS `classcna24c5marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `test1` float DEFAULT '0',
  `Assignment1` float DEFAULT '0',
  `Assignment2` float DEFAULT '0',
  `Assignment3` float DEFAULT '0',
  `Assignment4` float DEFAULT '0',
  `Assignment5` float DEFAULT '0',
  `groupdiscussion` float DEFAULT '0',
  `total` float DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c6`
--

DROP TABLE IF EXISTS `classcna24c6`;
CREATE TABLE IF NOT EXISTS `classcna24c6` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcna24c6`
--

INSERT INTO `classcna24c6` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Zaid Mengstu', 'CNA24', 6, ''),
(2, 'Rahwa Hadgu', 'CNA24', 6, ''),
(3, 'Saron Yemane', 'CNA24', 6, ''),
(4, 'Milena Gebrezgabiher', 'CNA24', 6, ''),
(5, 'Muna Tahir', 'CNA24', 6, ''),
(6, 'Tsion Daniel ', 'CNA24', 6, ''),
(7, 'Kemer Mulubrhan', 'CNA24', 6, ''),
(8, 'Tsinat Kahsai', 'CNA24', 6, ''),
(9, 'Semira Gebremeskel', 'CNA24', 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c6marklist`
--

DROP TABLE IF EXISTS `classcna24c6marklist`;
CREATE TABLE IF NOT EXISTS `classcna24c6marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `finalproject` float DEFAULT '0',
  `practical` float DEFAULT '0',
  `Assignment1` float DEFAULT '0',
  `Assignment2` float DEFAULT '0',
  `Assignment3` float DEFAULT '0',
  `Assignment4` float DEFAULT '0',
  `Assignment5` float DEFAULT '0',
  `attendance` float DEFAULT '0',
  `total` float DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classcna24c7`
--

DROP TABLE IF EXISTS `classcna24c7`;
CREATE TABLE IF NOT EXISTS `classcna24c7` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classcna24c7`
--

INSERT INTO `classcna24c7` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Msghana	Zeweldi ', 'CNA24', 7, ''),
(2, 'Merry  Welderufael', 'CNA24', 7, ''),
(3, 'Winta Yohannes Zerai', 'CNA24', 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `classdma24c1`
--

DROP TABLE IF EXISTS `classdma24c1`;
CREATE TABLE IF NOT EXISTS `classdma24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classdma24c1`
--

INSERT INTO `classdma24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'kalil', 'dma24', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `classdma24c1marklist`
--

DROP TABLE IF EXISTS `classdma24c1marklist`;
CREATE TABLE IF NOT EXISTS `classdma24c1marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `test1` int DEFAULT '0',
  `test2` int DEFAULT '0',
  `Assignment1` int DEFAULT '0',
  `Assignment2` int DEFAULT '0',
  `GroupAssignment` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classdma24c1marklist`
--

INSERT INTO `classdma24c1marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `test1`, `test2`, `Assignment1`, `Assignment2`, `GroupAssignment`, `finalexam`, `total`, `date`) VALUES
(1, 'kalil', 'DMA24', '1', '1', 3, 7, 5, 0, 19, 34, 68, '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `classdma24c2`
--

DROP TABLE IF EXISTS `classdma24c2`;
CREATE TABLE IF NOT EXISTS `classdma24c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(124) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classdma24c2`
--

INSERT INTO `classdma24c2` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Dlet Kiros', 'DMA24', 2, ''),
(2, 'Betiel Asmat', 'DMA24', 2, ''),
(3, 'Harena Fqadu', 'DMA24', 2, ''),
(4, 'Fnan Welderufael', 'DMA24', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a0c1`
--

DROP TABLE IF EXISTS `classeng24a0c1`;
CREATE TABLE IF NOT EXISTS `classeng24a0c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a0c1`
--

INSERT INTO `classeng24a0c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(2, 'Meron Araya', 'ENG24', 1, 'A0'),
(3, 'Reem Fsehaye', 'ENG24', 1, 'A0'),
(4, 'Ahmed Abdrahmane', 'ENG24', 1, 'A0'),
(5, 'Ksanet Samuel ', 'ENG24', 1, 'A0'),
(6, 'Adiam Berihu', 'ENG24', 1, 'A0'),
(7, 'Ksanet Ghebru', 'ENG24', 1, 'A0'),
(8, 'Adam Suliman', 'ENG24', 1, 'A0'),
(9, 'Samuel Bereket', 'ENG24', 1, 'A0'),
(10, 'Hodan Mursal', 'ENG24', 1, 'A0'),
(11, 'Hodan Mursal', 'ENG24', 1, 'A0'),
(12, 'Simret Mehari', 'ENG24', 1, 'A0'),
(13, 'Amanuel Paulos', 'ENG24', 1, 'A0'),
(14, 'Tesfalem Tekleab', 'ENG24', 1, 'A0'),
(15, 'Awien Makuei', 'ENG24', 1, 'A0');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a0c1marklist`
--

DROP TABLE IF EXISTS `classeng24a0c1marklist`;
CREATE TABLE IF NOT EXISTS `classeng24a0c1marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `speakingskills` int DEFAULT '0',
  `readingskills` int DEFAULT '0',
  `writingskills` int DEFAULT '0',
  `listeningskills` int DEFAULT '0',
  `grammarcomprehension` int DEFAULT '0',
  `panctuality` int DEFAULT '0',
  `participation` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `homework` int DEFAULT '0',
  `discipline` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c4`
--

DROP TABLE IF EXISTS `classeng24a1c4`;
CREATE TABLE IF NOT EXISTS `classeng24a1c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c4`
--

INSERT INTO `classeng24a1c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Merwa Adam', 'ENG24', 4, 'A1'),
(2, 'Selemawit Semere', 'ENG24', 4, 'A1'),
(3, 'Helen Teklesenbet', 'ENG24', 4, 'A1'),
(4, 'Brhane weldegergish', 'ENG24', 4, 'A1'),
(5, 'Senait Kidane', 'ENG24', 4, 'A1'),
(6, 'Measho Abay', 'ENG24', 4, 'A1'),
(7, 'Nardos Semere', 'ENG24', 4, 'A1'),
(8, 'Lula Bokretsion', 'ENG24', 4, 'A1');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c4marklist`
--

DROP TABLE IF EXISTS `classeng24a1c4marklist`;
CREATE TABLE IF NOT EXISTS `classeng24a1c4marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) DEFAULT NULL,
  `course_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) DEFAULT NULL,
  `classwork1` int DEFAULT '0',
  `classwork2` int DEFAULT '0',
  `test1` int DEFAULT '0',
  `test2` int DEFAULT '0',
  `group_assignment1` int DEFAULT '0',
  `group_assignment2` int DEFAULT '0',
  `participation` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `final_exam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student_term` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c4marklist`
--

INSERT INTO `classeng24a1c4marklist` (`id`, `student_name`, `course_name`, `level`, `class`, `term`, `classwork1`, `classwork2`, `test1`, `test2`, `group_assignment1`, `group_assignment2`, `participation`, `attendance`, `final_exam`, `total`, `date`) VALUES
(1, 'sbhat', 'ENG24', '', '4', '2', 3, 0, 0, 0, 24, 0, 0, 0, 0, 27, '2024-12-05'),
(3, 'sbhat', 'ENG24', 'A1', '4', '1', 10, 9, 10, 9, 24, 5, 4, 9, 4, 84, '2024-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c5`
--

DROP TABLE IF EXISTS `classeng24a1c5`;
CREATE TABLE IF NOT EXISTS `classeng24a1c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c5`
--

INSERT INTO `classeng24a1c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Zaid Mengstu', 'ENG24', 5, 'A1'),
(2, 'Trhas Tekeste', 'ENG24', 5, 'A1'),
(3, 'Mezengie Habtab', 'ENG24', 5, 'A1'),
(4, 'Merhawi Fitsum', 'ENG24', 5, 'A1'),
(5, 'Kebron Medhanie', 'ENG24', 5, 'A1'),
(6, 'Haben Fisha', 'ENG24', 5, 'A1'),
(7, 'Ramzi Salih', 'ENG24', 5, 'A1'),
(8, 'Makda Temesghen', 'ENG24', 5, 'A1');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c5marklist`
--

DROP TABLE IF EXISTS `classeng24a1c5marklist`;
CREATE TABLE IF NOT EXISTS `classeng24a1c5marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `speakingskills` int DEFAULT '0',
  `readingskills` int DEFAULT '0',
  `writingskills` int DEFAULT '0',
  `listeningskills` int DEFAULT '0',
  `grammarcomprehension` int DEFAULT '0',
  `panctuality` int DEFAULT '0',
  `participation` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `homework` int DEFAULT '0',
  `discipline` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c5marklist`
--

INSERT INTO `classeng24a1c5marklist` (`id`, `student_name`, `course_name`, `level`, `class`, `term`, `speakingskills`, `readingskills`, `writingskills`, `listeningskills`, `grammarcomprehension`, `panctuality`, `participation`, `attendance`, `homework`, `discipline`, `total`, `date`) VALUES
(1, 'trial2', 'ENG24', 'A1', '5', '1', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, '2024-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c6`
--

DROP TABLE IF EXISTS `classeng24a1c6`;
CREATE TABLE IF NOT EXISTS `classeng24a1c6` (
  `ID` int NOT NULL,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c6`
--

INSERT INTO `classeng24a1c6` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Mihreteab Goytom', 'ENG24', 6, '0'),
(2, 'Fiori Kesete', 'ENG24', 6, '0'),
(3, 'Ayman Mohhamed Adam', 'ENG24', 6, 'A1'),
(4, 'Ibrahim Abd', 'ENG24', 6, '0'),
(5, 'Ekram Abduselam', 'ENG24', 6, 'A1'),
(6, 'Neglaa Abdalla', 'ENG24', 6, 'A1'),
(7, 'Lidiya Brhane', 'ENG24', 6, 'A1'),
(8, 'Selam Ghirmay', 'ENG24', 6, 'A1'),
(9, 'Meron Tesfalem', 'ENG24', 6, 'A1'),
(10, 'Tesfamikael Zeridawit', 'ENG24', 6, 'A1');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a1c6marklist`
--

DROP TABLE IF EXISTS `classeng24a1c6marklist`;
CREATE TABLE IF NOT EXISTS `classeng24a1c6marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) DEFAULT NULL,
  `course_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) DEFAULT NULL,
  `classwork1` int DEFAULT '0',
  `classwork2` int DEFAULT '0',
  `test1` int DEFAULT '0',
  `test2` int DEFAULT '0',
  `group_assignment1` int DEFAULT '0',
  `group_assignment2` int DEFAULT '0',
  `participation` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `final_exam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student_term` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a1c6marklist`
--

INSERT INTO `classeng24a1c6marklist` (`id`, `student_name`, `course_name`, `level`, `class`, `term`, `classwork1`, `classwork2`, `test1`, `test2`, `group_assignment1`, `group_assignment2`, `participation`, `attendance`, `final_exam`, `total`, `date`) VALUES
(1, 'sample student', 'ENG24', '', '6', '1', 5, 0, 0, 0, 0, 0, 0, 0, 0, 5, '2024-12-05'),
(3, 'sample student 2', 'ENG24', '', '6', '1', 6, 0, 0, 3, 0, 0, 0, 0, 0, 9, '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24a2c4`
--

DROP TABLE IF EXISTS `classeng24a2c4`;
CREATE TABLE IF NOT EXISTS `classeng24a2c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24a2c4`
--

INSERT INTO `classeng24a2c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Adiam Habtom', 'ENG24', 4, 'A2'),
(2, 'Adiam Habtom', 'ENG24', 4, 'A2'),
(3, 'Tmnit Fitwi', 'ENG24', 4, 'A2'),
(4, 'Tmnit Fitwi', 'ENG24', 4, 'A2'),
(5, 'Soliana Matiwos', 'ENG24', 4, 'A2'),
(6, 'Zekaria Mohammed', 'ENG24', 4, 'A2'),
(7, 'Henos Samuel', 'ENG24', 4, 'A2'),
(8, 'Meron Russom', 'ENG24', 4, 'A2'),
(9, 'Nahom Habtab', 'ENG24', 4, 'A2'),
(10, 'Ruta Gebrezgziabher', 'ENG24', 4, 'A2'),
(11, 'Yafet Kidane', 'ENG24', 4, 'A2'),
(12, 'Adiam Habtom', 'ENG24', 4, 'A2'),
(13, 'Tmnit Fitwi', 'ENG24', 4, 'A2'),
(14, 'Soliana Matiwos', 'ENG24', 4, 'A2'),
(15, 'Zekaria Mohammed', 'ENG24', 4, 'A2'),
(16, 'Henos Samuel', 'ENG24', 4, 'A2'),
(17, 'Meron Russom', 'ENG24', 4, 'A2'),
(18, 'Nahom Habtab', 'ENG24', 4, 'A2'),
(19, 'Ruta Gebrezgziabher', 'ENG24', 4, 'A2'),
(20, 'Yafet Kidane', 'ENG24', 4, 'A2');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24b1c1`
--

DROP TABLE IF EXISTS `classeng24b1c1`;
CREATE TABLE IF NOT EXISTS `classeng24b1c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classeng24b1c2`
--

DROP TABLE IF EXISTS `classeng24b1c2`;
CREATE TABLE IF NOT EXISTS `classeng24b1c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24b1c2`
--

INSERT INTO `classeng24b1c2` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'try2', 'ENG24', 2, '0000-00-00'),
(2, 'Luwam Ghirmay', 'ENG24', 2, '0000-00-00'),
(3, 'Wegahta Eyob', 'ENG24', 2, '0000-00-00'),
(4, 'Msghana	Zeweldi ', 'ENG24', 2, '0000-00-00'),
(5, 'Lulia Okbamichael', 'ENG24', 2, '0000-00-00'),
(6, 'Abadi Tekie', 'ENG24', 2, '0000-00-00'),
(7, 'Bietsayda Filmon', 'ENG24', 2, '0000-00-00'),
(8, 'Amani Sulieman', 'ENG24', 2, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `classeng24b2c1`
--

DROP TABLE IF EXISTS `classeng24b2c1`;
CREATE TABLE IF NOT EXISTS `classeng24b2c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classeng24b2c2`
--

DROP TABLE IF EXISTS `classeng24b2c2`;
CREATE TABLE IF NOT EXISTS `classeng24b2c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classeng24b2c2`
--

INSERT INTO `classeng24b2c2` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'try2', 'ENG24', 2, 'B2'),
(2, 'Mohamed Abdirizak', 'ENG24', 2, 'B2'),
(3, 'Muhad Mohmud', 'ENG24', 2, 'B2'),
(4, 'Helen Teklemariam', 'ENG24', 2, 'B2'),
(5, 'Abdisamad Ibrahim', 'ENG24', 2, 'B2'),
(6, 'Ahmed Mohammed Ahmed', 'ENG24', 2, 'B2'),
(7, 'Mussie Mhreteab', 'ENG24', 2, 'B2'),
(8, 'Eyob Kibreab', 'ENG24', 2, 'B2'),
(9, 'Anwar Abdulla', 'ENG24', 2, 'B2'),
(10, 'Selam Tesfagergish', 'ENG24', 2, 'B2');

-- --------------------------------------------------------

--
-- Table structure for table `classfrench24c1`
--

DROP TABLE IF EXISTS `classfrench24c1`;
CREATE TABLE IF NOT EXISTS `classfrench24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(89) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(65) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classfrench24c1`
--

INSERT INTO `classfrench24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'try2', 'FRENCH24', 1, ''),
(2, 'Saron Yohannes', 'FRENCH24', 1, ''),
(3, 'Mukatabala Alex', 'FRENCH24', 1, ''),
(4, 'Lamek Fkreyesus', 'FRENCH24', 1, ''),
(5, 'Robel Belay', 'FRENCH24', 1, ''),
(6, 'Robel Belay', 'FRENCH24', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `classielts24c1`
--

DROP TABLE IF EXISTS `classielts24c1`;
CREATE TABLE IF NOT EXISTS `classielts24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classielts24c1`
--

INSERT INTO `classielts24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Muna Ahmed', 'IELTS24', 1, ''),
(2, 'Solomon Ghezae', 'IELTS24', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `classit24c4`
--

DROP TABLE IF EXISTS `classit24c4`;
CREATE TABLE IF NOT EXISTS `classit24c4` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classit24c4`
--

INSERT INTO `classit24c4` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'trail', 'it24', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `classit24c4marklist`
--

DROP TABLE IF EXISTS `classit24c4marklist`;
CREATE TABLE IF NOT EXISTS `classit24c4marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `homework1` int DEFAULT '0',
  `homework2` int DEFAULT '0',
  `homework3` int DEFAULT '0',
  `homework4` int DEFAULT '0',
  `quiz` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `finalproject` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classit24c4marklist`
--

INSERT INTO `classit24c4marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `homework1`, `homework2`, `homework3`, `homework4`, `quiz`, `attendance`, `finalexam`, `finalproject`, `total`, `date`) VALUES
(1, 'trail', 'IT24', '4', '1', 4, 4, 4, 4, 9, 9, 29, 29, 92, '2024-12-10'),
(2, 'trail', 'IT24', '4', '2', 4, 0, 0, 0, 0, 0, 0, 29, 33, '2024-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `classit24c5`
--

DROP TABLE IF EXISTS `classit24c5`;
CREATE TABLE IF NOT EXISTS `classit24c5` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classit24c5`
--

INSERT INTO `classit24c5` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(1, 'Robel Tesfamichael', 'IT24', 5, ''),
(2, 'Fnan Hadish', 'IT24', 5, ''),
(3, 'Helden Habte', 'IT24', 5, ''),
(4, 'Temesgen Tewelde', 'IT24', 5, ''),
(5, 'Temesgen Tewelde', 'IT24', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `classit24c5marklist`
--

DROP TABLE IF EXISTS `classit24c5marklist`;
CREATE TABLE IF NOT EXISTS `classit24c5marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `homework1` int DEFAULT '0',
  `homework2` int DEFAULT '0',
  `homework3` int DEFAULT '0',
  `homework4` int DEFAULT '0',
  `quiz` int DEFAULT '0',
  `attendance` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `finalproject` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classit24c5marklist`
--

INSERT INTO `classit24c5marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `homework1`, `homework2`, `homework3`, `homework4`, `quiz`, `attendance`, `finalexam`, `finalproject`, `total`, `date`) VALUES
(1, 'Robel Tesfamichael', 'IT24', '5', '1', 4, 4, 4, 4, 9, 9, 29, 29, 92, '2024-12-18'),
(2, 'Robel Tesfamichael', 'IT24', '5', '2', 5, 5, 5, 5, 10, 10, 30, 30, 100, '2024-12-18'),
(3, 'Robel Tesfamichael', 'IT24', '5', '3', 3, 3, 2, 2, 7, 6, 20, 24, 67, '2024-12-18'),
(4, 'Fnan Hadish', 'IT24', '5', '1', 5, 3, 3, 4, 10, 8, 23, 30, 86, '2024-12-18'),
(5, 'Fnan Hadish', 'IT24', '5', '2', 4, 4, 4, 4, 10, 10, 30, 30, 96, '2024-12-18'),
(6, 'Fnan Hadish', 'IT24', '5', '3', 2, 2, 4, 3, 6, 6, 24, 12, 59, '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `classplmb24c1`
--

DROP TABLE IF EXISTS `classplmb24c1`;
CREATE TABLE IF NOT EXISTS `classplmb24c1` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` int NOT NULL,
  `classname` varchar(45) NOT NULL,
  `levelname` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classplmb24c1`
--

INSERT INTO `classplmb24c1` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(2, 'Mebrahtom Gebrezgabiher', 0, '1', ''),
(3, 'Tedros Kibreab', 0, '1', ''),
(4, 'Menkem Biniam', 0, '1', ''),
(5, 'Solomon Amanuel', 0, '1', ''),
(6, 'Nahom Fissehaye', 0, '1', ''),
(7, 'Yafet solomon', 0, '1', ''),
(8, 'Natnael Mebrahtom', 0, '1', ''),
(9, 'Ateshm Kibreab', 0, '1', ''),
(10, 'Samuel Teweldebrhan', 0, '1', ''),
(11, 'Tedros Teklehaymanot', 0, '1', ''),
(12, 'Biniam Abraham ', 0, '1', ''),
(13, 'Temesgen Hamde', 0, '1', ''),
(14, 'Gebriel Mussie', 0, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `classplmb24c1marklist`
--

DROP TABLE IF EXISTS `classplmb24c1marklist`;
CREATE TABLE IF NOT EXISTS `classplmb24c1marklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `term` varchar(100) NOT NULL,
  `classwork1` int DEFAULT '0',
  `classwork2` int DEFAULT '0',
  `homework1` int DEFAULT '0',
  `homework2` int DEFAULT '0',
  `Assignment1` int DEFAULT '0',
  `Assignment2` int DEFAULT '0',
  `finalproject` int DEFAULT '0',
  `finalexam` int DEFAULT '0',
  `total` int DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_name` (`student_name`,`term`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classplmb24c1marklist`
--

INSERT INTO `classplmb24c1marklist` (`id`, `student_name`, `course_name`, `class`, `term`, `classwork1`, `classwork2`, `homework1`, `homework2`, `Assignment1`, `Assignment2`, `finalproject`, `finalexam`, `total`, `date`) VALUES
(2, 'Mebrahtom Gebrezgabiher', 'PLMB24', '1', '1', 9, 9, 4, 4, 9, 9, 18, 25, 87, '2024-12-18'),
(3, 'Tedros Kibreab', 'PLMB24', '1', '1', 8, 9, 4, 4, 9, 9, 18, 22, 83, '2024-12-18'),
(4, 'Menkem Biniam', 'PLMB24', '1', '1', 2, 9, 4, 4, 9, 9, 16, 22, 75, '2024-12-18'),
(5, 'Solomon Amanuel', 'PLMB24', '1', '1', 9, 9, 4, 4, 9, 6, 20, 30, 91, '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `classplmb24c2`
--

DROP TABLE IF EXISTS `classplmb24c2`;
CREATE TABLE IF NOT EXISTS `classplmb24c2` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `studentname` text NOT NULL,
  `coursename` varchar(124) NOT NULL,
  `classname` int NOT NULL,
  `levelname` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classplmb24c2`
--

INSERT INTO `classplmb24c2` (`ID`, `studentname`, `coursename`, `classname`, `levelname`) VALUES
(2, 'Tewelde Andemariam', 'PLMB24', 2, ''),
(3, 'Erimias Yrgalem', 'PLMB24', 2, ''),
(4, 'Biniam Berhane', 'PLMB24', 2, ''),
(5, 'Grmazgi Tesfalem', 'PLMB24', 2, ''),
(6, 'Natnael Mengsteab', 'PLMB24', 2, ''),
(7, 'Siem Futsumbrhan', 'PLMB24', 2, ''),
(8, 'Siem Futsumbrhan', 'PLMB24', 2, ''),
(9, 'Solomon Teklu', 'PLMB24', 2, ''),
(10, 'Merih Nguse', 'PLMB24', 2, ''),
(11, 'Merih Nguse', 'PLMB24', 2, ''),
(12, 'Brhane Teages', 'PLMB24', 2, ''),
(13, 'Mussie Michael', 'PLMB24', 2, ''),
(14, 'Mengsteab Zerabruk', 'PLMB24', 2, ''),
(15, 'Faisel Omeredin', 'PLMB24', 2, ''),
(16, 'Temesgen Alem', 'PLMB24', 2, ''),
(17, 'Smon Berhane', 'PLMB24', 2, ''),
(18, 'Berhanu Ibrahim', 'PLMB24', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `course_names`
--

DROP TABLE IF EXISTS `course_names`;
CREATE TABLE IF NOT EXISTS `course_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `courses` varchar(156) NOT NULL,
  `level` varchar(67) NOT NULL,
  `classes` int NOT NULL,
  `terms` int NOT NULL,
  PRIMARY KEY (`id`,`courses`,`level`,`classes`,`terms`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_names`
--

INSERT INTO `course_names` (`id`, `courses`, `level`, `classes`, `terms`) VALUES
(1, 'ACFN24', '', 3, 1),
(2, 'ACFNs24', '', 5, 1),
(3, 'DMA24', '', 1, 1),
(4, 'CNA24', '', 4, 1),
(5, 'IT24', '', 4, 1),
(7, 'CB24', '', 4, 1),
(8, 'PLMB24', '', 1, 1),
(9, 'AM24', '', 1, 1),
(10, 'ENG24', 'A0', 1, 1),
(11, 'IELTS24', '', 1, 1),
(12, 'ACFN24', '', 3, 2),
(13, 'ACFN24', '', 3, 3),
(14, 'ACFN24', '', 4, 1),
(15, 'ACFN24', '', 4, 2),
(16, 'ACFN24', '', 4, 3),
(17, 'ACFN24', '', 5, 1),
(18, 'ACFN24', '', 5, 2),
(19, 'ACFN24', '', 5, 3),
(20, 'ACFN24', '', 6, 1),
(21, 'ACFN24', '', 6, 2),
(22, 'ACFN24', '', 6, 3),
(23, 'ACFNs24', '', 5, 2),
(24, 'ACFNs24', '', 5, 3),
(25, 'CNA24', '', 4, 2),
(26, 'CNA24', '', 4, 3),
(27, 'CNA24', '', 5, 1),
(28, 'CNA24', '', 5, 2),
(29, 'CNA24', '', 5, 3),
(30, 'CNA24', '', 6, 1),
(31, 'CNA24', '', 6, 2),
(32, 'CNA24', '', 6, 3),
(33, 'CNA24', '', 7, 1),
(34, 'CNA24', '', 7, 2),
(35, 'CNA24', '', 7, 3),
(38, 'DMA24', '', 2, 1),
(41, 'IT24', '', 4, 2),
(42, 'IT24', '', 4, 3),
(43, 'IT24', '', 5, 1),
(44, 'IT24', '', 5, 2),
(45, 'IT24', '', 5, 3),
(46, 'BM24', '', 1, 1),
(49, 'CB24', '', 4, 2),
(50, 'CB24', '', 4, 3),
(51, 'CB24', '', 5, 1),
(52, 'CB24', '', 5, 2),
(53, 'CB24', '', 5, 3),
(56, 'PLMB24', '', 2, 1),
(61, 'AM24', '', 2, 1),
(64, 'IELTS24', '', 1, 2),
(65, 'IELTS24', '', 1, 3),
(66, 'ENG24', 'A0', 1, 2),
(67, 'ENG24', 'A0', 1, 3),
(68, 'ENG24', 'A1', 4, 1),
(69, 'ENG24', 'A1', 4, 2),
(70, 'ENG24', 'A1', 4, 3),
(71, 'ENG24', 'A1', 5, 1),
(72, 'ENG24', 'A1', 5, 2),
(73, 'ENG24', 'A1', 5, 3),
(74, 'ENG24', 'A1', 6, 1),
(75, 'ENG24', 'A1', 6, 2),
(76, 'ENG24', 'A1', 6, 3),
(77, 'ENG24', 'A2', 4, 1),
(78, 'ENG24', 'A2', 4, 2),
(79, 'ENG24', 'A2', 4, 3),
(80, 'ENG24', 'B1', 1, 1),
(81, 'ENG24', 'B1', 1, 2),
(82, 'ENG24', 'B1', 1, 3),
(83, 'ENG24', 'B2', 1, 1),
(84, 'ENG24', 'B2', 1, 2),
(85, 'ENG24', 'B2', 1, 3),
(86, 'CNA24', '', 5, 4),
(87, 'CNA24', '', 5, 5),
(88, 'CNA24', '', 6, 4),
(89, 'CNA24', '', 6, 5),
(90, 'CNA24', '', 7, 4),
(91, 'CNA24', '', 7, 5),
(92, 'CNA24', '', 4, 4),
(94, 'CNA24', '', 4, 5);

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
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(6, 'ACFN24'),
(7, 'ACFNs24'),
(8, 'DMA24'),
(9, 'CNA24'),
(10, 'IT24'),
(11, 'CB24'),
(12, 'PLMB24'),
(13, 'AM24'),
(14, 'ENG24'),
(15, 'IELTS24'),
(16, 'BM24'),
(17, 'office'),
(18, 'admin');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `role`, `password`) VALUES
(1, 'yorkabiel', 'yorki', 'admin', '2004'),
(8, 'yohana yohans', 'yowhin', 'ENG24', 'hani'),
(7, 'kaleb teame', 'kali', 'admin', 'task'),
(5, 'loli', 'yorki', 'office', '2000'),
(9, 'hadish habtemicael', 'hadish', 'ACFNs24', 'hadi'),
(10, 'idk', 'idk', 'Array', 'task'),
(11, 'idk', 'idmi', 'Array', 'task');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

DROP TABLE IF EXISTS `userroles`;
CREATE TABLE IF NOT EXISTS `userroles` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`user_id`, `role_id`) VALUES
(1, 17),
(3, 18),
(5, 17),
(11, 8),
(11, 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `password`) VALUES
(1, 'yorkabiel', 'yorki', '2004'),
(2, 'yohana yohannse', 'yowhin', 'hani'),
(3, 'kaleb teame', 'kali', 'task'),
(4, 'loli', 'yorki', '2000'),
(5, 'hadish habtemicael', 'hadish', 'hadi'),
(13, 'kalil gibral', 'kaling', 'gibral'),
(12, 'winta teweldemedhin', 'winti', 'win234'),
(11, 'buruk tekle', 'buruk', 'buruk');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
