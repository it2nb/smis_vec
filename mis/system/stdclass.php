<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$class_ID=$_GET["class_ID"];
$student_ID=$_GET["student_ID"];
$type=$_GET["type"];
if($type=="update"){
	$classID=$_GET["classID"];
	$query="Update student SET class_ID='$classID' Where student_ID='$student_ID'";
	$student_update=mysql_query($query,$conn) or die(mysql_error());
}else if($type=="status"){
	$student_endstatus = $_GET["student_endstatus"];
	if($student_endstatus==0)
		$query="Update student SET student_endstatus='1' Where student_ID='$student_ID'";
	else
		$query="Update student SET student_endstatus='0' Where student_ID='$student_ID'";
	$student_update=mysql_query($query,$conn) or die(mysql_error());
}
$query="Select * From student Where class_ID='$class_ID'";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="7" bgcolor="#CCCCCC">นักเรียนนักศึกษาในกลุ่มเรียน <?php echo $class_ID;?>
                  <input type="hidden" name="class_ID" id="class_ID"  value="<?php echo $class_ID;?>"/>
( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขาวิชา</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สถานะ</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
  ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_area"];?></td>
    <td align="center" valign="middle"><a href="#" onClick="update_stdstatus('<?php echo $student_fetch["student_ID"];?>','<?php echo $student_fetch["student_endstatus"];?>');">
	<?php
	if($student_fetch["student_endstatus"]==0)
    	echo "<img src='../images/icons/32/alive.png' width='32' height='32' />";
	else
		echo "<img src='../images/icons/32/dropout.png' width='32' height='32' />";
	?>
    </a></td>
    <td align="center" valign="middle"><a  href="#" onClick="delete_stdclass('<?php echo $student_fetch["student_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" /></a></td>
  </tr>
  <?php } ?>
</table><br />
</center>