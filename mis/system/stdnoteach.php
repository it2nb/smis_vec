<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$stdsch=$_POST["stdsearch_txt"];
$class_ID=$_POST["classID_comb"];
$teach_ID=$_POST["teachID_txt"];

if(empty($stdsch)&&$class_ID==0)
	$query="Select * From student,major Where student.major_ID=major.major_ID Order By student_ID ASC";
else if(empty($stdsch))
	$query="Select * From student,major Where student.major_ID=major.major_ID and class_ID='$class_ID' Order By student_ID ASC";
else if($class_ID==0)
	$query="Select * From student,major Where student.major_ID=major.major_ID and (student_ID like '%$stdsch%' or student_name like '%$stdsch%' or student_ser like '%$stdsch%') Order By student_ID ASC";
else
	$query="Select * From student,major Where student.major_ID=major.major_ID and (student_ID like '%$stdsch%' or student_name like '%$stdsch%' or student_ser like '%$stdsch%') and class_ID='$class_ID' Order By student_ID ASC";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#all_ch').change(function(){
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.prop('checked',this.checked);
	});
	$('#addstdteachform').ajaxForm({ 
        target: '#teachstd_tb',
		beforeSubmit: function(){
			$('#teachstd_tb').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#stdsearchcancel').click(function(){
		$('#stdsearch_tb').html("");
	});
});
</script>
<center>
<a href="#" id="stdsearchcancel">ยกเลิกการแสดงผลรายชื่อนักเรียนนักศึกษา<?php echo $class_ID;?></a>
	<form id="addstdteachform" action="stdteach.php" method="post">
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="6" bgcolor="#CCCCCC">ทั้งหมด <?php echo $studentnum;?> คน</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขางาน</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เพิ่ม
      <br />      <input type="checkbox" name="all_ch" id="all_ch" /></td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["major_name"];?></td>
    <td align="center" valign="middle"><input name="studentID_ch[]" type="checkbox" id="studentID_ch[]" value="<?php echo $student_fetch["student_ID"]; ?>" />
      <label for="studentID_ch[]"></label></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="6" align="center" valign="middle"><input type="submit" name="add_bt" id="add_bt" value="เพิ่ม" />
      <input name="teachID_txt" type="hidden" id="teachID_txt" value="<?php echo $teach_ID;?>" /></td>
    </tr>
</table></form><br />
</center>