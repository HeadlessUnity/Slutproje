-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: expabtrans.se.mysql:3306
-- Generation Time: Apr 16, 2017 at 06:58 PM
-- Server version: 10.1.21-MariaDB-1~xenial
-- PHP Version: 5.4.45-0+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `expabtrans_se`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fordon`
--

CREATE TABLE IF NOT EXISTS `Fordon` (
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  `AntalPallPlatser` int(3) DEFAULT NULL,
  PRIMARY KEY (`RegNummer`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Kund`
--

CREATE TABLE IF NOT EXISTS `Kund` (
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`Namn`),
  UNIQUE KEY `Namn` (`Namn`),
  UNIQUE KEY `Namn_2` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `php_users_login`
--

CREATE TABLE IF NOT EXISTS `php_users_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `content` text,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `php_users_login`
--

INSERT INTO `php_users_login` (`id`, `email`, `password`, `name`, `phone`, `content`, `last_login`) VALUES
(1, 'demo1@demo.com', 'pass', 'Demo 1', '+0123456789', 'text content for Demo1 user.', NULL),
(2, 'demo2@demo.com', 'pass', 'Demo 2', '+9876543210', 'another text content for Demo2 user', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Produkt`
--

CREATE TABLE IF NOT EXISTS `Produkt` (
  `ID` int(7) NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AndelavPall` int(3) DEFAULT NULL,
  `Antal` int(8) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Namn` (`Namn`),
  UNIQUE KEY `Namn_2` (`Namn`),
  UNIQUE KEY `Namn_3` (`Namn`),
  KEY `Antal` (`Antal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProduktDatum`
--

CREATE TABLE IF NOT EXISTS `ProduktDatum` (
  `ProduktID` int(7) NOT NULL,
  `StartDatum` date DEFAULT NULL,
  `SlutDatum` date DEFAULT NULL,
  PRIMARY KEY (`ProduktID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TransportOrder`
--

CREATE TABLE IF NOT EXISTS `TransportOrder` (
  `OrderID` int(7) NOT NULL,
  `TurID` int(7) NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `KundNamn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Plantering` tinyint(1) DEFAULT NULL,
  `Datum` date DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `Tur-ID` (`TurID`,`RegNummer`,`KundNamn`),
  KEY `TurID` (`TurID`),
  KEY `RegNummer` (`RegNummer`),
  KEY `KundNamn` (`KundNamn`),
  KEY `Datum` (`Datum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TransportProdukt`
--

CREATE TABLE IF NOT EXISTS `TransportProdukt` (
  `OrderID` int(7) NOT NULL,
  `ProduktID` int(7) NOT NULL,
  `ProduktAntal` int(7) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE KEY `ProduktID` (`ProduktID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tur`
--

CREATE TABLE IF NOT EXISTS `Tur` (
  `ID` int(9) NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TurDatum`
--

CREATE TABLE IF NOT EXISTS `TurDatum` (
  `TurID` int(7) NOT NULL,
  `StartDatum` date DEFAULT NULL,
  `SlutDatum` date DEFAULT NULL,
  PRIMARY KEY (`TurID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TurFordon`
--

CREATE TABLE IF NOT EXISTS `TurFordon` (
  `TurID` int(7) NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `FordonNamn` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`TurID`),
  KEY `RegNummer` (`RegNummer`,`FordonNamn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ProduktDatum`
--
ALTER TABLE `ProduktDatum`
  ADD CONSTRAINT `ProduktDatum_ibfk_1` FOREIGN KEY (`ProduktID`) REFERENCES `Produkt` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TransportOrder`
--
ALTER TABLE `TransportOrder`
  ADD CONSTRAINT `TransportOrder_ibfk_1` FOREIGN KEY (`TurID`) REFERENCES `Tur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TransportOrder_ibfk_2` FOREIGN KEY (`KundNamn`) REFERENCES `Kund` (`Namn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TransportOrder_ibfk_3` FOREIGN KEY (`RegNummer`) REFERENCES `TurFordon` (`RegNummer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TransportProdukt`
--
ALTER TABLE `TransportProdukt`
  ADD CONSTRAINT `TransportProdukt_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `TransportOrder` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TransportProdukt_ibfk_2` FOREIGN KEY (`ProduktID`) REFERENCES `Produkt` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TurDatum`
--
ALTER TABLE `TurDatum`
  ADD CONSTRAINT `TurDatum_ibfk_2` FOREIGN KEY (`TurID`) REFERENCES `Tur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
