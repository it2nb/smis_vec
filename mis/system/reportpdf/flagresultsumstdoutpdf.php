<?php
session_start();
include("../../includefiles/connectdb.php");
include("../../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$check_period = $_GET["check_period"];
list($flag_term,$flag_tyear) = split("/",$check_period);
$query = "Select * From period Where period_year='$flag_tyear' and period_term='$flag_term'";
$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
$yearterm_fetch = mysql_fetch_array($yearterm_query);
$allday=0;
list($st_year,$st_month,$st_day) = split("-",$yearterm_fetch["period_start"]);
list($sp_year,$sp_month,$sp_day) = split("-",$yearterm_fetch["period_end"]);
$date_st = ($st_year*10000)+($st_month*100)+$st_day;
$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
list($flag_year,$flag_month,$flag_day) = split("-",$check_date);
while($date_st<=$date_sp){
  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,(int)$st_day,$st_year),0)!=6){
	$allday++;
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
$allday=$allday-5;
$query = "Select student.*,count(flagcheck.student_ID) as sumout,class.* From student,flagcheck,class Where student.student_ID=flagcheck.student_ID and student.class_ID=class.class_ID and  flagcheck.flagcheck_result='0' and flagcheck_date between '".$yearterm_fetch["period_start"]."' And '".$yearterm_fetch["period_end"]."' Group By student_ID Order By sumout DESC";
$student_query = mysql_query($query,$conn)or die(mysql_error());
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
		font-size: 14px;
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
	padding-top: 2cm;
	padding-right: 1cm;
	padding-bottom: 1cm;
	padding-left: 1cm;
}
.head{
	font-size: 16px;
	font-weight: bold;
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
		font-size: 14px;
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
 	$rownum = mysql_num_rows($student_query);
 	$pagenum = ceil($rownum/30);
	for($p=1;$p<=$pagenum;$p++){
 ?>
 	<div class="page">
    <div class="subpage">
    <center><div class="head">
    รายงานการขาดการเข้าร่วมกิจกรรมหน้าเสาธง<br />
ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></div>
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ทั้งหมด(วัน)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ขาด(วัน)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การขาด</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ผลลัพธ์</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
    </tr>
  <?php
  $r=1;
  while($r<=30&&$student_fetch=mysql_fetch_assoc($student_query))
  {
	  if($student_fetch["student_endstatus"]=="0"){
		  $r++;
		  $query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID"]."'";
	  	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	  $personnel_fetch = mysql_fetch_array($personnel_query);
	  	  $query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID2"]."'";
	  	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	  $personnel2_fetch = mysql_fetch_array($personnel_query);
		  $result_percent = round(($student_fetch["sumout"]/$allday)*100,2);
  ?>
  <tr
  <?php
  	if((100-$result_percent)<80)
		echo "bgcolor='#FF6666'";
	else if((100-$result_percent)<85)
		echo "bgcolor='#FFCC99'";
	else if((100-$result_percent)<90)
		echo "bgcolor='#FFFF99'";
  ?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $allday;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["sumout"];?></td>
    <td align="center" valign="middle"><?php echo $result_percent;?></td>
    <td align="center" valign="middle">
    <?php
	if((100-$result_percent)>=80)
		echo "ผ่าน";
	else
		echo "ไม่ผ่าน";
    ?>
    </td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    </tr>
  <?php }} ?>
</table>
</center></div></div><?php } ?>
</body>
</html>