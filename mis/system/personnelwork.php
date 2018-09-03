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
if($_POST["addwork_bt"]=="เพิ่ม"){
	$personnelwokrh_position = $_POST["personnelwokrhposition_txt"];
	$personnelwokrh_school = $_POST["personnelwokrhschool_txt"];
	$personnelwokrh_standing = $_POST["personnelwokrhstanding_comb"];
	$personnelwokrh_salary = $_POST["personnelwokrhsalary_txt"];
	$personnelwokrh_date = $_POST["personnelwokrhyear_comb"]."-".$_POST["personnelwokrhmonth_comb"]."-".$_POST["personnelwokrhday_comb"];
	$query = "Insert Into personnelwokrh(personnelwokrh_position, personnelwokrh_school, personnelwokrh_standing, personnelwokrh_salary, personnelwokrh_date, personnel_ID) Value ('$personnelwokrh_position','$personnelwokrh_school','$personnelwokrh_standing','$personnelwokrh_salary','$personnelwokrh_date','$personnel_ID')";
	$personnelwork_insert = mysql_query($query,$conn)or die(mysql_error());
	$userlogs_des='บันทึกประวัติการทำงาน';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Personnel Work','personnelwork_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["editwork_bt"]=="แก้ไข"){
	$personnelwokrh_ID = $_POST["personnelwokrhID_txt"];
	$personnelwokrh_position = $_POST["personnelwokrhposition_txt"];
	$personnelwokrh_school = $_POST["personnelwokrhschool_txt"];
	$personnelwokrh_standing = $_POST["personnelwokrhstanding_comb"];
	$personnelwokrh_salary = $_POST["personnelwokrhsalary_txt"];
	$personnelwokrh_date = $_POST["personnelwokrhyear_comb"]."-".$_POST["personnelwokrhmonth_comb"]."-".$_POST["personnelwokrhday_comb"];;
	$query = "Update personnelwokrh Set personnelwokrh_position='$personnelwokrh_position', personnelwokrh_school='$personnelwokrh_school', personnelwokrh_standing='$personnelwokrh_standing', personnelwokrh_salary='$personnelwokrh_salary', personnelwokrh_date='$personnelwokrh_date' Where personnelwokrh_ID='$personnelwokrh_ID'";
	$personnelwork_update = mysql_query($query,$conn)or die(mysql_error());
	$userlogs_des='แก้ไขประวัติการทำงาน';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Personnel Work','personnelwork_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_GET["perworkdelete_bt"]=="ลบ"){
	$personnelwokrh_ID = $_GET["personnelwokrh_ID"];
	$query = "Delete From personnelwokrh Where personnelwokrh_ID='$personnelwokrh_ID'";
	$personnelwork_query = mysql_query($query,$conn) or die(mysql_error());
	$userlogs_des='ลบประวัติการทำงาน';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Personnel Work','personnelwork_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
$query="Select * From personnelwokrh Where personnel_ID='$personnel_ID' Order By personnelwokrh_date DESC";
$personnelwork_query = mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addperwork').click(function(){
		$('#work_add').load("addpersonnelwork.php");
	});
});
function editperwork(id, tagid){
	$.get('editpersonnelwork.php',{
		'personnelwokrh_ID':id,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deleteperwork(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบประวัติการทำงาน "+txt);
	if(conf==true)
		$.get('personnelwork.php',{
			'personnelwokrh_ID':id,
			'perworkdelete_bt':'ลบ'},function(data){$('#personnelwork').html(data)});
}
</script>
<?php include("../includefiles/datalist.php");?>
<div id="perwork">
<div id="personnelwork1">
<span class="BlueDark"><h3>&nbsp;&nbsp;ประวัติการทำงาน</h3></span>
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
	<tr height="30">
    	<th align="center" width="55%">ตำแหน่ง/วิทยฐานะ/สถาศึกษา</th>
        <th align="center" width="15%">เงินเดือน</th>
        <th align="center" width="20%">ตั้งแต่</th>
        <th align="center"></th>
    </tr><?php while($personnelwork_fetch = mysql_fetch_array($personnelwork_query)){ ?>
    <tr height="25" bgcolor="#EEEEEE"><td align="center" colspan="4">
	
    <div id="<?php echo"work".$personnelwork_fetch["personnelwokrh_ID"];?>">	
    <table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="2" cellspacing="0">
    <tr height="25" bgcolor="#EEEEEE">
    	<td align="left" width="55%"><?php echo $personnelwork_fetch["personnelwokrh_position"];?><br /><?php echo $personnelwork_fetch["personnelwokrh_standing"];?><br /><?php echo $personnelwork_fetch["personnelwokrh_school"];?></td>
        <td align="right" width="15%"><?php echo $personnelwork_fetch["personnelwokrh_salary"];?></td>
        <td align="center" width="20%"><?php echo (substr($personnelwork_fetch["personnelwokrh_date"],8,2)+0)." ".$thmountbf[(substr($personnelwork_fetch["personnelwokrh_date"],5,2)+0)]." ".(substr($personnelwork_fetch["personnelwokrh_date"],0,4)+543);?></td>
        <td align="center"><a href="#" onclick="editperwork('<?php echo $personnelwork_fetch["personnelwokrh_ID"];?>','<?php echo"work".$personnelwork_fetch["personnelwokrh_ID"];?>');"><img src="../images/icons/16/edit.png" width="16" height="16" /></a><a href="#" onclick="deleteperwork('<?php echo $personnelwork_fetch["personnelwokrh_ID"];?>','<?php echo $personnelwork_fetch["personnelwokrh_position"]." เงินเดือน ".$personnelwork_fetch["personnelwokrh_salary"];?>');"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
    </tr></table>
    </div>
   </td></tr> <?php } ?>
    <tr height="25" bgcolor="#EEEEEE">
         <td align="center" colspan="4"><div id="work_add"><a href="#" id="addperwork"><img src="../images/icons/16/add.png" width="16" height="16" />เพิ่ม</a></div></td>
    </tr>
</table>
</div>
</div>