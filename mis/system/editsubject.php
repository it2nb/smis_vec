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
	$validator->addValidation("subjectID_txt","req","กรุณากรอกรหัสวิชา");
	$validator->addValidation("subjectname_txt","req","กรุณากรอกชื่อวิขา");
	$validator->addValidation("subjectunit_txt","req","กรุณากรอกหน่วยกิต");
	$validator->addValidation("subjecthourt_txt","req","กรุณากรอกจำนวนชั่วโมงทฤษฎี");
	$validator->addValidation("subjecthourt_txt","req","กรุณากรอกจำนวนชั่วโมงปฏิบัติ");
	if($validator->ValidateForm())
	{
		$subject_ID = $_POST["subjectID_txt"];
		$oldsubject_ID = $_POST["oldsubjectID_txt"];
		$course_ID = $_POST["course_comb"];
		$oldcourse_ID = $_POST["oldcourseID_txt"];
		$query="Select subject_ID From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
		$checksubject_query = mysql_query($query,$conn)or die(mysql_error());

		if(mysql_num_rows($checksubject_query) && $subject_ID!=$oldsubject_ID){
			$error_txt["subjectID_txt"] = "รหัสรายวิชานี้มีอยู่แล้ว";
			$subject_ID = $oldsubject_ID;
			$course_ID = $oldcourse_ID;
		}
		else
		{
			$subject_name = $_POST["subjectname_txt"];
			$subject_obj = $_POST["subjectobj_txt"];
			$subject_std = $_POST["subjectstd_txt"];
			$subject_des = $_POST["subjectdes_txt"];
			$subject_pfm = $_POST["subjectpfm_txt"];
			$subject_unit = $_POST["subjectunit_txt"];
			$subject_hourt = $_POST["subjecthourt_txt"];
			$subject_hourp = $_POST["subjecthourp_txt"];

			$query="Update subject Set subject_ID='$subject_ID', subject_name='$subject_name', subject_obj='$subject_obj', subject_std='$subject_std', subject_des='$subject_des', subject_pfm='$subject_pfm', subject_unit='$subject_unit', subject_hourt='$subject_hourt', subject_hourp='$subject_hourp', course_ID='$course_ID' Where subject_ID='$oldsubject_ID' and course_ID='$course_ID'";
			$subject_update=mysql_query($query,$conn) or die(mysql_error());
			$query="Update teach Set Subject_ID='$subject_ID' Where subject_ID='$oldsubject_ID'";
			$teach_update=mysql_query($query,$conn) or die(mysql_error());
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('บันทึกข้อมูลเรียบร้อย');
					$('#systemcontent').load('managesubject.php');
					</script>";
		}
	}
	else{
		$error_txt = $validator->GetErrors(); 
		$subject_ID = $_POST["oldsubjectID_txt"];
	}
}
else if($_POST["cancel_bt"]=="ยกเลิก")
{
	echo "<script type='text/javascript'>
		$('#admincontent').hide();
		$('#systemcontent').load('managesubject.php');
		</script>";
}
else{
	$subject_ID = $_GET["subject_ID"];
	$course_ID = $_GET["course_ID"];
}
$query = "Select * From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
$subject_query = mysql_query($query,$conn)or die(mysql_error());
$subject_fetch = mysql_fetch_array($subject_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#managesubject').click(function(){
		$('#systemcontent').load('managesubject.php');		
    });
	$('#editsubjectform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">แก้ไขข้อมูลรายวิชา</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="managesubject"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="editsubjectform" action="editsubject.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลรายวิชา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">หลักสูตร : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="course_comb" id="course_comb">
        <?php
			$query="Select * From course";
			$course_query=mysql_query($query,$conn)or die(mysql_error());
			while($course_fetch=mysql_fetch_array($course_query)){
				if($course_ID==$course_fetch["course_ID"])
					echo "<option value='".$course_fetch["course_ID"]."' selected='selected'>".$course_fetch["course_des"]."</option>";
				else
					echo "<option value='".$course_fetch["course_ID"]."'>".$course_fetch["course_des"]."</option>";
			}
		?>
        </select>
        <input type="hidden" name="oldcourseID_txt" id="oldcourseID_txt" value="<?php echo $subject_fetch["course_ID"];?>"/>
    </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <input name="subjectID_txt" type="text" id="subjectID_txt" value="<?php echo $subject_fetch["subject_ID"];?>" size="9" maxlength="50" />
    <span class="RedRegula10"><?php echo $error_txt["subjectID_txt"];?> 
    <input type="hidden" name="oldsubjectID_txt" id="oldsubjectID_txt" value="<?php echo $subject_fetch["subject_ID"];?>"/>
    </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="subjectname_txt" type="text" id="subjectname_txt" value="<?php echo $subject_fetch["subject_name"];?>" size="45" />
    </label><span class="RedRegula10"><?php echo $error_txt["subjectname_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">จุดประสงค์รายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <textarea name="subjectobj_txt" cols="45" rows="5" id="subjectobj_txt"><?php echo $subject_fetch["subject_obj"];?></textarea>
    </label>
      <span class="RedRegula10"><?php echo $error_txt["subjectobj_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">มาตรฐานรายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="subjectstd_txt"></label>
      <textarea name="subjectstd_txt" cols="45" rows="5" id="subjectstd_txt"><?php echo $subject_fetch["subject_std"];?></textarea>
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["subjectstd_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">สมรรถนะรายวิชา :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <textarea name="subjectpfm_txt" cols="45" rows="5" id="subjectpfm_txt"><?php echo $subject_fetch["subject_pfm"];?></textarea>
    </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">คำอธิบายรายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="subjectpfm_txt"></label>
      <textarea name="subjectdes_txt" cols="45" rows="5" id="subjectdes_txt"><?php echo $subject_fetch["subject_des"];?></textarea>
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["subjectdes_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">หน่วยกิต : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="subjectunit_txt"></label>
      <input name="subjectunit_txt" type="text" id="subjectunit_txt" value="<?php echo $subject_fetch["subject_unit"];?>" size="5" maxlength="1" />
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["subjectunit_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชั่วโมง ทฤษฎี :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <input name="subjecthourt_txt" type="text" id="subjecthourt_txt" value="<?php echo $subject_fetch["subject_hourt"];?>" size="5" maxlength="2" />
      <span class="RedRegula10"><?php echo $error_txt["subjecthourt_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชั่วโมง ปฏิบัติ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <input name="subjecthourp_txt" type="text" id="subjecthourp_txt" value="<?php echo $subject_fetch["subject_hourp"];?>" size="5" maxlength="2" />
      <span class="RedRegula10"><?php echo $error_txt["subjecthourp_txt"];?></span></td>
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
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table></form>
        </center>
</div>