<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

function __autoload($produkt)
{
  require_once "{$produkt}_class.php";
};
$produkt = new Produkt;

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
<title>produkt</title>
<meta http-equiv="X-UA-Compatible"  content="IT=edge,chrome=IE8">

<meta charset='utf-8'>
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
<link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

<script src="js/jquery-1.7.min.js">
</script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/main.js"></script>
<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="tablesorter/js/jquery.tablesorter.js"></script>

<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="tablesorter/js/jquery.tablesorter.widgets.js"></script>
<script src="js/tablesorter.js"></script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
<![endif]-->
<?php
         session_name("produkt");
         session_start();

        if (isset($_POST['uppdatera'])) {
if (isset($_GET['ac']) && $_GET['ac'] === "uppdatera") {
                $postAntal = $_POST["Antal"];
            $postID = $_POST["ID"];
                foreach (array_combine($postID, $postAntal) as $index => $value){
                $post = array("ID" => $index, "Antal" => $value);
                updateData($produkt, $post);
                };
                                                        };
        };
    if(!isset($_SESSION['produkt'])){
              $_SESSION['produkt'] = $produkt;


           };
          ?>
</head>
<body>
<div class="main">
  <!--==============================header=================================-->
  <header>
    <h1><?php echo $_SESSION['user_info']['user'];
        session_write_close();?></h1>
     <div class="höger"><h2><a href="index.php?ac=logout" style="color:#53b2c3">Logga ut</a></h2></div>
    <div class="clear"></div>
    <nav class="box-shadow">
      <div>
        <ul class="menu">
          <li class="home-page"><?php session_unset("produkt")?><a href="oversikt.php"><span></span></a></li>
          <li><a href="boka.php"><?php session_unset("produkt")?>Boka transport</a></li>
          <li><a href="turer.php" ><?php session_unset("produkt")?>Turer</a></li>
          <li><a href="Fordon.php">Fordon</a></li>
          <li><a href="sortiment.php"><?php session_unset("produkt")?>Sortiment</a></li>
          <li class="current"><a href="lager.php">Lagersaldo</a></li>
          <li><a href="artiklar.php"><?php session_unset("produkt")?>Sammanställning artiklar</a></li>
          <li><a href="skicka.php"><?php session_unset("produkt")?>Skicka tur</a></li>
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
          <div class="wrap block-1 tight">
<div class="table-wrapper antalhover container">
  <div id="table-scroll">
      <?php
    echo '<table id="table" class="tablesorter">
        <thead>
            <tr>
                <th><span class="text">Antal</span></th>
                <th><span class="text">Produktnamn</span></th>
                <th><span class="text">Räcker till:</span></th>
            </tr>
        </thead>
        <tbody>';


echo '<form id="form" method="post" action="lager.php?ac=uppdatera">';
$data = getData($produkt, "ID LIKE '%'");
                 foreach ($data as $row) {;

echo "<tr>";
                                 foreach ($row as $field => $value) {;
 if($field === "Antal"){ $antal = $value;


                       }else if($field === "Namn"){
 $produktNamn = $value;
 }else if($field === "ID"){ $ID = $value;}};

                              echo '<td id= "lagerantal"> <input type="text"
                              name="Antal[]" value="'.$antal.'"/>'.$antal.'</td>';

                              echo '<td>'.$produktNamn.'</td>';

                                            echo "<td>$produktRT</td>";
echo '<input type="hidden" name="ID[]" value="'.$ID.'" />';
        ChromePhp::log('Here: ', $ID);

echo '</tr>';
                                                      };



        echo '</tbody>';
    echo '</table>';
    ?>
  </div>
</div>

                              <div class="btns uppdatera"><button type="submit" name="uppdatera" id="uppdatera" class="button" value="uppdatera">Uppdatera</button></div>                                                      <?php echo '</form>'; ?>
          </div>
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
