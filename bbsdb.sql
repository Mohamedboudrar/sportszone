-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 16, 2024 at 02:43 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `AdminuserName` varchar(20) DEFAULT NULL,
  `MobileNumber` bigint DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UserType` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `AdminuserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`, `UserType`) VALUES
(2, 'Admin', 'admin', 8956565656, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-08-31 18:30:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblboat`
--

CREATE TABLE `tblboat` (
  `ID` int NOT NULL,
  `BoatName` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Image` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Size` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Capacity` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Source` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Destination` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Route` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Price` decimal(10,0) DEFAULT NULL,
  `Description` mediumtext COLLATE utf8mb4_general_ci,
  `AddedBy` int DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblboat`
--

INSERT INTO `tblboat` (`ID`, `BoatName`, `Image`, `Size`, `Capacity`, `Source`, `Destination`, `Route`, `Price`, `Description`, `AddedBy`, `CreationDate`) VALUES
(12, 'Business Balck Jet', 'd41d8cd98f00b204e9800998ecf8427e1731760837', 'Medium', '8', 'Casablanca, Morocco', 'Monaco', 'Direct', 2000, 'Balck Jet for Business', 2, '2024-11-16 12:40:37'),
(13, 'Learjet 45', 'd41d8cd98f00b204e9800998ecf8427e1731762399', 'Medium', '10', 'Rabat, Morocco', 'Paris, France', 'Direct', 3000, 'bussiness', 2, '2024-11-16 13:06:39'),
(14, 'The Super Versatile Jet', 'd41d8cd98f00b204e9800998ecf8427e1731764688', 'Medium', '8', 'Casablanca, Morocco', 'London, UK', 'Direct', 2500, 'Business, Trip', 2, '2024-11-16 13:44:48'),
(15, 'Tecnam P2008', 'd41d8cd98f00b204e9800998ecf8427e1731766564', 'Small', '2', 'Rabat, Morocco', 'Errachidia, Morocco', 'Direct', 750, 'quick', 2, '2024-11-16 14:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `tblbookings`
--

CREATE TABLE `tblbookings` (
  `ID` int NOT NULL,
  `BoatID` int DEFAULT NULL,
  `BookingNumber` bigint DEFAULT NULL,
  `FullName` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `EmailId` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PhoneNumber` bigint DEFAULT NULL,
  `BookingDateFrom` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BookingDateTo` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BookingTime` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NumnerofPeople` int DEFAULT NULL,
  `Notes` mediumtext COLLATE utf8mb4_general_ci,
  `postingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BookingStatus` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbookings`
--

INSERT INTO `tblbookings` (`ID`, `BoatID`, `BookingNumber`, `FullName`, `EmailId`, `PhoneNumber`, `BookingDateFrom`, `BookingDateTo`, `BookingTime`, `NumnerofPeople`, `Notes`, `postingDate`, `AdminRemark`, `BookingStatus`, `UpdationDate`) VALUES
(6, 14, 5902399998, 'Boudrar Mohamed', 'boudrarmed2003@gmail.com', 612450649, '2024-11-17', '2024-11-23', '06:45', 8, 'hhh', '2024-11-16 13:45:45', 'ok', 'Accepted', '2024-11-16 13:46:25'),
(7, 15, 2699224874, 'simo', 'simo@gmail.com', 726353627, '2024-11-18', '2024-11-20', '10:00', 10, 'thanks', '2024-11-16 14:18:09', 'only 2 persons', 'Rejected', '2024-11-16 14:18:46'),
(8, 15, 9667171288, 'simo', 'mohamed@gmail.com', 999999999, '2024-11-20', '2024-11-23', '12:21', 2, 'ok', '2024-11-16 14:22:21', 'ok', 'Accepted', '2024-11-16 14:22:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblboat`
--
ALTER TABLE `tblboat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblbookings`
--
ALTER TABLE `tblbookings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bid` (`BoatID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblboat`
--
ALTER TABLE `tblboat`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblbookings`
--
ALTER TABLE `tblbookings`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbookings`
--
ALTER TABLE `tblbookings`
  ADD CONSTRAINT `bid` FOREIGN KEY (`BoatID`) REFERENCES `tblboat` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
