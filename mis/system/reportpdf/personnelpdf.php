<?php
session_start();
include("../../includefiles/connectdb.php");
require('../../../fpdf/fpdf.php');
include("../../includefiles/datalist.php");
$personnel_ID = $_SESSION["user_personnelID"];
mysql_query("SET NAMES TIS620");
$query="Select * From personnel Where personnel_ID='$personnel_ID'";
$personnel_query = mysql_query($query,$conn)or die(mysql_error());
$personnel_fetch = mysql_fetch_array($personnel_query);
$pdf = new FPDF();
$pdf->SetMargins(35,25,25);
$pdf->AddPage();
$pdf->AddFont('THSarabanb','','thsarabanb.php');
$pdf->AddFont('THSarabun','','thsarabun.php');
$pdf->SetFont('THSarabanb','',18);

$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"ข้อมูลประวัติส่วนตัว"),0,'C');
$pdf->Ln();
$pdf->SetFont('THSarabanb','',16);
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"1. ข้อมูลทั่วไป"),0,'L');
$pdf->SetFont('THSarabun','',16);
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        ชื่อ  ").$personnel_fetch["personnel_name"].iconv('UTF-8','cp874',"        นามสกุล  ").$personnel_fetch["personnel_ser"],0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        เกิดวันที่ ").(substr($personnel_fetch["personnel_birthday"],8,2)*1).iconv('UTF-8','cp874'," เดือน ".$thmonth[(substr($personnel_fetch["personnel_birthday"],5,2)*1)]).iconv('UTF-8','cp874'," พ.ศ ").(substr($personnel_fetch["personnel_birthday"],0,4)+543).iconv('UTF-8','cp874',"        อายุ  ").(date("Y")-substr($personnel_fetch["personnel_birthday"],0,4)).iconv('UTF-8','cp874'," ปี"),0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        ตำแหน่ง  ").$personnel_fetch["personnel_position"].iconv('UTF-8','cp874',"        เลขที่ตำแหน่ง  ").$personnel_fetch["personnel_positionno"],0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        สถานศึกษา  ").$personnel_fetch["personnel_school"].iconv('UTF-8','cp874',"        สังกัด  ").$personnel_fetch["personnel_agency"],0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        ปฏิบัติราชการในสถานศึกษาแห่งนี้มาเป็นเวลา  ").(date("Y")-substr($personnel_fetch["personnel_startwork"],0,4)).iconv('UTF-8','cp874'," ปี"),0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        ที่อยู่ตามสำเนาทะเบียนบ้าน  ").trim(preg_replace('/\s+/', ' ',$personnel_fetch["personnel_addbr"])),0,'L');
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        ที่อยู่ตามปัจจุบัน  ").trim(preg_replace('/\s+/', ' ',$personnel_fetch["personnel_addnow"])),0,'L');
$pdf->Ln();
$pdf->SetFont('THSarabanb','',16);
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"2. ผลงานที่ภาคภูมิใจ"),0,'L');
$pdf->SetFont('THSarabun','',16);
//$award = explode(" ",trim(preg_replace('/\s+/', ' ',$personnel_fetch["personnel_award"])));
$award = explode("\n",$personnel_fetch["personnel_award"]);
for($i=0;$i<count($award);$i++){
	$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"        - ").$award[$i],0,'L');
}
$pdf->Ln();
$pdf->SetFont('THSarabanb','',16);
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"3. ประวัติการศึกษา"),0,'L');
$pdf->SetFillColor(230,230,230);
$pdf->MultiCell(0,2," ",0,'L');
$pdf->Cell(20,10,iconv('UTF-8','cp874',"ระดับ"),1,0,"C",true);
$pdf->Cell(50,10,iconv('UTF-8','cp874',"วุฒิ/สาขา"),1,0,"C",true);
$pdf->Cell(70,10,iconv('UTF-8','cp874',"สถาบัน"),1,0,"C",true);
$pdf->Cell(20,10,iconv('UTF-8','cp874',"ปีที่จบ"),1,0,"C",true);
$pdf->Ln();
$pdf->SetFont('THSarabun','',16);
$query="Select * From personneledu Where personnel_ID='$personnel_ID' Order By personneledu_year DESC";
$personneledu_query = mysql_query($query,$conn)or die(mysql_error());
while($personneledu_fetch=mysql_fetch_array($personneledu_query)){
	$pdf->Cell(20,8,$personneledu_fetch["personneledu_level"],1,0,"L");
	$pdf->Cell(50,8,$personneledu_fetch["personneledu_major"],1,0,"L");
	$pdf->Cell(70,8,$personneledu_fetch["personneledu_school"],1,0,"L");
	$pdf->Cell(20,8,($personneledu_fetch["personneledu_year"]+543),1,0,"C");
	$pdf->Ln();
}
$pdf->Ln();
$pdf->SetFont('THSarabanb','',16);
$pdf->MultiCell(0,8,iconv('UTF-8','cp874',"4. ประวัติการทำงาน"),0,'L');
$pdf->SetFillColor(230,230,230);
$pdf->MultiCell(0,2," ",0,'L');
$pdf->Cell(25,10,iconv('UTF-8','cp874',"ตำแหน่ง"),1,0,"C",true);
$pdf->Cell(25,10,iconv('UTF-8','cp874',"วิทยฐานะ"),1,0,"C",true);
$pdf->Cell(70,10,iconv('UTF-8','cp874',"สถานศึกษา"),1,0,"C",true);
$pdf->Cell(17,10,iconv('UTF-8','cp874',"เงินเดือน"),1,0,"C",true);
$pdf->Cell(23,10,iconv('UTF-8','cp874',"เมื่อ"),1,0,"C",true);
$pdf->Ln();
$pdf->SetFont('THSarabun','',16);
$query="Select * From personnelwokrh Where personnel_ID='$personnel_ID' Order By personnelwokrh_date DESC";
$personnelwork_query = mysql_query($query,$conn)or die(mysql_error());
while($personnelwork_fetch=mysql_fetch_array($personnelwork_query)){
	$pdf->Cell(25,8,$personnelwork_fetch["personnelwokrh_position"],1,0,"L");
	$pdf->Cell(25,8,$personnelwork_fetch["personnelwokrh_standing"],1,0,"L");
	$pdf->Cell(70,8,$personnelwork_fetch["personnelwokrh_school"],1,0,"L");
	$pdf->Cell(17,8,$personnelwork_fetch["personnelwokrh_salary"],1,0,"C");
	$pdf->Cell(23,8,(substr($personnelwork_fetch["personnelwokrh_date"],8,2)+0)." ".iconv('UTF-8','cp874',$thmountbf[(substr($personnelwork_fetch["personnelwokrh_date"],5,2)+0)])." ".(substr($personnelwork_fetch["personnelwokrh_date"],0,4)+543),1,0,"C");
	$pdf->Ln();
}
$pdf->Ln();
//$pdf->Cell(40,10,'Hello ??????');
$pdf->Output();
?>