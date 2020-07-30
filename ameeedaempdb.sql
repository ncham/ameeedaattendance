-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2020 at 04:42 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ameeedaempdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `date` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time NOT NULL,
  `qkin` time NOT NULL,
  `qkout` time NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `empid`, `date`, `timein`, `timeout`, `qkin`, `qkout`, `notes`) VALUES
(1, 100, '2020-07-27', '09:25:03', '12:01:02', '13:00:00', '18:00:00', ''),
(2, 101, '2020-07-27', '21:39:54', '00:00:00', '00:00:00', '00:00:00', ''),
(3, 101, '2020-07-28', '13:51:20', '00:00:00', '14:50:37', '15:50:37', ''),
(4, 101, '2020-07-29', '17:04:34', '21:26:54', '21:27:03', '22:27:03', ''),
(8, 100, '2020-07-29', '18:07:28', '18:07:32', '18:07:34', '19:07:34', ''),
(9, 100, '2020-07-30', '09:20:51', '00:00:00', '00:00:00', '00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `middlename`, `lastname`, `email`, `dob`, `address`, `notes`, `created_at`) VALUES
(100, 'Niwantha', 'Chamara', 'Wickramasinghe', 'n.wickramasinghe@ameeeda.jp', '1985-12-11', '', '', '2020-07-21 13:51:55'),
(101, 'John', '', 'Doe', 'johndoe@gmail.com', '1988-01-25', '', '', '2020-07-22 10:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `notes`) VALUES
(1, 'Administrator', ''),
(2, 'Operator', ''),
(3, 'User', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `roleid`, `empid`, `username`, `password`, `created_at`) VALUES
(1, 1, 100, 'chamarawix', '123456', '2020-07-21 13:56:09'),
(4, 3, 101, 'johndoe', '123', '2020-07-22 14:59:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_employee_attendance` (`empid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_user_role` (`roleid`),
  ADD KEY `FK_user_employee` (`empid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FK_employee_attendance` FOREIGN KEY (`empid`) REFERENCES `employee` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_employee` FOREIGN KEY (`empid`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `FK_user_role` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
