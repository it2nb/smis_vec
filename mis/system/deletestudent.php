<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
		if($_POST["delete_bt"]=="ลบ")
		{	
			$student_ID = $_POST["studentID_txt"];
			$query = "Delete From student Where student_ID='$student_ID'";
			$member_delete = mysql_query($query,$conn)or die(mysql_error());
			
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('ลบข้อมูลเรียบร้อย');
					$('#systemcontent').load('managestudent.php');
					</script>";
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					$('#systemcontent').load('managestudent.php');
					</script>";
		}
		else
		{
			$student_ID=$_GET["student_ID"];
			$query = "Select * From student Where student_ID='$student_ID'";
			$student_query = mysql_query($query,$conn)or die(mysql_error());
			$student_fetch = mysql_fetch_array($student_query);
		}
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#managestudent').click(function(){
		$('#systemcontent').load('managestudent.php');		
    });
	$('#deletestudentform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">ลบข้อมูลผู้ใช้</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managestudent"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="deletestudentform" action="deletestudent.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ยืนยันการลบข้อมูลนักเรียนนักศึกษา</th>
    </tr>
  <tr>
    <td width="30%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC"><input name="studentID_txt" type="hidden" id="studentID_txt" value="<?php echo $student_ID;?>" />
      </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <img src="../../images/student/<?php echo $student_fetch["student_picfile"];?>" width="300" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">รหัสนักศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <?php echo $student_fetch["student_ID"];?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">ชื่อ-สกุล : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <?php echo $student_fetch["student_name"]." ". $student_fetch["student_ser"];?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><label>
      <input type="submit" name="delete_bt" id="delete_bt" value="ลบ" />
    </label>
      <label>
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table>
        </form>
        </center>
</div>