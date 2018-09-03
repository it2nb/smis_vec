<?php
session_start();
include("../includefiles/connectdb.php");
include '../classes/Affective.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(empty($_GET["n"]))
	$n=0;
else
	$n = $_GET["n"];
$type=$_GET["type"];
$affective = new Affective($conn);
if($type=="status"){
	$affective_ID = $_GET["affective_ID"];
	$affective->toggleEn($affective_ID);
}
if($_GET["delete_bt"]=="ลบ"){
	$affective_ID = $_GET["affective_ID"];
	$affective->deleteData($affective_ID);
}
$affective->queryLimit(25,$n);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#addaffective').click(function(){
		$('#systemcontent').load("addaffective.php");
	});
});
function editaffective(id){
	$.get('editaffective.php',{'affective_ID':id},function(data){$('#systemcontent').html(data);});
}

function deleteaffective(id, txt){
	var conf = confirm("คุณแน่ใจที่จะลบจิตพิสัย "+txt);
	if(conf==true)
		$.get('manageaffective.php',{'affective_ID': id,'delete_bt':'ลบ'},function(data){$('#systemcontent').html(data);});
}
function update_affectivestatus(affectiveID,affectiveStatus){
	$.get('manageaffective.php',{
		'affective_ID':affectiveID,
		'affective_en':affectiveStatus,
		'type':'status'},function(data){$('#systemcontent').html(data);});
}
function changepage(npage){
	//var url = "manageusertype.php?n="+npage;
	//$('#systemcontent').load(url);
	$.get('manageaffective.php',{'n':npage},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">จัดการข้อมูลจิตพิสัย</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu"><a href="#" id="addaffective"><img src="../images/icons/64/add.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="7" bgcolor="#CCCCCC">ข้อมูลหัวข้อจิตพิสัย</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หัวข้อจิตพิสัย</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คำอธิบาย</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เปิดใช้</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($affective->fetchRow())
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><?php echo $affective->affective_name;?></td>
    <td align="left" valign="middle"><?php echo $affective->affective_detail;?></td>
    <td align="center" valign="middle"><a href="#" onClick="update_affectivestatus('<?php echo $affective->affective_ID;?>','<?php echo $affective->affective_en;?>');">
	<?php
	if($affective->affective_en==1)
    	echo "<img src='../images/icons/32/alive.png' width='32' height='32' />";
	else
		echo "<img src='../images/icons/32/dropout.png' width='32' height='32' />";
	?>
    </a></td>
    <td align="center" valign="middle"><a href="#" onclick="editaffective('<?php echo $affective->affective_ID;?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteaffective('<?php echo $affective->affective_ID;?>','<?php echo $affective->affective_name;?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$affective->queryAll();
$totalpage=ceil($affective->countRow()/25);
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