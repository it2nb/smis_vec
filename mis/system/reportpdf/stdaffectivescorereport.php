<?php
session_start();
include("../../includefiles/connectdb.php");
include("../../includefiles/datalist.php");
include ('../../classes/stdaffectivescorereport.class.php');
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
$main_obj = new Stdaffectivescorereport_class($conn,$teach_ID);
$main_obj->queryTeach();
$main_obj->querySubject();
$main_obj->queryPersonnel();
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
	writing-mode: tb-rl;
	filter: flipv fliph;
	-webkit-transform:rotate(-90deg);
	width: -moz-fit-content; 
	width: fit-content;
	white-space:nowrap;
	display:block;
	overflow: hidden;
	padding: 0;
	margin-left: -50px;
	margin-top: -15px;
    position: absolute;
    width: 125px;
}
.verticaltext2 {
	writing-mode: tb-rl;
	filter: flipv fliph;
	-webkit-transform:rotate(-90deg);
	width: -moz-fit-content; 
	width: fit-content;
	white-space:nowrap;
	display:block;
	overflow: hidden;
	padding: 0;
	margin-left: -45px;
	margin-top: -15px;
    position: absolute;
    width: 125px;
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
        วิทยาลัย...
        <br>
        แบบสรุปผลการประเมินด้านคุณธรรม จริยธรรม ค่านิยม และคุณลักษณะอันพึงประสงค์ (จิตพิสัย)</span><br>
        </p>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000" class="maintb">
  <tr>
    <td height="25" colspan="2" align="left" valign="middle"><strong>รหัสวิชา <?php echo $main_obj->subject_ID;?></strong></td>
    <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td rowspan="5" align="left" valign="middle"><span class="verticaltext2"><b><?php echo $main_obj->affective_name;?></b></span></td>
    <?php } ?>
    <td width="30" rowspan="5" align="left" valign="middle"><span class="verticaltext"><strong>คะแนนจิตพิสัย</strong></span></td>
  </tr>
  <tr align="left" valign="middle">
    <td height="25" colspan="2"><strong>ชื่อวิชา <?php echo $main_obj->subject_name;?></strong></td>
    </tr>
  <tr align="left" valign="middle">
    <td height="25" colspan="2"><strong>ระดับชั้น <?php if(substr($main_obj->class_ID,2,1)==2) echo 'ปวช.'; else echo 'ปวส.'; echo substr($main_obj->teach_year+543,2,2)-substr($main_obj->class_ID,0,2)+1;?> กลุ่มที่ <?php echo (int)substr($main_obj->class_ID,6,2);?></strong></td>
    </tr>
  <tr align="left" valign="middle">
    <td height="25" colspan="2"><strong>สาขางาน <?php echo $main_obj->major_name?></strong></td>
    </tr>
  <tr align="left" valign="middle">
    <td height="25" colspan="2"><strong>ครูผู้สอน <?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser;?></strong></td>
    </tr>
  <tr>
    <td width="5%" height="25" align="center" valign="middle"><strong>ที่</strong></td>
    <td width="25%" height="25" align="center" valign="middle"><strong>ชื่อ - สกุล</strong></td>
     <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle"><strong><?php echo $main_obj->teachaffective_score;?></strong></td>
    <?php } ?>
    <td align="center" valign="middle"><strong><?php echo $main_obj->affective_score;?></strong></td>
  </tr>
  <?php $n=1;$main_obj->queryStudent(); while($main_obj->fetchStudent()){ ?>
  <tr>
    <td align="center" valign="middle"><?php echo $n++;?></td>
    <td><?php echo $main_obj->student_prefix.$main_obj->student_name.' '.$main_obj->student_ser;?></td>
    <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle"><?php $main_obj->queryStudentaffective(); echo $main_obj->stdaffective_score;?></td>
    <?php } ?>
    <td align="center" valign="middle"><?php echo $main_obj->getSumScore();?></td>
  </tr>
  <?php }while($n<=30){ ?>
  <tr>
    <td align="center" valign="middle"><?php echo $n++;?></td>
    <td>&nbsp;</td>
    <?php for($i=1;$i<=$main_obj->getTeacaffectiveQty();$i++){ ?>
    <td align="center" valign="middle">&nbsp;</td>
    <?php } ?>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <?php } ?>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
    	<td width="30%" height="100" align="center" valign="bottom"></td>
        <td width="35%" align="center" valign="bottom"></td>
        <td height="50" align="center" valign="bottom">
        (<?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser;?>)
          <br>
          ครูผู้สอน</td>
	</tr>
</table>
    </center></div></div><?php } ?>
</body>