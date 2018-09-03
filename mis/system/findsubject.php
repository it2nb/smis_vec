<?php
session_start();
require_once '../includefiles/connectdb.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query ='Select course_des From course Where course_ID="'.$_GET['course_ID'].'"';
$course_query = mysql_query($query,$conn);
$course_fetch = mysql_fetch_assoc($course_query);
if($_GET['findvalue'])
	$query ='Select * From subject Where course_ID="'.$_GET['course_ID'].'" and (subject_name like "%'.$_GET['findvalue'].'%" or subject_ID like "%'.$_GET['findvalue'].'%") Order By subject_ID ASC';
else
	$query ='Select * From subject Where course_ID="'.$_GET['course_ID'].'" Order By subject_ID ASC';
$subject_query=mysql_query($query,$conn);
?>
<center>
<div style="width:100%; background-color:#FFF" >
	<br>
	<h3>รายวิชา<?php echo $course_fetch['course_des'];?></h3>
	ค้นหาส่วนหนึ่งของ <b>รหัสวิชา</b> หรือ <b>ชื่อวิชา</b> : 
<input type="text" id="findvalue" value="<?php echo $_GET['findvalue'];?>"/>
<input type="button" onclick="finds()" value="ค้นหา" id="find_bt">
<br><br>
<table width="80%" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
	<tr bgcolor="#FFCC33">
		<td align="center" valign="middle" height="30" width="10%"><b>ลำดับ</b></td>
		<td align="center" valign="middle" width="20%"><b>รหัสวิชา</b></td>
		<td align="center" valign="middle"><b>ชื่อวิชา</b></td>
	</tr>
	<?php 
		$n=1;
		while($subject_fetch=mysql_fetch_assoc($subject_query)){
	?>
	<tr  <?php if($n%2) echo'bgcolor="#EFEFEF"'; ?>>
		<td align="center" valign="middle" height="25"><?php echo $n++;?></td>
		<td align="center" valign="middle"><a href="#" onclick="selsubject('<?php echo $subject_fetch['subject_ID'];?>')"><?php echo $subject_fetch['subject_ID'];?></a></td>
		<td align="left" valign="middle"><a href="#" onclick="selsubject('<?php echo $subject_fetch['subject_ID'];?>')"><?php echo $subject_fetch['subject_name'];?></a></td>
	</tr>
	<?php } ?>
</table>
<br>
</div>
</center>