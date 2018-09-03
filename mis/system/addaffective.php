<?php
session_start();
include("../includefiles/connectdb.php");
include '../classes/Affective.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["save_bt"]=="บันทึก")
{
	require_once("../includefiles/formvalidator.php");
	$validator = new FormValidator();
	$validator->addValidation("affective_name","req","กรุณากรอกข้อมูลชื่อจิตพิสัย");
	if($validator->ValidateForm())
	{
		$affective_name = $_POST["affective_name"];
		$affective_detail = $_POST["affective_detail"];
		$affective = new Affective($conn);	
		$affective->insertData($affective_name,$affective_detail,1);
			
		echo "<script type='text/javascript'>
			$('#admincontent').hide();
			alert('บันทึกข้อมูลเรียบร้อย');
			$('#systemcontent').load('manageaffective.php');
			</script>";
	}
	else
		$error_txt = $validator->GetErrors(); 
}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#manageaffective').click(function(){

		$('#systemcontent').load('manageaffective.php');		

    });

	$('#addaffectiveform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
    	<div id="statusbar">เพิ่มข้อมูลจิตพิสัย</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="manageaffective"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="addaffectiveform" action="addaffective.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลจิตพิสัย</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อหัวข้อจิตพิสัย&nbsp;: &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="affective_name" type="text" id="affective_name" value="<?php echo $_POST["affective_name"];?>" size="30" maxlength="50" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["affective_name"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">คำอธิบาย : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <label for="affective_detail"></label>
      <textarea name="affective_detail" id="affective_detail" cols="45" rows="5"><?php echo nl2br($_POST["affective_detail"]);?></textarea>
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