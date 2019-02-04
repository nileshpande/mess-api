-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2018 at 05:56 PM
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
-- Table structure for table `account_status`
--

CREATE TABLE `account_status` (
  `id` bigint(255) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thak_baki` varchar(255) NOT NULL DEFAULT '0',
  `extra_payment` varchar(255) NOT NULL DEFAULT '0',
  `last_pay_amount` varchar(255) NOT NULL DEFAULT '0',
  `pay_date` date NOT NULL,
  `date` date NOT NULL,
  `year` varchar(255) NOT NULL,
  `closed` int(5) NOT NULL COMMENT '0:on 1:closed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_status`
--

INSERT INTO `account_status` (`id`, `reg_id`, `name`, `thak_baki`, `extra_payment`, `last_pay_amount`, `pay_date`, `date`, `year`, `closed`) VALUES
(1, 0, 'Common Middle Man', '0', '0', '0', '0000-00-00', '0000-00-00', '2018', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(255) NOT NULL,
  `reg_id_student` bigint(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `present_status` int(5) NOT NULL,
  `shift_time` int(5) NOT NULL DEFAULT '0' COMMENT '1:nashta 2:lunch 3:dinner',
  `khada_status` int(5) NOT NULL COMMENT 'khada aheka',
  `day` varchar(255) NOT NULL COMMENT 'var:- monday tuesday etc',
  `month` varchar(255) NOT NULL COMMENT 'june july etc',
  `year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `authentic_user`
--

CREATE TABLE `authentic_user` (
  `id` int(55) NOT NULL,
  `loginid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  `active_status` int(55) NOT NULL COMMENT '1:active:0:deactive',
  `role` int(55) NOT NULL COMMENT 'role'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` bigint(255) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `name` varchar(555) NOT NULL,
  `thak_baki` int(255) NOT NULL,
  `extra_payment` varchar(255) NOT NULL,
  `amount_this_month` varchar(255) NOT NULL,
  `amount_tobe_pay` varchar(255) NOT NULL,
  `paid` int(5) NOT NULL,
  `paid_ammount` varchar(255) DEFAULT '0' COMMENT 'actual paid ammount',
  `date` date NOT NULL,
  `note` text NOT NULL,
  `auther` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cron_and_status`
--

CREATE TABLE `cron_and_status` (
  `id` bigint(255) NOT NULL,
  `type_of_ob` int(5) NOT NULL COMMENT '1:session 2:bill 3:backup',
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `complete` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `id` bigint(255) NOT NULL,
  `known_unkonwn` int(5) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `normal_feist` int(5) NOT NULL,
  `date` date NOT NULL,
  `amount` varchar(255) NOT NULL COMMENT 'either customm or by fixed rate',
  `paid_status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `khada_table`
--

CREATE TABLE `khada_table` (
  `id` bigint(255) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `total_khade_demand` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `informed_date` date NOT NULL,
  `shift` int(11) NOT NULL COMMENT 'morning,evening'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mess_config`
--

CREATE TABLE `mess_config` (
  `id` int(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `contact_number_person` varchar(55) NOT NULL,
  `contact_number_organization` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL,
  `adhar_number` varchar(255) NOT NULL,
  `active_status` int(5) NOT NULL DEFAULT '0' COMMENT '1:active:0:deactive',
  `system_key` varchar(255) NOT NULL COMMENT 'key',
  `your_key` varchar(255) NOT NULL COMMENT 'product key',
  `amount` varchar(55) DEFAULT '0',
  `licence_type` varchar(55) NOT NULL COMMENT '1:lifetime,2:1year,3:2year',
  `organization_adress` varchar(255) NOT NULL,
  `khada_limit` int(55) NOT NULL DEFAULT '1',
  `monthly_rate` int(255) NOT NULL DEFAULT '1000',
  `feist_rate` int(255) NOT NULL DEFAULT '50',
  `outsider_member_rate` int(255) NOT NULL DEFAULT '50',
  `nashta_rate` int(255) NOT NULL DEFAULT '10',
  `nashtastarttime` varchar(255) NOT NULL DEFAULT '07:00',
  `nashtaendtime` varchar(255) NOT NULL DEFAULT '10:59',
  `lunchstarttime` varchar(255) NOT NULL DEFAULT '11:00',
  `lunchendtime` varchar(255) NOT NULL DEFAULT '17:00',
  `dinnerstarttime` varchar(255) NOT NULL DEFAULT '17:01',
  `dinnerendtime` varchar(255) NOT NULL DEFAULT '23:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_summary`
--

CREATE TABLE `monthly_summary` (
  `id` bigint(255) NOT NULL,
  `reg_id` bigint(255) NOT NULL,
  `total_days_present` int(255) NOT NULL,
  `total_days_abscent` int(255) NOT NULL,
  `total_khade_known` int(255) NOT NULL,
  `total_days_month` int(255) NOT NULL,
  `xyz` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `reg_id` bigint(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `addres_permanant` varchar(255) NOT NULL,
  `address_corespondance` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `course` text NOT NULL,
  `hostel_no` varchar(255) NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `blood_grp` varchar(255) NOT NULL DEFAULT '0',
  `start_date_mess` date NOT NULL,
  `photo` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `deactivated` int(55) NOT NULL COMMENT '0:active1:deactivate',
  `update_date` date NOT NULL,
  `deactivated_date` date NOT NULL COMMENT 'date of deactivate',
  `deactivate_type` int(55) NOT NULL COMMENT '1:guest type2:monthly type3:admission close'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`reg_id`, `fname`, `mname`, `lname`, `addres_permanant`, `address_corespondance`, `phone_number`, `mobile`, `department`, `branch`, `course`, `hostel_no`, `room_no`, `blood_grp`, `start_date_mess`, `photo`, `year`, `deactivated`, `update_date`, `deactivated_date`, `deactivate_type`) VALUES
(0, 'Common', 'Middle', 'Man', 'Jalgaon', 'Jalgaon', '9673129396', '9673129396', 'IT', 'IT', 'IT', '0', '0', 'A+', '2018-02-01', 'no.jpg', '2018', 0, '2018-02-01', '0000-00-00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_status`
--
ALTER TABLE `account_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id_student` (`reg_id_student`);

--
-- Indexes for table `authentic_user`
--
ALTER TABLE `authentic_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loginid` (`loginid`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `cron_and_status`
--
ALTER TABLE `cron_and_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`),
  ADD KEY `known_unkonwn` (`known_unkonwn`);

--
-- Indexes for table `khada_table`
--
ALTER TABLE `khada_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `mess_config`
--
ALTER TABLE `mess_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_summary`
--
ALTER TABLE `monthly_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`reg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_status`
--
ALTER TABLE `account_status`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `authentic_user`
--
ALTER TABLE `authentic_user`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cron_and_status`
--
ALTER TABLE `cron_and_status`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `khada_table`
--
ALTER TABLE `khada_table`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mess_config`
--
ALTER TABLE `mess_config`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `monthly_summary`
--
ALTER TABLE `monthly_summary`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `reg_id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_status`
--
ALTER TABLE `account_status`
  ADD CONSTRAINT `account_status_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`);

--
-- Constraints for table `active_deactivate`
--
ALTER TABLE `active_deactivate`
  ADD CONSTRAINT `active_deactivate_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`reg_id_student`) REFERENCES `student` (`reg_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `guest`
--
ALTER TABLE `guest`
  ADD CONSTRAINT `guest_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`);

--
-- Constraints for table `khada_table`
--
ALTER TABLE `khada_table`
  ADD CONSTRAINT `khada_table_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`);

--
-- Constraints for table `monthly_summary`
--
ALTER TABLE `monthly_summary`
  ADD CONSTRAINT `monthly_summary_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `student` (`reg_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
