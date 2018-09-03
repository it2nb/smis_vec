<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$member_ID = $_SESSION["userID"];
if($_POST["add_bt"]=="บันทึก"){
	$teach_ID = $_POST["teach_ID"];
	$teachday_day=$_POST["day_comb"];
	$teachday_start=$_POST["daystart_comb"];
	$teachday_stop=$_POST["daystop_comb"];
	if(substr($teachday_start,0,2)<=12&&substr($teachday_stop,0,2)>=13)
		$teachday_hour=$teachday_stop-$teachday_start-1;
	else 
		$teachday_hour=$teachday_stop-$teachday_start;
	if($teachday_start<$teachday_stop){
		$query="Insert Into teachday(teachday_day,teachday_start,teachday_stop,teachday_hour,teach_ID) Values ('$teachday_day','$teachday_start','$teachday_stop','$teachday_hour','$teach_ID')";
		$insert_teachday=mysql_query($query,$conn)or die(mysql_error());
		$query="Select sum(teachday_hour) as teach_hour From teachday Where teach_ID='$teach_ID'";
		$teachhour_query=mysql_query($query,$conn)or die(mysql_error());
		$teach_hour = mysql_result($teachhour_query,0,"teach_hour");
		$query="Update teach Set teach_hour='$teach_hour' Where teach_ID='$teach_ID'";
		$update_teach=mysql_query($query,$conn)or die(mysql_error());
		$userlogs_des='บันทึกวัน เวลา ห้องที่สอน teachid '.$teach_ID;
		$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Teach Day','teachday_mis','$userlogs_des')";
		$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		echo "<script>alert('ระบุช่วงเวลาไม่ถูกต้อง');</script>";
	}
}
else if($_POST["edit_bt"]=="แก้ไข"){
	$teachday_ID = $_POST["teachday_ID"];
	$teach_ID = $_POST["teach_ID"];
	$teachday_day=$_POST["day_comb"];
	$teachday_start=$_POST["daystart_comb"];
	$teachday_stop=$_POST["daystop_comb"];
	if(substr($teachday_start,0,2)<=12&&substr($teachday_stop,0,2)>=13)
		$teachday_hour=$teachday_stop-$teachday_start-1;
	else 
		$teachday_hour=$teachday_stop-$teachday_start;
	if($teachday_start<$teachday_stop){
		$query="Update teachday Set teachday_day='$teachday_day',teachday_start='$teachday_start',teachday_stop='$teachday_stop',teachday_hour='$teachday_hour' Where teachday_ID='$teachday_ID'";
		$update_teachday=mysql_query($query,$conn)or die(mysql_error());
		$query="Select sum(teachday_hour) as teach_hour From teachday Where teach_ID='$teach_ID'";
		$teachhour_query=mysql_query($query,$conn)or die(mysql_error());
		$teach_hour = mysql_result($teachhour_query,0,"teach_hour");
		$query="Update teach Set teach_hour='$teach_hour' Where teach_ID='$teach_ID'";
		$update_teach=mysql_query($query,$conn)or die(mysql_error());
		$userlogs_des='แก้ไขวัน เวลา ห้องที่สอน teachdayid '.$teachday_ID;
		$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Teach Day','teachday_mis','$userlogs_des')";
		$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		echo "<script>alert('ระบุช่วงเวลาไม่ถูกต้อง');</script>";
	}
}
else if($_GET["delete_bt"]=="ลบ"){
	$teachday_ID = $_GET["teachday_ID"];
	$teach_ID = $_GET["teach_ID"];
	$query = "Delete From teachday Where teachday_ID='$teachday_ID'";
	$teachdaydelete_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From teachcheck Where teachday_ID='$teachday_ID'";
	$teachcheckdelete_query = mysql_query($query,$conn) or die(mysql_error());
	$query="Select sum(teachday_hour) as teach_hour From teachday Where teach_ID='$teach_ID'";
	$teachhour_query=mysql_query($query,$conn)or die(mysql_error());
	$teach_hour = mysql_result($teachhour_query,0,"teach_hour");
	$query="Update teach Set teach_hour='$teach_hour' Where teach_ID='$teach_ID'";
	$update_teach=mysql_query($query,$conn)or die(mysql_error());
	$userlogs_des='ลบวัน เวลา ห้องที่สอน teachdayid '.$teachday_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Teach Day','teachday_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["cancel_bt"]=="ยกเลิก"){
	$teach_ID = $_POST["teach_ID"];
}
else{
	$teach_ID = $_GET["teach_ID"];
}
echo "<script type='text/javascript'>var teach_ID='".$teach_ID."'</script>";
$query="Select * From teachday Where teach_ID='$teach_ID' Order By teachday_day ASC";
$teachday_query = mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addteachday').click(function(){
		$('#teachday_add').load("addteachday.php?teach_ID="+teach_ID);
	});
});
function editteachday(id, tagid, tid){
	$.get('editteachday.php',{
		'teachday_ID':id,
		'teach_ID':tid,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deleteteachday(id, txt, tid){
	var conf = confirm("คุณแน่ใจว่าจะลบ "+txt);
	if(conf==true)
		$.get('teachday.php',{
			'teachday_ID':id,
			'teach_ID':tid,
			'delete_bt':'ลบ'},function(data){$('#teachday').html(data)});
}
</script>
<?php include("../includefiles/datalist.php");?>
<div id="tday">
<span class="BlueDark">
<h3>วัน เวลา ห้องเรียน</h3></span>
<table width="90%" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
	<tr height="30">
    	<th align="center" bgcolor="#FFCC33">วัน</th>
        <th width="15%" align="center" bgcolor="#FFCC33">เริ่มเวลา</th>
      <th width="15%" align="center" bgcolor="#FFCC33">สิ้นสุดเวลา</th>
      <th width="10%" align="center" bgcolor="#FFCC33">จำนวน(ชม)</th>
        <th width="25%" align="center" bgcolor="#FFCC33">ห้องเรียน</th>
        <th width="10%" align="center" bgcolor="#FFCC33"></th>
    </tr><?php while($teachday_fetch = mysql_fetch_assoc($teachday_query)){ ?>
    <tr height="25" bgcolor="#EEEEEE"><td align="center" colspan="6">
	
    <div id="<?php echo"teachday".$teachday_fetch["teachday_ID"];?>">	
    <table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="2" cellspacing="0">
    <tr height="25" bgcolor="#EEEEEE">
    	<td align="left" valign="middle">วัน<?php echo $thday[$teachday_fetch["teachday_day"]];?></td>
        <td width="15%" align="center" valign="middle"><?php echo substr($teachday_fetch["teachday_start"],0,5);?></td>
        <td width="15%" align="center" valign="middle"><?php echo substr($teachday_fetch["teachday_stop"],0,5);?></td>
        <td width="10%" align="center" valign="middle"><?php echo $teachday_fetch["teachday_hour"];?></td>
        <td width="25%" align="left" valign="middle"></td>
        <td width="10%" align="center"><a href="#" onclick="editteachday('<?php echo $teachday_fetch["teachday_ID"];?>','<?php echo"teachday".$teachday_fetch["teachday_ID"];?>','<?php echo $teach_ID;?>');"><img src="../images/icons/16/edit.png" width="16" height="16" /></a><a href="#" onclick="deleteteachday('<?php echo $teachday_fetch["teachday_ID"];?>','<?php echo $thday[$teachday_fetch["teachday_day"]]." / ".$teachday_fetch["teachday_start"]."-".$teachday_fetch["teachday_stop"];?>','<?php echo $teach_ID;?>');"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
    </tr></table>
    </div>
   </td></tr> <?php } ?>
    <tr height="25" bgcolor="#EEEEEE">
         <td colspan="6" align="center" bgcolor="#CCCCCC"><div id="teachday_add"><a href="#" id="addteachday"><img src="../images/icons/16/add.png" width="16" height="16" />เพิ่ม</a></div></td>
    </tr>
</table>
</div>