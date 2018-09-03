<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select max(teach_year) as maxyear, min(teach_year) as minyear From teach";
if($_POST["import_bt"]=="นำเข้า"){
	$stdfile = $_FILES["csv_file"]["tmp_name"];
	if(!empty($_FILES["csv_file"]["name"])){
	$query = "Update student Set student_endstatus='90' Where student_endstatus='5'";
	$student_update = mysql_query($query,$conn)or die(mysql_error());
	$query = "Update student Set student_endstatus='5' Where student_endstatus='0'";
	$student_update = mysql_query($query,$conn)or die(mysql_error());
	$fopen = fopen( $stdfile,"r" );
	while ( !feof($fopen)){
		$stddata = fgets($fopen,4096);
		$student = explode(",",$stddata);
		if(is_numeric($student[0])){
			$query = "Select student_ID,student_endstatus From student Where student_ID='$student[44]'";
			$check_query = mysql_query($query,$conn)or die(mysql_error());
			$check_fetch = mysql_fetch_array($check_query);
			if($stdent[5]==1)
				$student_prefix="นาง";
			else if($student[5]==2)
				$student_prefix="นาย";
			else
				$student_prefix="นางสาว";
			if($student[8]==1)
				$student_gender="ชาย";
			else
				$student_gender="หญิง";
			list($dd, $mm, $yy) = split('/', $student[9]);
			$student_birthday=($yy-543)."-".$mm."-".$dd;
			$student_add = "เลขที่ ".$student[11]." หมู่ที่ ".$student[12]." ถนน ".$student[12];
			if(substr($student[39],0,1)=='2')
				$student_level = "ปวช";
			else
				$student_level = "ปวส";
			$area_ID = substr($student[39],0,4);
			$student_startyear = $student[37]-543;
			$student_endyear = $student[60]-543;
			$prefecture_ID = substr($student[14],0,4);
			if(mysql_num_rows($check_query)<1){
				$query = "Insert into student(student_ID,student_name,student_ser,personnelcard_ID,student_prefix,student_gender,student_birthday,nationality_ID,student_add,district_ID,prefecture_ID,student_height,student_weight,student_fatname,student_fatser,student_fatstatus,student_fatsalary,student_motname,student_motser,student_motstatus,student_motsalary,student_fmmarry,student_parname,student_parser,student_parsalary,student_startyear,student_level,area_ID,major_ID,class_ID,student_nickname,student_religion,province_ID,student_fatphone,student_parphone,student_bloodgroup,student_endyear,student_endstatus) values ('$student[44]','$student[6]','$student[7]','$student[4]','$student_prefix','$student_gender','$student_birthday','$student[10]','$student_add','$student[14]','$prefecture_ID','$student[16]','$student[17]','$student[18]','$student[19]','$student[21]','$student[22]','$student[24]','$student[25]','$student[27]','$student[28]','$student[30]','$student[33]','$student[34]','$student[35]','$student_startyear','$student_level','$area_ID','$student[39]','$student[45]','$student[46]','$student[47]','$student[48]','$student[50]','$student[51]','$student[52]','$student_endyear','0')";
				$student_insert = mysql_query($query,$conn)or die(mysql_error());
			}
			else{
				if($check_fetch["student_endstatus"]==5){
					$query = "Update student Set student_endstatus='0' Where student_ID='$student[44]'";
					$student_update = mysql_query($query,$conn)or die(mysql_error());
				}
				else if($check_fetch["student_endstatus"]==90){
					$query = "Update student Set student_endstatus='1' Where student_ID='$student[44]'";
					$student_update = mysql_query($query,$conn)or die(mysql_error());
				}
			}
		}
	}
	fclose($fopen);
	$query = "Update student Set student_endstatus='5' Where student_endstatus='90'";
	$student_update = mysql_query($query,$conn)or die(mysql_error());
	if(date("n")<5)
		$endyear = date("Y")-1;
	else
		$endyear = date("Y");
	$query = "Update student Set student_endyear='$endyear' Where student_endstatus='1' and student_endyear='0'";
	$student_update = mysql_query($query,$conn)or die(mysql_error());
	echo "<script type='text/javascript'>
			$('#admincontent').hide();
			alert('บันทึกข้อมูลเรียบร้อย');
			$('#systemcontent').load('managestudent.php');
			</script>";
	}else{
		echo "<script type='text/javascript'>
			$('#admincontent').hide();
			alert('ไม่พบไฟล์ข้อมูล');
			$('#systemcontent').load('managestudent.php');
			</script>";
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
    $('#managestudent').click(function(){
		$('#systemcontent').load('managestudent.php');		
    });
	//search
	$('#importstdform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
   	<div id="statusbar">นำเข้าข้อมูลนักเรียนนักศึกษา>></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a id="managestudent" href="#"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
    <div id="admincontent">
  <center><br /><b>
  		<form id="importstdform" action="importstd.php" method="post" enctype="multipart/form-data">
        <b>เลือกไฟล์</b><input name="csv_file" type="file" id="csv_file" />
            <input name="import_bt" type="submit" id="import_bt" value="นำเข้า" />
</form>    
<br /><hr />
 <br />
</center></div>