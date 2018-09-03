<?php
if(session_id()=='')
	session_start();
require_once("../../includefiles/connectdb.php");
require_once("../../includefiles/datalist.php");
require_once ('../../classes/recordgrade.class.php');
//header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	//echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
$main_obj = new Recordgrade_class($conn,$teach_ID);
$main_obj->queryTeach();
$main_obj->querySubject();
//$main_obj->queryPersonnel();
?>
<!doctype html>
<html lang="TH">
<head>
	<meta charset="utf-8" />
    <title>printpage</title>
<script type="text/javascript" src="../../includefiles/jquery.js"></script>
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
.verticaltext2 {
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
@page{
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
 	$main_obj->queryTeachStdClass();
	while($main_obj->fetchTeachStdClass()){
 ?>
 	<div class="page">
    <div class="subpage">
    <center>
      <div align="left" class="content">
        <p align="center">
        <span class="head">
        ภาคเรียนที่ <?php echo $main_obj->teach_term;?> ปีการศึกษา  <?php echo $main_obj->teach_year+543;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สาขาวิชา
        <?php echo $main_obj->area_name;?><br>
        ชื่อวิชา <?php echo $main_obj->subject_name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รหัสวิชา <?php echo $main_obj->subject_ID;?><br>
ระดับชั้น <?php if(substr($main_obj->class_ID,2,1)==2) echo 'ปวช.'; else echo 'ปวส.'; echo substr($main_obj->teach_year+543,2,2)-substr($main_obj->class_ID,0,2)+1;?> กลุ่มที่  <?php echo (int)substr($main_obj->class_ID,6,2);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวน <?php echo $main_obj->subject_hourt+$main_obj->subject_hourp;?> คาบ/สัปดาห์  <?php echo $main_obj->subject_unit;?> หน่วยกิต</span><br>
        </p>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000" class="maintb">
      <tr>
        <td width="5%" height="150" rowspan="3" align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10">ที่</td>
        <td rowspan="3" align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10">ชื่อ - นามสกุล</td>
        <td height="20" colspan="8" align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10">คะแนนระหว่างภาค</td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext">รวมระหว่างภาค</span></td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext">จิตพิสัย</span></td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext">สอบปลายภาค</span></td>
        <td width="6%" rowspan="2" align="center" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10">รวม</td>
        <td width="6%" rowspan="3" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext">ระดับคะแนน</span></td>
        <td width="10%" rowspan="3" align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10">หมายเหตุ</td>
      </tr>
      <tr>
    <td width="5%" height="120" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->queryScoregroup();$main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#CCCCCC" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->queryScoregroup();$main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php echo $main_obj->teachpoint_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php echo $main_obj->affective_score;?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php echo $main_obj->teachfinal_score?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC" class="BlackBold10"><?php echo $main_obj->teachpoint_score+$main_obj->teachfinal_score+$main_obj->affective_score;?></td>
    </tr>
  <?php $main_obj->queryStudent();
  $n=1;
   while($main_obj->fetchStudent()){ 
  	$main_obj->queryScoregroup();
  ?>
  <tr>
    <td align="center" valign="middle"><?php echo $n++;?></td>
    <td><?php echo $main_obj->student_name.' '.$main_obj->student_ser;?></td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle">      <?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?>    </td>
    <td align="center" valign="middle"><?php echo $main_obj->getStdsumscorepoint();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getSumAffective();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getStdfinalscore();?></td>
    <td align="center" valign="middle"><?php echo ($main_obj->getStdsumscorepoint()+$main_obj->getSumAffective()+$main_obj->getStdfinalscore());?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><b><?php echo $main_obj->student_grade;?></b></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <?php }while($n<=30){ ?>
  <tr>
    <td align="center" valign="middle"><?php echo $n++;?></td>
    <td>&nbsp;</td>
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
    <td align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
</tr>
  
  <?php }?>
      </table>
    </center></div></div><?php } ?>
</body>