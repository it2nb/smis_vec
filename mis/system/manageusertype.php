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
			$query="Select count(personneltype_ID) as totaltype From personneltype";
			$typenum_query=mysql_query($query,$conn) or die(mysql_error());
			$typenum_fetch=mysql_fetch_array($typenum_query);
			$typenum = $typenum_fetch["totaltype"];
			
			$query="Select * From personneltype Order by personneltype_ID Limit $n,25";
			$personneltype_query=mysql_query($query,$conn) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#manageuser').click(function(){
		$('#systemcontent').load("manageuser.php");
	});
	$('#addpersonneltype').click(function(){
		$('#systemcontent').load("addpersonneltype.php");
	});
});
function editusertype(id){
	//var url = "editpersonneltype.php?personneltype_ID="+id;
	//$('#systemcontent').load(url);
	$.get('editpersonneltype.php',{'personneltype_ID':id},function(data){$('#systemcontent').html(data);});
}

function deleteusertype(id){
	//var url = "deletepersonneltype.php?personneltype_ID="+id;
	//$('#systemcontent').load(url);
	$.get('deletepersonneltype.php',{'personneltype_ID':id},function(data){$('#systemcontent').html(data);});
}
function changepage(npage){
	//var url = "manageusertype.php?n="+npage;
	//$('#systemcontent').load(url);
	$.get('manageusertype.php',{'n':npage},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">จัดการข้อมูลกลุ่มผู้ใช้&nbsp;</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="manageuser"><img src="../images/icons/64/back.png" width="64" height="64" /></a> <a href="#" id="addpersonneltype"><img src="../images/icons/64/add.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="6" bgcolor="#CCCCCC">ข้อมูลกลุ่มผู้ใช้ ( ทั้งหมด <?php echo $typenum;?> ชื่อกลุ่มผู้ใช้ )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อกลุ่มผู้ใช้</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คำอธิบาย</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($personneltype_fetch=mysql_fetch_array($personneltype_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><?php echo $personneltype_fetch["personneltype_name"];?></td>
    <td align="left" valign="middle"><?php echo $personneltype_fetch["personneltype_des"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editusertype('<?php echo $personneltype_fetch["personneltype_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteusertype('<?php echo $personneltype_fetch["personneltype_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($typenum/25);
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