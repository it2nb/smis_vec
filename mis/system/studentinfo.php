<?php
session_start();
	require_once("../includefiles/connectdb.php");
	if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
	$student_ID=$_GET["student_ID"];
	$query="Select * From student Where student_ID='$student_ID'";
	$student_query=mysql_query($query,$conn)or die(mysql_error());
	$student_fetch=mysql_fetch_array($student_query);
	if($student_fetch["student_status"]=="teach")
	{
		$teacher_ID=$student_fetch["teacher_ID"];
		$query="Select * From teacher Where teacher_ID='$teacher_ID'";
		$teacher_query=mysql_query($query,$conn)or die(mysql_error());
		$teacher_fetch=mysql_fetch_array($teacher_query);
	}
	
?>
	<center>
	<div style="width:100%; background-color:#FFF" >
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33"><strong>ข้อมูลนักเรียนนักศึกษา รหัส <?php echo $_GET["student_ID"];?></strong></td>
        </tr>
      <tr>
        <td width="30%">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ชื่อ - สกุล: </strong>&nbsp;</td>
        <td bgcolor="#FFFFFF"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ระดับชั้น :&nbsp;</strong></td>
        <td bgcolor="#FFFFFF"><?php echo $student_fetch["student_level"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>สาขาวิชา :&nbsp;</strong></td>
        <td bgcolor="#FFFFFF"><?php echo $student_fetch["student_area"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>สาขางาน :&nbsp; </strong></td>
        <td bgcolor="#FFFFFF"><?php echo $student_fetch["student_major"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      </table>
	</div>
    </center>