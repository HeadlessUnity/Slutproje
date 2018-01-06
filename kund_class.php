<?php
require_once "default_table_class.php";

class Kund extends Default_table
{
    // additional class variables go here
    function Kund ()
    {
        $this->tablename       = 'Kund';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('ID', 'Namn', 'Skickad');
        $this->fieldlist['ID'] = array('pkey' => 'y');
        $this->fieldlist['Namn'] = array('ukey' => 'y');
    } // end class constructor

}
/*
-- Tabellstruktur `kund`
--

CREATE TABLE `kund` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Namn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------
*/
?>
