<?php
session_start();
	require_once("../includefiles/connectdb.php");
	header("Content-type: text/html; charset=utf-8");
	if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
	$member_ID=$_GET["member_ID"];
	$query="Select * From member Where member_ID='$member_ID'";
	$member_query=mysql_query($query,$conn)or die(mysql_error());
	$member_fetch=mysql_fetch_array($member_query);
	$teacher_ID=$member_fetch["personnel_ID"];
	$query="Select * From personnel Where personnel_ID='$teacher_ID'";
	$teacher_query=mysql_query($query,$conn)or die(mysql_error());
	$teacher_fetch=mysql_fetch_array($teacher_query);
?>
	<center>
	<div style="width:100%; background-color:#FFF" >
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33"><strong>ข้อมูลผู้ใช้</strong></td>
        </tr>
      <tr>
        <td width="30%">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ชื่อผู้ใช้ : </strong>&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $member_fetch["member_name"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>สถานะผู้ใช้ :&nbsp;</strong></td>
        <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $member_fetch["member_status"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ชื่อ - สกุล :&nbsp;</strong></td>
        <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $teacher_fetch["personnel_name"]." ".$teacher_fetch["personnel_ser"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      </table>
	</div>
    </center>