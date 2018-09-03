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
			$personnel_ID = $_POST["personnelID"];
			$query = "Select * From personnel Where personnel_ID='$personnel_ID'";
			$personnel_query = mysql_query($query,$conn)or die(mysql_error());
			$personnel_fetch = mysql_fetch_array($personnel_query);
			if(!empty($personnel_fetch["personnel_picfile"]))
				unlink("../../images/personnel/".$personnel_fetch["personnel_picfile"]);
			$query = "Delete From personnel Where personnel_ID='$personnel_ID'";
			$personnel_delete = mysql_query($query,$conn)or die(mysql_error());
			
			$member_ID = $_POST["memberID"];
			$query = "Delete From member Where member_ID='$member_ID'";
			$member_delete = mysql_query($query,$conn)or die(mysql_error());
			
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('ลบข้อมูลเรียบร้อย');
					$('#systemcontent').load('manageuser.php');
					</script>";
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					$('#systemcontent').load('manageuser.php');
					</script>";
		}
		else
		{
			$member_ID=$_GET["member_ID"];
			$query = "Select * From member,personnel Where member.personnel_ID=personnel.personnel_ID and member_ID='$member_ID'";
			$member_query = mysql_query($query,$conn)or die(mysql_error());
			$member_fetch = mysql_fetch_array($member_query);
		}
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#manageuser').click(function(){
		$('#systemcontent').load('manageuser.php');		
    });
	$('#deleteuserform').ajaxForm({ 
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
        <div id="headmenu">&nbsp;<a href="#" id="manageuser"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="deleteuserform" action="deleteuser.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ยืนยันการลบข้อมูลผู้ใช้</th>
    </tr>
  <tr>
    <td width="30%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC"><input name="memberID" type="hidden" id="memberID" value="<?php echo $member_ID;?>" />
      <input name="personnelID" type="hidden" id="personnelID" value="<?php echo $member_fetch["personnel_ID"];?>" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <img src="../../images/personnel/<?php echo $member_fetch["personnel_picfile"];?>" width="300" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อผู้ใช้&nbsp; : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $member_fetch["member_name"];?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">ชื่อ-สกุล : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <?php echo $member_fetch["personnel_name"]." ". $member_fetch["personnel_ser"];?></td>
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