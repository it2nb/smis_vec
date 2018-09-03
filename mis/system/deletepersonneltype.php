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
			
			$personneltype_ID = $_POST["personneltypeID"];	
			
			$query="Delete From personneltype Where personneltype_ID='$personneltype_ID'";
			$delete_personneltype=mysql_query($query,$conn)or die(mysql_error());
				
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('ลบข้อมูลเรียบร้อย');
					$('#systemcontent').load('manageusertype.php');
					</script>";
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					$('#systemcontent').load('manageusertype.php');
					</script>";
		}
		else
		{
			$personneltype_ID=$_GET["personneltype_ID"];
			
			$query="Select * From personneltype Where personneltype_ID='$personneltype_ID'";
			$personneltype_query=mysql_query($query,$conn) or die(mysql_error());
			$personneltype_fetch=mysql_fetch_array($personneltype_query);
			
			$personneltype_ID = $personneltype_fetch["personneltype_ID"];
			$personneltype_name =$personneltype_fetch["personneltype_name"];
		}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
    $('#manageusertype').click(function(){
		$('#systemcontent').load('manageusertype.php');		
    });
	$('#deletepersonneltypeform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    <div id="statusbar">ลบข้อมูลกลุ่มผู้ใช้</div>
	  <div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="manageusertype"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="deletepersonneltypeform" action="deletepersonneltype.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ลบข้อมูลกลุ่มผู้ใช้</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสกลุ่มผู้ใช้ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label><input name="personneltypeID" type="hidden" id="personneltypeID" value="<?php echo $personneltype_ID;?>" /></label><?php echo $personneltype_ID;?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อกลุ่มผู้ใช้ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <?php echo $personneltype_name;?></td>
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