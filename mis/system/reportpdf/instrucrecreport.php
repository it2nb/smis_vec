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

$query="Select * From teach,subject,course,personnel Where teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and subject.course_ID=course.course_ID and teach.personnel_ID=personnel.personnel_ID and teach.teach_ID='$teach_ID'";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
$teach_fetch=mysql_fetch_assoc($teach_query);

$query="Select * From period Where period_term='".$teach_fetch["teach_term"]."' and period_year='".$teach_fetch["teach_year"]."'";
$period_query=mysql_query($query,$conn)or die(mysql_error());
$period_fetch=mysql_fetch_assoc($period_query);

$query = "Select * From instrucrec,teachday Where instrucrec.teachday_ID=teachday.teachday_ID and  instrucrec.teach_ID='$teach_ID' Order By week ASC, teachday.teachday_day ASC";
$instrucrec_query=mysql_query($query,$conn)or die(mysql_error());

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
		font-size: 18px;
}
* {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
}
table {
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-left-width: 0px;
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
	padding-left: 2cm;
}
.head{
	font-size: 18px;
	font-weight: bold;
}
	.regular12{
	font-size: 12px;
}
}
	.regular16{
	font-size: 16px;
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
	border: thin solid #000;
}
.BlackBold10{
		font-weight: bold;
}
.content{
	padding-left: 10px;
	padding-right: 5px;	
}
@page {
        size: A4;
        margin: 0;
}
@media print {
    .page {
		font-family: "TH SarabunPSK", "Angsana New", AngsanaUPC;
		font-size: 18px;
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
	font-size: 18px;
	font-weight: bold;
}
	.regular12{
	font-size: 12px;
}
	.regular16{
	font-size: 16px;
}
.blod12{
	font-size: 12px;
	font-weight: bold;
}
.blackRegula8{
	font-size: 8px;
}
.content{
	padding-left: 10px;
	padding-right: 5px;	
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
 	while($instrucrec_fetch=mysql_fetch_assoc($instrucrec_query)){
		$stdate = new DateTime($period_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
		$plusdate = (($instrucrec_fetch["week"]-1)*7)+($instrucrec_fetch["teachday_day"]-1);
		$stdate->modify("+".$plusdate." day");
		list($rec_year,$rec_month,$rec_day) = split("-",$stdate->format("Y-m-d"));
 ?>
 	<div class="page">
    <div class="subpage">
    <center>
      <table width="100%" cellspacing="0" cellpadding="0" bordercolor="#000000">
        <tr>
          <td width="90" rowspan="3" align="center" valign="middle"><img src="../../images/icons/logo_vec90.png" width="90" height="90"></td>
          <td height="30" align="center" valign="middle" class="head">บันทึกหลังการสอน ภาคเรียนที่ <?php echo $teach_fetch["teach_term"];?> ปีการศึกษา <?php echo $teach_fetch["teach_year"]+543;?></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle" class="head">หลักสูตร : <?php echo $teach_fetch["course_level"];?>. 
          <?php
		  $query = "Select DISTINCT(teachstd.class_ID),area_name,major_name From teachstd,class Where teachstd.class_ID=class.class_ID and teach_ID='$teach_ID'";
		  $class_query=mysql_query($query,$conn)or die(mysql_error());
		  while($class_fetch=mysql_fetch_assoc($class_query)){
          	echo "สาขาวิชา : ".$class_fetch["area_name"]." &nbsp;&nbsp;สาขางาน : ".$class_fetch["major_name"]."<br>";
		  }
		  ?></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle" class="head">รหัสวิชา : <?php echo $teach_fetch["subject_ID"];?> วิชา : <?php echo $teach_fetch["subject_name"];?> จำนวน <?php echo $teach_fetch["subject_unit"];?> หน่วยกิต <?php echo $teach_fetch["subject_hourp"]+$teach_fetch["subject_hourt"];?> ชั่วโมง </td>
        </tr>
      </table>
      <div align="left" class="content">
      <p>
      <b>สัปดาห์ที่ <?php echo $instrucrec_fetch["week"];?> <?php echo " วัน".$thday[jddayofweek(gregoriantojd($rec_month,$rec_day,$rec_year),0)]." ที่ ".(int)$rec_day." ".$thmonth[(int)$rec_month]." ".((int)$rec_year+543);?></b>
      </p>
      <p>
      <?php echo $instrucrec_fetch["instrucrec_detail"];?>
      </p>
      <div align="right" style="padding-right: 10px">ผู้บันทึก <?php echo $teach_fetch["personnel_name"]." ".$teach_fetch["personnel_ser"];?></div>
      <?php
	  	$query="Select * From instruccomm,personnel Where instruccomm.personnel_ID=personnel.personnel_ID and instrucrec_ID='".$instrucrec_fetch["instrucrec_ID"]."'";
		$instruccomm_query=mysql_query($query,$conn)or die(mysql_error());
		if(mysql_num_rows($instruccomm_query)>0){
	  ?>
      <div align="right" >
      <div align="left" style="width: 80%" class="regular16">
      <p>
      <b>ความคิดเห็น</b>
      <?php
	  	while($instruccomm_fetch=mysql_fetch_assoc($instruccomm_query)){
			list($instruccomm_year,$instruccomm_month,$instruccomm_day) = split("-",$instruccomm_fetch["instruccomm_date"]);
			echo "<p>";
			echo $instruccomm_fetch["instruccomm_detail"]."<div align='right' style='padding-right: 10px'>";
			echo $instruccomm_fetch["personnel_name"]." ".$instruccomm_fetch["personnel_ser"]." ( ".(int)$instruccomm_day." ".$thmountbf[(int)$instruccomm_month]." ".((int)$instruccomm_year+543)." )";
			echo "</div><hr color='#000000' size='1'></p>";
		}
	  ?>
      </p>
      </div>
      </div>
      <?php } ?>
      </div>
    </center></div></div><?php } ?>
</body>