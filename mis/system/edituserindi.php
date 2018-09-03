<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
		if($_POST["save_bt"]=="บันทึก")
		{
			$member_ID = $_SESSION["userID"];
			$member_name = $_POST["membername_txt"];
			$member_password = $_POST["memberpassword_txt"];

			require_once("../includefiles/formvalidator.php");
			$validator = new FormValidator();
			$validator->addValidation("membername_txt","req","กรุณากรอกชื่อผู้ใช้");
			if(!empty($_POST["memberpassword_txt"]))
				$validator->addValidation("memberpassword_txt","eqelmnt=cfmemberpassword_txt","กรุณากรอกรหัสผ่านให้ตรงกัน");
			if($validator->ValidateForm())
			{
				$query="Select member_ID From member Where member_name='$member_name' and member_ID!='$member_ID'";
				$checkname_query = mysql_query($query,$conn)or die(mysql_error());
				if(mysql_num_rows($checkname_query))
					$error_txt["membername_txt"] = "ชื่อผู้ใช้ซ้ำ กรุณากรอกชื่อผู้ใช้ใหม่";
				else
				{	
					if(!empty($member_password))	
						$query="Update member Set member_name='$member_name',member_password=md5('$member_password') Where member_ID='$member_ID'";
					else
						$query="Update member Set member_name='$member_name' Where member_ID='$member_ID'";
					
					$member_update=mysql_query($query,$conn) or die(mysql_error());
					$_SESSION["user_name"]=$member_name;
					$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit User/Password','user_mis','')";
					$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
					echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('แก้ไขข้อมูลเรียบร้อย');
					</script>
					<meta http-equiv='refresh' content='0;url=index.php'>";
				}
			}
			else
				$error_txt = $validator->GetErrors(); 
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					</script>
					<meta http-equiv='refresh' content='0;url=index.php'>";
		}
		else
			$member_ID = $_SESSION["userID"];
		$query = "Select * From member,personnel Where member.personnel_ID=personnel.personnel_ID and member.member_ID='$member_ID'";
		$member_query = mysql_query($query,$conn)or die(mysql_error());
		$member_fetch = mysql_fetch_array($member_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#edituserform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">แก้ไขข้อมูลผู้ใช้ระบบ</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="edituserform" action="edituserindi.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลผู้ใช้</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อผู้ใช้ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="membername_txt" type="text" id="membername_txt" value="<?php echo $member_fetch["member_name"];?>" size="30" maxlength="50" />
    </label>
    <span class="RedRegula10">
    <input name="memberID" type="hidden" id="memberID" value="<?php echo $member_ID;?>" />
    <?php echo $error_txt["membername_txt"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสผ่าน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="memberpassword_txt" type="password" id="memberpassword_txt" size="30" />
    </label><span class="RedRegula10"><?php echo $error_txt["memberpassword_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ยืนยันรหัสผ่าน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="cfmemberpassword_txt" type="password" id="cfmemberpassword_txt" size="30" />
      </label></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
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
      <input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
    </label>
      <label>
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table>
        </form>
        </center>
</div>