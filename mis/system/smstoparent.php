<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
include("../includefiles/sms.php");
include '../classes/Student.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$sms = new siccsms();
$student_obj = new Student($conn);
if($_POST["send_bt"]=="ส่งข้อความ"){
	if(!empty($_POST["sms_txt"])){
		$smstxt = $_POST["sms_txt"];
		$member_ID = $_SESSION["userID"];
		$student_obj->queryBySql('Select student_parphone From student Where student_parphone!="" and student_endstatus="0"');
		while($student_obj->fetchRow()){
			if(is_numeric($student_obj->student_parphone))
				$smsphone .= $student_obj->student_parphone.';';
		}
		$smsresult = $sms->sendsms($smsphone,$smstxt);
		if(substr($smsresult,7,1)=="0"){
			$userlogs_des="ส่ง sms ".$_POST["sms_txt"]." ไปยังผู้ปกครอง  ";
			$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','sms_mis','$userlogs_des')";
			$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
		
			echo "<script type='text/javascript'>
				alert('ส่ง SMS เรียนร้อย');
				</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>
			alert('กรุณากรอกข้อความ');
			</script>";
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//sendsms
	$('#sendsmspar').ajaxForm({ 
        target: '#admincontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	//edit
});
</script>
  <center>
  		<h2>ส่งข้อความไปยัง <big><u>ผู้ปกครอง</u></big><br />
	    (<?php echo $sms->getCredit();?>) </h2>
	<form id="sendsmspar" action="smstoparent.php" method="post">
    <div align="center">
	  <b> 
	  ข้อความ : </b>
	  <input name="sms_txt" type="text" id="sms_txt" size="60" maxlength="70" /> ไม่เกิน 70 ตัวอักษร
      </div>
      <div align="center">
      <br /><input name="send_bt" type="submit" id="send_bt" value="ส่งข้อความ" /><br /><br />
	</form>
</center>