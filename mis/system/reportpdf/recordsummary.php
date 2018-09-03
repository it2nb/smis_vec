<?php
if(session_id()=='')
	session_start();
require_once("../../includefiles/connectdb.php");
require_once("../../includefiles/datalist.php");
require_once ('../../classes/recordsummary.class.php');
//header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	//echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
$main_obj = new Recordsummary_class($conn,$teach_ID);
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
        <span class="head">แบบรายงานผลการเรียน<br>
วิทยาลัยการอาชีพสอง<br>
        ภาคเรียนที่ <?php echo $main_obj->teach_term;?> ปีการศึกษา  <?php echo $main_obj->teach_year+543;?><br>รหัสวิชา <?php echo $main_obj->subject_ID;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ชื่อวิชา <?php echo $main_obj->subject_name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; จำนวน <?php echo $main_obj->subject_unit;?> หน่วยกิต<br>
        ระดับชั้น <?php if(substr($main_obj->class_ID,2,1)==2) echo 'ปวช.'; else echo 'ปวส.'; echo substr($main_obj->teach_year+543,2,2)-substr($main_obj->class_ID,0,2)+1;?> กลุ่มที่  <?php echo (int)substr($main_obj->class_ID,6,2);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การเรียนต่อสัปดาห์ ทฤษฎี <?php echo $main_obj->subject_hourt;?> คาบ ปฏิบัติ <?php echo $main_obj->subject_hourp;?> คาบ<br>
สาขาวิชา <?php echo $main_obj->area_name;?> &nbsp;&nbsp;&nbsp;&nbsp;สาขางาน <?php echo $main_obj->major_name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ครูผู้สอน <?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser;?>
</span></p></div><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><span class="head">อนุมัติผลการเรียน</span></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top"><br>

    <span><strong>เสนอ </strong> ผู้อำนวยการวิทยาลัยเทคนิคสุราษฎร์ธานี</span><br>
    <span>ตามที่วิทยาลัยฯ  ได้มอบหมายให้ดำเนินการสอน
ในวิชานี้  บัดนี้ได้ดำเนินการสอน  และประเมินผล
การเรียนการสอนนักเรียน นักศึกษาในรายวิชานี้เสร็จ
เรียบร้อยแล้ว  ดังปรากฏผลรายละเอียดข้างล้างนี้</span>
	<div align="center"><br>
	  <table width="80%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#CCCCCC"><strong>เกรด</strong></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><strong>ช่วงคะแนน</strong></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><strong>จำนวน</strong></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">4</td>
    <td align="center" valign="middle">80 ขึ้นไป</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('4');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">3.5</td>
    <td align="center" valign="middle">75 - 79</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('3.5');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">3</td>
    <td align="center" valign="middle">70 -74</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('3');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">2.5</td>
    <td align="center" valign="middle">65 - 69</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('2.5');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">2</td>
    <td align="center" valign="middle">60 - 64</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('2');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">1.5</td>
    <td align="center" valign="middle">55 - 59</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('1.5');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">1</td>
    <td align="center" valign="middle">50 - 54</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('1');?></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">0</td>
    <td align="center" valign="middle">0 - 49</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('0');?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle">ขาดเรียนไม่มีสิทธิ์สอบ(ขร.)</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('ขร');?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle">ไม่สมบูรณ์(มส.)</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('มส');?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle">ขาดสอบ(ขส.)</td>
    <td align="center" valign="middle"><?php echo $main_obj->sumGrade('ขส');?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle">ทุจริตในการสอบ(ท.)</td>
    <td height="25" align="center" valign="middle"><?php echo $main_obj->sumGrade('ท');?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle">อื่นๆ</td>
    <td height="25" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" valign="middle"><strong>รวม</strong></td>
    <td height="25" align="center" valign="middle"><?php echo $main_obj->countGrade();?></td>
  </tr>
    </table><br>

  </div>
    <span>จึงเรียนเพื่อโปรดอนุมัติ</span><br>
	<div align="center"><br>
<br>
ลงชื่อ..........................................................ครูผู้สอน<br>( <?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser;?> )<br>

............../.............../...............</div><br>

    </td>
    <td align="left" valign="top"><br>

    <span>
    <strong>ความเห็นหัวหน้าแผนก</strong><br>
	พิจารณาแล้วเห็นชอบตามที่ผู้สอนเสนอ
    </span>
    <div align="center">
<br>
<br>
ลงชื่อ..........................................................<br>
(..........................................................)<br>

............../.............../...............
    </div><br>

    <span>
    <strong>ความเห็นหัวหน้างานวัดผลและประเมินผล</strong><br>
	พิจารณาแล้วเห็นสมควรอนุมัติผลการเรียน
    </span>
    <div align="center">
<br>
<br>
ลงชื่อ..........................................................<br>
(..........................................................)<br>

............../.............../...............
    </div><br>

    <span>
    <strong>ความเห็นของรองผู้อำนวยการฝ่ายวิชาการ</strong><br>
	พิจารณาแล้วเห็นสมควรอนุมัติผลการเรียนได้
    </span>
    <div align="center">
<br>
<br>
ลงชื่อ..........................................................<br>
(..........................................................)<br>

............../.............../...............
    </div><br>

    <span>
    <strong>ความเห็นของผู้อำนวยการฯ</strong><br>
    </span>
    <div align="center">
    (    )อนุมัติ                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(    )ไม่อนุมัติ <br>
<br><br>
ลงชื่อ..........................................................<br>
(..........................................................)<br>

............../.............../...............
    </div><br>

    </td>
  </tr>
</table>

    </center></div></div><?php } ?>
</body>