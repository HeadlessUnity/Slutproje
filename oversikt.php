<?php
require_once 'db_connection.php';
require_once 'db_error_handler.php';
require_once 'data_functions.php';
//include 'ChromePhp.php';

function __autoload($class_name)
{
  require_once "{$class_name}_class.php";
};
$transportOrder = new TransportOrder;
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
<title>Översikt | Hem</title>
<meta http-equiv="X-UA-Compatible"  content="IT=edge,chrome=IE8">

<meta charset='utf-8'>
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/slider.css">
<link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<script src="js/jquery-1.7.min.js">
</script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/main.js">
</script>


<?php



        if (isset($_POST['spara'])) {
        if (isset($_GET['ac']) && $_GET['ac'] == "redigera" ){;
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
            #TODO: här måste den egentligen kolla om namnet/ID finns först.
            #TODO funkar ej
            if (getData($kund, "Namn = ".$kundInfo['Namn']) === null){
              insertData($kund, $kundInfo);
            }
            //echo($_POST['KundID']);
            $_POST['KundID'] = getData($kund, 'ID = Kund.ID');
            $orderArray = array_merge($_POST, $_SESSION["TurFordonInfo"]);
            echo($orderArray);
            insertData($_SESSION['transport'], $orderArray);
            unset($_POST);

		}};



          ?>
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
          <li class="home-page current"><a href="oversikt.php"><span></span></a></li>
          <li><a href="boka.php">Boka transport</a></li>
          <li><a href="turer.php">Turer</a></li>
          <li><a href="fordon.php">Fordon</a></li>
          <li><a href="sortiment.php">Sortiment</a></li>
          <li><a href="lager.php">Lagersaldo</a></li>
          <li><a href="artiklar.php">Sammanställning artiklar</a></li>
          <li><a href="skicka.php">Skicka tur</a></li>
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
              <div class="table-wrapper fordontables-wrapper">
                <div class="table-scroll fordontables">
                          <?php
                  echo '<table>
                      <thead>
                          <tr>';
                          $turFordonData = getData($turFordon, "RegNummer LIKE '%'");
                          $orderData = getData($transportOrder, "OrderID LIKE '%'");

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
                        ChromePhp::log($turFordonData, $_SESSION[$index]['TurID']);
                        $turID = $_SESSION[$index]['TurID'];
                        ChromePhp::log($turFordonData, $_SESSION[$index]['TurID'], $turID);
                     $turDatumData = getData($turDatum, "TurID = '$turID'");
                      $turData = getData($tur, "ID = '$turID'");
                    ChromePhp::log($turData[0]['Namn']);
                      foreach ($turDatumData[0] as $field => $value) {;
               if($field === "StartDatum"){
                   $start = strtotime($value=substr($value, 0, strrpos($value, ' ')));
                   $startText = $value;
                   ChromePhp::log($start, $value, $startText);
                    }else if($field === "SlutDatum"){
                   $end = strtotime($value);
                   ChromePhp::log($end, $value);
                       $diff = $end - $start;
                   $days = floor($diff / (60 * 60 * 24));
                    };

                              ChromePhp::log($diff, $days);
                                                                  };
                      // foreach ($turFordonData as $row){

                        echo' <td>
                        <div class="table-wrapper fordontable-wrapperhover2">
                <div class="table-scroll fordontable">
                  <table>
                      <thead>
                          <tr>';

                          // $FordonData = getData($fordon, "RegNummer = '$regNummer'");
                          $turData = getData($tur, "ID = '$turID'");

                          //array_multisort($turData, $orderData);
                          //$turData = usort($turData, create_function('$a,$b', 'return $b["ID"] - $a["ID"];'));
                              echo '<th><span class="text">Datum</span></th>
                              <th><span class="text">Tur</span></th>                <th><span class="text">Pall</span></th>           <th><span class="text">Kunder</span></th>
                              <th><span class="text">Plantering</span></th>
                          </tr>
                      </thead>
                      <tbody>';
                      for($i = 0; $i <= $days; ++$i){
                        if(date('Y-m-d', strtotime($startText . ' +'.$i.' day')) >= date('Y-m-d')){
                          //$orderData = getData($transportOrder, "Datum = '$startText'");
                          #TODO: Fixa så att flera orderIDs och kundIDs kan sparas på samma datum.
                          foreach($orderData as $index1 => $row){
                            $kundID = $orderData[$index1]['KundID'];
                            $kundData = getData($kund, "ID = '$kundID'");

                            if($orderData[$index1]['Datum'] === date('Y-m-d',
                             strtotime($startText . ' +'.$i.' day'))){
                               foreach($turData as $index2 => $row){
                              if($turData[$index2]['ID'] == $orderData[$index1]['TurID']) {
                                $kundNamn = $kundData[$index2]['Namn'];
                        echo '<tr class="oversiktrad"> <td class="fordon datum">
                        <input type="text" name="Datum[]" value="'.date(
                          'Y-m-d', strtotime($startText . ' +'.$i.' day')).'" readonly/>
                          </td> <td class="fordon tur"><input type="text" name="TurNamn" value="'.$turData[0]['Namn'].'" readonly/>
                          <input type="hidden" name="KundNamn" value="'.$kundNamn.'" readonly/>
                          <input type="hidden" name="OrderID" value="'.$orderData[$index1]['OrderID'].'" readonly/>
                          </td><td></td><td></td> <td></td></tr>';

                          break;
                            }
                       }
                       break;
                          }else{
                            if ($index1 === count($orderData) - 1){
                            echo '<tr> <td class="fordon datum"><input type="text" name="Datum[]" value="'.date('Y-m-d', strtotime($startText . ' +'.$i.' day')).'" readonly/></td> <td class="fordon tur"><input type="text" name="TurNamn" value="'.$turData[0]['Namn'].'" readonly/></td><td></td><td></td> <td></td></tr>';
                          };
                          }

                        };
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
              </div>

          </div>   <div class="loose block-1">
            <h2 class="top-1 p0 turNamn"></h2>
<div class="table-wrapper skicka">
  <div id="table-scroll skicka">
<table>
        <thead>
            <tr>
                <th><span class="text">Kund</span></th>
                 <th><span class="text">OrderID</span></th>
            </tr>
        </thead>
            <!--#TODO: den här kan inte hantera flera order eller kundIds.-->
            <tbody class="tbody">

            </tbody>
        </table>
        </tbody>
    </table>
    </div></div>
</div> </div> </div> </div>
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
