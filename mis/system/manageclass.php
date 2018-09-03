<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_GET["classdelete_bt"]=="ลบ"){
	$class_ID = $_GET["class_ID"];
	$query = "Delete From class Where class_ID='$class_ID'";
	$class_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Update student Set class_ID='' Where class_ID='$class_ID'";
	$student_query = mysql_query($query,$conn) or die(mysql_error());
}
//$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID Order By class_ID DESC";
$query = "Select * From class Order By class_ID DESC";
$class_query=mysql_query($query,$conn) or die(mysql_error());	
$classnum=mysql_num_rows($class_query);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#managestudent').click(function(){
		$('#systemcontent').load("managestudent.php");
	});
	$('#addclass').click(function(){
		$('#systemcontent').load("addclass.php");
	});
});

function addstdclass(id){
	$.get('addstdclass.php',{'class_ID' : id},function(data) {
		$('#systemcontent').html(data);
	});
}

function editclass(id){
	var url = "editclass.php?class_ID="+id;
	$('#systemcontent').load(url);
}

function deleteclass(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะกลุ่มเรียนรหัส "+txt);
	if(conf==true)
		$.get('manageclass.php',{
			'class_ID':id,
			'classdelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลกลุ่มเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="managestudent"><img src="../images/icons/64/back.png" width="64" height="64" /></a> <a href="#" id="addclass"><img src="../images/icons/64/add.png" name="addclass" width="64" height="64" id="addclass"></a></div>
    <div id="admincontent">
  <center>
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="9" bgcolor="#CCCCCC">ข้อมูลกลุ่มเรียน ( ทั้งหมด <?php echo $classnum;?> กลุ่มเรียน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสกลุ่มเรียน</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คำอธิบาย</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนผู้เรียน</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษาร่วม</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($class_fetch=mysql_fetch_array($class_query))
  {
	  $query = "Select count(student_ID) As stdpclass From student Where class_ID='".$class_fetch["class_ID"]."'";
	  $stdpclass_query = mysql_query($query,$conn) or die(mysql_error());
	  $stdpclass_fetch = mysql_fetch_array($stdpclass_query);
	  $query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID"]."'";
	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  $personnel_fetch = mysql_fetch_array($personnel_query);
	  $query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID2"]."'";
	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  $personnel2_fetch = mysql_fetch_array($personnel_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><a href="#" onclick="addstdclass('<?php echo $class_fetch["class_ID"]; ?>');"><?php echo $class_fetch["class_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="addstdclass('<?php echo $class_fetch["class_ID"]; ?>');"><?php echo $class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2);?></a></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editclass('<?php echo $class_fetch["class_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข"></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteclass('<?php echo $class_fetch["class_ID"];?>','<?php echo $class_fetch["class_ID"]." ".$class_fetch["class_des"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ"></a></td>
  </tr>
  <?php } ?>
</table><br />
</center></div>