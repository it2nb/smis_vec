<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$department_ID=$_GET["department_ID"];
$personnel_ID=$_GET["personnel_ID"];
$type=$_GET["type"];
if($type=="update"){
	$departmentID=$_GET["departmentID"];
	$query="Update personnel SET department_ID='$departmentID' Where personnel_ID='$personnel_ID'";
	$personnel_update=mysql_query($query,$conn) or die(mysql_error());
}
else if($type=="boss"){
	$query='Update department Set personnel_ID="'.$personnel_ID.'" Where department_ID="'.$department_ID.'"';
	$depart_update=mysql_query($query,$conn);
}
$query="Select * From department Where department_ID='$department_ID'";
$department_query=mysql_query($query,$conn) or die(mysql_error());
$department_fetch = mysql_fetch_array($department_query);
$query="Select * From personnel Where department_ID='$department_ID'";

$personnel_query=mysql_query($query,$conn) or die(mysql_error());
$personnelnum = mysql_num_rows($personnel_query);
?>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="6" bgcolor="#CCCCCC">บุคลากรใน <?php echo $department_fetch["department_name"];?>
                    <input type="hidden" name="department_ID" id="department_ID"  value="<?php echo $department_ID;?>"/>
( ทั้งหมด <?php echo $personnelnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ตำแหน่ง</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หัวหน้าแผนก</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
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
    <td align="center" valign="middle">
	<?php
	if($department_fetch['personnel_ID']==$personnel_fetch['personnel_ID'])
	echo '<img src="../images/icons/32/alive.png" width="32" height="32" />';
	else
	echo '<a  href="#" onClick="boss_selected(\''.$personnel_fetch['personnel_ID'].'\',\''.$department_ID.'\')"><img src="../images/icons/32/dropout.png" width="32" height="32" /></a>'; 
	?>
    </td>
    <td align="center" valign="middle"><a  href="#" onClick="delete_perdepart('<?php echo $personnel_fetch["personnel_ID"];?>','<?php echo $department_ID;?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
</center>