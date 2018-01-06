<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

spl_autoload_register(function ($class_name) {
    include "{$class_name}_class.php";
});

include 'calendar.php';
$calendar = new Calendar();

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
<title>artiklar</title>
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
<script src="js/main.js">
</script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
<![endif]-->
<?php
         session_name("produkt");
         session_start();
    if (isset($_GET['ac']) && $_GET['ac'] == "redigera" && isset($_POST['selector'])){
            $produktNamn = $_POST['selector'];
        //ChromePhp::log($_POST['selector']);
      ChromePhp::log($produkt);

            $data = getData($produkt, "Namn = '$produktNamn'");
      // ChromePhp::log($data[0]);
                   foreach ($data[0] as $field => $value) {
                    if($field === "ID"){
                    $_POST["ID"] = $value;
                   }else if($field === "Namn"){
                  $_POST["RedigeraNamn"] = $value;
                    }else if($field === "AndelavPall"){
                $_POST["RedigeraAvP"] = $value;
                    };
                 };
   };






            $_SESSION['show'] = $calendar->show('greyed');

           if (isset($_POST["calinfo"])) {
               ChromePhp::log($_POST["calinfo"]);
               $_POST['calinfo'] = str_replace('li-', '', $_POST['calinfo']);
               $data = json_decode(stripslashes($_POST['calinfo']));
                   if (is_numeric($data[0])){
                   $turDatumInfo =  array(
                "ID"  => $data[0],
                "StartDatum" => $data[1],
                "SlutDatum" => $data[2]
               );
                   }else{
                $turDatumInfo = array(
                "TurID"  => null,
                "StartDatum" => $data[0],
                "SlutDatum" => $data[1]
               );
                   }
ChromePhp::log($turDatumInfo);
               $_SESSION["calinfo"] = $turDatumInfo;
               };



        if (isset($_POST['spara'])) {
                   if ($_POST["Skickad"] !== null){
                   $turInfo =  array(
                "ID"  => $_POST["ID"],
                "Namn" => $_POST["Namn"],
                "Skickad" => $_POST["Skickad"]
               );
    }else{          $turInfo =  array(
                "ID"  => $_POST["ID"],
                "Namn" => $_POST["Namn"]
               );

                   }

        ChromePhp::log($turInfo);
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){;
                ChromePhp::log($turInfo);
                updateData($tur, $turInfo);
                $turFordonInfo["TurID"] = $_POST["ID"];
                updateData($turFordon, $turFordonInfo);
                $_SESSION["calinfo"]["TurID"] = $_POST["ID"];
                updateData($turDatum, $_SESSION["calinfo"]);
                ChromePhp::log("Hello2");
                $_GET['ac'] = "spara";
            }else if (isset($_GET['ac']) && $_GET['ac'] === "spara" && $turNamn == null) {


                alterClass($tur, "AUTO_INCREMENT = 1");
                $_POST['ID'] = null;
                unset($_POST['ID']);
            $turInfo = array(
            "Namn" => $_POST["Namn"]
               );
                insertData($tur, $turInfo);
              //  if (isset($turInfo["Namn"])){
                $turNamn = $turInfo["Namn"];
                $data4 = getData($tur, "Namn = '$turNamn'");
                   foreach ($data4[0] as $field => $value) {
                    if($field === "ID"){
                    $_POST["ID"] = $value;
                    };
                  }
                $turFordonInfo["TurID"] = $_POST["ID"];
                insertData($turFordon, $turFordonInfo);
                $_SESSION["calinfo"]["TurID"] = $_POST["ID"];
                insertData($turDatum, $_SESSION["calinfo"]);

		}};
    if(!isset($_SESSION['tur'])){
              $_SESSION['tur'] = $tur;


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
          <li><a href="lager.php"><?php session_unset("produkt")?>Lagersaldo</a></li>
          <li class="current"><a href="artiklar.php">Sammanställning artiklar</a></li>
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
            <div class="wrap block-1">
                   <div class="box-2 vänster">


                    <?php echo 'Startdatum:<b>'.$turDatumInfo["StartDatum"]=substr($turDatumInfo["StartDatum"], 0, strrpos($turDatumInfo["StartDatum"], ' ')).'</b>';?>

    <?php
        echo 'Slutdatum:<b>'.$turDatumInfo["SlutDatum"].'</b>';

        ?>

                    <?php
    echo '<form method="post" id="calendarform" action="turer.php?ac=spara"';
    echo "<fieldset>";
    echo $_SESSION['show'];
  echo "</fieldset>";   ?>
               </div>         <div class="loose block-1">
                                              <div class="höger2"><button type="submit" name="sök" id="sök" class="button" value="sök">Sök</button></div>
   <?php echo "</form>";?></div>
            </div>
          <div class="loose block-1">
<div class="table-wrapper">
  <div class="table-scroll artiklar">
    <table>
        <thead>
            <tr>
                <th><span class="text">Antal</span></th>
                <th><span class="text">Produktnamn</span></th>
            </tr>
        </thead>
        <tbody>
          <tr> <td>1, 0</td> <td>2, 0</td></tr>
          <tr> <td>1, 1</td> <td>2, 1</td>  </tr>
          <tr> <td>1, 2</td> <td>2, 2</td>  </tr>
          <tr> <td>1, 3</td> <td>2, 3</td>  </tr>
          <tr> <td>1, 4</td> <td>2, 4</td> </tr>
          <tr> <td>1, 5</td> <td>2, 5</td>  </tr>
          <tr> <td>1, 6</td> <td>2, 6</td> </tr>
          <tr> <td>1, 7</td> <td>2, 7</td> </tr>
          <tr> <td>1, 8</td> <td>2, 8</td>  </tr>
          <tr> <td>1, 9</td> <td>2, 9</td> </tr>
          <tr> <td>1, 10</td> <td>2, 10</td>  </tr>
          <tr> <td>1, 99</td> <td>2, 99</td> </tr>
        </tbody>
    </table>
  </div>
</div>

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
