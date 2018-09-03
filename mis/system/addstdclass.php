<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$class_ID = $_GET["class_ID"];
$query="Select * From class Where class_ID='$class_ID'";
$class_query=mysql_query($query,$conn) or die(mysql_error());
$class_fetch=mysql_fetch_array($class_query);

echo "<script type='text/javascript'>
		var class_ID=".$class_ID.";</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$.get('stdclass.php',{'class_ID':class_ID},function(data){$('#stdclass_tb').html(data);});
	$('#manageclass').click(function(){
		$('#systemcontent').load("manageclass.php");
	});
	$('#stdparent').click(function(){
		$.get('stdparent.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data);});
	});
	$('#stdnoclassform').ajaxForm({ 
        target: '#stdsearch_tb',
		beforeSubmit: function(){
			$('#stdsearch_tb').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function add_stdclass(stdID){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'classID':class_ID,
		'type':'update'},function(data){$('#stdclass_tb').html(data);});
	$('#stdnoclassform').submit();
}
function delete_stdclass(stdID){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'type':'update'},function(data){$('#stdclass_tb').html(data);});
	$('#stdnoclassform').submit();
}
function update_stdstatus(stdID,stdStatus){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'student_endstatus':stdStatus,
		'type':'status'},function(data){$('#stdclass_tb').html(data);});
}
</script>
   	<div id="statusbar">ข้อมูลกลุ่มเรียน <?php echo $class_fetch["class_ID"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="center" valign="middle" width="64"><a href="#" id="stdparent"><img src="../images/icons/64/stdparent.png" width="64" height="64" /></a></td>
    	<td align="left" valign="middle" width="128"><a href="#" id="manageclass"><img src="../images/icons/64/back.png" width="64" height="64"></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle">จัดการข้อมูล</td>
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
    <div id="admincontentleft">
<div id="stdclass_tb">
</div></div>
<div id="admincontentright">
<div>
<center>
<strong>ค้นหารายชื่อนักเรียนนักศึกษาที่ยังไม่มีกลุ่มเรียน</strong><br />
<br />
<form id="stdnoclassform" action="stdnoclass.php" method="post">
  <label for="stdsearch_txt"></label>
  <input type="text" name="stdsearch_txt" id="stdsearch_txt" />
  <input type="submit" name="stdsearch_bt" id="stdsearch_bt" value="ค้นหา" />
</form></center>
</div>
<br />
<div id="stdsearch_tb">
&nbsp;
</div></div>
</div>