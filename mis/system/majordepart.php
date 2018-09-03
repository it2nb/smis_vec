<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$department_ID = $_GET["department_ID"];
if($_POST["departmajorsave_bt"]=="บันทึก"){
	$department_ID = $_POST["department_ID"];
	$major_ID = $_POST["major_comb"];
	$query = "Insert Into departmajor Values ('$department_ID','$major_ID')";
	$departmajor_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_POST["departmajoredit_bt"]=="บันทึก"){
	$department_ID = $_POST["department_ID"];
	$major_ID = $_POST["major_comb"];
	$oldmajor_ID = $_POST["oldmajor_ID"];
	$query = "Update departmajor Set major_ID='$major_ID' Where department_ID='$department_ID' and major_ID='$oldmajor_ID'";
	$departmajor_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_GET["departmajordelete_bt"]=="ลบ"){
	$major_ID = $_GET["major_ID"];
	$department_ID = $_GET["department_ID"];
	$query = "Delete From departmajor Where department_ID='$department_ID' and major_ID='$major_ID'";
	$departmajor_query = mysql_query($query,$conn) or die(mysql_error());
}
else if($_POST["departmajorcancel_bt"]=="ยกเลิก")
	$department_ID = $_POST["department_ID"];
else
	$department_ID = $_GET["department_ID"];
$query="Select * From departmajor,major,area Where departmajor.major_ID=major.major_ID and major.area_ID=area.area_ID and departmajor.department_ID='$department_ID' Order By area_level ASC";
$departmajor_query=mysql_query($query,$conn) or die(mysql_error());
$majornum = mysql_num_rows($departmajor_query);
$query="Select count(distinct area.area_ID) as areanum From departmajor,major,area Where departmajor.major_ID=major.major_ID and major.area_ID=area.area_ID and departmajor.department_ID='$department_ID'";
$areanum_query=mysql_query($query,$conn) or die(mysql_error());
$areanum_fetch=mysql_fetch_array($areanum_query); 
echo "<script type='text/javascript'>
		var department_ID=".$department_ID.";</script>";
?>
<script type="text/javascript">

$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#adddm').click(function(){
		$.get('adddepartmajor.php',{'department_ID':department_ID},function(data){$('#adddepartmajor').html(data)});
	});
});
function editdepartmajor(id, tagid){
	$.get('editdepartmajor.php',{
		'major_ID':id,
		'department_ID':department_ID,
		'tagid':tagid},function(data){$('#'+tagid).html(data)});
}
function deletedepartmajor(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบ "+txt);
	if(conf==true)
		$.get('majordepart.php',{
			'major_ID':id,
			'department_ID':department_ID,
			'departmajordelete_bt':'ลบ'},function(data){$('#areamajor').html(data)});
}
</script>
<center>
  <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <th height="50" colspan="5" bgcolor="#CCCCCC">สาขาวิชาและสาขางานใน <?php echo $department_fetch["department_name"];?>
                    <input type="hidden" name="department_ID" id="department_ID"  value="<?php echo $department_ID;?>"/>
( ทั้งหมด <?php echo $areanum_fetch["areanum"];?> สาขาวิชา <?php echo $majornum;?> สาขางาน )</th>
    <tr>
      <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
      <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ระดับ</td>
      <td width="40%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขาวิชา</td>
      <td width="40%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขางาน</td>
      <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    </tr>
    <?php
	$n=0;
	while($departmajor_fetch = mysql_fetch_array($departmajor_query)){
		$n++;
	?>
    <tr>
      <td colspan="5" align="center" valign="top"><div id="<?php echo "departmajor".$n;?>">
	  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
    <tr>
      <td width="5%" height="25" align="center" valign="middle"><?php echo $n;?></td>
      <td width="10%" align="left" valign="middle"><?php echo $departmajor_fetch["area_level"];?></td>
      <td width="40%" height="25" align="left" valign="middle"><?php echo $departmajor_fetch["area_name"];?></td>
      <td width="40%" height="25" align="left" valign="middle"><?php echo $departmajor_fetch["major_name"];?></td>
      <td align="center" valign="middle"><a href="#" onclick="editdepartmajor('<?php echo $departmajor_fetch["major_ID"];?>','<?php echo "departmajor".$n;?>');"><img src="../images/icons/16/edit.png" width="16" height="16" /></a><a href="#" onclick="deletedepartmajor('<?php echo $departmajor_fetch["major_ID"];?>','<?php echo "สาขาวิชา ".$departmajor_fetch["area_name"]." สาขางาน ".$departmajor_fetch["major_name"];?>');"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
    </tr>
    </table></div>
  </td>
    </tr>
    <?php } ?>
    <tr>
      <td height="25" colspan="5">
      <div align="center" id="adddepartmajor">
      <a href="#" id="adddm"><img src="../images/icons/16/add.png" width="16" height="16" /></a>
      </div></td>
    </tr>
  </table>
  </center>
  <br>