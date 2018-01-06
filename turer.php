<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

spl_autoload_register(function ($class_name) {
    include "{$class_name}_class.php";
});
$tur = new Tur;
$turDatum = new TurDatum;
$fordon = new Fordon;
$turFordon = new TurFordon;
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
<title>tur</title>
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
         session_name("tur");
         session_start();
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

ChromePhp::log(strlen($url) );
if (strlen($url) <= 50) {

    unset($_SESSION["FordonNamn"]);
$_SESSION["FordonNamn"] = "-- Välj Fordon --";
   // unset($_POST["FordonNamn"]);
    unset($_SESSION["Namn"]);
    unset($_SESSION["StartDatum"]);
    unset($_SESSION["SlutDatum"]);
   // unset($_SESSION['Action']);
};


    if (isset($_GET['ac']) && $_GET['ac'] == "redigera" && isset($_POST['selector'])){
            $_SESSION['Action'] = $_GET['ac'];
            $turNamn = $_POST['selector'];
        ChromePhp::log($_POST['selector'], "sdsd");
      ChromePhp::log($tur);
            $data1 = getData($tur, "Namn = '$turNamn'");
        ChromePhp::log($data1[0]['ID'], "wfoiöefie");
                   foreach ($data1[0] as $field => $value) {
                    if($field === "ID"){
                    $_SESSION["ID"] = $value;
                         ChromePhp::log($_SESSION["ID"]);
                   }else if($field === "Namn"){
                  $_SESSION["Namn"] = $value;
                    }else if($field === "Skickad"){
                $_POST["Skickad"] = $value;
                    };

                 };


                       $id = $data1[0]['ID'];
                       $fordonData = getData($turFordon, "TurID = '$id'");
                        $_SESSION['FordonNamn'] = $fordonData[0]['FordonNamn'];


                    $turDatumData = getData($turDatum, "TurID = '$id'");
                    $turDatumInfo = $turDatumData[0];
                $turDatumInfo = array(
                "TurID"  => $id,
                "StartDatum" => $turDatumData[0]["StartDatum"],
                "SlutDatum" => $turDatumData[0]["SlutDatum"]
               );
        ChromePhp::log($turDatumData[0]["StartDatum"]);
                   $_SESSION["StartDatum"] = $turDatumInfo["StartDatum"];
        $_SESSION["StartDatum"]=substr($_SESSION["StartDatum"], 0, strrpos($_SESSION["StartDatum"], ' '));
    $_SESSION["SlutDatum"] = $turDatumInfo["SlutDatum"];
   };


     // if (isset($_SESSION['FordonNamn']) || isset($_POST["calinfo"])){
ChromePhp::log("fiuedfiuh");/*
if (isset($_POST["calinfo"])){
                $data = json_decode(stripslashes($_POST['calinfo']));
                $_SESSION["Namn"] = $data[1];
                ChromePhp::log("NU", $_SESSION['Namn']);
                $_SESSION['FordonNamn'] = $data[0];
            }*/
           if (isset($_POST["calinfo"])) {
            ChromePhp::log($_POST["calinfo"]);

               $_POST['calinfo'] = str_replace('li-', '', $_POST['calinfo']);
               $data = json_decode(stripslashes($_POST['calinfo']));
               $_SESSION['FordonNamn'] = $data[0];
                $_SESSION['Namn'] = $data[1];
               ChromePhp::log($data);
                   if (is_numeric($data[2])){
                   $turDatumInfo =  array(
                "ID"  => $data[2],
                "StartDatum" => $data[3],
                "SlutDatum" => $data[4]
               );
                   }else{
                $turDatumInfo = array(
                "TurID"  => null,
                "StartDatum" => $data[2],
                "SlutDatum" => $data[3]
               );
                   }
               ChromePhp::log($turDatumInfo["StartDatum"]);
ChromePhp::log($turDatumInfo);
              $_SESSION['calinfo'] = $turDatumInfo;
                   $_SESSION["StartDatum"] = $turDatumInfo["StartDatum"];
    $_SESSION["SlutDatum"] = $turDatumInfo["SlutDatum"];
               };
          if (isset($_SESSION['FordonNamn']) || isset($_POST['FordonNamn'])){
            if (isset($_POST['FordonNamn'])){
              $fordonNamn = $_POST['FordonNamn'];
            }else{
              $fordonNamn = $_SESSION['FordonNamn'];
            }
            $data2 = getData($fordon, "Namn = '".$fordonNamn."'");
                   foreach ($data2[0] as $field => $value) {
                    if($field === "RegNummer"){
                    $_POST["RegNummer"] = $value;
                   }else if($field === "Namn"){
                  $_SESSION['FordonNamn'] = $value;
                }else if($field === "AntalPallPlatser"){
                   $_SESSION['AntalPallPlatser'] = $value;
                     }
                $_POST["FordonSkickad"] = 'NULL';

                    $_POST["FordonTurID"] = $_SESSION["ID"];
                    $print = $_POST["FordonTurID"];
                    ////echo("<script>alert($print);</script>");
                 // $turFordonInfo = array($_POST["RegNummer"], $_POST["FordonNamn"],
                   //               $_POST["FordonSkickad"], $_POST["FordonTurID"]);
                                   $_SESSION["TurFordonInfo"] = array(
                    "TurID"  => $_POST["FordonTurID"],
                    "FordonNamn" => $_SESSION['FordonNamn'],
                    "RegNummer" => $_POST["RegNummer"],
                    "AntalPallPlatser" => $_SESSION['AntalPallPlatser']
                                                    );

                 };
   };
              //}

            $_SESSION['show'] = $calendar->show('greyed');





        if (isset($_POST['spara'])) {
                   if ($_POST["Skickad"] !== null){
                   $turInfo =  array(
                "ID"  => $_SESSION["ID"],
                "Namn" => $_POST["Namn"],
                "Skickad" => $_POST["Skickad"]
               );
    }else{          $turInfo =  array(
                "ID"  => $_SESSION["ID"],
                "Namn" => $_POST["Namn"]
               );

                   }
        if (isset($_SESSION['Action'])){
        $_GET['ac'] = $_SESSION['Action'];
            ChromePhp::log($_GET['ac']);
        };
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){;
                ChromePhp::log($turInfo);
                updateData($tur, $turInfo);
                $_SESSION["TurFordonInfo"]["TurID"] = $_SESSION["ID"];
                updateData($turFordon, $_SESSION["TurFordonInfo"]);
                $_SESSION["calinfo"]["TurID"] = $_SESSION["ID"];
                updateData($turDatum, $_SESSION["calinfo"]);
                ChromePhp::log("Hello2");
                $_GET['ac'] = "spara";
                unset($_SESSION['Action']);
            }else if (isset($_GET['ac']) && $_GET['ac'] === "spara") {


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
                    $_SESSION["ID"] = $value;
                    };
                  }
                $_SESSION["TurFordonInfo"]["TurID"] = $_SESSION["ID"];
                $print = $_SESSION["ID"];
                //echo("<script>alert($print);</script>");
                insertData($turFordon, $_SESSION["TurFordonInfo"]);
                $_SESSION["calinfo"]["TurID"] = $_SESSION["ID"];
                insertData($turDatum, $_SESSION["calinfo"]);
                unset($_SESSION['Action']);
		}};
    if(isset($_POST['ta_bort'])){
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){
            deleteData($tur, $_POST);
            #TODO: dom här funkar inte längre.
            deleteData($turDatum, $_SESSION["TurFordonInfo"]);
            deleteData($turFordon, $_SESSION["calinfo"]);

            unset($_SESSION['Action']);
          }
    };
    if(!isset($_SESSION['tur'])){
              $_SESSION['tur'] = $tur;


           };
    //session_unset();

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
          <li class="home-page"><?php session_unset("tur")  ;?><a href="oversikt.php"><span></span></a></li>
          <li><a href="boka.php"><?php session_unset("tur")  ;?>Boka transport</a></li>
          <li  class="current"><a href="turer.php" ><?php session_unset("tur") ;?>Turer</a></li>
          <li><a href="Fordon.php">Fordon</a></li>
          <li><a href="sortiment.php"><?php session_unset("tur") ;?>Sortiment</a></li>
          <li><a href="lager.php"><?php session_unset("tur") ;?>Lagersaldo</a></li>
          <li><a href="artiklar.php"><?php session_unset("tur") ;?>Sammanställning artiklar</a></li>
          <li><a href="skicka.php"><?php session_unset("tur") ;?>Skicka tur</a></li>
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
            	          <form id="form" method="post" action="turer.php?ac=redigera">
<?php
            echo "<select id = 'selector' name = 'selector' class=dropdown edit>";
                 if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                              echo "<option disabled selected>$turNamn</option>";
                }else{
                    echo "<option disabled selected>-- Redigera tur --</option>";
                     };
                $data = getData($tur, "Namn LIKE '%'");
                 foreach ($data as $row) {;
                   foreach ($row as $field => $value) {;
                    if($field === "Namn"):
                  echo "<option>$value</option>";
                   endif;
                 };
                     };
            echo "</select>";
              echo '<input type="hidden" id="selected" name="selected" value="" />'
                              ?>
                        <div class="btns redigera"><button type="submit" name="Redigera" class="button" value="Redigera">Redigera</button></div></form>
            </div></div>

          <div class="tight block-1">
            <h3>Lägg in/redigera tur:</h3>
               <?php  if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                                echo '<form id="form" method="post" action="turer.php?ac=redigera">';
                                                                          }
            else{
             echo '<form id="form" method="post" action="turer.php?ac=spara">';
            };?>
              <fieldset>
                  <div class="box-2">
                <label>Namn:</label>
                  <input id="Namn" name="Namn" type="text" value="<?php echo $_SESSION["Namn"]; ?>"/>
                  </div>
                  <div class="box-2">
                <label class="vänster" for="TurFordon">Fordon:</label>
<?php
            echo "<select id = 'FordonNamn' name = 'FordonNamn' class=dropdown edit>";
                 if (isset($_GET['ac']) && $_GET['ac'] == "redigera" || $_SESSION['FordonNamn'] !== "-- Välj Fordon --"){;
                              echo "<option disabled selected>".$_SESSION['FordonNamn']."</option>";
                }else{
                    echo "<option disabled selected>-- Välj Fordon --</option>";
                     };
                $data = getData($fordon, "Namn LIKE '%'");
                 foreach ($data as $row) {;
                   foreach ($row as $field => $value) {;
                    if($field === "Namn"):
                  echo "<option>$value</option>";
                   endif;
                 };
                     };
            echo "</select>";
              echo '<input type="hidden" id="selected" name="selected" value="" />'
                              ?>

                  <input type="hidden" id="ID" name="ID" value="<?php echo $_SESSION["ID"]; ?>" /> <input type="hidden" id="Action" name="Action" value="<?php echo $_SESSION["Action"]; ?>" />



          </div>
                                </fieldset>

                   <div class="box-2 vänster">


                    <?php echo 'Startdatum:<b>'.$_SESSION["StartDatum"].'</b>';?>

    <?php
        echo 'Slutdatum:<b>'.$_SESSION["SlutDatum"].'</b>';

        ?>

                    <?php
    echo '<form method="post" id="calendarform" action="turer.php?ac=spara"';
    echo "<fieldset>";
    echo $_SESSION['show'];
  echo "</fieldset>";   ?>
               </div>
               </div>
               <div class ="nerhöger4 flex">
                <div>   <button type="submit" name="ta_bort" class="button" value="Ta_bort">Ta Bort</button></div>
              <div><button type="submit" name="spara" id="spara" class="button" value="Spara">Spara</button></div>
            </div>
   <?php echo "</form>";?>
                  <?php echo "</form>" ?>

        </div></div>
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
