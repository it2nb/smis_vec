<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["update_bt"]=="บันทึก"){
	$class_ID=$_POST["class_ID"];
	$query="Select * From student Where class_ID='$class_ID'";
	$std_query=mysql_query($query,$conn)or die(mysql_error());
	while($std_fetch=mysql_fetch_array($std_query)){
		$student_ID = $std_fetch["student_ID"];
		$query="Update student Set student_fatname='".$_POST["fatname_txt"][$student_ID]."',student_fatser='".$_POST["fatser_txt"][$student_ID]."',student_motname='".$_POST["motname_txt"][$student_ID]."',student_motser='".$_POST["motser_txt"][$student_ID]."',student_parname='".$_POST["parname_txt"][$student_ID]."',student_parser='".$_POST["parser_txt"][$student_ID]."',student_parphone='".$_POST["phone_txt"][$student_ID]."' Where student_ID='$student_ID'";
		$std_update=mysql_query($query,$conn)or die(mysql_error());
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='แก้ไขข้อมูลผู้ปกครองกลุ่มเรียน '.$class_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Stdparent','student_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	echo "<script type='text/javascript'>
			alert('แก้ไขข้อมูลเรียบร้อย');
			</script>";
}else if($_POST["cancel_bt"]=="ยกเลิก"){
	$class_ID=$_POST["class_ID"];}
else{
	$class_ID=$_GET["class_ID"];
}
$query="Select * From student Where class_ID='$class_ID' Order By student_ID ASC";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
});
function consultdata(id){
	$.get('consultdata.php',{'class_ID':id},function(data){$('#systemcontent').html(data)});
}
function editstdparent(id){
	$.get('editstdparentft.php',{'class_ID':id},function(data){$('#admincontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลผู้ปกครอง</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="128"><a href="#" onclick="consultdata('<?php echo $class_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
<center>
<div align="right"><a href="#" onclick="editstdparent('<?php echo $class_ID;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="7" bgcolor="#CCCCCC">นักเรียนนักศึกษาในกลุ่มเรียน <?php echo $class_ID;?>
                  <input type="hidden" name="class_ID" id="class_ID"  value="<?php echo $class_ID;?>"/>
( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="18%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล บิดา</td>
    <td width="18%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล มารดา</td>
    <td width="18%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล ผู้ปกครอง</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
  ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_fatname"]." ".$student_fetch["student_fatser"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_motname"]." ".$student_fetch["student_motser"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_parname"]." ".$student_fetch["student_parser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
  </tr>
  <?php } ?>
</table><br />
<div align="right"><a href="#" onclick="editstdparent('<?php echo $class_ID;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
</center></div>