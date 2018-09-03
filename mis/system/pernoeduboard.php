<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$persch=$_POST["persearch_txt"];

if(empty($persch))
	$query="Select * From personnel Where personnel_eduboard<1";
else
	$query="Select * From personnel Where (personnel_ID like '%$persch%' or personnel_name like '%$persch%' or personnel_ser like '%$persch%') and personnel_eduboard<1";

$personnel_query=mysql_query($query,$conn) or die(mysql_error());
$personnelnum = mysql_num_rows($personnel_query);
?>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="7" bgcolor="#CCCCCC">ทั้งหมด <?php echo $personnelnum;?> คน</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ตำแหน่ง</td>
    <td height="30" colspan="3" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">เพิ่ม</td>
    </tr>
  <?php
  while($personnel_fetch=mysql_fetch_array($personnel_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_position"];?></td>
    <td align="center" valign="middle"><a  href="#" onclick="update_pereduboard('<?php echo $personnel_fetch["personnel_ID"];?>','1');">&lt;&lt;ประธาน
    </a></td>
    <td align="center" valign="middle"><a  href="#" onclick="update_pereduboard('<?php echo $personnel_fetch["personnel_ID"];?>','2');">&lt;&lt;กรรมการ
    </a></td>
    <td align="center" valign="middle"><a  href="#" onclick="update_pereduboard('<?php echo $personnel_fetch["personnel_ID"];?>','3');">&lt;&lt;เลขา
    </a></td>
  </tr>
  <?php } ?>
</table><br />
</center>