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
	$validator->addValidation("coursedes_txt","req","กรุณากรอกรายละเอียด");
	$validator->addValidation("courseyear_txt","req","กรุณากรอกปี");
	if($validator->ValidateForm())
	{
		$course_level = $_POST["courselevel_comb"];
		$course_des = $_POST["coursedes_txt"];
		$course_year = $_POST["courseyear_txt"];
		$query = "Insert into course(course_level,course_des,course_year) values ('$course_level','$course_des','$course_year')";
		$course_insert=mysql_query($query,$conn) or die(mysql_error());
		
		echo "<script type='text/javascript'>
				$('#admincontent').hide();
				alert('บันทึกข้อมูลเรียบร้อย');
				$('#systemcontent').load('managecourse.php');
				</script>";
	}
	else
		$error_txt = $validator->GetErrors(); 
}
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#managecourse').click(function(){
		$('#systemcontent').load('managecourse.php');		
    });
	$('#addcourseform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">เพิ่มข้อมูลรายวิชา</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managecourse"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="addcourseform" action="addcourse.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลรายวิชา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ระดับ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="courselevel_comb" id="courselevel_comb">
        <option value="ปวช">ปวช</option>
        <option value="ปวส">ปวส</option>
        </select>
      </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รายละเอียดชื่อหลักสูตร : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="coursedes_txt" type="text" id="coursedes_txt" value="<?php echo $_POST["coursedes_txt"];?>" size="60" />
      </label><span class="RedRegula10"><?php echo $error_txt["coursedes_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ปี : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="courseyear_txt"></label>
      <input name="courseyear_txt" type="text" id="courseyear_txt" value="<?php echo $_POST["courseyear_txt"];?>" size="5" maxlength="4" />
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["courseyear_txt"];?></span></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
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
</table></form>
        </center>
</div>