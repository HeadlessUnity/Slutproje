<?php
require_once "default_table_class.php";
#TODO: ska inte den här extendas från produkt?
class TransportProdukt extends Default_table
{
    // additional class variables go here
    function TransportProdukt ()
    {
        $this->tablename       = 'TransportProdukt';
        $this->dbname          = 'expabtrans_se';
        $this->rows_per_page   = 10;
        $this->fieldlist       = array('OrderID', 'ProduktID', 'ProduktAntal',
        'Skickad');
        #TODO: maybe not primary?
        $this->fieldlist['OrderID'] = array('pkey' => 'y');
      //  $this->fieldlist['OrderID'] = array('ukey' => 'y');
        $this->fieldlist['ProduktID'] = array('ukey' => 'y');

    } // end class constructor

}
/*
-- Tabellstruktur `transportprodukt`
--

CREATE TABLE `transportprodukt` (
  `OrderID` int(10) NOT NULL,
  `ProduktID` int(10) UNSIGNED NOT NULL,
  `ProduktAntal` int(8) UNSIGNED DEFAULT NULL,
  `Skickad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------
*/
?>
