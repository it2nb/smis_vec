<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["confirm_bt"]=="ยืนยัน")
{
	$subject_ID = $_POST["subjectID"];	
	$course_ID=$_POST["courseID"];	
	$query="Delete From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
	$delete_subject=mysql_query($query,$conn)or die(mysql_error());
			
	echo "<script type='text/javascript'>
		$('#admincontent').hide();
		alert('ลบข้อมูลเรียบร้อย');
		$('#systemcontent').load('managesubject.php');
		</script>";
}
else if($_POST["cancel_bt"]=="ยกเลิก")
{
	echo "<script type='text/javascript'>
		$('#admincontent').hide();
		$('#systemcontent').load('managesubject.php');
		</script>";
}
else
{
	$subject_ID=$_GET["subject_ID"];
	$course_ID=$_GET["course_ID"];
	$query="Select * From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
	$subject_query=mysql_query($query,$conn) or die(mysql_error());
	$subject_fetch=mysql_fetch_array($subject_query);
			
	$subject_ID = $subject_fetch["subject_ID"];
	$subject_name =$subject_fetch["subject_name"];
}
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#managesubject').click(function(){
		$('#systemcontent').load('managesubject.php');		
    });
	$('#deletesubjectform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">ลบข้อมูลรายวิชา</div>
	  <div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managesubject"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="deletesubjectform" action="deletesubject.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ลบข้อมูลรายวิชา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><input name="subjectID" type="hidden" id="subjectID" value="<?php echo $subject_ID;?>" /><input name="courseID" type="hidden" id="courseID" value="<?php echo $course_ID;?>" /><?php echo $subject_ID;?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <?php echo $subject_name;?></td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><label>
      <input type="submit" name="confirm_bt" id="confirm_bt" value="ยืนยัน" />
    </label>
      <label>
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table>
</form>
        </center>
</div>