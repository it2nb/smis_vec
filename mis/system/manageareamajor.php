<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["areasave_bt"]=="บันทึก"){
	$area_ID = $_POST["areaID_txt"];
	$area_name = $_POST["areaname_txt"];
	$area_level = $_POST["arealevel_comb"];
	$query = "Insert Into area (area_ID,area_name,area_level) Values ('$area_ID','$area_name','$area_level')";
	$area_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_POST["areaedit_bt"]=="บันทึก"){
	$area_ID = $_POST["area_ID"];
	$area_name = $_POST["areaname_txt"];
	$area_level = $_POST["arealevel_comb"];
	$query = "Update area Set area_name='$area_name',area_level='$area_level' Where area_ID='$area_ID'";
	$area_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_GET["areadelete_bt"]=="ลบ"){
	$area_ID = $_GET["area_ID"];
	$query="Select * From major Where area_ID='$area_ID'";
	$major_query=mysql_query($query,$conn)or die(mysql_error());
	while($major_fetch=mysql_fetch_assoc($major_query)){
		$major_ID = $major_fetch["major_ID"];
		$query = "Delete From departmajor Where major_ID='$major_ID'";
		$departmajor_query = mysql_query($query,$conn) or die(mysql_error());
	}
	$query = "Delete From major Where area_ID='$area_ID'";
	$major_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From area Where area_ID='$area_ID'";
	$area_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_POST["majorsave_bt"]=="บันทึก"){
	$area_ID = $_POST["area_ID"];
	$major_ID = $_POST["majorID_txt"];
	$major_name = $_POST["majorname_txt"];
	$query = "Insert Into major (major_ID,major_name,area_ID) Values ('$major_ID','$major_name','$area_ID')";
	$major_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_POST["majoredit_bt"]=="บันทึก"){
	$department_ID = $_POST["department_ID"];
	$major_ID = $_POST["major_ID"];
	$major_name = $_POST["majorname_txt"];
	$query = "Update major Set major_name='$major_name' Where major_ID='$major_ID'";
	$major_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_GET["majordelete_bt"]=="ลบ"){
	$major_ID = $_GET["major_ID"];
	$query = "Delete From departmajor Where major_ID='$major_ID'";
	$department_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From major Where major_ID='$major_ID'";
	$area_query = mysql_query($query,$conn) or die(mysql_error());
}
	
$query="Select * From area Order By area_level ASC";
$area_query=mysql_query($query,$conn) or die(mysql_error());
$query="Select count(major_ID) as majornum From major,area Where major.area_ID=area.area_ID";
$areanum = mysql_num_rows($area_query);
$majornum_query=mysql_query($query,$conn) or die(mysql_error());
$majornum_fetch=mysql_fetch_array($majornum_query); 
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#addarea').click(function(){
		$('#area_add').load("addarea.php");
	});
});
function editarea(id, tagid){
	$.get('editarea.php',{
		'area_ID':id,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deletearea(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบสาขาวิชา "+txt+"\nข้อมูลอื่นๆ ที่เกี่ยวข้องกับสาขางานนี้จะถูกลบด้วย");
	if(conf==true)
		$.get('manageareamajor.php',{
			'area_ID':id,
			'areadelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
function addmajor(id, tagid){
	$.get('addmajor.php',{
		'area_ID':id,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function editmajor(id, tagid){
	$.get('editmajor.php',{
		'major_ID':id,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deletemajor(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบสาขางาน "+txt);
	if(conf==true)
		$.get('manageareamajor.php',{
			'major_ID':id,
			'majordelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
</script>
<div id="statusbar">จัดการข้อมูลสาขาวิชา สาขางาน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
  <div id="areamajor">
  <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <th height="50" colspan="3" bgcolor="#CCCCCC">สาขาวิชาและสาขางานใน <?php echo $department_fetch["department_name"];?>
                    <input type="hidden" name="department_ID" id="department_ID"  value="<?php echo $department_ID;?>"/>
( ทั้งหมด <?php echo $areanum;?> สาขาวิชา <?php echo $majornum_fetch["majornum"];?> สาขางาน )</th>
    <tr>
      <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
      <td width="50%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขาวิชา</td>
      <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขางาน</td>
    </tr>
    <?php
	$n=0;
	while($area_fetch = mysql_fetch_array($area_query)){
		$n++;
		$area_ID=$area_fetch["area_ID"];
		$query="Select * From major Where area_ID='$area_ID'";
		$major_query=mysql_query($query,$conn)or die(mysql_error());
	?>
    <tr>
      <td height="25" align="center" valign="top"><?php echo $n;?></td>
      <td height="25" align="left" valign="top">
      <div id="<?php echo "area_tb".$n;?>">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
    	<td width="90%" align="left" valign="middle" height="25"><?php echo $area_fetch["area_ID"].":".$area_fetch["area_name"]." (".$area_fetch["area_level"].")";?></td>
    	<td width="5%" align="center" valign="middle" height="25"><a href="#" onclick="editarea('<?php echo $area_ID;?>','<?php echo "area_tb".$n;?>');"><img src="../images/icons/16/edit.png" width="16" height="16"></a></td>
    	<td align="center" valign="middle" height="25"><a href="#" onclick="deletearea('<?php echo $area_ID;?>','<?php echo $area_fetch["area_name"]." (".$area_fetch["area_level"].")";?>');"><img src="../images/icons/16/delete.png" width="16" height="16"></a></td>
  		</tr>
	</table>
      </div>
      </td>
      <td height="25" align="left" valign="top">
      <?php
	  $m=0;
	  while($major_fetch=mysql_fetch_array($major_query)){
		  $m++;
	  ?>
      <div id="<?php echo "major_tb".$n.$m;?>">
     <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom-style:dotted; border-top-style:dotted; border-width:thin; border-right-style:none; border-left-style:none" bordercolor="#666666">
  		<tr>
    	<td width="90%" align="left" valign="middle" height="25"><?php echo $major_fetch["major_ID"].":".$major_fetch["major_name"];?></td>
    	<td width="5%" align="center" valign="middle" height="25"><a href="#" onclick="editmajor('<?php echo $major_fetch["major_ID"];?>','<?php echo "major_tb".$n.$m;?>');"><img src="../images/icons/16/edit.png" width="16" height="16"></a></td>
    	<td align="center" valign="middle" height="25"><a href="#" onclick="deletemajor('<?php echo $major_fetch["major_ID"];?>','<?php echo $major_fetch["major_name"];?>');"><img src="../images/icons/16/delete.png" width="16" height="16"></a></td>
  		</tr>
	</table>
      </div>
      <?php }?>
      <div id="<?php echo "major_add".$n;?>"><table width="100%"><tr><td align="right" valign="top"><a href="#" onclick="addmajor('<?php echo $area_ID;?>','<?php echo "major_add".$n;?>');"><img src="../images/icons/16/add.png" width="16" height="16"></a></td></tr></table></div>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td height="25">&nbsp;</td>
      <td height="25" align="right" valign="middle">
      <div id="area_add"><a href="#" id="addarea"><img src="../images/icons/16/add.png" width="16" height="16"></a></div>
      </td>
      <td height="25">&nbsp;</td>
    </tr>
  </table>
  <br>
  </div>
</center></div>