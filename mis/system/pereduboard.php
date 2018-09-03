<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$position=$_GET["position"];
$personnel_ID=$_GET["personnel_ID"];
$type=$_GET["type"];
if($type=="update")
{
	$query = "Select personnel_ID From personnel Where personnel_eduboard='1'";
	$check_query = mysql_query($query,$conn)or die(mysql_error());
	if(mysql_num_rows($check_query)>0 && $position==1)	
		echo "<script languege='java-script'>alert('ตำแหน่งประธานมีอยู่แล้ว')</script>";
	else
	{
	$query="Update personnel SET personnel_eduboard='$position' Where personnel_ID='$personnel_ID'";
	$personnel_update=mysql_query($query,$conn) or die(mysql_error());
	}
}

$query="Select * From personnel Where personnel_eduboard>0 Order by personnel_eduboard, personneltype_ID";

$personnel_query=mysql_query($query,$conn) or die(mysql_error());
$personnelnum = mysql_num_rows($personnel_query);
?>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <th height="50" colspan="5" bgcolor="#CCCCCC">คณะกรรมการบริหารสถานศึกษา
                    
( ทั้งหมด <?php echo $personnelnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ตำแหน่ง</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($personnel_fetch=mysql_fetch_array($personnel_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php 
		if($personnel_fetch["personnel_eduboard"]=='1') echo "ประธาน";
		else if($personnel_fetch["personnel_eduboard"]=='2') echo "กรรมการ";
		else echo "เลขา";
	?></td>
    <td align="center" valign="middle"><a  href="#" onclick="update_pereduboard('<?php echo $personnel_fetch["personnel_ID"];?>','0');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
</center>