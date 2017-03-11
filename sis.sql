-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2017 at 03:30 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sisnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `ID` char(4) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `DOB` date NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `PHONE` varchar(50) NOT NULL,
  `IC` varchar(50) NOT NULL,
  `POSITION` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `LEVEL` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `NAME`, `GENDER`, `DOB`, `ADDRESS`, `PHONE`, `IC`, `POSITION`, `PASSWORD`, `LEVEL`) VALUES
('E001', 'AFIF ZAFRI', 'Male', '1996-05-21', 'KAMPUNG PAYA, PERLIS', '0171235984', '960521024569', 'MANAGER', 'Afif12345', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `TEXT` varchar(200) NOT NULL,
  `EMPID` char(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`ID`, `TITLE`, `TEXT`, `EMPID`) VALUES
(1, 'Sticky Notes!', '1. Click "Add Notes" to add new Sticky Notes <br>\r\n2. Click on existing notes to edit it.', 'E001');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` varchar(50) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `SizeAvailable` varchar(200) NOT NULL,
  `ColorsAvailable` varchar(200) DEFAULT NULL,
  `SleeveAvailable` varchar(200) DEFAULT NULL,
  `FlowersEmbAvailable` varchar(200) DEFAULT NULL,
  `GPRICE` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `productdetail`
--

CREATE TABLE IF NOT EXISTS `productdetail` (
  `DetailID` int(11) NOT NULL,
  `ProductID` varchar(50) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Colors` varchar(50) NOT NULL,
  `Sleeve` varchar(100) DEFAULT NULL,
  `FlowersEmb` varchar(100) DEFAULT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `ID` int(11) NOT NULL,
  `EMPID` char(4) NOT NULL,
  `PRODUCTID` varchar(50) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `COLORS` varchar(50) NOT NULL,
  `SIZE` varchar(10) NOT NULL,
  `SLEEVE` varchar(100) DEFAULT NULL,
  `FLOWERSEMB` varchar(100) DEFAULT NULL,
  `QUANTITY` int(200) NOT NULL,
  `PRICE` double NOT NULL,
  `REVENUE` double NOT NULL,
  `DATE_TIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `productdetail`
--
ALTER TABLE `productdetail`
  ADD PRIMARY KEY (`DetailID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `productdetail`
--
ALTER TABLE `productdetail`
  MODIFY `DetailID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
