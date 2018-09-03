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
			require_once("../includefiles/formvalidator.php");
			$validator = new FormValidator();
			$validator->addValidation("departmentname_txt","req","กรุณากรอกชื่อแผนกวิชา");
			if($validator->ValidateForm())
			{
				$department_name = $_POST["departmentname_txt"];
				$department_des = $_POST["departmentdes_txt"];
				
				$query = "Insert Into department(department_name,department_des) Values ('$department_name','$department_des')";
				$department_insert = mysql_query($query,$conn)or die(mysql_error());
				echo "<script type='text/javascript'>

					$('#admincontent').hide();

					alert('บันทึกข้อมูลเรียบร้อย');

					$('#systemcontent').load('managedepart.php');

					</script>";
			}
			else
				$error_txt = $validator->GetErrors(); 
		}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#managedepart').click(function(){

		$('#systemcontent').load('managedepart.php');		

    });

	$('#adddepartform').ajaxForm({ 

        target: '#systemcontent',

		beforeSubmit: function(){

			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");

		},

		success: function(){

		}

    });

});

</script>
    	<div id="statusbar">เพิ่มข้อมูลแผนกวิชา</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managedepart"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="adddepartform" action="adddepart.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลแผนกวิชา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อแผนกวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="departmentname_txt" type="text" id="departmentname_txt" value="<?php echo $_POST["departmentname_txt"];?>" size="30" maxlength="50" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["departmentname_txt"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">คำอธิบาย : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="departmentdes_txt"></label>
      <textarea name="departmentdes_txt" id="departmentdes_txt" cols="45" rows="5"><?php echo $_POST["departmentdes_txt"];?></textarea>
    </td>
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