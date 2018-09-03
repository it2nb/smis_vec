<?php
session_start();
	require_once("../includefiles/connectdb.php");
	if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
	$subject_ID=$_GET["subject_ID"];
	$query="Select * From subject Where subject_ID='$subject_ID'";
	$subject_query=mysql_query($query,$conn)or die(mysql_error());
	$subject_fetch=mysql_fetch_array($subject_query);
	if($subject_fetch["subject_status"]=="teach")
	{
		$teacher_ID=$subject_fetch["teacher_ID"];
		$query="Select * From teacher Where teacher_ID='$teacher_ID'";
		$teacher_query=mysql_query($query,$conn)or die(mysql_error());
		$teacher_fetch=mysql_fetch_array($teacher_query);
	}
	
?>
	<center>
	<div style="width:100%; background-color:#FFF" >
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33"><strong>ข้อมูลรายวิชา รหัส <?php echo $_GET["subject_ID"];?></strong></td>
        </tr>
      <tr>
        <td width="30%">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ชื่อวิชา: </strong>&nbsp;</td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $subject_fetch["subject_name"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>หน่วยกิต : &nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $subject_fetch["subject_unit"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ชั่วโมง : &nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $subject_fetch["subject_hour"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="top"><strong>วัตถุประสงค์รายวิชา :&nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo nl2br($subject_fetch["subject_obj"]);?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="top"><strong>มาตรฐานรายวิชา :&nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo nl2br($subject_fetch["subject_std"]);?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="top"><strong>คำอธิบายรายวิชา :&nbsp; </strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo nl2br($subject_fetch["subject_des"]);?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      </table>
	</div>
    </center>