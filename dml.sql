-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2019 at 09:46 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dml`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `ccode` varchar(4) NOT NULL,
  `grpNo` varchar(2) NOT NULL,
  `semester` enum('1','2','3') NOT NULL,
  `acadYr` year(4) NOT NULL,
  `day` varchar(10) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `teacher` int(11) NOT NULL,
  `status` enum('active','disabled') NOT NULL,
  `pname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_grp`
--

CREATE TABLE `class_grp` (
  `id` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `acadYr` year(4) NOT NULL,
  `semester` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `constants`
--

CREATE TABLE `constants` (
  `id` int(11) NOT NULL,
  `semester` enum('1','2','3') NOT NULL,
  `acadYr` year(4) NOT NULL,
  `acadYr_end` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `constants`
--

INSERT INTO `constants` (`id`, `semester`, `acadYr`, `acadYr_end`) VALUES
(1, '1', 2019, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `value` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('available','broken','repair') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `ordr` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('working','dispensed','returned') NOT NULL,
  `flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordr`
--

CREATE TABLE `ordr` (
  `id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `status` enum('pending','approved','removed','broken','dispensed','returned') NOT NULL,
  `date_ordered` date NOT NULL,
  `date_approved` date NOT NULL,
  `date_dispensed` date NOT NULL,
  `date_returned` date NOT NULL,
  `flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `school_id` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` enum('pending','active','disabled') NOT NULL,
  `type` enum('staff','student','admin','teacher') NOT NULL,
  `contact` varchar(11) NOT NULL,
  `profilepic` varchar(20) NOT NULL,
  `rfid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `mname`, `lname`, `school_id`, `username`, `email`, `password`, `status`, `type`, `contact`, `profilepic`, `rfid`) VALUES
(1, 'Roy', 'Dingding', 'Bispo', '12100469', 'BispoRoy', 'jomarisaragenaofficial@gmail.com', '1234', 'active', 'admin', '09776134935', '5cbc6ecd1a346.png', '111111111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacher`);

--
-- Indexes for table `class_grp`
--
ALTER TABLE `class_grp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class` (`class`),
  ADD KEY `student` (`student`);

--
-- Indexes for table `constants`
--
ALTER TABLE `constants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item` (`item`),
  ADD KEY `ordr` (`ordr`);

--
-- Indexes for table `ordr`
--
ALTER TABLE `ordr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student` (`student`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_grp`
--
ALTER TABLE `class_grp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `constants`
--
ALTER TABLE `constants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordr`
--
ALTER TABLE `ordr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `user` (`id`);

--
-- Constraints for table `class_grp`
--
ALTER TABLE `class_grp`
  ADD CONSTRAINT `class_grp_ibfk_1` FOREIGN KEY (`class`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `class_grp_ibfk_2` FOREIGN KEY (`class`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `class_grp_ibfk_3` FOREIGN KEY (`student`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`item`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`ordr`) REFERENCES `ordr` (`id`);

--
-- Constraints for table `ordr`
--
ALTER TABLE `ordr`
  ADD CONSTRAINT `ordr_ibfk_1` FOREIGN KEY (`student`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ordr_ibfk_2` FOREIGN KEY (`class`) REFERENCES `class` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
