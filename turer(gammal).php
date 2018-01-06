<!DOCTYPE html>
<html lang="en">
<head>
<title>Turer</title>
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
<?php
include 'db_connection.php';
 
$conn = OpenCon();
 
echo "<p style='color:red;'>"."Connected Successfully";
 
CloseCon($conn);
 
?>
</head>
<body>
<div class="main">
  <!--==============================header=================================-->
  <header>
    <h1>Admin</h1>
    <div class="clear"></div>
    <nav class="box-shadow">
      <div>
        <ul class="menu">
          <li class="home-page"><a href="index.php"><span></span></a></li>
          <li><a href="boka.php">Boka transport</a></li>
          <li class="current"><a href="turer.php">Turer</a></li>
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
            <select class = "dropdown edit">
             <option disabled selected value> -- Redigera Tur -- </option>
              <option value="Linköping">Linköping</option>
              <option value="Norrköping">Norrköping</option>
              <option value="Kambodja">Kambodja</option>
              <option value="audi">Audi</option>
            </select>
            <div class="btns redigera"><a href="#" class="button">Redigera</a></div>
          </div>
        </div>
          <div class="tight block-1">
            <h3>Lägg in/redigera tur:</h3>
            <form id="form" method="post" action="#">
              <fieldset>
                  <div class="box-2">
                <label for="Namn">Namn:</label>
                  <input type="text"/>
                  </div>
                  
                  <div class="box-2">
                <label class="vänster" for="TurFordon">Fordon:</label>
                <select class = "dropdown vänster">
                 <option disabled selected value> -- Välj Fordon -- </option>
                  <option value="volvo">Volvo</option>
                  <option value="saab">Saab</option>
                  <option value="mercedes">Mercedes</option>
                  <option value="audi">Audi</option>
                </select>
                  </div>
                <div class="box-2 ner">
                    <label class="tight vänster" for="TurDatum">Välj start- och slutdatum: </label>

                    <div class="cal">
                      <header class="cal">
                        <button class="cal">«</button>
                        <h2 class="cal">April 2017</h2>
                        <button class="cal">»</button>
                      </header>
                    <table class="cal">
                      <tr class="cal">
                        <td>S</td>
                        <td>M</td>
                        <td>T</td>
                        <td>W</td>
                        <td>Th</td>
                        <td>F</td>
                        <td>S</td>
                      </tr>
                      <tr class="cal">
                        <td></td>
                        <td></td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                      </tr>
                      <tr class="cal">
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                        <td>11</td>
                        <td>12</td>
                      </tr>
                      <tr class="cal">
                        <td>13</td>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>
                        <td class="selected1">17</td>
                        <td>18</td>
                        <td>19</td>
                      </tr>
                      <tr class="cal">
                        <td>20</td>
                        <td>21</td>
                        <td>22</td>
                        <td>23</td>
                        <td class="selected2">24</td>
                        <td>25</td>
                        <td>26</td>
                      </tr>
                      <tr class="cal">
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td>30</td>
                        <td>31</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </table>
                    </div>
                  </div>
    
                <div class="btns nerhöger"><a href="#" class="button">Spara</a></div>
              </fieldset>
            </form>
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
