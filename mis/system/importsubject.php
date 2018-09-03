<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["import_bt"]=="นำเข้า"){
	$subjectfile = $_FILES["csv_file"]["tmp_name"];
	$course_ID = $_POST["course_comb"];
	if(!empty($_FILES["csv_file"]["name"])){
		$fopen = fopen( $subjectfile,"r" );
		while ( !feof ($fopen)){
			$subjectdata = fgets($fopen,200);
			echo $subjectdata."<br>";
			list($subject_ID,$subject_name,$subject_obj,$subject_std,$subject_pfm,$subject_des,$subject_hourt,$subject_hourp,$subject_unit) = explode(",",$subjectdata);
			$query = "Select subject_ID From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
			$check_query = mysql_query($query,$conn)or die(mysql_error());
			if(mysql_num_rows($check_query)<1 && !empty($subject_ID)){
				$query = "Insert into subject(subject_ID,subject_name,subject_obj,subject_std,subject_pfm,subject_des,subject_hourt,subject_hourp,subject_unit,course_ID) values ('$subject_ID','$subject_name','$subject_obj','$subject_std','$subject_pfm','$subject_des','$subject_hourt','$subject_hourp','$subject_unit','$course_ID')";
				$subject_insert = mysql_query($query,$conn)or die(mysql_error());
			}	
		}
		fclose($fopen);
		echo "<script type='text/javascript'>
			$('#admincontent').hide();
			alert('บันทึกข้อมูลเรียบร้อย');
			$('#systemcontent').load('managesubject.php');
			</script>";
	}
	else{
		echo "<script type='text/javascript'>
			$('#admincontent').hide();
			alert('กรุณาเลือกไฟล์');
			$('#systemcontent').load('importsubject.php');
			</script>";
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
    $('#managesubject').click(function(){
		$('#systemcontent').load('managesubject.php');		
    });
	//search
	$('#importsubjectform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
   	<div id="statusbar">นำเข้าข้อมูลรายวิชา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a id="managesubject" href="#"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
    <div id="admincontent">
  <center><br /><b>
  		<form id="importsubjectform" action="importsubject.php" method="post" enctype="multipart/form-data">
        <b>เลือกหลักสูตร 
        <label for="course_comb"></label>
        <select name="course_comb" id="course_comb">
        <?php
			$query="Select * From course";
			$course_query=mysql_query($query,$conn)or die(mysql_error());
			while($course_fetch=mysql_fetch_array($course_query)){
				echo "<option value='".$course_fetch["course_ID"]."'>".$course_fetch["course_des"]."</option>";
			}
		?>
        </select>
        <br />
        เลือกไฟล์</b> 
        <input name="csv_file" type="file" id="csv_file" />
            <input name="import_bt" type="submit" id="import_bt" value="นำเข้า" />
</form>
  		<br /><hr />
  		รูปแบบไฟล์ CSV (ห้ามมีชื่อหัวคอลัมน์)<br />
  		<br />
    <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="10%" height="25" align="center" valign="middle">รหัสวิชา</td>
            <td width="10%" height="25" align="center" valign="middle">ชื่อวิชา</td>
            <td width="10%" height="25" align="center" valign="middle">วัตถุประสงค์</td>
            <td width="10%" height="25" align="center" valign="middle">มาตรฐานรายวิชา</td>
            <td width="10%" height="25" align="center" valign="middle">สมรรถนะรายวิชา</td>
            <td width="10%" height="25" align="center" valign="middle">คำอธิบายรายวิชา</td>
            <td width="10%" height="25" align="center" valign="middle">ชั่วโมงทฤษฎี</td>
            <td width="10%" height="25" align="center" valign="middle">ชั่วโมงปฏิบัติ</td>
            <td width="10%" height="25" align="center" valign="middle">หน่วยกิต</td>
          </tr>
    </table>
    <br />
</center></div>