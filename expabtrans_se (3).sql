-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 maj 2017 kl 14:00
-- Serverversion: 5.7.14
-- PHP-version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `expabtrans_se`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `fordon`
--

CREATE TABLE `fordon` (
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AntalPallPlatser` int(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;



-- --------------------------------------------------------

--
-- Tabellstruktur `kund`
--

CREATE TABLE `kund` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `php_users_login`
--

CREATE TABLE `php_users_login` (
  `ID` int(10) UNSIGNED NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `content` text,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `php_users_login`
--

INSERT INTO `php_users_login` (`ID`, `user`, `password`, `name`, `phone`, `content`, `last_login`) VALUES
(1, 'admin', 'RHfmgzR6', 'admin', NULL, NULL, '2017-05-15 17:28:42');

-- --------------------------------------------------------

--
-- Tabellstruktur `produkt`
--

CREATE TABLE `produkt` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AndelavPall` int(3) UNSIGNED DEFAULT NULL,
  `Antal` int(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;



-- --------------------------------------------------------

--
-- Tabellstruktur `produktdatum`
--

CREATE TABLE `produktdatum` (
  `ProduktID` int(10) UNSIGNED NOT NULL,
  `StartDatum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SlutDatum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `transportorder`
--

CREATE TABLE `transportorder` (
  `OrderID` int(10) NOT NULL,
  `TurID` int(10) UNSIGNED NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `KundID` int(10) UNSIGNED NOT NULL,
  `Plantering` tinyint(1) DEFAULT NULL,
  `Datum` date DEFAULT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `transportprodukt`
--

CREATE TABLE `transportprodukt` (
  `OrderID` int(10) NOT NULL,
  `ProduktID` int(10) UNSIGNED NOT NULL,
  `ProduktAntal` int(8) UNSIGNED DEFAULT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `tur`
--

CREATE TABLE `tur` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;



-- --------------------------------------------------------

--
-- Tabellstruktur `turdatum`
--

CREATE TABLE `turdatum` (
  `TurID` int(10) UNSIGNED NOT NULL,
  `StartDatum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SlutDatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;



-- --------------------------------------------------------

--
-- Tabellstruktur `turfordon`
--

CREATE TABLE `turfordon` (
  `TurID` int(10) UNSIGNED NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `FordonNamn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AntalPallPlatser` int(4) DEFAULT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;



--
-- Index för dumpade tabeller
--

--
-- Index för tabell `fordon`
--
ALTER TABLE `fordon`
  ADD PRIMARY KEY (`RegNummer`),
  ADD UNIQUE KEY `Namn` (`Namn`);

--
-- Index för tabell `kund`
--
ALTER TABLE `kund`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Namn` (`Namn`);

--
-- Index för tabell `php_users_login`
--
ALTER TABLE `php_users_login`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Namn` (`Namn`);

--
-- Index för tabell `produktdatum`
--
ALTER TABLE `produktdatum`
  ADD PRIMARY KEY (`ProduktID`);

--
-- Index för tabell `transportorder`
--
ALTER TABLE `transportorder`
  ADD PRIMARY KEY (`OrderID`);

--
-- Index för tabell `transportprodukt`
--
ALTER TABLE `transportprodukt`
  ADD PRIMARY KEY (`OrderID`),
  ADD UNIQUE KEY `OrderID` (`OrderID`),
  ADD UNIQUE KEY `ProduktID` (`ProduktID`);

--
-- Index för tabell `tur`
--
ALTER TABLE `tur`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Namn` (`Namn`);

--
-- Index för tabell `turdatum`
--
ALTER TABLE `turdatum`
  ADD PRIMARY KEY (`TurID`),
  ADD UNIQUE KEY `TurID` (`TurID`);

--
-- Index för tabell `turfordon`
--
ALTER TABLE `turfordon`
  ADD PRIMARY KEY (`TurID`),
  ADD UNIQUE KEY `TurID` (`TurID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `kund`
--
ALTER TABLE `kund`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT för tabell `php_users_login`
--
ALTER TABLE `php_users_login`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT för tabell `produkt`
--
ALTER TABLE `produkt`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT för tabell `tur`
--
ALTER TABLE `tur`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `produktdatum`
--
ALTER TABLE `produktdatum`
  ADD CONSTRAINT `ProduktDatum_ibfk_1` FOREIGN KEY (`ProduktID`) REFERENCES `produkt` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `transportorder`
--
ALTER TABLE `transportorder`
  ADD CONSTRAINT `TransportOrder_ibfk_2` FOREIGN KEY (`TurID`) REFERENCES `tur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TransportOrder_ibfk_3` FOREIGN KEY (`KundID`) REFERENCES `kund` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TransportOrder_ibfk_4` FOREIGN KEY (`RegNummer`) REFERENCES `turfordon` (`RegNummer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `transportprodukt`
--
ALTER TABLE `transportprodukt`
  ADD CONSTRAINT `OrderIDprodukt` FOREIGN KEY (`OrderID`) REFERENCES `transportorder` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transportprodukt_ibfk_2` FOREIGN KEY (`ProduktID`) REFERENCES `produkt` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `turdatum`
--
ALTER TABLE `turdatum`
  ADD CONSTRAINT `TurDatumID` FOREIGN KEY (`TurID`) REFERENCES `tur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `turfordon`
--
ALTER TABLE `turfordon`
  ADD CONSTRAINT `RegNummer` FOREIGN KEY (`RegNummer`) REFERENCES `fordon` (`RegNummer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TurID` FOREIGN KEY (`TurID`) REFERENCES `tur` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
