<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(empty($_GET["n"]))
	$n=0;
else
	$n = $_GET["n"];
$query="Select count(department_ID) as totaldepartment From department";
$departmentnum_query=mysql_query($query,$conn) or die(mysql_error());
$departmentnum_fetch=mysql_fetch_array($departmentnum_query);
$departmentnum = $departmentnum_fetch["totaldepartment"];
			
$query="Select * From department Order by department_ID Limit $n,25";
$department_query=mysql_query($query,$conn) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#adddepart').click(function(){
		$('#systemcontent').load("adddepart.php");
	});
});

function addperdepart(id){
	//var url = "addperdepart.php?addperdepart="+id;
	//$('#systemcontent').load(url);
	$.get('addperdepart.php',{'department_ID':id},function(data){$('#systemcontent').html(data)});
}

function editdepart(id){
	//var url = "editdepart.php?department_ID="+id;
	//$('#systemcontent').load(url);
	$.get('editdepart.php',{'department_ID':id},function(data){$('#systemcontent').html(data)});
}

function deletedepart(id){
	//var url = "deletedepart.php?department_ID="+id;
	//$('#systemcontent').load(url);
	$.get('deletedepart.php',{'department_ID':id},function(data){$('#systemcontent').html(data)});
}
function changepage(npage){
	//var url = "managedepart.php?n="+npage;
	//$('#systemcontent').load(url);
	$.get('managedepart.php',{'n':npage},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลแผนกวิชา5</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="adddepart"><img src="../images/icons/64/add.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="6" bgcolor="#CCCCCC">ข้อมูลแผนกวิขา ( ทั้งหมด <?php echo $departmentnum;?> แผนกวิชา )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">&nbsp;</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ชื่อแผนกวิชา</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">จำนวนบุคลากร</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" department="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($department_fetch=mysql_fetch_array($department_query))
  {
	  $query = "Select count(personnel_ID) As perpdepartment From personnel Where department_ID='".$department_fetch["department_ID"]."'";
	  $perpdepartment_query = mysql_query($query,$conn) or die(mysql_error());
	  $perpdepartment_fetch = mysql_fetch_array($perpdepartment_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><a href="#" onclick="addperdepart('<?php echo $department_fetch["department_ID"];?>');"><?php echo $department_fetch["department_name"];?></a></td>
    <td align="center" valign="middle"><?php echo $perpdepartment_fetch["perpdepartment"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editdepart('<?php echo $department_fetch["department_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deletedepart('<?php echo $department_fetch["department_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($departmentnum/25);
if($totalpage>1)
{
	for($i=1;$i<=$totalpage;$i++)
	{
		echo "หน้า ";
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>";
	}
} 
?>
</center></div>