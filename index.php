<?php
###########################################################
/*
GuestBook Script
Copyright (C) StivaSoft ltd. All rights Reserved.


This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.

For further information visit:
http://www.phpjabbers.com/
info@phpjabbers.com

Version:  1.0
Released: 2014-11-25
*/
###########################################################

session_name('LoginForm');
@session_start();

error_reporting(0);
include("config.php");

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Logga in</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/main.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="js/jquery-1.8.2.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/main.js"></script>
    </head>
    <body>
<?php
	$error = '';
	if(isset($_POST['is_login'])){
  	$sql = "SELECT * FROM ".$SETTINGS["USERS"]." WHERE `user` = '".mysql_real_escape_string($_POST['user'])."'";
		$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
		$user = mysql_fetch_assoc($sql_result);
    #TODO: Den här måste vara anpassad efter lösen med salt ifall ska läggas upp.
    $hash = '$2y$10$w60yvnr7L314AaQf.mYFyOKcXOqpTsvQFsLU093k2faETTl61O16W';

		if(!empty($user) && password_verify($_POST['password'], $hash)){
			$_SESSION['user_info'] = $user;
			$query = " UPDATE ".$SETTINGS["USERS"]." SET last_login = NOW() WHERE ID=".$user['ID'];
			mysql_query ($query, $connection ) or die ('request "Could not execute SQL query" '.$query);
		}
		else{
			$error = 'Fel användare eller lösenord.';
		}
	}

	if(isset($_GET['ac']) && $_GET['ac'] == 'logout'){
		$_SESSION['user_info'] = null;
		unset($_SESSION['user_info']);
	}
?>
	<?php if(isset($_SESSION['user_info']) && is_array($_SESSION['user_info'])) { ?>

	    <form id="login-form" class="login-form" name="form1">

	        <div id="form-content">
	            <div class="welcome">
					<?php echo $_SESSION['user_info']['user']  ?> har loggat in.
                    <br /><br />
                    <meta http-equiv="refresh" content="2;url=http://expabtrans.local/oversikt.php" />
                    <a href="index.php?ac=logout" style="color:#53b2c3">Logga ut</a>
				</div>
	        </div>

	    </form>

	<?php } else { ?>
	    <form id="login-form" class="login-form" name="form1" method="post" action="index.php">
	    	<input type="hidden" name="is_login" value="1">
	        <div class="h1">Logga in</div>
	        <div id="form-content">
	            <div class="group">
	                <label for="user">Användare</label>
	                <div><input id="user" name="user" class="form-control required" type="user" placeholder="Användare"></div>
	            </div>
	           <div class="group">
	                <label for="name">Lösenord</label>
	                <div><input id="password" name="password" class="form-control required" type="password" placeholder="Lösenord"></div>
	            </div>
	            <?php if($error) { ?>
	                <em>
						<label class="err" for="password" generated="true" style="display: block;"><?php echo $error ?></label>
					</em>
				<?php } ?>
	            <div class="group submit">
	                <label class="empty"></label>
	                <div><input name="submit" type="submit" value="OK"/></div>
	            </div>
	        </div>
	        <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
	    </form>
	<?php } ?>
    </body>
</html>
