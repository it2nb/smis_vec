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
if($_POST["addedu_bt"]=="เพิ่ม"){
	$personneledu_level = $_POST["personneledulevel_comb"];
	$personneledu_school = $_POST["personneleduschool_txt"];
	$personneledu_major = $_POST["personneledumajor_txt"];
	$personneledu_year = $_POST["personneleduyear_comb"];
	$query = "Insert Into personneledu(personneledu_level, personneledu_school, personneledu_major, personneledu_year, personnel_ID) Value ('$personneledu_level','$personneledu_school','$personneledu_major','$personneledu_year','$personnel_ID')";
	$personneledu_insert = mysql_query($query,$conn)or die(mysql_error());
	$userlogs_des='เพิ่มประวัติการศึกษา ';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Personnel Education','personneledu_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["editedu_bt"]=="แก้ไข"){
	$personneledu_ID = $_POST["personneleduID_txt"];
	$personneledu_level = $_POST["personneledulevel_comb"];
	$personneledu_school = $_POST["personneleduschool_txt"];
	$personneledu_major = $_POST["personneledumajor_txt"];
	$personneledu_year = $_POST["personneleduyear_comb"];
	$query = "Update personneledu Set personneledu_level='$personneledu_level', personneledu_school='$personneledu_school', personneledu_major='$personneledu_major', personneledu_year='$personneledu_year' Where personneledu_ID='$personneledu_ID'";
	$personneledu_update = mysql_query($query,$conn)or die(mysql_error());
	$userlogs_des='แก้ไขประวัติการศึกษา';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Personnel Education','personneledu_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_GET["peredudelete_bt"]=="ลบ"){
	$personneledu_ID = $_GET["personneledu_ID"];
	$query = "Delete From personneledu Where personneledu_ID='$personneledu_ID'";
	$personneledu_query = mysql_query($query,$conn) or die(mysql_error());
	$userlogs_des='ลบประวัติการศึกษา';
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Personnel Education','personneledu_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
$query="Select * From personneledu Where personnel_ID='$personnel_ID' Order By personneledu_year DESC";
$personneledu_query = mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addperedu').click(function(){
		$('#edu_add').load("addpersonneledu.php");
	});
});
function editperedu(id, tagid){
	$.get('editpersonneledu.php',{
		'personneledu_ID':id,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deleteperedu(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบประวัติการศึกษา "+txt);
	if(conf==true)
		$.get('personneledu.php',{
			'personneledu_ID':id,
			'peredudelete_bt':'ลบ'},function(data){$('#personneledu').html(data)});
}
</script>
<?php include("../includefiles/datalist.php");?>
<div id="peredu">
<div id="personneledu1">
<span class="BlueDark"><h3>&nbsp;&nbsp;ประวัติการศึกษา</h3></span>
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
	<tr height="30">
    	<th align="center" width="20%">ระดับ</th>
        <th align="center" width="55%">วุฒิ/สาขา/สถานศึกษา</th>
        <th align="center" width="15%">ปีที่จบ</th>
        <th align="center"></th>
    </tr><?php while($personneledu_fetch = mysql_fetch_array($personneledu_query)){ ?>
    <tr height="25" bgcolor="#EEEEEE"><td align="center" colspan="4">
	
    <div id="<?php echo"edu".$personneledu_fetch["personneledu_ID"];?>">	
    <table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="2" cellspacing="0">
    <tr height="25" bgcolor="#EEEEEE">
    	<td align="center" width="20%"><?php echo $personneledu_fetch["personneledu_level"];?></td>
        <td align="left" width="55%"><?php echo $personneledu_fetch["personneledu_major"];?><br /><?php echo $personneledu_fetch["personneledu_school"];?></td>
        <td align="center" width="15%"><?php echo ($personneledu_fetch["personneledu_year"]+543);?></td>
        <td align="center"><a href="#" onclick="editperedu('<?php echo $personneledu_fetch["personneledu_ID"];?>','<?php echo"edu".$personneledu_fetch["personneledu_ID"];?>');"><img src="../images/icons/16/edit.png" width="16" height="16" /></a><a href="#" onclick="deleteperedu('<?php echo $personneledu_fetch["personneledu_ID"];?>','<?php echo $personneledu_fetch["personneledu_level"]." ".$personneledu_fetch["personneledu_major"];?>');"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
    </tr></table>
    </div>
    </td></tr><?php } ?>
    <tr height="25" bgcolor="#EEEEEE">
         <td align="center" colspan="4"><div id="edu_add"><a href="#" id="addperedu"><img src="../images/icons/16/add.png" width="16" height="16" />เพิ่ม</a></div></td>
    </tr>
</table>
    
</div>
</div>