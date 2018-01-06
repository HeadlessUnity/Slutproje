<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';


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



        if (isset($_POST['spara'])) {
          //echo("<script>alert('PHP: sparar/uppdaterar');</script>");
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){;
                updateData($produkt, $_POST);
                $_GET['ac'] = "spara";
            }else if (isset($_GET['ac']) && $_GET['ac'] === "spara" && $produktNamn == null) {
                alterClass($produkt, "AUTO_INCREMENT = 1");
                $_POST['ID'] = null;
                unset($_POST['ID']);
                insertData($produkt, $_POST);

		}
  }else if(isset($_POST['ta_bort'])){
      if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){
          deleteData($produkt, $_POST);
          $_GET['ac'] = "spara";
        }
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
          <li class="current"><a href="sortiment.php"><?php session_unset("produkt")?>Sortiment</a></li>
          <li><a href="lager.php"><?php session_unset("produkt")?>Lagersaldo</a></li>
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
        <div class="wrap block-1">
            	          <form id="form" method="post" action="sortiment.php?ac=redigera">
<?php
            echo "<select id = 'selector' name = 'selector' class=dropdown edit>";
                 if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                              echo "<option disabled selected>$produktNamn</option>";
                }else{
                    echo "<option disabled selected>-- Välj produkt --</option>";
                     };
                $data = getData($produkt, "Namn LIKE '%'");
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

          <div class="block-1">
            <h3>Lägg in/redigera produkt:</h3>
               <?php  if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                                echo '<form id="form" method="post" action="sortiment.php?ac=redigera">';
                                                                          }
            else{
             echo '<form id="form" method="post" action="sortiment.php?ac=spara">';
            };?>
              <fieldset>
                  <div class="box-2">
                <label>Namn:</label>
                  <input name="Namn" type="text" value="<?php echo $_POST["RedigeraNamn"]; ?>"/>
                  </div>
                  <div class="box-2">
                <label >Andel av pall:</label>
                  <input name="AndelavPall" type="text"
                         value="<?php echo $_POST["RedigeraAvP"]; ?>"/> %
                  </div>
                  <input type="hidden" id="ID" name="ID" value="<?php echo $_POST["ID"]; ?>" />
                  <div class="btns nerhöger flex">
                      <div><button type="submit" name="ta_bort" class="button" value="Ta_bort">Ta Bort</button></div>
                      <div>  <button type="submit" name="spara" class="button" value="Spara">Spara</button></div>

                </div>
              </fieldset>
            <?php echo "</form>" ?>
          </div>
        </div>
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
