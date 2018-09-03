<?php
session_start();
include("../includefiles/connectdb.php");
$query="Select * From teach";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
while($teach_fetch=mysql_fetch_assoc($teach_query)){
	$teach_ID=$teach_fetch["teach_ID"];
	$query="Select * From teachday Where teach_ID='$teach_ID'";
	$teachday_query=mysql_query($query,$conn)or die(mysql_error());
	while($teachday_fetch=mysql_fetch_assoc($teachday_query)){
		$teachday_ID=$teachday_fetch["teachday_ID"];
		if(substr($teachday_fetch["teachday_start"],0,2)<=12&&substr($teachday_fetch["teachday_stop"],0,2)>=13)
			$teachday_hour=$teachday_fetch["teachday_stop"]-$teachday_fetch["teachday_start"]-1;
		else 
			$teachday_hour=$teachday_fetch["teachday_stop"]-$teachday_fetch["teachday_start"];
		
		$query="Update teachday Set teachday_hour='$teachday_hour' Where teachday_ID='$teachday_ID'";
		$update_teachday=mysql_query($query,$conn)or die(mysql_error());
	}
	$query="Select sum(teachday_hour) as teach_hour From teachday Where teach_ID='$teach_ID'";
	$teachhour_query=mysql_query($query,$conn)or die(mysql_error());
	$teach_hour = mysql_result($teachhour_query,0,"teach_hour");
	$query="Update teach Set teach_hour='$teach_hour' Where teach_ID='$teach_ID'";
	$update_teach=mysql_query($query,$conn)or die(mysql_error());
}
echo "<script>alert('Ok');</script>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>