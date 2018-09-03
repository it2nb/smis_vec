<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$department_ID=$_GET["department_ID"];
$query="Select * From department Where department_ID='$department_ID'";
$department_query=mysql_query($query,$conn) or die(mysql_error());
$department_fetch = mysql_fetch_array($department_query);
echo "<script type='text/javascript'>var department_ID='".$department_ID."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//$('#areamajor').load('addareamajor.php?department_ID='+department_ID);
	$.get('majordepart.php',{'department_ID':department_ID},function(data){$('#areamajor').html(data);});
	//$('#perdepartment_tb').load('perdepart.php?department_ID='+department_ID);
	$.get('perdepart.php',{'department_ID':department_ID},function(data){$('#perdepartment_tb').html(data);});
	$('#managedepart').click(function(){
		$('#systemcontent').load("managedepart.php");
	});
	$('#pernodepartform').ajaxForm({ 
        target: '#persearch_tb',
		beforeSubmit: function(){
			$('#persearch_tb').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function add_perdepart(perID, department_ID)
{
	//var url="perdepart.php?personnel_ID="+perID+"&department_ID="+department_ID+"&departmentID="+department_ID+"&type=update";
	//$('#perdepartment_tb').load(url);
	$.get('perdepart.php',{
		'personnel_ID':perID,
		'department_ID':department_ID,
		'departmentID':department_ID,
		'type':'update'},function(data){$('#perdepartment_tb').html(data);});
	$('#pernodepartform').submit();
}
function delete_perdepart(perID, department_ID)
{
	//var url="perdepart.php?personnel_ID="+perID+"&department_ID="+department_ID+"&type=update";
	//$('#perdepartment_tb').load(url);
	$.get('perdepart.php',{
		'personnel_ID':perID,
		'department_ID':department_ID,
		'type':'update'},function(data){$('#perdepartment_tb').html(data);});
	$('#pernodepartform').submit();
}
function boss_selected(perID, department_ID){
	$.get('perdepart.php',{
		'personnel_ID':perID,
		'department_ID':department_ID,
		'type':'boss'},function(data){$('#perdepartment_tb').html(data);});
}
</script>
   	<div id="statusbar">ข้อมูล<?php echo $department_fetch["department_name"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="managedepart"><img src="../images/icons/64/back.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
    <div id="admincontenttop">
    <div id="areamajor"></div>
    </div>
    <hr />
    <div id="admincontentleft">
<div id="perdepartment_tb">
</div></div>
<div id="admincontentright">
<div>
<center>
<strong>ค้นหารายชื่อบุคลากรที่ยังไม่มีแผนกวิชา</strong><br />
<br />
<form id="pernodepartform" action="pernodepart.php" method="post">
  <label for="persearch_txt"></label>
  <input type="text" name="persearch_txt" id="persearch_txt" />
  <input type="hidden" name="department_ID" value="<?php echo $department_ID;?>">
  <input type="submit" name="persearch_bt" id="persearch_bt" value="ค้นหา" />
</form></center>
</div>
<br />
<div id="persearch_tb">
&nbsp;
</div></div>
</div>