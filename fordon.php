<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

function __autoload($fordon)
{
  require_once "{$fordon}_class.php";
}$fordon = new Fordon;

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
<title>Fordon</title>
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
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
<![endif]-->
<?php
         session_name("Fordon");
         session_start();
    if (isset($_GET['ac']) && $_GET['ac'] == "redigera" && isset($_POST['selector'])){
            $fordonNamn = $_POST['selector'];
        //ChromePhp::log($_POST['selector']);
      // ChromePhp::log($fordon);

            $data = getData($fordon, "Namn = '$fordonNamn'");
      // ChromePhp::log($data[0]);
                   foreach ($data[0] as $field => $value) {;
                    if($field === "Namn"){
                  $_POST["RedigeraNamn"] = $value;
                    }else if($field === "RegNummer"){
                $_POST["RedigeraRegNr"] = $value;
                    }else if($field === "AntalPallPlatser"){
                $_POST["RedigeraAPP"] = $value;
                    };
                 };
   };



        if (isset($_POST['spara'])) {

            //$RegNr = $_POST['RedigeraRegNr'];
          //  echo($RegNr);
            //$data = getData($fordon, "RegNummer = '$RegNr'");

        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){;
                updateData($fordon, $_POST);

                $_GET['ac'] = "spara";
            }else if (isset($_GET['ac']) && $_GET['ac'] === "spara" && $fordonNamn == null) {
                insertData($fordon, $_POST);

		}
  }else if(isset($_POST['ta_bort'])){
      if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){
          deleteData($fordon, $_POST);
          $_GET['ac'] = "spara";
        }
  };
            if(!isset($_SESSION['Fordon'])){
              $_SESSION['Fordon'] = $fordon;


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
          <li class="home-page"><?php session_unset("Fordon")?><a href="oversikt.php"><span></span></a></li>
          <li><a href="boka.php"><?php session_unset("Fordon")?>Boka transport</a></li>
          <li><a href="turer.php" ><?php session_unset("Fordon")?>Turer</a></li>
          <li class="current"><a href="Fordon.php">Fordon</a></li>
          <li><a href="sortiment.php"><?php session_unset("Fordon")?>Sortiment</a></li>
          <li><a href="lager.php"><?php session_unset("Fordon")?>Lagersaldo</a></li>
          <li><a href="artiklar.php"><?php session_unset("Fordon")?>Sammanställning artiklar</a></li>
          <li><a href="skicka.php"><?php session_unset("Fordon")?>Skicka tur</a></li>
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
            	          <form id="form" method="post" action="Fordon.php?ac=redigera">
<?php
            echo "<select id = 'selector' name = 'selector' class=dropdown edit>";
                 if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                              echo "<option disabled selected>$fordonNamn</option>";
                }else{
                    echo "<option disabled selected>-- Redigera Fordon --</option>";
                     };
                $data = getData($_SESSION['Fordon'], "Namn LIKE '%'");
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

          </div>
        </div>
          <div class="tight block-1">
            <h3>Lägg in/redigera fordon:</h3>
               <?php  if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                                echo '<form id="form" method="post" action="fordon.php?ac=redigera">';
                                                                          }
            else{
             echo '<form id="form" method="post" action="fordon.php?ac=spara">';
            };?>
              <fieldset>
                  <div class="box-2">
                <label>Namn:</label>
                  <input type="text" name="Namn" value="<?php echo $_POST["RedigeraNamn"]; ?>"/>
                  </div>
                  <div class="box-2">
                <label>Reg nr:</label>
                  <input type="text" name="RegNummer"  value="<?php echo $_POST["RedigeraRegNr"]; ?>"/>
                  </div>
                                    <div class="box-2">
                <label for=AntalPallPlatser>Antal pallplatser:</label>
                  <input type="text" name="AntalPallPlatser"  value="<?php echo $_POST["RedigeraAPP"]; ?>"/>
                  </div>

                  <div class="btns nerhöger flex">
                      <div><button type="submit" name="ta_bort" class="button" value="Ta_bort">Ta Bort</button></div>
                      <div>  <button type="submit" name="spara" class="button" value="Spara">Spara</button></div>

                </div>

              </fieldset>
             <?php echo '</form>'; ?>

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
