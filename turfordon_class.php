<?php


require_once "fordon_class.php";

class TurFordon extends Fordon
{
    // additional class variables go here
    function TurFordon ()
    {
        $this->tablename       = 'TurFordon';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('RegNummer', 'FordonNamn', 'TurID',
        'AntalPallPlatser',
         'Skickad');
        //$this->fieldlist['TurID'] = array('ukey' => 'y');
        //$this->fieldlist['RegNummer'] = array('ukey' => 'y');
        //$this->fieldlist['FordonNamn'] = array('ukey' => 'y');
        $this->fieldlist['TurID'] = array('pkey' => 'y');

    } // end class constructor

}
/*
-- --------------------------------------------------------

--
-- Table structure for table `TurFordon`
--

CREATE TABLE IF NOT EXISTS `TurFordon` (
  `TurID` int(10) unsigned NOT NULL,
  `RegNummer` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `FordonNamn` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
`Skickad` tinyint(1) DEFAULT NULL,

  UNIQUE KEY `RegNummer` (`RegNummer`),
  UNIQUE KEY `TurID` (`TurID`),
  CONSTRAINT RegNummer PRIMARY KEY (RegNummer, TurID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
*/
?>
