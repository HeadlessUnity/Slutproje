<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

spl_autoload_register(function ($class_name) {
    include "{$class_name}_class.php";
});
$transportOrder = new TransportOrder;
$transportProdukt = new TransportProdukt;
$kund = new Kund;
$tur = new Tur;
$turDatum = new TurDatum;
$Fordon = new Fordon;
$turFordon = new TurFordon;

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
<title>Boka Transport</title>
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
         session_name("transport");
         session_start();
        ob_start();
        if(!isset($_SESSION['transport'])){
                  $_SESSION['transport'] = $transportOrder;


               };

    if (isset($_GET['ac']) && $_GET['ac'] == "redigera" && (isset($_POST['sök'])
     || isset($_GET["OrderID"])
  || isset($_POST['spara']))){
            if (isset($_GET["OrderID"])){
              $orderID = $_GET["OrderID"];
            }else if (isset($_POST["OrderID"])){
              $orderID = $_POST["OrderID"];
            }else{
            $orderID = $_POST['sokorder'];
            }

            $data1 = getData($transportOrder, "OrderID = '$orderID'");

                   foreach ($data1[0] as $field => $value) {
                    if($field === "OrderID"){
                    $_POST["OrderID"] = $value;

                  }else if($field === "TurID"){
                  $_POST["TurID"] = $value;
                  $turData = getData($tur, "ID = '$value'");
                  $_POST["TurNamn"] = $turData[0]['Namn'];

                    }else if($field === "RegNummer"){

                $_POST["RegNummer"] = $value;
                $fordonData = getData($turFordon, "RegNummer = '$value'");
                $_POST["FordonNamn"] = $fordonData[0]['FordonNamn'];
              }else if($field === "KundID"){
                $_POST["KundID"] = $value;
                $kundData = getData($kund, "ID = '$value'");
                $_POST["KundNamn"] = $kundData[0]['Namn'];
                    }else if($field === "Plantering"){
                  $_POST['Plantering'] = $value;
                    }else if($field === "Datum"){
               $_POST["Datum"] = $value;
               #TODO: markeras inte i turfordonet.
                    }
                    /*
                    #TODO: måste egentligen vara med.
                    else if($field === "Skickad"){
               $_POST["Skickad"] = $value;
                    };
                    */

                 };

   };

               if (isset($_POST["TurFordonInfo"])) {
                  echo('IN');
               $data = json_decode(stripslashes($_POST["TurFordonInfo"]));
               echo($data);
               $turFordonInfo = array(
               "Datum"  => $data[0],
               "RegNummer" => $data[1],
               "TurID" => $data[2]
              );


              $_SESSION["TurFordonInfo"] = $turFordonInfo;

               };

        if (isset($_POST['spara'])) {
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){
                #TODO: gör inte det den ska.
                if(isset($_POST['Plantering']))
                {
                  $_POST['Plantering'] = 1;
                } else{
                  $_POST['Plantering'] = 0;
                };
                $value = $_POST["KundNamn"];
                $kundData = getData($kund, "Namn = '$value'");
                $_POST['KundID'] = $kundData[0]['ID'];
                $orderArray = array_merge($_POST, $_SESSION["TurFordonInfo"]);
                updateData($_SESSION['transport'], $orderArray);

                $_GET['ac'] = "spara";
                unset($_POST);
            }else if (isset($_GET['ac']) && $_GET['ac'] === "spara"
            && $_POST["RegNummer"] !== ''
             && $_POST["OrderID"] !== '' && $_POST["KundNamn"] !== '') {
                alterClass($kund, "AUTO_INCREMENT = 1");
                if ($_POST["Skickad"] !== null){
                  $kundInfo = array(
                    "Namn" => $_POST["KundNamn"],
                    "Skickad" => $_POST["Skickad"]
               );
             }else{  $kundInfo = array(
            "Namn" => $_POST["KundNamn"]
               );
                }

              if(isset($_POST['Plantering']))
              {
                $_POST['Plantering'] = 1;
              } else{
                $_POST['Plantering'] = 0;
              };
            #TODO funkar ej
            $name = $kundInfo['Namn'];
            if (empty(getData($kund, "Namn = '".$name."'"))){
              insertData($kund, $kundInfo);
            }
            //echo($_POST['KundID']);
            $_POST['KundID'] = getData($kund, "ID LIKE '%'");
            $orderArray = array_merge($_POST, $_SESSION["TurFordonInfo"]);
            insertData($_SESSION['transport'], $orderArray);
            unset($_POST);

		}};



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
          <li class="home-page"><?php session_unset("transport")?><a href="oversikt.php"><span></span></a></li>
          <li class="current"><a href="boka.php">Boka transport</a></li>
          <li><a href="turer.php" ><?php session_unset("transport")?>Turer</a></li>
          <li><a href="Fordon.php">Fordon</a></li>
          <li><a href="sortiment.php"><?php session_unset("transport")?>Sortiment</a></li>
          <li><a href="lager.php">Lagersaldo</a></li>
          <li><a href="artiklar.php"><?php session_unset("transport")?>Sammanställning artiklar</a></li>
          <li><a href="skicka.php"><?php session_unset("transport")?>Skicka tur</a></li>
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
            <div class="block-1">
               <form id="form" method="post" action="boka.php?ac=redigera">
              <fieldset>       <div class="box-2 vänster">
                  <input name="sokorder" type="text" name="sokorder"/>
                  <div class="box-2 höger"><button type="submit" name="sök" id="sök" class="button">Sök</button></div></div>
                                </fieldset>
            </form>
                  <div class="loose block-9">
                                  <h4>Lägg in/redigera transport:</h4>
                                     <?php  if (isset($_GET['ac']) && $_GET['ac'] == "redigera"){;
                                echo '<form id="form" method="post" action="boka.php?ac=redigera">';
                                                                          }
            else{
             echo '<form id="form" method="post" action="boka.php?ac=spara">';
            };?>
              <fieldset>
                      <div class="box-2 vänster">
                <label for="Namn">OrderID:</label>
                  <input type="text" name="OrderID" value="<?php echo $_POST["OrderID"]; ?>"/>
                  </div>
                                  <div class="box-3 vänster">
                <label for="Namn">KundNamn:</label>
                  <input type="text"  name="KundNamn" value="<?php echo $_POST["KundNamn"]; ?>"/></div>
                                    <input type="hidden" id="ID" name="KundID" value="<?php echo $_POST["KundID"]; ?>" />
                                          <div class = "vänster" action=""><Label>Plantering:</Label>
<input type="checkbox"  name="Plantering" value="1" <?php echo ($_POST["Plantering"]==1 ? 'checked' : '');?>>
</div>

              </fieldset>


                  </div>


          </div>

            </div>
             <!--
                            <div class="block-1">
<div class="table-wrapper boka">
  <div id="table-scroll boka">

              <fieldset>
    <table>
        <tbody>
          <tr> <td>Produkt1:</td> <td>            <select class = "dropdown">
             <option disabled selected value> -- Välj produkt --</option>
              <option value="volvo">Volvo</option>
              <option value="saab">Saab</option>
              <option value="mercedes">Mercedes</option>
              <option value="audi">Audi</option>
            </select></td> <td>                  <div class="box-2 antal">
                <label for="Namn">Antal:</label>
                  <input type="text"/>
              </div></td><td>(Uträkning)</td><td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
          <tr> <td>Produkt2:</td> <td>            <select class = "dropdown">
             <option disabled selected value> -- Välj produkt -- </option>
              <option value="volvo">Volvo</option>
              <option value="saab">Saab</option>
              <option value="mercedes">Mercedes</option>
              <option value="audi">Audi</option>
            </select></td> <td>                  <div class="box-2 antal">
                <label for="Namn">Antal:</label>
                  <input type="text"/>
                  </div></td><td>(Uträkning)</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr>
          <tr> <td>Produkt3:</td> <td>            <select class = "dropdown">
             <option disabled selected value> -- Välj produkt -- </option>
              <option value="volvo">Volvo</option>
              <option value="saab">Saab</option>
              <option value="mercedes">Mercedes</option>
              <option value="audi">Audi</option>
            </select></td> <td>                  <div class="box-2 antal">
                <label for="Namn">Antal:</label>
                  <input type="text"/>
                  </div></td> <td>(Uträkning)</td> <td><a href="#" id="tablebutton">Ta bort</a></td> </tr><tr><td></td><td></td><td></td><td>(Summering)</td></tr>

        </tbody>
                  </table>
                      <div class="höger3">
                <label for="Namn">Lås manuellt pallplatser:</label>
                  <input type="text"/>
              </div></fieldset>
    </div></div>
</div>-->
   </div>     <div class="box-2">

        <?php echo ('<b>Datum:</b>  '.$_POST["Datum"]);
        ?>
        <?php echo ('<b>Tur:</b>  '.$_POST["TurNamn"]);
        ?>
        <?php echo ('<b>Fordon:</b>  '.$_POST["FordonNamn"]);
        ?>
   </div>            <div class="block-1">


<div class="table-wrapper fordontables-wrapper vänster">
  <div class="table-scroll fordontables">
            <?php
    echo '<table>
        <thead>
            <tr>';
            $turFordonData = getData($turFordon, "RegNummer LIKE '%'");

                 foreach ($turFordonData as $index => $row) {;

ChromePhp::log($index);
                                 foreach ($row as $field => $value) {;
 if($field === "RegNummer"){
                $_SESSION[$index]['RegNummer'] = $value;
              };
if($field === "AntalPallPlatser"){
                  $AntalPallPlatser = $value;

                };
  if($field === "TurID"){
                $_SESSION[$index]['TurID'] = $value;
 };
 if($field === "FordonNamn"){
   $tempFordonNamn = $value;

 };
                                                                    }
echo ('<th><span class="text">
'.$tempFordonNamn.': '.$AntalPallPlatser.'</span></th>');
                                                                  };
                echo'
            </tr>

        </thead> <tbody><tr>';
      foreach ($turFordonData as $index => $row){

          $turID = $_SESSION[$index]['TurID'];


       $turDatumData = getData($turDatum, "TurID = '$turID'");
        $turData = getData($tur, "ID = '$turID'");

        foreach ($turDatumData[0] as $field => $value) {;
 if($field === "StartDatum"){
     $start = strtotime($value=substr($value, 0, strrpos($value, ' ')));
     $startText = $value;
      }else if($field === "SlutDatum"){
     $end = strtotime($value);

         $diff = $end - $start;
     $days = floor($diff / (60 * 60 * 24));
      };

                                                    };
        // foreach ($turFordonData as $row){

          echo' <td>
          <div class="table-wrapper fordontable-wrapperhover">
  <div class="table-scroll fordontable">
    <table>
        <thead>
            <tr>';

            // $FordonData = getData($fordon, "RegNummer = '$regNummer'");
            //$turData = getData($tur, "ID = '$turID'");

                echo '<th><span class="text">Datum</span></th>
                <th><span class="text">Tur</span></th>                <th><span class="text">Pall</span></th>           <th><span class="text">Kunder</span></th>
                <th><span class="text">Plantering</span></th>
            </tr>

        </thead>
        <tbody>';
        for($i = 0; $i <= $days; ++$i){
            if(date('Y-m-d', strtotime(
              $startText . ' +'.$i.' day')) >= date('Y-m-d')){
          echo '<tr class="bokarad"> <td class="fordon datum">
          <input type="text" name="Datum" value=
          "'.date('Y-m-d', strtotime(
              $startText . ' +'.$i.' day')).'" readonly/>
            </td> <td class="fordon tur">
            <input type="text" name="TurNamn" value=
            "'.$turData[0]['Namn'].'" readonly/>
            <input type="hidden" name="TurID" value=
            "'.$turData[0]['ID'].'"/>
            <input type="hidden" name="RegNummer" value=
            "'.$_SESSION[$index]['RegNummer'].'"/>
            </td><td></td><td></td> <td></td></tr>';
          }};
        echo '</tbody>
    </table>
  </div>
</div>
      </td>';}
      echo '</tr>
        </tbody>
    </table>';
    ?>
  </div>
</div>    <!--<td><div class="table-wrapper fordontable-wrapperhover">
  <div class="table-scroll fordontable">
    <table>
        <thead>
            <tr>
                <th><span class="text">Datum</span></th>
                <th><span class="text">Tur</span></th>                <th><span class="text">Pall</span></th>           <th><span class="text">Kunder</span></th>
                                <th><span class="text">Plantering</span></th>
            </tr>
        </thead>
        <tbody>
          <tr> <td>1, 0</td> <td>2, 0</td><td>3, 0</td><td>4, 0</td> <td>5, 0</td></tr>

        </tbody>
    </table>
  </div>
</div></td><td><div class="table-wrapper fordontable-wrapperhover">
  <div class="table-scroll fordontable">
    <table>
        <thead>
            <tr>
                <th><span class="text">Datum</span></th>
                <th><span class="text">Tur</span></th>                <th><span class="text">Pall</span></th>           <th><span class="text">Kunder</span></th>
                                <th><span class="text">Plantering</span></th>
            </tr>
        </thead>
        <tbody>
          <tr> <td>1, 0</td> <td>2, 0</td><td>3, 0</td><td>4, 0</td> <td>5, 0</td></tr>

        </tbody>
    </table>
  </div>
</div></td>-->
             <div class="btns nerhöger3"><button type="submit" name="spara" id="spara" class="button" value="Spara">Spara</button></div>
            <?php echo '</form>'; ?>
          </div>  </div>
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
