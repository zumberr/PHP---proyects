-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2023 at 02:27 PM
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
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Design', '2023-03-07 13:07:46'),
(2, 'Marketing', '2023-03-07 13:07:46'),
(3, 'Programming', '2023-03-07 13:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(3) NOT NULL,
  `title` varchar(200) NOT NULL,
  `post_author` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `post_author`, `category`, `body`, `created_at`) VALUES
(1, 'Post one', 'Mohamed sallah', 'Design', 'Competently harness resource-leveling e-tailers with cost effective mindshare. Globally synergize inexpensive quality vectors before inexpensive metrics. Phosfluorescently transition ubiquitous process improvements and process-centric web.', '2023-03-06 13:31:51'),
(2, 'post 2', 'Mohamed sallah', 'Marketing', 'Competently facilitate visionary web-readiness after progressive process improvements. Globally leverage other\'s high standards in testing procedures without global bandwidth. Progressively underwhelm progressive functionalities rather.', '2023-03-06 13:34:14'),
(3, 'third question ', 'Mohamed sallah', 'Programming', 'Collaboratively optimize client-based expertise without proactive opportunities. Globally disintermediate high standards in technologies and virtual e-services. ', '2023-03-07 12:53:58'),
(4, 'fourth question', 'Mohamed sallah', 'Marketing', 'Monotonectally underwhelm prospective communities via intermandated action items. Seamlessly architect strategic meta-services without team driven growth strategies. Quickly network error-free architectures with clicks-and-mortar relationships.', '2023-03-07 13:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(3) NOT NULL,
  `author_name` varchar(200) NOT NULL,
  `replay` text NOT NULL,
  `post_id` int(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `author_name`, `replay`, `post_id`, `created_at`) VALUES
(1, 'Mohamed Hassan', 'Continually mesh web-enabled imperatives after unique deliverables. Synergistically actualize future-proof vortal', 1, '2023-03-06 14:27:13'),
(2, 'Jake Walker', 'Proactively fashion excellent schemas for distributed data. Competently whiteboard tactical imperatives after cross-unit alignments. Intrinsicly expedite synergistic quality vectors without just in time strategic.', 1, '2023-03-06 14:36:22'),
(3, 'Mohamed Hassan', 'Holisticly unleash high-quality platforms with error-free potentialities. Authoritatively exploit bricks-and-clicks supply chains via standards compliant leadership skills.', 2, '2023-03-06 17:10:34'),
(4, 'Mohamed Hassan', 'Continually develop web-enabled platforms without granular web services. Continually deploy market positioning imperatives through clicks-and-mortar schemas. Conveniently maintain cross functional platforms rather than installed.', 4, '2023-03-07 13:14:19'),
(5, 'MOhamed Hassan', 'a new reply', 3, '2023-03-07 13:21:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
