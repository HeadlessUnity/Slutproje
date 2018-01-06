<?php

session_name('Register');
@session_start();

error_reporting(0);
include("config.php");
require_once 'db_connection.php';
$conn = OpenCon();
$query= $conn->prepare("INSERT INTO `php_users_login` (`ID`, `user`,
`password`, `name`, `phone`, `content`, `last_login`)
 VALUES (?,?,?,?,?,?,?)");
//(1, 'admin', SHA2('RHfmgzR6', 256), 'admin', NULL, NULL, '2017-05-15 17:28:42')
$ID = 1;
$user = 'admin';
$password = PASSWORD_HASH('password', PASSWORD_DEFAULT);
$name = 'admin';
$phone = null;
$content = null;
$last_login = '2017-05-15 17:28:42';
$query->bind_param('issssss', $ID, $user, $password, $name, $phone, $content,
$last_login);
if ($query->execute()) {
  echo "Query executed.";
} else{
  echo "Query error.";
}
?>
