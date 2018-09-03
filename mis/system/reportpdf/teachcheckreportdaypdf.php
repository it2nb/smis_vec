<?php
session_start();
include("../../includefiles/connectdb.php");
include("../../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
$check_date=date("Y-m-d");

$query = "Select * From teach,subject Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.teach_ID='$teach_ID'";
$teach_query = mysql_query($query,$conn)or die(mysql_error());
$teach_fetch = mysql_fetch_assoc($teach_query);
$check_period = $teach_fetch["teach_term"]."/".$teach_fetch["teach_year"];

$query="Select DISTINCT(teachstd.class_ID),major.*,area.* From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='$teach_ID' group by teachstd.class_ID";
$class_query=mysql_query($query,$conn)or die(mysql_error());
?>
<!doctype html>
<html lang="TH">
<head>
	<meta charset="utf-8" />
    <title>printpage</title>
<script type="text/javascript" src="../../includefiles/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	print();
});
</script>
<style type="text/css">
body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font-family: "TH SarabunPSK", "Angsana New", AngsanaUPC;
		font-size: 12px;
}
* {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
}
table {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
td {
	border-left: 1px solid #000;
	border-top: 1px solid #000;
}
#verticaltext {
	writing-mode: tb-rl;
	filter: flipv fliph;
	-webkit-transform:rotate(-90deg);
	white-space:nowrap;
	display:block;
	overflow: hidden;
	padding: 0;
}
.page {
	width: 21cm;
	min-height: 29.7cm;
	border: 1px #D3D3D3 solid;
	border-radius: 5px;
	background: white;
	box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	margin-top: 0cm;
	margin-right: auto;
	margin-bottom: 0cm;
	margin-left: auto;
	padding-top: 1cm;
	padding-right: 1cm;
	padding-bottom: 1cm;
	padding-left: 2cm;
}
.head{
	font-size: 16px;
	font-weight: bold;
}
	.regular12{
	font-size: 12px;
}
.blod12{
	font-size: 12px;
	font-weight: bold;
}
.blackRegula8{
	font-size: 10px;
}
.subpage {
            
        height: 247mm;      
}
.BlackBold10{
		font-weight: bold;
}
@page {
        size: A4;
        margin: 0;
}
@media print {
    .page {
		font-family: "TH SarabunPSK", "Angsana New", AngsanaUPC;
		font-size: 10px;
        margin-bottom: 1cm;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
	.head{
	font-size: 16px;
	font-weight: bold;
}
	.regular12{
	font-size: 12px;
}
.blod12{
	font-size: 12px;
	font-weight: bold;
}
.blackRegula8{
	font-size: 8px;
}
	.noprint {
		display:none;
	}
}
</style>
</head>
<body>
<div class="noprint">
    <a href="javascript:window.print()"><img src="../../images/icons/64/printer.png" width="64" height="64"/></a>
 </div>
 <?php
 	while($class_fetch=mysql_fetch_assoc($class_query)){
	$n=0;
	$class_ID=$class_fetch["class_ID"];
 	$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID' and teachstd.class_ID='$class_ID' Order By student.student_ID ASC";
	$student_query = mysql_query($query,$conn)or die(mysql_error());
 	$rownum = mysql_num_rows($student_query);
 	$pagenum = ceil($rownum/40);
	for($p=1;$p<=$pagenum;$p++){
 ?>
 	<div class="page">
    <div class="subpage">
    <center><div class="head">
    บันทึกเวลาเรียน<br />
    รหัสวิชา <?php echo $teach_fetch["subject_ID"];?> &nbsp;&nbsp;&nbsp;&nbsp;  วิชา <?php echo $teach_fetch["subject_name"];?><br>
ระดับ <?php echo $class_fetch["area_level"].".".(substr(($teach_fetch["teach_year"]+543),2,2)-substr($class_fetch["class_ID"],0,2)+1)."/".substr($class_fetch["class_ID"],7,1);?>  สาขางาน <?php echo $class_fetch["major_name"];?>&nbsp;&nbsp;&nbsp;&nbsp;ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?><br>
	สอน
    <?php
	$query="Select * From teachday Where teach_ID='$teach_ID'";
	$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
	$dayofweek=mysql_num_rows($dayofweek_query);
	 while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
		 echo "วัน".$thday[$dayofweek_fetch["teachday_day"]]." เวลา ".substr($dayofweek_fetch["teachday_start"],0,5)." - ".substr($dayofweek_fetch["teachday_stop"],0,5)." น. , ";
	 }
	?>
    </div>
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="3%" height="70" align="center" valign="middle" bgcolor="#CCCCCC" class="blod12">ที่</td>
    <td width="10%" align="center" valign="middle" bgcolor="#CCCCCC" class="blod12">รหัสนักศึกษา</td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#CCCCCC" class="blod12">ชื่อสกุล</td>
    <?php
			  $query="Select * From period Where period_year='".substr($check_period,2,4)."' and period_term='".substr($check_period,0,1)."'";
			  $date_query=mysql_query($query,$conn)or die(mysql_error());
			  $date_fetch = mysql_fetch_assoc($date_query);
			  list($st_year,$st_month,$st_day) = split("-",$date_fetch["period_start"]);
			  list($sp_year,$sp_month,$sp_day) = split("-",$date_fetch["period_end"]);
			  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  $date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
			  $todaydate = (date("Y")*10000)+(date("m")*100)+date("j");
			  list($teach_year,$teach_month,$teach_day) = split("-",$check_date);
			  $week = 1;
			  $day = 1;
			  while($date_st<=$date_sp&&$date_st<=$date_sp){
				  $query="Select teachday_ID From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)."'";
				  $teachday_query=mysql_query($query,$conn)or die(mysql_error());
				  while($teachday_fetch=mysql_fetch_assoc($teachday_query)){//;			  
				  //if(mysql_num_rows($teachday_query)){
					  ?>
	  	  <td align="center" valign="middle" bgcolor="#CCCCCC" class="blackRegula8"><?php echo $st_day."<br>".$thmountbf[(int)$st_month]."<br>".substr($st_year+543,2,2)."<hr color='#000000'>".$week.""; ?></td>
                    <?php
					if($day%$dayofweek==0)
					$week++;
					$day++;
				  }
				  $st_day++;
				  if($st_day>cal_days_in_month(CAL_GREGORIAN, $st_month, $st_year)){
					  $st_day=1;
					  $st_month++;
				  }
				  if($st_month>12){
					  $st_month=1;
					  $st_year++;
				  }
				  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  }
			  ?>
    <td width="3%" align="center" valign="middle" bgcolor="#CCCCCC" class="blod12">รวม</td>
    </tr>
  <?php
  $r=1;
  while($r<=40&&$student_fetch=mysql_fetch_assoc($student_query))
  {
	  if($student_fetch["student_endstatus"]==0){
		  $r++;
		$student_ID = $student_fetch["student_ID"];
	  	$query = "Select * From teachcheck,teachday Where teachcheck.teachday_ID=teachday.teachday_ID and teachcheck.teach_ID='$teach_ID' and teachcheck.student_ID='$student_ID' Order By teachcheck.teachcheck_week,teachday.teachday_day";
	  	$teachcheck_query = mysql_query($query,$conn)or die(mysql_error());
	  	while($teach_check=mysql_fetch_assoc($teachcheck_query)){
		  	$check_result[$teach_check["teachcheck_week"]][$teach_check["teachday_ID"]]=$teach_check["teachcheck_result"];
	  }
  ?>
  <tr>
    <td height="20" align="center" valign="middle" class="regular12"><?php echo ++$n;?></td>
    <td align="center" valign="middle" class="regular12"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle" class="regular12"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <?php
	$miss = 0;
	$all=0;
	for($i=1;$i<$week;$i++){
		$query="Select teachday_ID,teachday_day,teachday_start,teachday_stop From teachday Where teach_ID='$teach_ID' Order By teachday_day ASC";
		$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
		while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
    		echo "<td align='center' valign='middle' ";
			if($check_result[$i][$dayofweek_fetch["teachday_ID"]]!=""){
				if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==1)
					echo ">/</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==2)
					echo ">ส</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==3)
					echo ">ป</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==4)
					echo ">ก</td>";
				else{
						echo ">ข</td>";
						if(substr($dayofweek_fetch["teachday_start"],0,2)<=12&&substr($dayofweek_fetch["teachday_stop"],0,2)>=13)
							$miss+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"]-1;
						else 
							$miss+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"];
				}
			}
			else
				echo "></td>";
			if(substr($dayofweek_fetch["teachday_start"],0,2)<=12&&substr($dayofweek_fetch["teachday_stop"],0,2)>=13)
				$all+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"]-1;
			else 
				$all+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"];
		}
	}
	?>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $all-$miss;?></td>
    </tr>
  <?php }} ?>
  <?php
  while($r<=40)
  {
	 $r++;
	?> 
  <tr>
    <td height="20" align="center" valign="middle" class="regular12"><?php echo ++$n;?></td>
    <td align="center" valign="middle" class="regular12">&nbsp;</td>
    <td align="left" valign="middle" class="regular12">&nbsp;</td>
    <?php
	$miss = 0;
	$all=0;
	for($i=1;$i<$week;$i++){
		$query="Select teachday_ID,teachday_day,teachday_start,teachday_stop From teachday Where teach_ID='$teach_ID' Order By teachday_day ASC";
		$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
		while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
    		echo "<td align='center' valign='middle'>&nbsp;</td>";
		}
	}
	?>
    <td align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  <?php } ?>
</table>
</center></div></div><?php }} ?>
</body>