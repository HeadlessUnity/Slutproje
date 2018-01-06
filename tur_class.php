<?php
require_once "default_table_class.php";

class Tur extends Default_table
{
    // additional class variables go here
    function Tur ()
    {
        $this->tablename       = 'Tur';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('ID', 'Namn', 'Skickad');
        $this->fieldlist['ID'] = array('pkey' => 'y');
        $this->fieldlist['Namn'] = array('ukey' => 'y');
				
    } // end class constructor

}
/*
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
*/
?>