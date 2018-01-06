<?php
require_once "default_table_class.php";

class Produkt extends Default_table
{
    // additional class variables go here
    function Produkt ()
    {
        $this->tablename       = 'Produkt';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('ID', 'Namn', 'AndelavPall', 'Antal');
        $this->fieldlist['ID'] = array('pkey' => 'y');
        $this->fieldlist['Namn'] = array('ukey' => 'y');
				
    } // end class constructor

}
/*
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
   */ ?>