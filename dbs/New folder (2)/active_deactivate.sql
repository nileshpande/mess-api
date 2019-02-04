-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2017 at 12:52 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mymess`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_deactivate`
--

CREATE TABLE `active_deactivate` (
  `id` bigint(255) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '1:deactive 2:active',
  `amount` varchar(255) NOT NULL,
  `paid` int(5) NOT NULL COMMENT '1:paid  0:unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  ADD CONSTRAINT `active_deactivate_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
