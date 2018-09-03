<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(empty($_GET["n"]))
	$n=0;
else
	$n = $_GET["n"];
if($_GET["delete_bt"]=="ลบ"){
	$course_ID = $_GET["course_ID"];
	$query = "Delete From course Where course_ID='$course_ID'";
	$delete_course = mysql_query($query,$conn)or die(mysql_error());
}
$query="Select * From course Order by course_year DESC Limit $n,25";
$course_query=mysql_query($query,$conn) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#managesubject').click(function(){
		$('#systemcontent').load("managesubject.php");
	});
	$('#addcourse').click(function(){
		$('#systemcontent').load("addcourse.php");
	});
});
function editcourse(id){
	$.get('editcourse.php',{'course_ID': id},function(data){$('#systemcontent').html(data);});
}
function deletecourse(id, txt){
	var conf = confirm("คุณแน่ใจที่จะลบหลักสูตร "+txt);
	if(conf==true)
		$.get('managecourse.php',{'course_ID': id,'delete_bt':'ลบ'},function(data){$('#systemcontent').html(data);});
}
function changepage(npage){
	$.get('managecourse.php',{
		'n':npage,},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">จัดการข้อมูลหลักสูตร</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="managesubject"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="#" id="addcourse"><img src="../images/icons/64/add.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <th height="50" colspan="7" bgcolor="#CCCCCC">ข้อมูลหลักสูตร</th>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ระดับ</td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อหลักสูตร</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ปี</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($course_fetch=mysql_fetch_array($course_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $course_fetch["course_level"];?></td>
    <td align="left" valign="middle"><?php echo $course_fetch["course_des"];?></td>
    <td align="center" valign="middle"><?php echo $course_fetch["course_year"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editcourse('<?php echo $course_fetch["course_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deletecourse('<?php echo $course_fetch["course_ID"];?>','<?php echo $course_fetch["course_des"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($newsnum/25);
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