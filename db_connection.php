
<?php

function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "expabtrans_se";


 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);


 return $conn;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }
$dbconnect  = NULL;
$dbhost     = "localhost";
$dbusername = "root";
$dbuserpass = "";
$query      = NULL;

function db_connect($dbname)
{
   global $dbconnect, $dbhost, $dbusername, $dbuserpass;

   if (!$dbconnect) $dbconnect = mysql_connect($dbhost, $dbusername, $dbuserpass);
   if (!$dbconnect) {
      return 0;
   } elseif (!mysql_select_db($dbname)) {
      return 0;
   } else {
      return $dbconnect;
   } // if

}
?>
