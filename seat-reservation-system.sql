-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 11:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seat-reservation-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Admin1', 'admin1'),
(2, 'Admin2', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(50) NOT NULL,
  `reservation_date` date NOT NULL,
  `seat_no` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `emp_id`, `reservation_date`, `seat_no`, `employee_name`, `phone_number`, `email`, `created_at`) VALUES
(16, 'slt/2024/002', '2024-09-18', 2, 'Yashini', '0770350696', 'yashini@gmail.com', '2024-08-31 08:25:46'),
(18, 'slt/2024/001', '2024-09-18', 1, 'Udari Sandalika', '0701094099', 'udarihatharasinghe@gmail.com', '2024-08-31 08:27:58'),
(21, 'slt/2024/003', '2024-10-23', 2, 'Udari Sandalika', '0701094099', 'udarihatharasinghe@gmail.com', '2024-09-02 13:49:43'),
(22, 'slt/2024/002', '2024-11-13', 3, 'Yashini', '546485475', 'jyut6ruyi@gmail.com', '2024-09-02 17:52:46'),
(26, 'slt/2024/001', '2024-10-17', 2, 'Udari Sandalika', '0701094099', 'udarihatharasinghe@gmail.com', '2024-09-03 08:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(50) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `seat_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `emp_id`, `reservation_date`, `seat_no`, `created_at`) VALUES
(32, 'slt/2024/002', '2024-09-18', 2, '2024-08-31 08:25:46'),
(34, 'slt/2024/001', '2024-09-18', 1, '2024-08-31 08:27:58'),
(37, 'slt/2024/003', '2024-10-23', 2, '2024-09-02 13:49:43'),
(38, 'slt/2024/002', '2024-11-13', 3, '2024-09-02 17:52:46'),
(42, 'slt/2024/001', '2024-10-17', 2, '2024-09-03 08:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `seat_no` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `emp_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `seat_no`, `reservation_date`, `emp_id`, `created_at`) VALUES
(32, 2, '2024-09-18', 'slt/2024/002', '2024-08-31 08:25:46'),
(34, 1, '2024-09-18', 'slt/2024/001', '2024-08-31 08:27:58'),
(37, 2, '2024-10-23', 'slt/2024/003', '2024-09-02 13:49:43'),
(38, 3, '2024-11-13', 'slt/2024/002', '2024-09-02 17:52:46'),
(42, 2, '2024-10-17', 'slt/2024/001', '2024-09-03 08:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_id`, `name`, `email`, `nic`, `password`) VALUES
(1, 'slt/2024/001', 'Udari Sandalika', 'udarihatharasinghe@gmail.com', '200062401684', '1122'),
(2, 'slt/2024/002', 'Yashini Nimendya', 'yashininim@gmail.com', '200108100306', '200108100306'),
(3, 'slt/2024/003', 'H.G.U. Sandalika', 'udari@gmail.com', '20304050', '20304050');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `users` (`emp_id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `users` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
