-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 04:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `g_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam_seating`
--

CREATE TABLE `exam_seating` (
  `id` int(11) NOT NULL,
  `odd_i` text NOT NULL,
  `even_i` text NOT NULL,
  `hall_no` varchar(50) NOT NULL,
  `exam_date` date NOT NULL,
  `session` varchar(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `total_students` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `odd_dept` text DEFAULT NULL,
  `left_subjects` text DEFAULT NULL,
  `even_dept` text DEFAULT NULL,
  `right_subjects` text DEFAULT NULL,
  `odd_subjects` text DEFAULT NULL,
  `even_subjects` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_seating`
--

INSERT INTO `exam_seating` (`id`, `odd_i`, `even_i`, `hall_no`, `exam_date`, `session`, `subject`, `total_students`, `created_at`, `odd_dept`, `left_subjects`, `even_dept`, `right_subjects`, `odd_subjects`, `even_subjects`) VALUES
(1, 'a:13:{i:0;i:950322104001;i:1;i:950322104002;i:2;i:950322104003;i:3;i:950322104004;i:4;i:950322104005;i:5;i:950322104006;i:6;i:950322104007;i:7;i:950322104008;i:8;i:950322104009;i:9;i:950322104010;i:10;i:950322104011;i:11;i:950322104012;i:12;i:950322104013;}', 'a:12:{i:0;i:950322106001;i:1;i:950322106002;i:2;i:950322106003;i:3;i:950322106004;i:4;i:950322106005;i:5;i:950322106006;i:6;i:950322106007;i:7;i:950322106008;i:8;i:950322106009;i:9;i:950322106010;i:10;i:950322106011;i:11;i:950322106012;}', 'ECE GROUND FLOOR ', '2025-11-28', 'FN', '', 25, '2025-11-26 10:36:15', 'a:13:{i:0;s:5:\"CSE A\";i:1;s:5:\"CSE A\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:5:\"CSE A\";i:7;s:5:\"CSE A\";i:8;s:0:\"\";i:9;s:5:\"CSE A\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";}', NULL, 'a:12:{i:0;s:3:\"ECE\";i:1;s:3:\"ECE\";i:2;s:3:\"ECE\";i:3;s:3:\"ECE\";i:4;s:3:\"ECE\";i:5;s:3:\"ECE\";i:6;s:3:\"ECE\";i:7;s:0:\"\";i:8;s:3:\"ECE\";i:9;s:3:\"ECE\";i:10;s:3:\"ECE\";i:11;s:3:\"ECE\";}', NULL, 'a:13:{i:0;s:17:\"COMPUTER NETWORKS\";i:1;s:17:\"COMPUTER NETWORKS\";i:2;s:17:\"COMPUTER NETWORKS\";i:3;s:17:\"COMPUTER NETWORKS\";i:4;s:17:\"COMPUTER NETWORKS\";i:5;s:17:\"COMPUTER NETWORKS\";i:6;s:17:\"COMPUTER NETWORKS\";i:7;s:17:\"COMPUTER NETWORKS\";i:8;s:17:\"COMPUTER NETWORKS\";i:9;s:17:\"COMPUTER NETWORKS\";i:10;s:17:\"COMPUTER NETWORKS\";i:11;s:17:\"COMPUTER NETWORKS\";i:12;s:17:\"COMPUTER NETWORKS\";}', 'a:12:{i:0;s:14:\"ANTENNA DESIGN\";i:1;s:14:\"ANTENNA DESIGN\";i:2;s:14:\"ANTENNA DESIGN\";i:3;s:14:\"ANTENNA DESIGN\";i:4;s:14:\"ANTENNA DESIGN\";i:5;s:14:\"ANTENNA DESIGN\";i:6;s:14:\"ANTENNA DESIGN\";i:7;s:14:\"ANTENNA DESIGN\";i:8;s:14:\"ANTENNA DESIGN\";i:9;s:14:\"ANTENNA DESIGN\";i:10;s:14:\"ANTENNA DESIGN\";i:11;s:14:\"ANTENNA DESIGN\";}'),
(2, 'a:13:{i:0;i:950322105001;i:1;i:950322105002;i:2;i:950322105003;i:3;i:950322105004;i:4;i:950322105005;i:5;i:950322105006;i:6;i:950322105007;i:7;i:950322105008;i:8;i:950322105009;i:9;i:950322105010;i:10;i:950322105011;i:11;i:950322105012;i:12;i:950322105013;}', 'a:5:{i:0;i:950322114001;i:1;i:950322114002;i:2;i:950322114003;i:3;i:950322114004;i:4;i:950322114005;}', 'ECE FIRST FLOOR ', '2025-11-28', 'AN', '', 18, '2025-11-26 10:43:27', 'a:13:{i:0;s:3:\"EEE\";i:1;s:3:\"EEE\";i:2;s:3:\"EEE\";i:3;s:3:\"EEE\";i:4;s:3:\"EEE\";i:5;s:3:\"EEE\";i:6;s:3:\"EEE\";i:7;s:3:\"EEE\";i:8;s:0:\"\";i:9;s:3:\"EEE\";i:10;s:3:\"EEE\";i:11;s:3:\"EEE\";i:12;s:0:\"\";}', NULL, 'a:5:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";}', NULL, 'a:13:{i:0;s:22:\"ELECTRONICS CIRCUITS 2\";i:1;s:22:\"ELECTRONICS CIRCUITS 2\";i:2;s:22:\"ELECTRONICS CIRCUITS 2\";i:3;s:22:\"ELECTRONICS CIRCUITS 2\";i:4;s:22:\"ELECTRONICS CIRCUITS 2\";i:5;s:22:\"ELECTRONICS CIRCUITS 2\";i:6;s:22:\"ELECTRONICS CIRCUITS 2\";i:7;s:22:\"ELECTRONICS CIRCUITS 2\";i:8;s:22:\"ELECTRONICS CIRCUITS 2\";i:9;s:22:\"ELECTRONICS CIRCUITS 2\";i:10;s:22:\"ELECTRONICS CIRCUITS 2\";i:11;s:22:\"ELECTRONICS CIRCUITS 2\";i:12;s:22:\"ELECTRONICS CIRCUITS 2\";}', 'a:5:{i:0;s:15:\"THERMO DYNAMICS\";i:1;s:15:\"THERMO DYNAMICS\";i:2;s:15:\"THERMO DYNAMICS\";i:3;s:15:\"THERMO DYNAMICS\";i:4;s:15:\"THERMO DYNAMICS\";}'),
(3, 'a:2:{i:0;i:911513106001;i:1;i:2;}', 'a:12:{i:0;i:950321104002;i:1;i:950321104003;i:2;i:950321104004;i:3;i:950321104005;i:4;i:950321104006;i:5;i:950321104007;i:6;i:950321104008;i:7;i:950321104009;i:8;i:950321104010;i:9;i:950321104011;i:10;i:950321104012;i:11;i:950321104013;}', 'ECE FIRST FLOOR ', '2025-11-28', 'AN', '', 14, '2025-11-26 10:51:20', 'a:2:{i:0;s:0:\"\";i:1;s:0:\"\";}', NULL, 'a:12:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";}', NULL, 'a:2:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";}', 'a:12:{i:0;s:4:\"CRYS\";i:1;s:4:\"CRYS\";i:2;s:4:\"CRYS\";i:3;s:4:\"CRYS\";i:4;s:4:\"CRYS\";i:5;s:4:\"CRYS\";i:6;s:4:\"CRYS\";i:7;s:4:\"CRYS\";i:8;s:4:\"CRYS\";i:9;s:4:\"CRYS\";i:10;s:4:\"CRYS\";i:11;s:4:\"CRYS\";}'),
(4, 'a:13:{i:0;i:911513106001;i:1;i:911513106002;i:2;i:911513106003;i:3;i:911513106004;i:4;i:911513106005;i:5;i:911513106006;i:6;i:911513106007;i:7;i:911513106008;i:8;i:911513106009;i:9;i:911513106010;i:10;i:911513106011;i:11;i:911513106012;i:12;i:911513106013;}', 'a:12:{i:0;i:950321104002;i:1;i:950321104003;i:2;i:950321104004;i:3;i:950321104005;i:4;i:950321104006;i:5;i:950321104007;i:6;i:950321104008;i:7;i:950321104009;i:8;i:950321104010;i:9;i:950321104011;i:10;i:950321104012;i:11;i:950321104013;}', 'ECE FIRST FLOOR ', '2025-11-28', 'AN', '', 25, '2025-11-26 13:49:09', 'a:13:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";}', NULL, 'a:12:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";}', NULL, 'a:13:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";}', 'a:12:{i:0;s:4:\"CRYS\";i:1;s:4:\"CRYS\";i:2;s:4:\"CRYS\";i:3;s:4:\"CRYS\";i:4;s:4:\"CRYS\";i:5;s:4:\"CRYS\";i:6;s:4:\"CRYS\";i:7;s:4:\"CRYS\";i:8;s:4:\"CRYS\";i:9;s:4:\"CRYS\";i:10;s:4:\"CRYS\";i:11;s:4:\"CRYS\";}'),
(5, 'a:13:{i:0;i:911513106001;i:1;i:911513106002;i:2;i:911513106003;i:3;i:911513106004;i:4;i:911513106005;i:5;i:911513106006;i:6;i:911513106007;i:7;i:911513106008;i:8;i:911513106009;i:9;i:911513106010;i:10;i:911513106011;i:11;i:911513106012;i:12;i:911513106013;}', 'a:0:{}', 'ECE FIRST FLOOR ', '2025-11-29', 'AN', '', 13, '2025-11-26 13:50:10', 'a:13:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";}', NULL, 'a:0:{}', NULL, 'a:13:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";}', 'a:0:{}'),
(6, 'a:0:{}', 'a:0:{}', '', '0000-00-00', '', '', 0, '2025-11-27 01:11:09', 'a:0:{}', NULL, 'a:0:{}', NULL, 'a:0:{}', 'a:0:{}'),
(7, 'a:0:{}', 'a:0:{}', '', '0000-00-00', '', '', 0, '2025-11-27 01:11:10', 'a:0:{}', NULL, 'a:0:{}', NULL, 'a:0:{}', 'a:0:{}'),
(8, 'a:0:{}', 'a:0:{}', '', '0000-00-00', '', '', 0, '2025-11-27 01:11:12', 'a:0:{}', NULL, 'a:0:{}', NULL, 'a:0:{}', 'a:0:{}'),
(9, 'a:26:{i:0;i:950322104001;i:1;i:950322104002;i:2;i:950322104003;i:3;i:950322104004;i:4;i:950322104005;i:5;i:950322104006;i:6;i:950322104007;i:7;i:950322104008;i:8;i:950322104009;i:9;i:950322104010;i:10;i:950322104011;i:11;i:950322104012;i:12;i:950322104013;i:13;i:950322104001;i:14;i:950322104002;i:15;i:950322104003;i:16;i:950322104004;i:17;i:950322104005;i:18;i:950322104006;i:19;i:950322104007;i:20;i:950322104008;i:21;i:950322104009;i:22;i:950322104010;i:23;i:950322104011;i:24;i:950322104012;i:25;i:950322104013;}', 'a:0:{}', '', '0000-00-00', '', '', 26, '2025-11-27 06:26:19', 'a:26:{i:0;s:5:\"CSE A\";i:1;s:5:\"CSE A\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:5:\"CSE A\";i:7;s:5:\"CSE A\";i:8;s:0:\"\";i:9;s:5:\"CSE A\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";i:13;s:5:\"CSE A\";i:14;s:5:\"CSE A\";i:15;s:0:\"\";i:16;s:0:\"\";i:17;s:0:\"\";i:18;s:0:\"\";i:19;s:5:\"CSE A\";i:20;s:5:\"CSE A\";i:21;s:0:\"\";i:22;s:5:\"CSE A\";i:23;s:0:\"\";i:24;s:0:\"\";i:25;s:0:\"\";}', NULL, 'a:0:{}', NULL, 'a:26:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";i:13;s:8:\"WEB TECH\";i:14;s:8:\"WEB TECH\";i:15;s:8:\"WEB TECH\";i:16;s:8:\"WEB TECH\";i:17;s:8:\"WEB TECH\";i:18;s:8:\"WEB TECH\";i:19;s:8:\"WEB TECH\";i:20;s:8:\"WEB TECH\";i:21;s:8:\"WEB TECH\";i:22;s:8:\"WEB TECH\";i:23;s:8:\"WEB TECH\";i:24;s:8:\"WEB TECH\";i:25;s:8:\"WEB TECH\";}', 'a:0:{}'),
(10, 'a:13:{i:0;i:950322243001;i:1;i:950322243002;i:2;i:950322243003;i:3;i:950322243004;i:4;i:950322243005;i:5;i:950322243006;i:6;i:950322243007;i:7;i:950322243008;i:8;i:950322243009;i:9;i:950322243010;i:10;i:950322243011;i:11;i:950322243012;i:12;i:950322243013;}', 'a:12:{i:0;i:950322243001;i:1;i:950322243002;i:2;i:950322243003;i:3;i:950322243004;i:4;i:950322243005;i:5;i:950322243006;i:6;i:950322243007;i:7;i:950322243008;i:8;i:950322243009;i:9;i:950322243010;i:10;i:950322243011;i:11;i:950322243012;}', '', '0000-00-00', '', '', 25, '2025-11-27 07:39:56', 'a:13:{i:0;s:4:\"AIDS\";i:1;s:4:\"AIDS\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:4:\"AIDS\";i:9;s:0:\"\";i:10;s:4:\"AIDS\";i:11;s:4:\"AIDS\";i:12;s:0:\"\";}', NULL, 'a:12:{i:0;s:4:\"AIDS\";i:1;s:4:\"AIDS\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:4:\"AIDS\";i:9;s:0:\"\";i:10;s:4:\"AIDS\";i:11;s:4:\"AIDS\";}', NULL, 'a:13:{i:0;s:4:\"aods\";i:1;s:4:\"aods\";i:2;s:4:\"aods\";i:3;s:4:\"aods\";i:4;s:4:\"aods\";i:5;s:4:\"aods\";i:6;s:4:\"aods\";i:7;s:4:\"aods\";i:8;s:4:\"aods\";i:9;s:4:\"aods\";i:10;s:4:\"aods\";i:11;s:4:\"aods\";i:12;s:4:\"aods\";}', 'a:12:{i:0;s:3:\"IOT\";i:1;s:3:\"IOT\";i:2;s:3:\"IOT\";i:3;s:3:\"IOT\";i:4;s:3:\"IOT\";i:5;s:3:\"IOT\";i:6;s:3:\"IOT\";i:7;s:3:\"IOT\";i:8;s:3:\"IOT\";i:9;s:3:\"IOT\";i:10;s:3:\"IOT\";i:11;s:3:\"IOT\";}'),
(11, 'a:10:{i:0;i:911513106001;i:1;i:911513106002;i:2;i:911513106003;i:3;i:911513106004;i:4;i:911513106005;i:5;i:950322104011;i:6;i:950322104012;i:7;i:950322104013;i:8;i:911513106001;i:9;i:911513106002;}', 'a:12:{i:0;i:950321104002;i:1;i:950321104003;i:2;i:950321104004;i:3;i:950321104005;i:4;i:950321104006;i:5;i:950321104007;i:6;i:950321104008;i:7;i:950321104009;i:8;i:950321104010;i:9;i:950321104011;i:10;i:950321104012;i:11;i:950321104013;}', 'Drawing Hall 1', '2025-11-28', 'FN', '', 22, '2025-11-27 07:54:56', 'a:10:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";}', NULL, 'a:12:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";}', NULL, 'a:10:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:14:\"YYYYYYYYYYYYYY\";i:6;s:14:\"YYYYYYYYYYYYYY\";i:7;s:14:\"YYYYYYYYYYYYYY\";i:8;s:9:\"Algorithm\";i:9;s:9:\"Algorithm\";}', 'a:12:{i:0;s:15:\"THERMO DYNAMICS\";i:1;s:15:\"THERMO DYNAMICS\";i:2;s:15:\"THERMO DYNAMICS\";i:3;s:15:\"THERMO DYNAMICS\";i:4;s:15:\"THERMO DYNAMICS\";i:5;s:15:\"THERMO DYNAMICS\";i:6;s:15:\"THERMO DYNAMICS\";i:7;s:15:\"THERMO DYNAMICS\";i:8;s:15:\"THERMO DYNAMICS\";i:9;s:15:\"THERMO DYNAMICS\";i:10;s:15:\"THERMO DYNAMICS\";i:11;s:15:\"THERMO DYNAMICS\";}'),
(12, 'a:25:{i:0;i:950322104002;i:1;i:950322104003;i:2;i:950322104004;i:3;i:950322104005;i:4;i:950322104006;i:5;i:950322104007;i:6;i:950322104008;i:7;i:950322104009;i:8;i:950322104010;i:9;i:950322104011;i:10;i:950322104012;i:11;i:950322104013;i:12;i:911513106001;i:13;i:911513106002;i:14;i:911513106003;i:15;i:911513106004;i:16;i:911513106005;i:17;i:911513106006;i:18;i:911513106007;i:19;i:911513106008;i:20;i:911513106009;i:21;i:911513106010;i:22;i:911513106011;i:23;i:911513106012;i:24;i:911513106013;}', 'a:0:{}', 'IV CSE A', '2025-11-30', 'FN', '', 25, '2025-11-27 08:51:12', 'a:25:{i:0;s:5:\"CSE A\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:5:\"CSE A\";i:6;s:5:\"CSE A\";i:7;s:0:\"\";i:8;s:5:\"CSE A\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";i:13;s:0:\"\";i:14;s:0:\"\";i:15;s:0:\"\";i:16;s:0:\"\";i:17;s:0:\"\";i:18;s:0:\"\";i:19;s:0:\"\";i:20;s:0:\"\";i:21;s:0:\"\";i:22;s:0:\"\";i:23;s:0:\"\";i:24;s:0:\"\";}', NULL, 'a:0:{}', NULL, 'a:25:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:17:\"COMPUTER NETWORKS\";i:13;s:17:\"COMPUTER NETWORKS\";i:14;s:17:\"COMPUTER NETWORKS\";i:15;s:17:\"COMPUTER NETWORKS\";i:16;s:17:\"COMPUTER NETWORKS\";i:17;s:17:\"COMPUTER NETWORKS\";i:18;s:17:\"COMPUTER NETWORKS\";i:19;s:17:\"COMPUTER NETWORKS\";i:20;s:17:\"COMPUTER NETWORKS\";i:21;s:17:\"COMPUTER NETWORKS\";i:22;s:17:\"COMPUTER NETWORKS\";i:23;s:17:\"COMPUTER NETWORKS\";i:24;s:17:\"COMPUTER NETWORKS\";}', 'a:0:{}'),
(13, 'a:13:{i:0;i:911513106001;i:1;i:911513106002;i:2;i:911513106003;i:3;i:911513106004;i:4;i:911513106005;i:5;i:911513106006;i:6;i:911513106007;i:7;i:911513106008;i:8;i:911513106009;i:9;i:911513106010;i:10;i:911513106011;i:11;i:911513106012;i:12;i:911513106013;}', 'a:11:{i:0;i:950321104002;i:1;i:950321104003;i:2;i:950321104004;i:3;i:950321104005;i:4;i:950321104006;i:5;i:950321104007;i:6;i:950321104008;i:7;i:950321104009;i:8;i:950321104010;i:9;i:950321104012;i:10;i:950321104013;}', 'IV CSE A', '2025-11-14', 'FN', '', 24, '2025-11-27 10:38:17', 'a:13:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";}', NULL, 'a:11:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";}', NULL, 'a:13:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";}', 'a:11:{i:0;s:4:\"CRYS\";i:1;s:4:\"CRYS\";i:2;s:4:\"CRYS\";i:3;s:4:\"CRYS\";i:4;s:4:\"CRYS\";i:5;s:4:\"CRYS\";i:6;s:4:\"CRYS\";i:7;s:4:\"CRYS\";i:8;s:4:\"CRYS\";i:9;s:14:\"ANTENNA DESIGN\";i:10;s:14:\"ANTENNA DESIGN\";}'),
(14, 'a:13:{i:0;i:950322243001;i:1;i:950322243002;i:2;i:950322243003;i:3;i:950322243004;i:4;i:950322243005;i:5;i:950322243006;i:6;i:950322243007;i:7;i:950322243008;i:8;i:950322243009;i:9;i:950322243010;i:10;i:950322243011;i:11;i:950322243012;i:12;i:950322243013;}', 'a:0:{}', 'IV CSE A', '2025-11-14', 'AN', '', 13, '2025-11-27 10:39:12', 'a:13:{i:0;s:4:\"AIDS\";i:1;s:4:\"AIDS\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:4:\"AIDS\";i:9;s:0:\"\";i:10;s:4:\"AIDS\";i:11;s:4:\"AIDS\";i:12;s:0:\"\";}', NULL, 'a:0:{}', NULL, 'a:13:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";}', 'a:0:{}'),
(15, 'a:13:{i:0;i:950322243001;i:1;i:950322243002;i:2;i:950322243003;i:3;i:950322243004;i:4;i:950322243005;i:5;i:950322243006;i:6;i:950322243007;i:7;i:950322243008;i:8;i:950322243009;i:9;i:950322243010;i:10;i:950322243011;i:11;i:950322243012;i:12;i:950322243013;}', 'a:12:{i:0;i:950322243001;i:1;i:950322243002;i:2;i:950322243003;i:3;i:950322243004;i:4;i:950322243005;i:5;i:950322243006;i:6;i:950322243007;i:7;i:950322243008;i:8;i:950322243009;i:9;i:950322243010;i:10;i:950322243011;i:11;i:950322243012;}', 'Drawing Hall 1', '2025-11-29', 'FN', '', 25, '2025-11-28 01:33:06', 'a:13:{i:0;s:3:\"CSE\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:4:\"AIDS\";i:11;s:4:\"AIDS\";i:12;s:0:\"\";}', NULL, 'a:12:{i:0;s:3:\"CSE\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:4:\"AIDS\";i:11;s:4:\"AIDS\";}', NULL, 'a:13:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";i:12;s:8:\"WEB TECH\";}', 'a:12:{i:0;s:3:\"IOT\";i:1;s:3:\"IOT\";i:2;s:3:\"IOT\";i:3;s:3:\"IOT\";i:4;s:3:\"IOT\";i:5;s:3:\"IOT\";i:6;s:3:\"IOT\";i:7;s:3:\"IOT\";i:8;s:3:\"IOT\";i:9;s:3:\"IOT\";i:10;s:3:\"IOT\";i:11;s:3:\"IOT\";}'),
(16, 'a:12:{i:0;i:950322104002;i:1;i:950322104003;i:2;i:950322104004;i:3;i:950322104005;i:4;i:950322104006;i:5;i:950322104007;i:6;i:950322104008;i:7;i:950322104009;i:8;i:950322104010;i:9;i:950322104011;i:10;i:950322104012;i:11;i:950322104013;}', 'a:0:{}', 'ECE FIRST FLOOR ', '2025-12-27', 'FN', '', 12, '2025-12-03 03:24:33', 'a:12:{i:0;s:5:\"CSE A\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:5:\"CSE A\";i:6;s:5:\"CSE A\";i:7;s:0:\"\";i:8;s:5:\"CSE A\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";}', NULL, 'a:0:{}', NULL, 'a:12:{i:0;s:8:\"WEB TECH\";i:1;s:8:\"WEB TECH\";i:2;s:8:\"WEB TECH\";i:3;s:8:\"WEB TECH\";i:4;s:8:\"WEB TECH\";i:5;s:8:\"WEB TECH\";i:6;s:8:\"WEB TECH\";i:7;s:8:\"WEB TECH\";i:8;s:8:\"WEB TECH\";i:9;s:8:\"WEB TECH\";i:10;s:8:\"WEB TECH\";i:11;s:8:\"WEB TECH\";}', 'a:0:{}');

-- --------------------------------------------------------

--
-- Table structure for table `seating_arrangement`
--

CREATE TABLE `seating_arrangement` (
  `id` int(11) NOT NULL,
  `hall_no` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `session` varchar(10) NOT NULL,
  `total_students` int(11) DEFAULT 0,
  `left_seats` text DEFAULT NULL,
  `right_seats` text DEFAULT NULL,
  `left_groups` text DEFAULT NULL,
  `right_groups` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seating_arrangement`
--

INSERT INTO `seating_arrangement` (`id`, `hall_no`, `department`, `exam_date`, `session`, `total_students`, `left_seats`, `right_seats`, `left_groups`, `right_groups`, `created_at`) VALUES
(1, 'LH32', '', '2025-11-27', 'FN', 21, '[950322104002,950322104003,950322104004,950322104005,950322104006,950322104007,950322104008,950322104009,950322104010,950322104011,950322104012,950322104013]', '[950321104002,950321104003,950321104004,950321104005,950321104006,950321104007,950321104008,950321104009,950321104010]', '[\"950322104002-950322104013\"]', '[\"950321104002-950321104010\"]', '2025-11-26 13:28:00'),
(2, 'LH32', '', '2025-11-27', 'FN', 25, '[911513106001,911513106002,911513106003,911513106004,911513106005,911513106006,911513106007,911513106008,911513106009,911513106010,911513106011,911513106012,911513106013]', '[950322243001,950322243002,950322243003,950322243004,950322243005,950322243006,950322243007,950322243008,950322243009,950322243010,950322243011,950322243012]', '[\"911513106001-911513106013\"]', '[\"950322243001-950322243012\"]', '2025-11-26 13:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `reg_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`reg_no`, `name`, `department`) VALUES
('121', 'Alaaudeen', 'CSE A'),
('950322103001', 'Bharath Kumar S', 'CIVIL'),
('950322103004', 'SUBASH CHANDRABOSE K', 'CIVIL'),
('950322104001', 'S. Abdul Rahim', 'CSE A'),
('950322104002', 'Abishek. V', 'CSE A'),
('950322104007', 'Akash Kumar', 'CSE A'),
('950322104008', 'Akshaya.J', 'CSE A'),
('950322104010', 'Anantha Kumar G', 'CSE A'),
('950322104014', 'Anitha.M', 'CSE A'),
('950322104015', 'A.Antony Jeba Aashika', 'CSE A'),
('950322104017', 'Aravindh R', 'CSE A'),
('950322104018', 'T Arthi', 'CSE A'),
('950322104019', 'Arul jayaraj', 'CSE A'),
('950322104021', 'Buddhayazhini', 'CSE A'),
('950322104024', 'Deeparani.S', 'CSE A'),
('950322104027', 'A.Gipson Xavier Jebas', 'CSE A'),
('950322104028', 'J. Gopika', 'CSE A'),
('950322104030', 'Sharon Gurapnoor', 'CSE A'),
('950322104031', 'Harini G', 'CSE A'),
('950322104032', 'K. Indhu mathi', 'CSE A'),
('950322104034', 'J.Jemimah arputham', 'CSE A'),
('950322104035', 'Jeril P', 'CSE A'),
('950322104036', 'J.jerlin', 'CSE A'),
('950322104037', 'Jeya bharathi K', 'CSE A'),
('950322104038', 'John Jahaziel', 'CSE A'),
('950322104041', 'Joyslin A', 'CSE A'),
('950322104043', 'Kamatchi nathan.k', 'CSE A'),
('950322104044', 'Karthick K', 'CSE A'),
('950322104046', 'KRISHNAN.K', 'CSE A'),
('950322104047', 'K.loha lakshmki', 'CSE A'),
('950322104049', 'Malar', 'CSE A'),
('950322104051', 'Manikandaprabhu.M', 'CSE A'),
('950322104052', 'Manimegala.J', 'CSE A'),
('950322104054', 'S. Mathew Jeron Kirubai', 'CSE B'),
('950322104056', 'Mukesh kannan s', 'CSE B'),
('950322104057', 'Murugesan', 'CSE B'),
('950322104058', 'R.Muthu Benisiya', 'CSE B'),
('950322104059', 'Muthu Gayathri', 'CSE B'),
('950322104060', 'Muthu ramanathan R', 'CSE B'),
('950322104061', 'M.Muthu roshini', 'CSE B'),
('950322104062', 'Muthuselvan', 'CSE B'),
('950322104063', 'M.Muthu Selvi', 'CSE B'),
('950322104064', 'P.Naga Narmatha', 'CSE B'),
('950322104065', 'Naveen Sam Raj', 'CSE B'),
('950322104066', 'Naveen .V', 'CSE B'),
('950322104067', 'Nerthi Ebenezer P', 'CSE B'),
('950322104070', 'Pritirani limma', 'CSE B'),
('950322104071', 'K.Priyadharshini', 'CSE B'),
('950322104072', 'R.Priyadharshini', 'CSE B'),
('950322104073', 'Quincy clinta.J', 'CSE B'),
('950322104074', 'A.Rajalakshmi', 'CSE B'),
('950322104075', 'A.Rajapriya', 'CSE B'),
('950322104076', 'Rama selvi M', 'CSE B'),
('950322104077', 'Ranish T', 'CSE B'),
('950322104078', 'N.Revathi selvam', 'CSE B'),
('950322104079', 'ROSA MYSTICA.M', 'CSE B'),
('950322104081', 'A.sahaya shiny vaz', 'CSE B'),
('950322104083', 'Sangeetha Prabha I', 'CSE B'),
('950322104084', 'SANTHIYA M', 'CSE B'),
('950322104085', 'Selva bharath', 'CSE B'),
('950322104086', 'A. Shalini', 'CSE B'),
('950322104088', 'SIMIYON .J', 'CSE B'),
('950322104089', 'T.sirajudeen', 'CSE B'),
('950322104090', 'SIVAKAMI A', 'CSE B'),
('950322104091', 'J.Snowfa P Rayer', 'CSE B'),
('950322104093', 'SRIMATHI S', 'CSE B'),
('950322104094', 'Srivaishnavi M', 'CSE B'),
('950322104095', 'Stanly Geno. S', 'CSE B'),
('950322104096', 'M.SUBA MALARVIZHI', 'CSE B'),
('950322104098', 'Susanna kumari', 'CSE B'),
('950322104099', 'S.Tamilmozhi', 'CSE B'),
('950322104100', 'M. Uthayakumar', 'CSE B'),
('950322104101', 'Vasanthan B', 'CSE B'),
('950322104103', 'Vishal Kumar', 'CSE B'),
('950322104301', 'Praveen', 'CSE B'),
('950322104302', 'E. Vasanthan', 'CSE B'),
('950322104701', 'Joshua Davidson J', 'CSE B'),
('950322105001', 'Arul raja', 'EEE'),
('950322105002', 'M.Arun Kumar', 'EEE'),
('950322105003', 'P.Arun Nevis', 'EEE'),
('950322105004', 'Baskar. P', 'EEE'),
('950322105005', 'Ebenezer pal s', 'EEE'),
('950322105006', 'EINSTEIN JEBA KUMAR . S', 'EEE'),
('950322105007', 'A Jasmine Beaulah', 'EEE'),
('950322105008', 'jeffray jabez', 'EEE'),
('950322105010', 'KERSOME C', 'EEE'),
('950322105011', 'Murugavalli k', 'EEE'),
('950322105012', 'C.Muthumari', 'EEE'),
('950322105015', 'Pravin Azaria  E', 'EEE'),
('950322105016', 'Varun Sathish.R', 'EEE'),
('950322105302', 'N.MUTHURAMAN', 'EEE'),
('950322106001', 'Aruna C', 'ECE'),
('950322106002', 'P.Bala Murugeshwari', 'ECE'),
('950322106003', 'Bharkavi M', 'ECE'),
('950322106004', 'S.Boomika mari', 'ECE'),
('950322106005', 'Daniel L', 'ECE'),
('950322106006', 'S.Harini', 'ECE'),
('950322106007', 'Jerson Abraham S', 'ECE'),
('950322106009', 'MOHAMMED ZAHEER K', 'ECE'),
('950322106010', 'Nancy Mariya . A', 'ECE'),
('950322106011', 'Parthiban N', 'ECE'),
('950322106012', 'Sakthi raja V', 'ECE'),
('950322106013', 'Sarmila', 'ECE'),
('950322106014', 'Sathyabama.R', 'ECE'),
('950322106015', 'Sivananthini S', 'ECE'),
('950322106018', 'VIJAYAN S', 'ECE'),
('950322106302', 'THAMBIRAJ S', 'ECE'),
('950322243001', 'Alex Matthew R', 'CSE'),
('950322243011', 'Hinduja M', 'AIDS'),
('950322243012', 'jeffrin S', 'AIDS'),
('950322243015', 'S.Muthuselvi', 'AIDS'),
('950322243016', 'S.L Muthu Vivek', 'AIDS'),
('950322243018', 'Oshan', 'AIDS'),
('950322243020', 'Renuga Sree S', 'AIDS'),
('950322243022', 'Ruby Esther Y', 'AIDS'),
('950322243024', 'Sarvesh', 'AIDS'),
('950322243027', 'SRIMURUGAN-A', 'AIDS'),
('950322243028', 'Swarna T', 'AIDS'),
('950322243301', 'Athithya S', 'AIDS'),
('950323631008', 'ARAVINDH P', 'MBA'),
('9894859691', 'Gowtham', 'CSE A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam_seating`
--
ALTER TABLE `exam_seating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seating_arrangement`
--
ALTER TABLE `seating_arrangement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam_seating`
--
ALTER TABLE `exam_seating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seating_arrangement`
--
ALTER TABLE `seating_arrangement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
