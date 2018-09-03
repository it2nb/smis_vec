<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$stdsch=$_GET["stdsearch_txt"];

if(empty($stdsch))
	$query="Select * From student Where class_ID=''";
else
	$query="Select * From student Where (student_ID like '%$stdsch%' or student_name like '%$stdsch%' or student_ser like '%$stdsch%') and class_ID=''";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="6" bgcolor="#CCCCCC">ทั้งหมด <?php echo $studentnum;?> คน</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขาวิชา</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เพิ่ม</td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_area"];?></td>
    <td align="center" valign="middle"><a  href="#" onClick="add_stdclass('<?php echo $student_fetch["student_ID"];?>');"><img src="../images/icons/32/add.png" width="32" height="32" /></a></td>
  </tr>
  <?php } ?>
</table><br />
</center>