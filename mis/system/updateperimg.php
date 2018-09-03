<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
if($_POST["update_bt"]=="บันทึก"){
	if(!empty($_FILES["personnelpic_file"]["name"]))
	{
		$personnel_picfile=($personnel_ID*1).".jpg";
		move_uploaded_file($_FILES["personnelpic_file"]["tmp_name"],"../../images/personnel/".$personnel_picfile);
		$query = "Update personnel Set personnel_picfile='$personnel_picfile' Where personnel_ID='$personnel_ID'";
		$personnel_update=mysql_query($query,$conn) or die(mysql_error());
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='แก้ไขรูปภาพประจำตัว';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Profile','personnelinfo_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	echo "<script type='text/javascript'>
		$('#perinfo').hide();
		alert('แก้ไขข้อมูลเรียบร้อย');
		var d = new Date();
		$('#personnelinfo').load('personnelinfo.php?'+d.getTime());
		</script>";
}
else if($_POST["cancel_bt"]=="ยกเลิก")
	echo "<script type='text/javascript'>
		$('#perinfo').hide();
		$('#personnelinfo').load('personnelinfo.php');
		</script>";

$query="Select * From personnel Where personnel_ID='$personnel_ID'";
$personnel_query = mysql_query($query,$conn)or die(mysql_error());
$personnel_fetch = mysql_fetch_array($personnel_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#updateperimgform').ajaxForm({ 
        target: '#personnelimg',
		beforeSubmit: function(){
			$('#personnelimg').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#personnelimg img').attr('src', $('#personnelimg img').attr('src') + '?' + Math.random());
});
</script>
<link href="../includefiles/stylepersonnel.css" rel="stylesheet" type="text/css" />
<?php include("../includefiles/datalist.php");?>
<form id="updateperimgform" action="updateperimg.php" method="post" enctype="multipart/form-data">
 <img src="../../images/personnel/<?php echo $personnel_fetch["personnel_picfile"];?>" /><br /><input name="personnelpic_file" type="file" id="personnelpic_file" size="10" /><br />
 <input name="update_bt" type="submit" id="update_bt" value="บันทึก" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" />
</form>