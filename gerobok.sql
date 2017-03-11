-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2016 at 03:22 PM
-- Server version: 5.5.27
-- PHP Version: 5.6.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gerobok`
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
  `LEVEL` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `NAME`, `GENDER`, `DOB`, `ADDRESS`, `PHONE`, `IC`, `POSITION`, `PASSWORD`, `LEVEL`) VALUES
('E001', 'AFIF ZAFRI', 'Male', '1996-05-21', 'KAMPUNG PAYA, PERLIS', '0174105440', '960521025077', 'MANAGER', 'Afif12345', 1),
('E002', 'HASSAN HAMID', 'Male', '1996-09-19', 'ALOR STAR', '0174446721', '960919025142', 'CASHER', 'E002', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(100) NOT NULL,
  `TEXT` varchar(200) NOT NULL,
  `EMPID` char(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `GPRICE` double NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `SizeAvailable`, `ColorsAvailable`, `SleeveAvailable`, `FlowersEmbAvailable`, `GPRICE`) VALUES
('KB01', 'KEBAYA HITAM', 'M,L,XL,XXL,XXXL,XXXXL,XXXXXL', 'BLACK', '3/4,L/S', 'KP,KL', 40),
('KB02', 'KEBAYA BUNGA', 'S,M,L,XL,XXL', 'PINK,PURPLE,KUNING,ASSORTED', 'L/S', '', 40),
('KB03', 'KEBAYA HITAM G/S', 'S,M,L,XL', 'BLACK', 'FULL BUTTON,1 BUTTON', 'GOLD,SILVER', 40),
('KB04', 'KEBAYA SALOMA', 'XS,S,M,L,XL', 'WHITE,BLACK,BLUE,DUSTY PURPLE,SHOCKING PINK', '', '', 30),
('KB05', 'KEBAYA PUTIH', 'L,XL', 'WHITE', '3/4,L', 'B1,B2,B3,B4', 35);

-- --------------------------------------------------------

--
-- Table structure for table `productdetail`
--

CREATE TABLE IF NOT EXISTS `productdetail` (
  `DetailID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` varchar(50) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Colors` varchar(50) NOT NULL,
  `Sleeve` varchar(100) DEFAULT NULL,
  `FlowersEmb` varchar(100) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`DetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `productdetail`
--

INSERT INTO `productdetail` (`DetailID`, `ProductID`, `Size`, `Colors`, `Sleeve`, `FlowersEmb`, `Quantity`) VALUES
(15, 'KB04', 'XS', 'WHITE', '', '', 11),
(16, 'KB04', 'XS', 'BLACK', '', '', 8),
(17, 'KB02', 'S', 'PINK', 'L/S', '', 2),
(18, 'KB03', 'S', 'BLACK', 'FULL BUTTON', 'GOLD', 10),
(19, 'KB05', 'L', 'WHITE', '3/4', 'B1', 7);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
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
  `DATE_TIME` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`ID`, `EMPID`, `PRODUCTID`, `NAME`, `COLORS`, `SIZE`, `SLEEVE`, `FLOWERSEMB`, `QUANTITY`, `PRICE`, `REVENUE`, `DATE_TIME`) VALUES
(27, 'E001', '', 'KEBAYA HITAM G/S', 'BLACK', 'S', 'FULL BUTTON', 'GOLD', 2, 156, 76, '2016-01-18 00:00:00'),
(28, 'E001', '', 'KEBAYA SALOMA', 'WHITE', 'XS', '', '', 2, 156, 96, '2016-01-18 00:00:00'),
(29, 'E001', '', 'KEBAYA SALOMA', 'WHITE', 'XS', '', '', 4, 312, 192, '2016-01-19 00:00:00'),
(30, 'E001', 'KB03', 'KEBAYA HITAM G/S', 'BLACK', 'S', 'FULL BUTTON', 'GOLD', 2, 200, 120, '2016-02-08 00:00:00'),
(31, 'E001', 'KB04', 'KEBAYA SALOMA', 'WHITE', 'XS', '', '', 2, 160, 100, '2016-02-08 00:00:00'),
(32, 'E001', 'KB02', 'KEBAYA BUNGA', 'PINK', 'S', 'L/S', '', 2, 200, 120, '2016-01-09 00:00:00'),
(33, 'E001', 'KB04', 'KEBAYA SALOMA', 'BLACK', 'XS', '', '', 2, 180, 120, '2016-02-05 00:00:00'),
(34, 'E001', 'KB04', 'KEBAYA SALOMA', 'WHITE', 'XS', '', '', 3, 255, 165, '2016-02-01 00:00:00'),
(35, 'E001', 'KB05', 'KEBAYA PUTIH', 'WHITE', 'L', '3/4', 'B1', 3, 210, 105, '2016-02-08 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
