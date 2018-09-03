<?php
session_start();
require_once("../includefiles/connectdb.php");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$department_ID=$_GET["department_ID"];
$personnel_ID=$_GET["personnel_ID"];
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query="Update personnel SET department_ID='$department_ID' Where personnel_ID='$personnel_ID'";

$personnel_update=mysql_query($query,$conn) or die(mysql_error());
?>