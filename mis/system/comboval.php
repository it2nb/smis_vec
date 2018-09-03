<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$table=$_GET["table"];
$where=$_GET["where"];
$whereval=$_GET["whereval"];
$value=$_GET["value"];
$comb_txt=$_GET["comb_txt"];
$comb_atxt=$_GET["comb_atxt"];
$comb_txt2=$_GET["comb_txt2"];
$comb_atxt2=$_GET["comb_atxt2"];
$comb_txt3=$_GET["comb_txt3"];
$comb_atxt3=$_GET["comb_atxt3"];
$comb_atxt3=$_GET["comb_atxt4"];
$select_ID=$_GET["select_ID"];
if(!empty($where))
	$query="Select * From ".$table." Where ".$where."='".$whereval."'";
else
	$query="Select * From ".$table;
$comb_query=mysql_query($query,$conn)or die(mysql_error());
while($comb_fetch=mysql_fetch_array($comb_query)){
	if($comb_fetch[$table."_ID"]==$select_ID)
		echo "<option value='".$comb_fetch[$value]."' selected='selected'>".$comb_atxt.$comb_fetch[$comb_txt].$comb_atxt2.$comb_fetch[$comb_txt2].$comb_atxt3.$comb_fetch[$comb_txt3].$comb_atxt4."</option>";
	else
		echo "<option value='".$comb_fetch[$value]."'>".$comb_atxt.$comb_fetch[$comb_txt].$comb_atxt2.$comb_fetch[$comb_txt2].$comb_atxt3.$comb_fetch[$comb_txt3].$comb_atxt4."</option>";
}
?>