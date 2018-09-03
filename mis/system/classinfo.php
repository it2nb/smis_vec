<?php
session_start();
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
	require_once("../includefiles/connectdb.php");
	$class_ID=$_GET["class_ID"];
	$query="Select * From class,major,area Where class.major_ID=major.major_ID and major.area_ID=area.area_ID and class_ID='$class_ID'";
	$class_query=mysql_query($query,$conn)or die(mysql_error());
	$class_fetch=mysql_fetch_array($class_query);
?>
	<center>
	<div style="width:100%; background-color:#FFF" >
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33"><strong>ข้อมูลกลุ่มเรียน รหัส <?php echo $_GET["class_ID"];?></strong></td>
        </tr>
      <tr>
        <td width="30%">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>รหัสกลุ่มเรียน: </strong>&nbsp;</td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $class_fetch["class_ID"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>ระดับ : &nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $class_fetch["area_level"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle"><strong>สาขาวิชา : &nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $class_fetch["area_name"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="top"><strong>สาขางาน :&nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $class_fetch["major_name"];?></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="top"><strong>คำอธิบาย :&nbsp;</strong></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo $class_fetch["class_des"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      </table>
	</div>
    </center>