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
			$member_ID = $_POST["memberID"];
			$member_name = $_POST["membername_txt"];
			$member_password = $_POST["memberpassword_txt"];
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
			$personnel_ID = $_POST["personnelID"];
			$personneltype_ID = $_POST["personneltypeID_comb"];
			$personnel_gender = $_POST["personnelgender_comb"];
			$personnel_name = $_POST["personnelname_txt"];
			$personnel_sername = $_POST["personnelsername_txt"];
			$personnel_position = $_POST["personnelposition_txt"];
			$personnel_lastedu = $_POST["personnellastedu_comb"];
			$personnel_lastedumajor = $_POST["personnellastedumajor_txt"];
			$personnel_status = $_POST["personnelstatus_comb"];
					
			require_once("../includefiles/formvalidator.php");
			$validator = new FormValidator();
			$validator->addValidation("membername_txt","req","กรุณากรอกชื่อผู้ใช้");
			if(!empty($_POST["memberpassword_txt"]))
				$validator->addValidation("memberpassword_txt","eqelmnt=cfmemberpassword_txt","กรุณากรอกรหัสผ่านให้ตรงกัน");
			$validator->addValidation("personneltypeID_comb","req","เลือกประเภทบุคลากร");
			$validator->addValidation("personnelname_txt","req","กรุณากรอกชื่อบุคลากร");
			$validator->addValidation("personnelsername_txt","req","กรุณากรอกชื่อบุคลากร");
			if($validator->ValidateForm())
			{
				$query="Select member_ID From member Where member_name='$member_name' and member_ID!='$member_ID'";
				$checkname_query = mysql_query($query,$conn)or die(mysql_error());
				if(mysql_num_rows($checkname_query))
					$error_txt["membername_txt"] = "ชื่อผู้ใช้ซ้ำ กรุณากรอกชื่อผู้ใช้ใหม่";
				else if($member_status=="0000")
					$error_txt["status_txt"] = "กรุณาเลือกอย่างน้อย 1";
				else
				{
					$query="Update personnel Set personnel_name='$personnel_name',personnel_ser='$personnel_sername',personnel_gender='$personnel_gender',personnel_position='$personnel_position',personnel_lastedu='$personnel_lastedu',personnel_lastedumajor='$personnel_lastedumajor',personnel_status='$personnel_status',personneltype_ID='$personneltype_ID' Where personnel_ID='$personnel_ID'";
					$personnel_update=mysql_query($query,$conn) or die(mysql_error());
						
					if(!empty($member_password))	
						$query="Update member Set member_name='$member_name',member_password=md5('$member_password'),member_status='$member_status' Where member_ID='$member_ID'";
					else
						$query="Update member Set member_name='$member_name',member_status='$member_status' Where member_ID='$member_ID'";
					
					$member_update=mysql_query($query,$conn) or die(mysql_error());
					
					if(!empty($_FILES["personnelpic_file"]["name"]))
					{
						$personnel_picfile=($personnel_ID*1).".jpg";
						move_uploaded_file($_FILES["personnelpic_file"]["tmp_name"],"../../images/personnel/".$personnel_picfile);
						$query = "Update personnel Set personnel_picfile='$personnel_picfile' Where personnel_ID='$personnel_ID'";
						$personnel_update=mysql_query($query,$conn) or die(mysql_error());
					}
					echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('แก้ไขข้อมูลเรียบร้อย');
					$('#systemcontent').load('manageuser.php');
					</script>";
				}
			}
			else
				$error_txt = $validator->GetErrors(); 
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					$('#systemcontent').load('manageuser.php');
					</script>";
		}
		else
			$member_ID = $_GET["member_ID"];
		$query = "Select * From member,personnel Where member.personnel_ID=personnel.personnel_ID and member.member_ID='$member_ID'";
		$member_query = mysql_query($query,$conn)or die(mysql_error());
		$member_fetch = mysql_fetch_array($member_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#manageuser').click(function(){
		$('#systemcontent').load('manageuser.php');		
    });
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
        <div id="headmenu">&nbsp;<a href="#" id="manageuser"><img src="../images/icons/64/back.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        <center>
        <form id="edituserform" action="edituser.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
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
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC"><br />สถานะผู้ใช้(เลือกได้มากกว่า1) : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <input name="admin_chk" type="checkbox" id="admin_chk" value="1" <?php if(substr($member_fetch["member_status"],0,1)=="1") echo "checked='checked'";?> />
      Admin <br />
        <input name="boss_chk" type="checkbox" id="boss_chk" value="1" <?php if(substr($member_fetch["member_status"],1,1)=="1") echo "checked='checked'";?> />
        ผู้บริหาร
        <br />
        <input name="teacher_chk" type="checkbox" id="teacher_chk" value="1" <?php if(substr($member_fetch["member_status"],2,1)=="1") echo "checked='checked'";?> />
        ครู<br />
        <input name="other_chk" type="checkbox" id="other_chk" value="1" <?php if(substr($member_fetch["member_status"],3,1)=="1") echo "checked='checked'";?> />
        อื่นๆ &nbsp;<span class="RedRegula10"><?php echo $error_txt["status_txt"];?></span>
   </td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลบุคลากร</tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC"><input name="personnelID" type="hidden" id="personnelID" value="<?php echo $member_fetch["personnel_ID"];?>" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ภาพบุคลากร :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelpic_file"></label>
      <input type="file" name="personnelpic_file" id="personnelpic_file" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ชื่อ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
      <input name="personnelname_txt" type="text" id="personnelname_txt" value="<?php echo $member_fetch["personnel_name"];?>" size="30" maxlength="25" />
      <span class="RedRegula10"><?php echo $error_txt["personnelname_txt"];?></span></label></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC"> นามสกุล : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <input name="personnelsername_txt" type="text" id="personnelsername_txt" value="<?php echo $member_fetch["personnel_ser"];?>" size="30" maxlength="25" />
      <?php echo $error_txt["personnelsername_txt"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC"> เพศ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <select name="personnelgender_comb" id="personnelgender_comb">
        <option value="ชาย" <?php if($member_fetch["personnel_gender"]=="ชาย") echo "selected='selected'";?>>ชาย</option>
        <option value="หญิง" <?php if($member_fetch["personnel_gender"]=="หญิง") echo "selected='selected'";?>>หญิง</option>
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
      <option <?php if($member_fetch["personneltype_ID"]==$personneltype_fetch["personneltype_ID"]) echo "selected='selected'";?> value="<?php echo $personneltype_fetch["personneltype_ID"];?>"><?php echo $personneltype_fetch["personneltype_name"];?></option>
      <?php }?>
      </select>
       <span class="RedRegula10"><?php echo $error_txt["personneltypeID_comb"];?></span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ตำแหน่ง : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelposition_txt"></label>
      <input type="text" name="personnelposition_txt" id="personnelposition_txt" value="<?php echo $member_fetch["personnel_position"];?>"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ระดับการศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnellastedu_comb"></label>
      <select name="personnellastedu_comb" id="personnellastedu_comb">
      <option <?php if($member_fetch["personnel_lastedu"]=="") echo "selected='selected'";?> value="">ไม่ระบุ</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ปริญญาเอก") echo "selected='selected'";?> value="ปริญญาเอก">ปริญญาเอก</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ปริญญาโท") echo "selected='selected'";?> value="ปริญญาโท">ปริญญาโท</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ปริญญาตรี") echo "selected='selected'";?> value="ปริญญาตรี">ปริญญาตรี</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="อนุปริญญา") echo "selected='selected'";?> value="อนุปริญญา">อนุปริญญา</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ปวส.") echo "selected='selected'";?> value="ปวส.">ปวส.</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ปวช.") echo "selected='selected'";?> value="ปวช.">ปวช.</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ม.6") echo "selected='selected'";?> value="ม.6">ม.6</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ม.3") echo "selected='selected'";?> value="ม.3">ม.3</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ป.6") echo "selected='selected'";?> value="ป.6">ป.6</option>
      <option <?php if($member_fetch["personnel_lastedu"]=="ป.3") echo "selected='selected'";?> value="ป.3">ป.3</option>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">วุฒิการศึกษา :&nbsp;&nbsp; </td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnellastedumajor_txt"></label>
      <input type="text" name="personnellastedumajor_txt" id="personnellastedumajor_txt" value="<?php echo $member_fetch["personnel_lastedumajor"];?>"></td>
  </tr>
   <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สถานะ :&nbsp;&nbsp; </td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="personnelstatus_txt"></label>
      <select name="personnelstatus_comb" id="personnelstatus_comb">
      <option <?php if($member_fetch["personnel_status"]=="work") echo "selected='selected'";?> value="work">ทำงาน</option>
      <option <?php if($member_fetch["personnel_status"]=="help") echo "selected='selected'";?> value="help">ช่วยราชการ</option>
      <option <?php if($member_fetch["personnel_status"]=="move") echo "selected='selected'";?> value="move">ย้าย</option>
      <option <?php if($member_fetch["personnel_status"]=="quit") echo "selected='selected'";?> value="quit">ออก</option>
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
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table>
        </form>
        </center>
</div>