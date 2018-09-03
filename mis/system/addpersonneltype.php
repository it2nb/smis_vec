<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
		if($_POST["save_bt"]=="บันทึก")
		{
			require_once("../includefiles/formvalidator.php");
			$validator = new FormValidator();
			$validator->addValidation("personneltypename_txt","req","กรุณากรอกชื่อกลุ่มผู้ใช้");
			if($validator->ValidateForm())
			{
				$personneltype_name = $_POST["personneltypename_txt"];
				
				$query="Select personneltype_ID From personneltype Where personneltype_name='$personneltype_name'";
				$checktype_query = mysql_query($query,$conn)or die(mysql_error());
				if(mysql_num_rows($checktype_query))
					$error_txt["personneltypename_txt"] = "ชื่อกลุ่มผู้ใช้นี้มีอยู่แล้ว";
				else
				{
					$personneltype_name = $_POST["personneltypename_txt"];
					$personneltype_des = $_POST["personneltypedes_txt"];
			
					$query="Insert Into personneltype(personneltype_name,personneltype_des) Values ('$personneltype_name','$personneltype_des')";
					$personneltype_insert=mysql_query($query,$conn) or die(mysql_error());
			
					echo "<script type='text/javascript'>

					$('#admincontent').hide();

					alert('บันทึกข้อมูลเรียบร้อย');

					$('#systemcontent').load('manageusertype.php');

					</script>";
				}
			}
			else
				$error_txt = $validator->GetErrors(); 
		}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#manageusertype').click(function(){

		$('#systemcontent').load('manageusertype.php');		

    });

	$('#addusertypeform').ajaxForm({ 

        target: '#systemcontent',

		beforeSubmit: function(){

			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");

		},

		success: function(){

		}

    });

});

</script>
    	<div id="statusbar">เพิ่มข้อมูลกลุ่มผู้ใช้</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="manageusertype"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="addusertypeform" action="addpersonneltype.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลกลุ่มผู้ใช้</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อกลุ่มผู้ใช้&nbsp; : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="personneltypename_txt" type="text" id="personneltypename_txt" value="<?php echo $_POST["personneltype_txt"];?>" size="30" maxlength="50" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["personneltypename_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">คำอธิบาย : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <label for="personneltypedes_txt"></label>
      <textarea name="personneltypedes_txt" id="personneltypedes_txt" cols="45" rows="5"><?php echo nl2br($_POST["personneltypedes_txt"]);?></textarea>
    </span></td>
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
      <input type="reset" name="button2" id="button2" value="ล้างข้อมูล" />
      </label></td>
    </tr>
</table>
        </form>
        </center>
</div>