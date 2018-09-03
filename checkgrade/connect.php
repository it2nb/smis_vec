<?php
$hostname = "localhost";
$database = "Your_db_name";
$username = "root";
$password = "root_password";
$conn = mysql_pconnect($hostname, $username, $password);
mysql_select_db($database,$conn); 
mysql_query("SET NAMES UTF8");
?>
