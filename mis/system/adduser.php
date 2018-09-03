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
			$validator->addValidation("membername_txt","req","กรุณากรอกชื่อผู้ใช้");
			$validator->addValidation("memberpassword_txt","req","กรุณากรอกรหัสผ่าน");
			$validator->addValidation("memberpassword_txt","eqelmnt=cfmemberpassword_txt","กรุณากรอกรหัสผ่านให้ตรงกัน");
			$validator->addValidation("personneltypeID_comb","req","เลือกประเภทบุคลากร");
			$validator->addValidation("personnelname_txt","req","กรุณากรอกชื่อบุคลากร");
			$validator->addValidation("personnelsername_txt","req","กรุณากรอกชื่อบุคลากร");
			if($validator->ValidateForm())
			{
				$member_name = $_POST["membername_txt"];
				if($_POST["admin_chk"]==1)
					$member_status = "1";
				else
					$member_status = "0";
				if($_POST["boss_chk"]==1)
					$member_status .= "1";
				else
					$member_status .= "0";
				if($_POST["teacher_chk"]==1)
					$member_status .= "1";
				else
					$member_status .= "0";
				if($_POST["other_chk"]==1)
					$member_status .= "1";
				else
					$member_status .= "0";
				$query="Select member_ID From member Where member_name='$member_name'";
				$checkname_query = mysql_query($query,$conn)or die(mysql_error());
				if(mysql_num_rows($checkname_query))
					$error_txt["membername_txt"] = "ชื่อผู้ใช้ซ้ำ กรุณากรอกชื่อผู้ใช้ใหม่";
				else if($member_status=="0000")
					$error_txt["status_txt"] = "กรุณาเลือกอย่างน้อย 1";
				else
				{
					$member_name = $_POST["membername_txt"];
					$member_password = $_POST["memberpassword_txt"];
					$personneltype_ID = $_POST["personneltypeID_comb"];
					$personnel_gender = $_POST["personnelgender_comb"];
					$personnel_name = $_POST["personnelname_txt"];
					$personnel_sername = $_POST["personnelsername_txt"];
					$personnel_position = $_POST["personnelposition_txt"];
					$personnel_lastedu = $_POST["personnellastedu_comb"];
					$personnel_lastedumajor = $_POST["personnellastedumajor_txt"];
					$personnel_status = $_POST["personnelstatus_comb"];
					
					$query="Insert Into personnel(personnel_gender,personnel_name,personnel_ser,personnel_position,personnel_lastedu,personnel_lastedumajor,personnel_status,personneltype_ID) Values ('$personnel_gender','$personnel_name','$personnel_sername','$personnel_position','$personnel_lastedu','$personnel_lastedumajor','$personnel_status','$personneltype_ID')";
					$personnel_insert=mysql_query($query,$conn) or die(mysql_error());
					
					$query = "Select max(personnel_ID) as lastID From personnel";
					$lastID_query = mysql_query($query,$conn)or die(mysql_error());
					$lastID_fetch = mysql_fetch_array($lastID_query);
					$personnel_ID = $lastID_fetch["lastID"];
					
					$query="Insert Into member(member_name,member_password,member_status,personnel_ID) Values ('$member_name',md5('$member_password'),'$member_status','$personnel_ID')";
					$member_insert=mysql_query($query,$conn) or die(mysql_error());
					
					if(!empty($_FILES["personnelpic_file"]["name"]))
					{
						$personnel_picfile=($personnel_ID*1).".jpg";
						move_uploaded_file($_FILES["personnelpic_file"]["tmp_name"],"../../images/personnel/".$personnel_picfile);
						$query = "Update personnel Set personnel_picfile='$personnel_picfile' Where personnel_ID='$personnel_ID'";
						$personnel_update=mysql_query($query,$conn) or die(mysql_error());
					}

					echo "<script type='text/javascript'>

					$('#admincontent').hide();

					alert('บันทึกข้อมูลเรียบร้อย');

					$('#systemcontent').load('manageuser.php');

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
    $('#manageuser').click(function(){

		$('#systemcontent').load('manageuser.php');		

    });

	$('#adduserForm').ajaxForm({ 

        target: '#systemcontent',

		beforeSubmit: function(){

			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");

		},

		success: function(){

		}

    });

});

</script>
    	<div id="statusbar">เพิ่มข้อมูลผู้ใช้ระบบ</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="manageuser"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="adduserForm" method="post" enctype="multipart/form-data" action="adduser.php"><table width="80%" border="0" cellspacing="0" cellpadding="0">
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
    <input name="membername_txt" type="text" id="membername_txt" value="<?php echo $_POST["membername_txt"];?>" size="30" maxlength="50" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["membername_txt"];?> </span></td>
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
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC"><br />สถานะผู้ใช้(เลือกได้มากกว่า1) : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><input name="admin_chk" type="checkbox" id="admin_chk" value="1" />
      Admin <br />
        <input name="boss_chk" type="checkbox" id="boss_chk" value="1" />
        ผู้บริหาร
        <br />
        <input name="teacher_chk" type="checkbox" id="teacher_chk" value="1" />
        ครู<br />
        <input name="other_chk" type="checkbox" id="other_chk" value="1" />
        อื่นๆ &nbsp;<span class="RedRegula10"><?php echo $error_txt["status_txt"];?></span></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลบุคลากร</tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ภาพบุคลากร :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelpic_file"></label>
      <input type="file" name="personnelpic_file" id="personnelpic_file" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="personnelname_txt" type="text" id="personnelname_txt" value="<?php echo $_POST["personnelname_txt"];?>" size="30" maxlength="25" />
      <span class="RedRegula10"><?php echo $error_txt["personnelname_txt"];?></span></label></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC"> นามสกุล : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <input name="personnelsername_txt" type="text" id="personnelsername_txt" value="<?php echo $_POST["personnelsername_txt"];?>" size="30" maxlength="25" />
      <?php echo $error_txt["personnelsername_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC"> เพศ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <select name="personnelgender_comb" id="personnelgender_comb">
        <option value="ชาย" <?php if($_POST["personnelgender_comb"]=="ชาย") echo "selected='selected'";?>>ชาย</option>
        <option value="หญิง" <?php if($_POST["personnelgender_comb"]=="หญิง") echo "selected='selected'";?>>หญิง</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ประเภทบุคลากร : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personneltypeID_comb"></label>
      <select name="personneltypeID_comb" id="personneltypeID_comb">
      <?php
	  $query = "Select * From personneltype";
	  $personneltype_query = mysql_query($query,$conn) or die(mysql_error());
	  while($personneltype_fetch = mysql_fetch_array($personneltype_query)){
	  ?>
      <option value="<?php echo $personneltype_fetch["personneltype_ID"];?>"><?php echo $personneltype_fetch["personneltype_name"];?></option>
      <?php }?>
      </select>
       <span class="RedRegula10"><?php echo $error_txt["personneltypeID_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ตำแหน่ง : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelposition_txt"></label>
      <input type="text" name="personnelposition_txt" id="personnelposition_txt" value="<?php echo $_POST["personnelposition_txt"];?>"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ระดับการศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnellastedu_comb"></label>
      <select name="personnellastedu_comb" id="personnellastedu_comb">
      <option value="">ไม่ระบุ</option>
      <option value="ปริญญาเอก">ปริญญาเอก</option>
      <option value="ปริญญาโท">ปริญญาโท</option>
      <option value="ปริญญาตรี">ปริญญาตรี</option>
      <option value="อนุปริญญา">อนุปริญญา</option>
      <option value="ปวท.">ปวท.</option>
      <option value="ปวส.">ปวส.</option>
      <option value="ปวช.">ปวช.</option>
      <option value="ม.6">ม.6</option>
      <option value="ม.3">ม.3</option>
      <option value="ป.6">ป.6</option>
      <option value="ป.3">ป.3</option>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">วุฒิการศึกษา :&nbsp;&nbsp; </td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnellastedumajor_txt"></label>
      <input type="text" name="personnellastedumajor_txt" id="personnellastedumajor_txt" value="<?php echo $_POST["personnellastedumajor_txt"];?>"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สถานะ :&nbsp;&nbsp; </td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelstatus_txt"></label>
      <select name="personnelstatus_comb" id="personnelstatus_comb">
      <option value="work">ทำงาน</option>
      <option value="help">ช่วยราชการ</option>
      <option value="move">ย้าย</option>
      <option value="quit">ออก</option>
      </select>
	</td>
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