-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 12:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wooxtravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(4) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mypassword` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `email`, `mypassword`, `created_at`) VALUES
(1, 'admin_first', 'admin.first@admin.first.com', '$2y$10$65CGA7.VMyPUZWRbL8GLS.YlvyP3ff2WDliCIdLhu/MsYEIoCSgSG', '2023-03-16 09:39:07'),
(2, 'admin.second@admin.com', 'admin.second@admin.com', '$2y$10$HjV.Y/.YdAO87kgKyhS/jOKwKasFLdrqkSlbl5RRnRWOto7H2VxXe', '2023-03-16 11:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone_number` int(30) NOT NULL,
  `num_of_geusts` int(10) NOT NULL,
  `checkin_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `destination` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `city_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `payment` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `phone_number`, `num_of_geusts`, `checkin_date`, `destination`, `status`, `city_id`, `user_id`, `payment`, `created_at`) VALUES
(1, 'Mohamed Hassan', 239933, 3, '2023-03-13 12:43:41.018338', 'Berlin', 'Pending', 3, 1, '', '2023-03-13 11:44:21'),
(2, 'John Doe', 2929333, 2, '2023-03-13 12:43:44.762363', 'Frankfurt', 'Pending', 4, 1, '', '2023-03-13 11:44:21'),
(3, 'Mohamed Hassan', 202039933, 2, '2023-03-13 12:43:47.207332', 'Berlin', 'Pending', 3, 1, '', '2023-03-13 11:59:13'),
(4, 'Mohamed Hassan', 2023333, 5, '0000-00-00 00:00:00.000000', 'Alex', 'Pending', 2, 1, '', '2023-03-13 14:00:15'),
(5, 'MOhamed ', 3434343, 2, '2023-03-24 22:00:00.000000', 'Frankfurt', 'Pending', 4, 1, '', '2023-03-13 14:44:12'),
(10, 'Mohamed Hassan ', 2147483647, 2, '2023-03-15 10:40:29.454315', 'Giza', 'Pending', 1, 1, '2', '2023-03-14 11:12:31'),
(11, 'Mohamed ', 3333333, 2, '2023-03-16 13:55:22.615992', 'Frankfurt', 'Booked Successfully', 4, 1, '1000', '2023-03-14 11:16:36'),
(17, 'Mohamed Hassan', 2147483647, 2, '2023-03-16 13:55:12.561384', 'Berlin', 'Pending', 3, 1, '1200', '2023-03-14 13:30:12'),
(18, 'Mohamed Hassan', 333333, 3, '2023-03-20 22:00:00.000000', 'Alex', 'Pending', 2, 2, '1350', '2023-03-17 11:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `trip_days` int(4) NOT NULL,
  `price` varchar(4) NOT NULL,
  `country_id` int(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `image`, `trip_days`, `price`, `country_id`, `created_at`) VALUES
(1, 'Giza', 'offers-02.jpg', 4, '200', 1, '2023-03-12 13:33:14'),
(2, 'Alex', 'offers-03.jpg', 6, '450', 1, '2023-03-12 13:33:14'),
(3, 'Berlin', 'offers-01.jpg', 4, '600', 2, '2023-03-12 13:52:46'),
(4, 'Frankfurt', 'deals-01.jpg', 5, '500', 2, '2023-03-12 13:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `continent` varchar(200) NOT NULL,
  `population` varchar(30) NOT NULL,
  `territory` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `image`, `continent`, `population`, `territory`, `description`, `created_at`) VALUES
(1, 'Egypt', 'banner-01.jpg', 'Africa', '100', '41.290 ', 'Credibly architect dynamic methodologies through global meta-services. Completely plagiarize cross-unit.\nFetching Countries in Index Page', '2023-03-12 13:28:03'),
(2, 'Germany', 'banner-02.jpg', 'Europe', '90', '275.40', 'Credibly architect dynamic methodologies through global meta-services. Completely plagiarize cross-unit.', '2023-03-12 13:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `mypassword` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `mypassword`, `created_at`) VALUES
(1, 'mohamed.hassan@gmail.com', 'mohamed.hassan@gmail.com', '$2y$10$65CGA7.VMyPUZWRbL8GLS.YlvyP3ff2WDliCIdLhu/MsYEIoCSgSG', '2023-03-11 15:21:17'),
(2, 'user@user.com', 'user@user.com', '$2y$10$hYFYK3ProvaCQ3WAhAqmheDtrDnWh/Ccyg0IHOyM6XunUikmFdeaC', '2023-03-17 11:46:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
