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
			$validator->addValidation("studentID_txt","req","กรุณากรอกรหัสนักเรียนนักศึกษา");
			$validator->addValidation("studentname_txt","req","กรุณากรอกชื่อ");
			$validator->addValidation("studentser_txt","req","กรุณากรอกนามสกุล");
			$validator->addValidation("studentlevel_comb","req","กรุณาเลือกระดับชั้น");
			$validator->addValidation("studentarea_comb","req","กรุณาเลือกสาขาวิชา");
			$validator->addValidation("studentmajor_comb","req","กรุณาเลือกสาขางาน");
			$validator->addValidation("studentemail_txt","email","กรุณากรอกอีเมลล์ให้ถูกต้อง");
			if($validator->ValidateForm())
			{
				$student_ID = $_POST["studentID_txt"];
				
				$query="Select student_ID From student Where student_ID='$student_ID'";
				$checkstudent_query = mysql_query($query,$conn)or die(mysql_error());
				if(mysql_num_rows($checkstudent_query))
					$error_txt["studentID_txt"] = "รหัสนักศึกษานี้มีอยู่แล้ว";
				else
				{
					$student_ID = $_POST["studentID_txt"];
					$student_gender = $_POST["studentgender_comb"];
					$student_prefix = $_POST["studentprefix_comb"];
					$student_name = $_POST["studentname_txt"];
					$student_ser = $_POST["studentser_txt"];
					$student_level = $_POST["studentlevel_comb"];
					$student_area = $_POST["studentarea_comb"];
					$student_major = $_POST["studentmajor_comb"];
					$student_add = $_POST["studentadd_txt"];
					$student_phone = $_POST["studentphone_txt"];
					$student_email = $_POST["studentemail_txt"];
			
					$query="Insert Into student(student_ID,student_gender,student_prefix,student_name,student_ser,student_level,area_ID,major_ID,student_add,student_phone,student_email,student_endstatus) Values ('$student_ID','$student_gender','$student_prefix','$student_name','$student_ser','$student_level','$student_area','$student_major','$student_add','$student_phone','$student_email','0')";
					$student_insert=mysql_query($query,$conn) or die(mysql_error());
			
					echo "<script type='text/javascript'>

					$('#admincontent').hide();

					alert('บันทึกข้อมูลเรียบร้อย');

					$('#systemcontent').load('managestudent.php');

					</script>";
				}
			}
			else
				$error_txt = $validator->GetErrors(); 
		}
?>
<script type="text/javascript">

$(document).ready(function() { 

    $('#managestudent').click(function(){

		$('#systemcontent').load('managestudent.php');		

    });
	$('#studentlevel_comb').change(function() {
		if($('#studentlevel_comb').select().val()=="ปวช")
        	$.get('comboval.php',{
				table:'area',
				where:'area_level',
				whereval:'ปวช',
				value:'area_ID',
				comb_txt:'area_name'},function(data){
				$('#studentarea_comb').html(data);
				$('#studentarea_comb').change();
			});
		else if($('#studentlevel_comb').select().val()=="ปวส")
        	$.get('comboval.php',{
				table:'area',
				where:'area_level',
				whereval:'ปวส',
				value:'area_ID',
				comb_txt:'area_name'},function(data){
				$('#studentarea_comb').html(data);
				$('#studentarea_comb').change();
			});
		else
			$('#studentarea_comb').html("");
    });
	$('#studentarea_comb').change(function() {
		var area_ID = $('#studentarea_comb').select().val();
        	$.get('comboval.php',{
				table:'major',
				where:'area_ID',
				whereval:area_ID,
				value:'major_ID',
				comb_txt:'major_name'},function(data){
				$('#studentmajor_comb').html(data);
			});
    });
	$('#addstudentform').ajaxForm({ 

        target: '#systemcontent',

		beforeSubmit: function(){

			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");

		},

		success: function(){

		}

    });

});

</script>
    	<div id="statusbar">เพิ่มข้อมูลนักเรียนนักศึกษา</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a id="managestudent" href="#"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="addstudentform" action="addstudent.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลนักเรียนนักศึกษา</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสนักศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="studentID_txt" type="text" id="studentID_txt" value="<?php echo $_POST["studentID_txt"];?>" size="15" maxlength="10" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["studentID_txt"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">เพศ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <label for="g_txt"></label>
      <select name="studentgender_comb" id="studentgender_comb">
      <option value="ชาย">ชาย</option>
      <option value="หญิง">หญิง</option>
      </select>
      <?php echo $error_txt["studentgender_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">คำนำหน้าชื่อ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <select name="studentprefix_comb" id="studentprefix_comb">
      <option value="นาย">นาย</option>
      <option value="นางสาว">นางสาว</option>
      <option value="นาง">นาง</option>
      </select>
      <?php echo $error_txt["studentprefix_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentname_txt"></label>
      <input name="studentname_txt" type="text" id="studentname_txt" value="<?php echo $_POST["studentname_txt"];?>" size="30" maxlength="25" />
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["studentname_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สกุล : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentser_txt"></label>
      <input name="studentser_txt" type="text" id="studentser_txt" value="<?php echo $_POST["studentser_txt"];?>" size="30" maxlength="25" />
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["studentser_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ระดับชั้น : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentlevel_comb"></label>
      <select name="studentlevel_comb" id="studentlevel_comb" >
       <option value="">เลือกระดับชั้น</option>
      <option value="ปวช">ปวช</option>
      <option value="ปวส">ปวส</option>
      </select>
      <span class="RedRegula10"> <?php echo $error_txt["studentlevel_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สาขาวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentarea_comb"></label>
      <select name="studentarea_comb" id="studentarea_comb" >
      </select>
      <span class="RedRegula10"> <?php echo $error_txt["studentarea_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สาขางาน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentmajor_comb"></label>
      <select name="studentmajor_comb" id="studentmajor_comb">
      </select>
      <span class="RedRegula10"> <?php echo $error_txt["studentmajor_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">ที่อยู่ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentadd_txt"></label>
      <textarea name="studentadd_txt" id="studentadd_txt" cols="45" rows="5"><?php echo $_POST["studentadd_txt"];?></textarea></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">เบอร์โทรติดต่อ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentphone_txt"></label>
      <input name="studentphone_txt" type="text" id="studentphone_txt" value="<?php echo $_POST["studentphone_txt"];?>" size="30" />
      <label> </label></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">อีเมลล์ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="studentemail_txt"></label>
      <input name="studentemail_txt" type="text" id="studentemail_txt" value="<?php echo $_POST["studentemail_txt"];?>" size="30" />
      <label> </label>
      <span class="RedRegula10"><?php echo $error_txt["studentemail_txt"];?></span></td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
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
