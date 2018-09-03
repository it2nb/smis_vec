<?php
session_start();
include("../../includefiles/connectdb.php");
require('../../../fpdf/fpdf.php');
include("../../includefiles/datalist.php");
$teach_ID = $_GET["teach_ID"];
mysql_query("SET NAMES TIS620");
$query = "Select * From teach,subject,course Where teach.subject_ID=subject.subject_ID and teach.course_ID=course.course_ID and teach.teach_ID='$teach_ID'";
$teach_query = mysql_query($query,$conn)or die(mysql_error());
$teach_fetch = mysql_fetch_assoc($teach_query);
$check_period = $teach_fetch["teach_term"]."/".$teach_fetch["teach_year"];

$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID'";
$student_query = mysql_query($query,$conn)or die(mysql_error());

$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='$teach_ID' group by teachstd.class_ID";
$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
$pdf = new FPDF();
$pdf->SetMargins(22,25,25);
$pdf->AddPage();
$pdf->AddFont('THSarabanb','','thsarabanb.php');
$pdf->AddFont('THSarabun','','thsarabun.php');
$pdf->SetFont('THSarabanb','',18);

$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"ข้อมูลสรุปผลการเข้าเรียนวิชา").$teach_fetch["subject_name"],0,'C');
$pdf->SetFont('THSarabanb','',16);
$stdlevel = iconv('UTF-8','cp874',"ระดับ ");
while($teachstd_fetch=mysql_fetch_assoc($teachstd_query))
	 $stdlevel = $stdlevel.$teachstd_fetch["area_level"].".".(substr(($teach_fetch["teach_year"]+543),2,2)-substr($teachstd_fetch["class_ID"],0,2)+1)." ".$teachstd_fetch["major_name"].", ";
$stdlevel = $stdlevel.iconv('UTF-8','cp874',"ภาคเรียนที่ ").$teach_fetch["teach_term"]."/".($teach_fetch["teach_year"]+543);
$pdf->MultiCell(0,8,$stdlevel,0,'C');
$pdf->Ln();
$pdf->SetFont('THSarabanb','',16);
$pdf->SetFillColor(230,230,230);
$pdf->MultiCell(0,2," ",0,'L');
$pdf->Cell(8,10,iconv('UTF-8','cp874',"ที่"),1,0,"C",true);
$pdf->Cell(25,10,iconv('UTF-8','cp874',"รหัสนักศึกษา"),1,0,"C",true);
$pdf->Cell(50,10,iconv('UTF-8','cp874',"ชื่อ-สกุล"),1,0,"C",true);
$pdf->Cell(10,10,iconv('UTF-8','cp874',"มา"),1,0,"C",true);
$pdf->Cell(12,10,iconv('UTF-8','cp874',"ลาป่วย"),1,0,"C",true);
$pdf->Cell(10,10,iconv('UTF-8','cp874',"ลากิจ"),1,0,"C",true);
$pdf->Cell(12,10,iconv('UTF-8','cp874',"มาสาย"),1,0,"C",true);
$pdf->Cell(10,10,iconv('UTF-8','cp874',"ขาด"),1,0,"C",true);
$pdf->Cell(15,10,iconv('UTF-8','cp874',"%"),1,0,"C",true);
$pdf->Cell(15,10,iconv('UTF-8','cp874',"ผลลัพธ์"),1,0,"C",true);
$pdf->Ln();
$pdf->SetFont('THSarabun','',16);
list($teach_term,$teach_tyear) = split("/",$check_period);
$query = "Select * From period Where period_year='$teach_tyear' and period_term='$teach_term'";
$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
$yearterm_fetch = mysql_fetch_assoc($yearterm_query);
$allday=0;
list($st_year,$st_month,$st_day) = split("-",$yearterm_fetch["period_start"]);
list($sp_year,$sp_month,$sp_day) = split("-",$yearterm_fetch["period_end"]);
$date_st = ($st_year*10000)+($st_month*100)+$st_day;
$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
list($teach_year,$teach_month,$teach_day) = split("-",$check_date);
while($date_st<=$date_sp){
	$query="Select teachday_ID From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)."'";
	$teachday_query=mysql_query($query,$conn)or die(mysql_error());
	if(mysql_num_rows($teachday_query)){
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
$allday=$allday;
$n=1;
while($student_fetch=mysql_fetch_assoc($student_query))
{
	if($student_fetch["student_endstatus"]==0){
		$student_ID = $student_fetch["student_ID"];
		$query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='0'";
		$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		$checkday_fetch = mysql_fetch_assoc($checkday_query);
		$out = $checkday_fetch["teachcheck"];
		$query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='1'";
		$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		$checkday_fetch = mysql_fetch_assoc($checkday_query);
		$present = $checkday_fetch["teachcheck"];
		$query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='2'";
		$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		$checkday_fetch = mysql_fetch_assoc($checkday_query);
		$late = $checkday_fetch["teachcheck"];
		$query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='3'";
		$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		$checkday_fetch = mysql_fetch_assoc($checkday_query);
		$sick = $checkday_fetch["teachcheck"];
		$query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='4'";
		$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		$checkday_fetch = mysql_fetch_assoc($checkday_query);
		$business = $checkday_fetch["teachcheck"];
		$checkday=$out+$present+$late+$sick+$business;
		$result_percent = round((($allday-($out+(floor($late/2))))/$allday)*100,2);
	$pdf->Cell(8,8,$n++,1,0,"C");
	$pdf->Cell(25,8,$student_fetch["student_ID"],1,0,"C");
	$pdf->Cell(50,8,$student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"],1,0,"L");
	$pdf->Cell(10,8,$present,1,0,"C");
	$pdf->Cell(12,8,$sick,1,0,"C");
	$pdf->Cell(10,8,$business,1,0,"C");
	$pdf->Cell(12,8,$late,1,0,"C");
	$pdf->Cell(10,8,$out,1,0,"C");
	$pdf->Cell(15,8,$result_percent,1,0,"C");
	if($result_percent>=80)
		$pdf->Cell(15,8,iconv('UTF-8','cp874',"ผ่าน"),1,0,"C");
	else
		$pdf->Cell(15,8,iconv('UTF-8','cp874',"ไม่ผ่าน"),1,0,"C");
	$pdf->Ln();
}}
$pdf->Cell(0,10,iconv('UTF-8','cp874',"ข้อมูล ณ วันที่ ".date("j")." ".$thmonth[(date("m")*1)]." ".(date("Y")+543)),0,0,"R");
$pdf->Output();
?>