-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2022 at 08:36 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DID` varchar(10) NOT NULL,
  `DName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DID`, `DName`) VALUES
('BME', 'Bio-Medical Engineering'),
('CHE', 'Chemical Engineering'),
('CSE', 'Computer Science and Engineering'),
('CVE', 'Civil Engineering'),
('ECE', 'Electronics and Communication Engineering'),
('ME', 'Mechanical Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `FID` varchar(10) NOT NULL,
  `FName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Mobile` varchar(13) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `LeaveApplied` int(11) NOT NULL,
  `LeaveRemaining` int(11) NOT NULL,
  `DID` varchar(10) NOT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FID`, `FName`, `Email`, `Mobile`, `Password`, `LeaveApplied`, `LeaveRemaining`, `DID`, `Role`) VALUES
('01', 'admin', 'admin@gmail.com', '9876543210', 'admin', 0, 12, 'CSE', 'Admin'),
('02', 'faculty', 'faculty@gmail.com', '9876543210', 'faculty', 0, 12, 'CSE', 'Faculty'),
('03', 'CSHOD', 'swapnil.lm14@gmail.com', '95175384260', 'cshod', 0, 12, 'CSE', 'HOD'),
('04', 'Principal', 'principal@gmail.com', '7456321890', 'principal', 0, 12, 'CVE', 'Principal'),
('05', 'faculty2', 'mannurkarswapnil@gmail.com', '456127890', 'fac2', 0, 12, 'CSE', 'Faculty'),
('CS01', 'ABC', 'swapnil.lm14@gmail.com', '9242239078', 'cs01', 0, 12, 'CSE', 'Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applied`
--

CREATE TABLE `leave_applied` (
  `LID` int(4) NOT NULL,
  `SubLID` int(10) NOT NULL,
  `FID` varchar(10) NOT NULL,
  `DID` varchar(10) NOT NULL,
  `Leave_type` varchar(100) NOT NULL,
  `Leave_from` date NOT NULL,
  `Leave_to` date NOT NULL,
  `NoDays` int(11) NOT NULL,
  `FAID` varchar(10) NOT NULL,
  `FAName` varchar(100) NOT NULL,
  `Leave_desc` text NOT NULL,
  `Leave_status` int(11) NOT NULL,
  `HODLS` int(11) NOT NULL,
  `PLS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_applied`
--

INSERT INTO `leave_applied` (`LID`, `SubLID`, `FID`, `DID`, `Leave_type`, `Leave_from`, `Leave_to`, `NoDays`, `FAID`, `FAName`, `Leave_desc`, `Leave_status`, `HODLS`, `PLS`) VALUES
(201, 1, '02', 'CSE', 'Academic', '2022-07-30', '2022-07-30', 1, '03', 'CSHOD', '', 1, 1, 1),
(201, 2, '02', 'CSE', 'Academic', '2022-07-30', '2022-07-30', 1, '05', 'faculty2', '', 1, 1, 1),
(201, 3, '02', 'CSE', 'Academic', '2022-07-30', '2022-07-30', 1, 'CS01', 'ABC', '', 2, 1, 1);

--
-- Triggers `leave_applied`
--
DELIMITER $$
CREATE TRIGGER `update_leave` AFTER INSERT ON `leave_applied` FOR EACH ROW IF (NEW.Leave_type = 'Casual') THEN UPDATE faculty SET LeaveRemaining = LeaveRemaining - (SELECT NoDays FROM leave_applied WHERE LID IN (SELECT MAX(LID) FROM leave_applied)), LeaveApplied = LeaveApplied + (SELECT NoDays FROM leave_applied WHERE LID IN (SELECT MAX(LID) FROM leave_applied)) WHERE FID = NEW.FID; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `LTID` varchar(10) NOT NULL,
  `Leave_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`LTID`, `Leave_type`) VALUES
('AL', 'Academic leave'),
('CL', 'Casual leave'),
('DL', 'Duty leave'),
('LWP', 'Leave without pay');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FID`);

--
-- Indexes for table `leave_applied`
--
ALTER TABLE `leave_applied`
  ADD PRIMARY KEY (`LID`,`SubLID`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`LTID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_applied`
--
ALTER TABLE `leave_applied`
  MODIFY `LID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
