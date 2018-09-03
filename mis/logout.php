<?php
ob_start();
session_start();
require_once("includefiles/connectdb.php");
$member_ID = $_SESSION["userID"];
$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system) Values ('$member_ID','logout','main_mis')";
$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
session_destroy();
echo "<meta http-equiv='refresh' content='0;url=../'>";
?>
