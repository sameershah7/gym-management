-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_task`
--

CREATE TABLE `daily_task` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workout` varchar(255) DEFAULT NULL,
  `workout_status` varchar(255) NOT NULL,
  `diet` varchar(255) DEFAULT NULL,
  `diet_status` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `time_stamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_task`
--

INSERT INTO `daily_task` (`id`, `user_id`, `workout`, `workout_status`, `diet`, `diet_status`, `weight`, `calories`, `time_stamp`) VALUES
(104, 9, 'Chest, Legs, Shoulders', 'true', '', '', 72, 2000, '2025-07-01'),
(105, 9, 'Chest, Legs, Shoulders', 'false', '2000', 'false', 72, 2000, '2025-07-02'),
(106, 9, 'Chest, Legs, Shoulders', 'true', 'i wil be eating applesdaDFSAAAAAA    VLKJAWHF;LASHDDLKFHASDLKFJHASDLKFJHLKSJADHFLKJASUEPRRASDJFLJNASD FASD;F;CHANG EOF THE AGO I WANT TO ATTEEND THE SCHOOL BUT THE SCHOOL IS FAR AWAY FROM MY HOUSE', 'true', 74, 2005, '2025-07-03'),
(108, 9, 'Chest, Legs, ShoulderssdFFDasdfasdfasdfdasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasd', 'false', '2005', 'false', 74, 2005, '2025-07-21'),
(116, 9, '', '', '', '', 87, 2343, '2025-07-22'),
(133, 9, '', '', '', '', 87, 2343, '2025-07-23'),
(134, 9, '', '', '', '', 85, 2379, '2025-07-24');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plan`
--

CREATE TABLE `diet_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `monday` varchar(255) NOT NULL,
  `tuesday` varchar(255) NOT NULL,
  `wednesday` varchar(255) NOT NULL,
  `thursday` varchar(255) NOT NULL,
  `friday` varchar(255) NOT NULL,
  `saturday` varchar(255) NOT NULL,
  `sunday` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `time_stemp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plan`
--

INSERT INTO `diet_plan` (`id`, `user_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `deleted`, `time_stemp`) VALUES
(23, 10, 'eating apple with banana', 'mango', '', '', '', '', '', 1, '2025-07-21'),
(24, 9, 'make shake', '', '', '', '', '', '', 1, '2025-07-21'),
(25, 9, 'hidden', 'i wil be eating apple', '', '', '', '', '', 1, '2025-07-21'),
(26, 10, 'apple', 'mango', '', '', '', '', '', 1, '2025-07-21'),
(27, 10, 'milk,mango', 'mango', 'aaa', '', '', '', '', 1, '2025-07-21'),
(28, 10, 'hidden,apple,chiken', 'mango', '', '', '', '', '', 1, '2025-07-22'),
(29, 9, 'milk', 'mango', 'pineapple', '', '', '', '', 1, '2025-07-23'),
(30, 10, '', 'mango', 'adsfasdfas', '', '', '', '', 0, '2025-07-24'),
(31, 9, 'apple', '', '', '', '', '', '', 1, '2025-07-24');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `username`, `email`, `password`, `timestamp`) VALUES
(9, 'Root', 'shahkhan@gmail.com', '$2y$10$s2jGXqyMipYqMWgg73eKIuTYxCxNyWt5Y0wx3PLJhClTinJ2I75S6', '2025-07-10'),
(10, 'sameershah', 'root@gmail.com', '$2y$10$uKnY/tMNttuNPki2Ekr25OJkTpFkKavnw8BeWmrt7d69tM7UvRL6q', '2025-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `workout_plan`
--

CREATE TABLE `workout_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `monday` varchar(255) NOT NULL,
  `tuesday` varchar(255) NOT NULL,
  `wednesday` varchar(255) NOT NULL,
  `thursday` varchar(255) NOT NULL,
  `friday` varchar(255) NOT NULL,
  `saturday` varchar(255) NOT NULL,
  `sunday` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `time_stamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_plan`
--

INSERT INTO `workout_plan` (`id`, `user_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `deleted`, `time_stamp`) VALUES
(54, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-20'),
(55, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-20'),
(56, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-20'),
(57, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-20'),
(58, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-21'),
(59, 9, 'Chest', 'Chest, Back', '', '', '', '', '', 1, '2025-07-21'),
(60, 9, 'Chest', 'Chest, Back', '', '', '', '', '', 1, '2025-07-21'),
(61, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-21'),
(62, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-22'),
(63, 10, 'Chest, Back, Shoulders', 'Chest, Back, Legs', '', '', '', '', '', 1, '2025-07-22'),
(64, 9, 'Chest', 'Chest, Back', '', '', '', '', '', 1, '2025-07-23'),
(65, 9, 'Chest', 'Chest, Back', '', '', '', '', '', 1, '2025-07-23'),
(66, 10, '', '', 'Chest, Back, Shoulders', '', '', '', '', 0, '2025-07-24'),
(67, 9, 'Chest', 'Chest, Back', '', '', '', '', '', 0, '2025-07-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_task`
--
ALTER TABLE `daily_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diet_plan`
--
ALTER TABLE `diet_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workout_plan`
--
ALTER TABLE `workout_plan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_task`
--
ALTER TABLE `daily_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `diet_plan`
--
ALTER TABLE `diet_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `workout_plan`
--
ALTER TABLE `workout_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
