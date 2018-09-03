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
$class_ID = $_GET["class_ID"];
$check_period=$_GET["check_period"];
list($flag_term,$flag_tyear) = split("/",$check_period);
$query = "select teachcheck.teach_ID,teachcheck.student_ID,student_name,student_prefix,student_ser,class_ID,student_parphone,teach_hour,count(teachcheck.student_ID) as missday,sum(teachday_hour) as steachday_hour,(sum(teachday_hour)/(teach_hour*18)*100) as percent From teachcheck,teach,teachday,student Where teachcheck.teach_ID=teach.teach_ID and teachcheck.teachday_ID=teachday.teachday_ID and teachcheck.student_ID=student.student_ID and teachcheck_result=0 and teach.teach_term='$flag_term' and teach.teach_year='$flag_tyear' and class_ID='$class_ID' Group By teachcheck.teach_ID,teachcheck.student_ID Order By percent DESC";
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
 	$pagenum = ceil($rownum/20);
	for($p=1;$p<=$pagenum;$p++){
 ?>
 	<div class="page">
    <div class="subpage">
    <center><div class="head">
    รายงานการขาดการเข้าเรียน<br />
ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></div>
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#000000" >
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="25%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รายวิชา/ครูผู้สอน</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">วัน<br />
      ขาด/ทั้งหมด</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชั่วโมง<br />
      ขาด/ทั้งหมด</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การขาด</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
    </tr>
  <?php
   $r=1;
  while($r<=20&&$student_fetch=mysql_fetch_assoc($student_query))
  {  
	  if($student_fetch["student_endstatus"]==0){
		  $r++;
		  $query="Select subject_name,personnel_name,personnel_ser,count(teachday_ID) as cteachday From teach,teachday,subject,personnel Where teach.teach_ID=teachday.teach_ID and teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.personnel_ID=personnel.personnel_ID and teach.teach_ID='".$student_fetch["teach_ID"]."' Group By teach.teach_ID";
		  $subject_query = mysql_query($query,$conn)or die(mysql_error());
		  $subject_fetch = mysql_fetch_assoc($subject_query);
  ?>
  <tr
  <?php
  	if((100-$student_fetch["percent"])<80)
		echo "bgcolor='#FF6666'";
	else if((100-$student_fetch["percent"])<85)
		echo "bgcolor='#FFCC99'";
	else if((100-$student_fetch["percent"])<90)
		echo "bgcolor='#FFFF99'";
  ?>>
    <td width="5%" height="25" align="center" valign="middle" bgcolor=""><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><?php echo $subject_fetch["subject_name"]."<br>".$subject_fetch["personnel_name"]." ".$subject_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["missday"]." / ".($subject_fetch["cteachday"]*18);?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["steachday_hour"]." / ".($student_fetch["teach_hour"]*18);?></td>
    <td align="center" valign="middle"><?php echo round($student_fetch["percent"],2);?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php }} ?>
</table>
</center></div></div><?php } ?>
</body>