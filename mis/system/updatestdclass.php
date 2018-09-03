<?php
session_start();
require_once("../includefiles/connectdb.php");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$class_ID=$_GET["class_ID"];
$student_ID=$_GET["student_ID"];

$query="Update student SET class_ID='$class_ID' Where student_ID='$student_ID'";

$student_update=mysql_query($query,$conn) or die(mysql_error());
?>