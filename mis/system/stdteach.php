<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$type=$_GET["type"];
if($_POST["add_bt"]=="เพิ่ม"){
	$teach_ID=$_POST["teachID_txt"];
	$student_IDs=$_POST["studentID_ch"];
	for($i=0;$i<count($student_IDs);$i++){
		$student_ID=$student_IDs[$i];
		$query="Select student_ID From teachstd Where teach_ID='$teach_ID' and student_ID='$student_ID'";
		$check_query=mysql_query($query,$conn)or die(mysql_error());
		if(mysql_num_rows($check_query)<1){
			$query="Select class_ID From student Where student_ID='$student_ID'";
			$student_query=mysql_query($query,$conn)or die(mysql_error());
			$student_fetch=mysql_fetch_assoc($student_query);
			$class_ID=$student_fetch["class_ID"];
			$query="Insert Into teachstd(teach_ID,student_ID,class_ID) Values ('$teach_ID','$student_ID','$class_ID')";
			$insert_teachstd=mysql_query($query,$conn)or die(mysql_error());
		}
	}
}else if($_POST["delete_bt"]=="ลบ"){
	$teach_ID=$_POST["teachID_txt"];
	$student_IDs=$_POST["studentID_ch2"];
	for($i=0;$i<count($student_IDs);$i++){
		$student_ID=$student_IDs[$i];
		$query="Delete From teachstd Where student_ID='$student_ID' and teach_ID='$teach_ID'";
		$teachstd_delete=mysql_query($query,$conn)or die(mysql_error());
	}
	
}
$query="Select * From teachstd,student,major Where teachstd.student_ID=student.student_ID and student.major_ID=major.major_ID and teachstd.teach_ID='$teach_ID'";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#all_ch2').change(function(){
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.prop('checked',this.checked);
	});
	$('#deletestdteachform').ajaxForm({ 
        target: '#teachstd_tb',
		beforeSubmit: function(){
			$('#teachstd_tb').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
<center>
<form id="deletestdteachform" action="stdteach.php" method="post">
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="6" bgcolor="#CCCCCC">นักเรียนนักศึกษาในกลุ่มเรียน <?php echo $class_ID;?>
                  <input type="hidden" name="class_ID" id="class_ID"  value="<?php echo $class_ID;?>"/>
( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="25%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขางาน</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ<br />
      <input type="checkbox" name="all_ch2" id="all_ch2" /></td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
  ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["major_name"];?></td>
    <td align="center" valign="middle"><input type="checkbox" name="studentID_ch2[]" id="studentID_ch2[]" value="<?php echo $student_fetch["student_ID"];?>" />
      </td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="6" align="center" valign="middle"><input type="submit" name="delete_bt" id="delete_bt" value="ลบ" />
      <input name="teachID_txt" type="hidden" id="teachID_txt" value="<?php echo $teach_ID;?>" /></td>
    </tr>
</table>
</form><br />
</center>