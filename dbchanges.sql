-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 28, 2023 at 06:38 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usk`
--

-- --------------------------------------------------------

--
-- Table structure for table `member_saving_summaries`
--

CREATE TABLE `member_saving_summaries` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `total_saving` float NOT NULL,
  `current_saving` float DEFAULT '0',
  `holded_saving` float NOT NULL DEFAULT '0',
  `last_saving_amount` float NOT NULL,
  `last_saving_date` datetime DEFAULT NULL,
  `total_monthly_fees` float DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_saving_summaries`
--

INSERT INTO `member_saving_summaries` (`id`, `member_id`, `total_saving`, `current_saving`, `holded_saving`, `last_saving_amount`, `last_saving_date`, `total_monthly_fees`, `uuid`, `created_at`, `updated_at`) VALUES
(1, 1, 500000, 400000, 100000, 50000, '2023-02-28 06:37:38', 300000, 'frsrrssss', '2023-02-28 06:38:13', '2023-02-28 06:38:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member_saving_summaries`
--
ALTER TABLE `member_saving_summaries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member_saving_summaries`
--
ALTER TABLE `member_saving_summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
