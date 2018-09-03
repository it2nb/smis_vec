<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$stdate=$_GET["stdate"];
$spdate = new DateTime($stdate,new DateTimeZone('Asia/Bangkok'));
date_modify($spdate,("+123 day"));
$spdate = $spdate->format("Y-m-d");
list($spy,$spm,$spd) = split("-",$spdate);
echo ($spd*1)." ".$thmonth[($spm*1)]." ".($spy+543);
echo "<input name='spdate' id='spdate' type='hidden' value='$spdate' />";
?>