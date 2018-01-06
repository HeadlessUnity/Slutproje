<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
//include 'ChromePhp.php';

function __autoload($Fordon)
{
  require_once "{$Fordon}_class.php";
}$Fordon = new Fordon; 
function getData($dbobject, $where) {
    $data = $dbobject->getData($where);
    return $data;
    
}
function insertData($dbobject, $data) {
    $dbobject->insertData($data);
    
}
function updateData($dbobject, $data) {
    $dbobject->updateData($data);
    
}
function deleteData($dbobject, $data) {
    $dbobject->deleteData($data);
    
}


session_name("LoginForm");
session_start();
if(!isset($_SESSION['user_info']['user'])){
   header("Location:index.php");
}


error_reporting(0);
require_once("config.php"); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Skicka tur</title>
<meta http-equiv="X-UA-Compatible"  content="IT=edge,chrome=IE8">

<meta charset='utf-8'>
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
<link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<script src="js/jquery-1.7.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
<![endif]-->
</head>
<body>
<div class="main">
  <!--==============================header=================================-->
  <header>
    <h1><?php echo $_SESSION['user_info']['user']  ?></h1>
     <div class="höger"><h2><a href="index.php?ac=logout" style="color:#53b2c3">Logga ut</a></h2></div> 
    <div class="clear"></div>
    <nav class="box-shadow">
      <div>
        <ul class="menu">
          <li class="home-page"><a href="oversikt.php"><span></span></a></li>
          <li><a href="boka.php">Boka transport</a></li>
          <li><a href="turer.php">Turer</a></li>
          <li><a href="fordon.php">Fordon</a></li>
          <li><a href="sortiment.php">Sortiment</a></li>
          <li><a href="lager.php">Lagersaldo</a></li>
          <li><a href="artiklar.php">Sammanställning artiklar</a></li>
          <li class="current"><a href="skicka.php">Skicka tur</a></li>
        </ul>
        <div class="clear"></div>
      </div>
    </nav>
  </header>
  <!--==============================content================================-->
  <section id="content">
    <div class="container_12">
      <div class="grid_12">
        <div class="wrap pad-3">
        <div class="wrap block-1">
            <select class = "dropdown edit">
             <option disabled selected value> -- Välj Tur -- </option>
              <option value="Linköping">Linköping</option>
              <option value="Norrköping">Norrköping</option>
              <option value="Kambodja">Kambodja</option>
              <option value="audi">Audi</option>
            </select>
            <div class="btns välj"><a href="#" class="button">Välj</a></div>
          </div>
        </div>
          <div class="tight block-1">
                        <h2 class="top-1 p0">Turnamn</h2>
<div class="table-wrapper skicka">
  <div id="table-scroll skicka">
      
    <table >
        <tbody>
          <tr> <td>1</td> <td>Adam</td> <td>1243</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
          <tr> <td>2</td> <td>Björn</td> <td>2345</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
          <tr> <td>3</td> <td>Kalle</td> <td>2346</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
          <tr> <td>4</td> <td>Siv</td> <td>2345</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
        </tbody>
    </table>
  </div>
</div>
                <div class="btns nerhöger2"><a href="#" class="button">Skicka och skriv ut</a></div>
          </div>
        </div>
                </div>
      <div class="clear"></div>
  </section>
</div>
<!--==============================footer=================================-->
<footer>
  <p>© 2017-<?php echo date("Y"); ?> <!--eximius partner AB --></p>
  <p>Website and Database by <a target="_blank" href="http://www.linkedin.com/in/bjorn-alvinge" class="link">Björn Alvinge</a></p>
</footer>
</body>
</html>
