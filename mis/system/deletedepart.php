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
			$department_ID = $_POST["departmentID"];	
			$query="Delete From departmajor Where department_ID='$department_ID'";
			$delete_departmajor=mysql_query($query,$conn)or die(mysql_error());
			$query="Delete From department Where department_ID='$department_ID'";
			$delete_depart=mysql_query($query,$conn)or die(mysql_error());
				
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('ลบข้อมูลเรียบร้อย');
					$('#systemcontent').load('managedepart.php');
					</script>";
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					$('#systemcontent').load('managedepart.php');
					</script>";
		else
		{
			$department_ID=$_GET["department_ID"];
			
			$query="Select * From department Where department_ID='$department_ID'";
			$department_query=mysql_query($query,$conn) or die(mysql_error());
			$department_fetch=mysql_fetch_array($department_query);
			
			$department_ID = $department_fetch["department_ID"];
			$department_name = $department_fetch["department_name"];
			$department_des =$department_fetch["department_des"];
		}
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#managedepart').click(function(){
		$('#systemcontent').load('managedepart.php');		
    });
	$('#deletedepartform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">ลบข้อมูลกลุ่มเรียน</div>
	  <div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managedepart"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="deletedepartform" action="deletedepart.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ลบข้อมูลแผนกวิชา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อแผนกวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label><input name="departmentID" type="hidden" id="departmentID" value="<?php echo $department_ID;?>" /></label><?php echo $department_name;?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">คำอธิบาย : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <?php echo $department_des;?></td>
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