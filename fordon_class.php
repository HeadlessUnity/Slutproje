<?php
require_once "default_table_class.php";

class Fordon extends Default_table
{
    // additional class variables go here
    function Fordon ()
    {
        $this->tablename       = 'Fordon';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('RegNummer', 'Namn', 'AntalPallPlatser');
        $this->fieldlist['RegNummer'] = array('pkey' => 'y');
        $this->fieldlist['Namn'] = array('ukey' => 'y');
				
    } // end class constructor

}
/*
-- Table structure for table `Fordon`
--

CREATE TABLE IF NOT EXISTS `Fordon` (
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AntalPallPlatser` int(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`RegNummer`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Kund`
--

CREATE TABLE IF NOT EXISTS `Kund` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
`Skickad` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `php_users_login`
--

CREATE TABLE IF NOT EXISTS `php_users_login` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `content` text,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;



-- --------------------------------------------------------

--
-- Table structure for table `Produkt`
--

CREATE TABLE IF NOT EXISTS `Produkt` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `AndelavPall` int(3) unsigned DEFAULT NULL,
  `Antal` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProduktDatum`
--

CREATE TABLE IF NOT EXISTS `ProduktDatum` (
  `ProduktID` int(10) unsigned NOT NULL,
  `StartDatum` timestamp DEFAULT CURRENT_TIMESTAMP,
  `SlutDatum` date NOT NULL,
  UNIQUE KEY `ProduktID` (`ProduktID`),
  CONSTRAINT ProduktID PRIMARY KEY (ProduktID, SlutDatum)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TransportOrder`
--

CREATE TABLE IF NOT EXISTS `TransportOrder` (
  `OrderID` int(10) NOT NULL,
  `TurID` int(10) unsigned NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `KundNamn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Plantering` tinyint(1) DEFAULT NULL,
  `Datum` date DEFAULT NULL,
 `Skickad` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE KEY `TurID` (`TurID`),
    UNIQUE KEY `RegNummer` (`RegNummer`),
   UNIQUE  KEY `KundNamn` (`KundNamn`),
    UNIQUE KEY `Datum` (`Datum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TransportProdukt`
--

CREATE TABLE IF NOT EXISTS `TransportProdukt` (
  `OrderID` int(10) NOT NULL,
  `ProduktID` int(10) NOT NULL,
  `ProduktAntal` int(8) unsigned DEFAULT NULL,
`Skickad` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `OrderID` (`OrderID`),
  UNIQUE KEY `ProduktID` (`ProduktID`),
  CONSTRAINT ProduktID PRIMARY KEY (ProduktID, OrderID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tur`
--

CREATE TABLE IF NOT EXISTS `Tur` (
`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
`Skickad` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Namn` (`Namn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TurDatum`
--

CREATE TABLE IF NOT EXISTS `TurDatum` (
  `TurID` int(10) unsigned NOT NULL,
  `StartDatum` timestamp DEFAULT CURRENT_TIMESTAMP,
  `SlutDatum` date NOT NULL,
  UNIQUE KEY `TurID` (`TurID`),
  CONSTRAINT TurID PRIMARY KEY (TurID, SlutDatum)   
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TurFordon`
--

CREATE TABLE IF NOT EXISTS `TurFordon` (
  `TurID` int(10) unsigned NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `FordonNamn` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
`Skickad` tinyint(1) DEFAULT NULL,
    
  UNIQUE KEY `RegNummer` (`RegNummer`),
  UNIQUE KEY `TurID` (`TurID`),
  CONSTRAINT RegNummer PRIMARY KEY (RegNummer, TurID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
*/