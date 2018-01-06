<?php
require_once "default_table_class.php";

class TurDatum extends Default_table
{
    // additional class variables go here
    function TurDatum ()
    {
        $this->tablename       = 'TurDatum';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('TurID', 'StartDatum', 'SlutDatum');
        //$this->fieldlist['TurID'] = array('ukey' => 'y');
        $this->fieldlist['TurID'] = array('pkey' => 'y');
      //  $this->fieldlist['SlutDatum'] = array('pkey' => 'y');
    } // end class constructor

}
/*
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
