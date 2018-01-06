<?php
require_once "default_table_class.php";

class TransportOrder extends Default_table
{
    // additional class variables go here
    function TransportOrder ()
    {
        $this->tablename       = 'TransportOrder';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('OrderID', 'TurID', 'RegNummer', 'KundID',
                                      'Plantering', 'Datum', 'Skickad');
        $this->fieldlist['OrderID'] = array('pkey' => 'y');
        $this->fieldlist['TurID'] = array('ukey' => 'y');
        $this->fieldlist['RegNummer'] = array('ukey' => 'y');
        $this->fieldlist['KundID'] = array('ukey' => 'y');
    } // end class constructor

}
/*
-- Tabellstruktur `transportorder`
--

CREATE TABLE `transportorder` (
  `OrderID` int(10) NOT NULL,
  `TurID` int(10) UNSIGNED NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `KundNamn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Plantering` tinyint(1) DEFAULT NULL,
  `Datum` date DEFAULT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------
*/
?>
