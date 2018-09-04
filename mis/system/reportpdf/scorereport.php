<?php
if(session_id()=='')
	session_start();
require_once("../../includefiles/connectdb.php");
require_once("../../includefiles/datalist.php");
require_once '../../classes/scorereport.class.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];

$scorereport = new Scorereport_class($conn,$teach_ID);

$check_period =$scorereport->teach_term."/".$scorereport->teach_year;

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
.verticaltext {
	filter: flipv fliph;
	-webkit-transform: rotate(-90deg);
  	-moz-transform: rotate(-90deg);
  	-ms-transform: rotate(-90deg);
  	-o-transform: rotate(-90deg);
  	transform: rotate(-90deg);
  	
  	float: left;
  	white-space:nowrap;
  	width: 20px;
  	padding-left: 3px;
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
 	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$teach_fetch["personnel_ID"]."'";
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$personnel_fetch=mysql_fetch_assoc($personnel_query);
 	while($class_fetch=mysql_fetch_assoc($class_query)){
		//$query="Select * From scoregroup Where  scoregroup_name!='finalID".$teach_ID."' and scoregroup_name!='finalID".(int)$teach_ID."' and teach_ID='$teach_ID' Order By scoregroup_ID ASC";
		//$scoregroup_query=mysql_query($query,$conn)or die(mysql_error());
		$scoregroup = $scorereport->queryScoregroup();
		while($scoregroup_fetch=mysql_fetch_assoc($scoregroup)){
			$n=0;
  			$query = "Select * From student,teachstd Where 			student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID' and teachstd.class_ID='".$class_fetch["class_ID"]."' Order By student.student_ID ASC";
			$student_query = mysql_query($query,$conn)or die(mysql_error());
			for($sl=1;$sl<=ceil(mysql_num_rows($student_query)/30);$sl++){
				$r=1;
			$query="Select sum(scoredetail_score) as sumscore From scoredetail Where scoregroup_ID='".$scoregroup_fetch["scoregroup_ID"]."' Group By scoregroup_ID";
			$sumscoredetail_query=mysql_query($query,$conn)or die(mysql_error());
			$sumscoredetail_fetch=mysql_fetch_assoc($sumscoredetail_query);
			$query="Select * From scoredetail Where scoregroup_ID='".$scoregroup_fetch["scoregroup_ID"]."' Order By scoredetail_ID ASC";
			$scoredetail_query=mysql_query($query,$conn)or die(mysql_error());
			$scoredetail_num=mysql_num_rows($scoredetail_query);
			$sdnum=1;
			$sdnum2=1;
			for($sdi=1;$sdi<=ceil($scoredetail_num/10);$sdi++){
 ?>
 	<div class="page">
    <div class="subpage">
    <center>
      <div align="left" class="content">
        <p align="center">
        <span class="head">
        วิทยาลัย...
        <br>
        แผนภูมิแสดงความก้าวหน้าทางการเรียน (PROGRESS CHART)
        </span><br>
        <span class="regular16">
        <?php $scorereport->querySubject(); ?>
        <?php echo "รหัสวิชา ".$scorereport->subject_ID." ชื่อวิชา ".$scorereport->subject_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ทฤษฎี ".$scorereport->subject_hourt." ปฏิบัติ ".$scorereport->subject_hourp." หน่วยกิต ".$scorereport->subject_unit;?><br>
        <?php echo "ระดับชั้น ".$class_fetch["area_level"].".".(substr($teach_fetch["teach_year"]+543,2,2)-substr($class_fetch["class_ID"],0,2)+1)."/".(int)substr($class_fetch["class_ID"],6,2)." สาขางาน ".$class_fetch["major_name"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ชื่อผู้สอน ".$scorereport->personnel_name." ".$scorereport->personnel_ser;?><br>
        สอนวัน
        <?php
	$query="Select * From teachday Where teach_ID='$teach_ID'";
	$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
	$dayofweek=mysql_num_rows($dayofweek_query);
	 while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
		 echo "วัน".$thday[$dayofweek_fetch["teachday_day"]]." เวลา ".substr($dayofweek_fetch["teachday_start"],0,5)." - ".substr($dayofweek_fetch["teachday_stop"],0,5)." น. , ";
	 }
	?></span>
        </p>
      </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr>
    <td height="120" colspan="3" align="center" valign="middle" class="BlackBold10"><?php echo $scoregroup_fetch["scoregroup_name"];?></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><?php if($scoredetail_num>=$sdnum)echo mysql_result($scoredetail_query,($sdnum++)-1,"scoredetail_name");?></span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext">รวม</span></td>
    <td width="20" align="left" valign="bottom"><span class="verticaltext"><b>รวมคะแนน</b></span></td>
  </tr>
  <tr>
    <td width="5%" align="center" valign="middle" class="BlackBold10">ลำดับ</td>
    <td width="15%" align="center" valign="middle" class="BlackBold10">รหัสประจำตัว</td>
    <td width="20%" align="center" valign="middle" class="BlackBold10">ชื่อ - สกุล</td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php if($scoredetail_num>=$sdnum2)echo mysql_result($scoredetail_query,($sdnum2++)-1,"scoredetail_score");?></td>
    <td align="center" valign="middle"><?php echo $sumscoredetail_fetch["sumscore"];?></td>
    <td align="center" valign="middle"><strong><?php echo $scoregroup_fetch["scoregroup_score"];?></strong></td>
  </tr>
  <?php
  while($r<=30&&$student_fetch=mysql_fetch_assoc($student_query))
  {
	  if($student_fetch["student_endstatus"]==0){
		  $sdnum3=1;
		  $r++;
		$student_ID = $student_fetch["student_ID"];
		$query="Select sum(stdscore_score) as sumscore From stdscore,scoredetail Where stdscore.scoredetail_ID=scoredetail.scoredetail_ID and student_ID='$student_ID' and scoregroup_ID='".$scoregroup_fetch["scoregroup_ID"]."'";
		$sumstdscore_query=mysql_query($query,$conn)or die(mysql_error());
		$sumstdscore_fetch=mysql_fetch_assoc($sumstdscore_query);
		$query="Select * From stdscore,scoredetail Where stdscore.scoredetail_ID=scoredetail.scoredetail_ID and student_ID='$student_ID' and scoregroup_ID='".$scoregroup_fetch["scoregroup_ID"]."' Order By scoredetail.scoredetail_ID ASC";
		$stdscore_query=mysql_query($query,$conn)or die(mysql_error());
		$stdscore_num=mysql_num_rows($stdscore_query);
  ?>
  <tr>
    <td align="center" valign="middle"><span class="regular12"><?php echo ++$n;?></span></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php if($stdscore_num>=$sdnum3)echo mysql_result($stdscore_query,($sdnum3++)-1,"stdscore_score");?></td>
    <td align="center" valign="middle"><?php echo $sumstdscore_fetch["sumscore"];?></td>
    <td align="center" valign="middle"><strong><?php echo round(($sumstdscore_fetch["sumscore"]*$scoregroup_fetch["scoregroup_score"])/$sumscoredetail_fetch["sumscore"],0);?></strong></td>
  </tr>
  <?php 
  }}
  while($r<=30)
  {
	 $r++;
	?> 
  <tr>
    <td align="center" valign="middle"><span class="regular12"><?php echo ++$n;?></span></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <?php } ?>
</table>

    </center></div></div>
    <?php } } } }?>
</body>
</html>