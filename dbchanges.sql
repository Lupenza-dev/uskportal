-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 27, 2023 at 08:28 PM
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
-- Table structure for table `loan_contracts`
--

CREATE TABLE `loan_contracts` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_application_id` int(11) NOT NULL,
  `loan_type` varchar(20) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `total_loan_amount` float DEFAULT NULL,
  `installment_amount` float NOT NULL,
  `plan` int(11) NOT NULL,
  `fee_amount` float DEFAULT NULL,
  `interest_amount` float DEFAULT NULL,
  `interest_rate` float DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `current_balance` float NOT NULL,
  `outstanding_amount` float NOT NULL,
  `contract_code` varchar(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `expected_end_date` date DEFAULT NULL,
  `past_due_days` int(11) DEFAULT NULL,
  `past_due_amount` float DEFAULT NULL,
  `penalt_amount` float DEFAULT NULL,
  `penalt_amount_paid` float DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loan_contracts`
--

INSERT INTO `loan_contracts` (`id`, `member_id`, `loan_application_id`, `loan_type`, `total_amount`, `total_loan_amount`, `installment_amount`, `plan`, `fee_amount`, `interest_amount`, `interest_rate`, `status`, `current_balance`, `outstanding_amount`, `contract_code`, `start_date`, `expected_end_date`, `past_due_days`, `past_due_amount`, `penalt_amount`, `penalt_amount_paid`, `uuid`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'emergence loan', 100000, 120000, 40000, 6, 10000, 10, 10, 'GRANTED', 35000, 75000, 'xc4555', '2023-02-01', '2023-02-24', 0, 0, 0, 0, 'errffff-poooop', '2023-02-27 20:27:34', '2023-02-27 20:27:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loan_contracts`
--
ALTER TABLE `loan_contracts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loan_contracts`
--
ALTER TABLE `loan_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
