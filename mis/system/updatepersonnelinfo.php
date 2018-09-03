<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
if($_POST["update_bt"]=="บันทึก"){
	require_once("../includefiles/formvalidator.php");
	$validator = new FormValidator();
	$validator->addValidation("personnelname_txt","req","กรุณากรอกชื่อ");
	$validator->addValidation("personnelser_txt","req","กรุณากรอกสกุล");
	if($validator->ValidateForm()){
		$personnel_name = $_POST["personnelname_txt"];
		$personnel_ser = $_POST["personnelser_txt"];
		$personnel_gender = $_POST["personnelgender_comb"];
		$personnel_birthday = $_POST["birthyear_comb"]."-".$_POST["birthmonth_comb"]."-".$_POST["birthdate_comb"];
		$personnel_nationality = $_POST["personnelnationality_txt"];
		$personnel_origin = $_POST["personnelorigin_txt"];
		$personnel_startwork = $_POST["startworkyear_comb"]."-".$_POST["startworkmonth_comb"]."-".$_POST["startworkdate_comb"];
		$personnel_position = $_POST["personnelposition_txt"];
		$personnel_positionno = $_POST["personnelpositionno_txt"];
		$personnel_school = $_POST["personnelschool_txt"];
		$personnel_lastedu = $_POST["personnellastedu_comb"];
		$personnel_lastedumajor = $_POST["personnellastedumajor_txt"];
		$personnel_agency = $_POST["personnelagency_txt"];
		$personnel_addbr = $_POST["personneladdbr_txt"];
		$personnel_addnow = $_POST["personneladdnow_txt"];
		$personnel_phone = $_POST["personnelphone_txt"];
		$personnel_email = $_POST["personnelemail_txt"];
		$personnel_award = $_POST["personnelaward_txt"];
		$query="Update personnel Set personnel_name='$personnel_name',personnel_ser='$personnel_ser',personnel_gender='$personnel_gender',personnel_birthday='$personnel_birthday',personnel_nationality='$personnel_nationality',personnel_origin='$personnel_origin',personnel_startwork='$personnel_startwork',personnel_position='$personnel_position',personnel_positionno='$personnel_positionno',personnel_school='$personnel_school',personnel_lastedu='$personnel_lastedu',personnel_lastedumajor='$personnel_lastedumajor',personnel_agency='$personnel_agency',personnel_addbr='$personnel_addbr',personnel_addnow='$personnel_addnow',personnel_phone='$personnel_phone',personnel_email='$personnel_email',personnel_award='$personnel_award' Where personnel_ID='$personnel_ID'";
		$personnel_update=mysql_query($query,$conn) or die(mysql_error());
		if(!empty($_FILES["personnelpic_file"]["name"]))
		{
			$personnel_picfile=($personnel_ID*1).".jpg";
			move_uploaded_file($_FILES["personnelpic_file"]["tmp_name"],"../../images/personnel/".$personnel_picfile);
			$query = "Update personnel Set personnel_picfile='$personnel_picfile' Where personnel_ID='$personnel_ID'";
			$personnel_update=mysql_query($query,$conn) or die(mysql_error());
		}
		$member_ID = $_SESSION["userID"];
		$userlogs_des='แก้ไขข้อมูลประวัติส่วนตัวทั่วไป ';
		$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Profile','personnelinfo_mis','$userlogs_des')";
		$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
		echo "<script type='text/javascript'>
			$('#perinfo').hide();
			$('#personnelinfo').load('personnelinfo.php');
			alert('แก้ไขข้อมูลเรียบร้อย');
			</script>";
	}else
		$error_txt = $validator->GetErrors(); 
}
else if($_POST["cancel_bt"]=="ยกเลิก")
	echo "<script type='text/javascript'>
		$('#perinfo').hide();
		$('#personnelinfo').load('personnelinfo.php');
		</script>";

$query="Select * From personnel Where personnel_ID='$personnel_ID'";
$personnel_query = mysql_query($query,$conn)or die(mysql_error());
$personnel_fetch = mysql_fetch_array($personnel_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#updatepersonnelinfoform').ajaxForm({ 
        target: '#personnelinfo',
		beforeSubmit: function(){
			$('#personnelinfo').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#personnelimg img').attr('src', $('#personnelimg img').attr('src') + '?' + Math.random());
});
</script>
<link href="../includefiles/stylepersonnel.css" rel="stylesheet" type="text/css" />
<?php include("../includefiles/datalist.php");?>
<span class="BlueDark"><h3>&nbsp;&nbsp;ประวัติส่วนตัวทั่วไป</h3></span>
<form id="updatepersonnelinfoform" action="updatepersonnelinfo.php" method="post" enctype="multipart/form-data">
 <div id="personnelimg" align="center"><img src="../../images/personnel/<?php echo $personnel_fetch["personnel_picfile"];?>" /><br /><input name="personnelpic_file" type="file" id="personnelpic_file" size="10" /></div>
<div id="personnelinfo1">
<ul>
	<li><b>ชื่อ : </b><input name="personnelname_txt" type="text" id="personnelname_txt" value="<?php echo $personnel_fetch["personnel_name"];?>" size="15" maxlength="50" /><span class="RedRegula10"><?php echo $error_txt["personnelname_txt"];?></span><br /><b> สกุล : </b><input name="personnelser_txt" type="text" id="personnelser_txt" value="<?php echo $personnel_fetch["personnel_ser"];?>" size="15" maxlength="50"/><span class="RedRegula10"><?php echo $error_txt["personnelser_txt"];?></span></li>
    <li><b>เพศ : </b><select name="personnelgender_comb" id="personnelgender_comb">
      <option value="ชาย" <?php if($personnel_fetch["personnel_gender"]=="ชาย") echo "selected='selected'";?>>ชาย</option>
      <option value="หญิง" <?php if($personnel_fetch["personnel_gender"]=="หญิง") echo "selected='selected'";?>>หญิง</option>
    </select></li>
    <li><b>เกิด : </b><div align="center">วันที่ <select name="birthdate_comb" id="birthdate_comb">
    <?php for($i=1;$i<=31;$i++){
		 echo "<option value='$i' ";
		 if((substr($personnel_fetch["personnel_birthday"],8,2)+0)==$i) echo "selected='selected'";
		 echo" >$i</option>";
	}?>
    </select> เดือน <select name="birthmonth_comb" id="birthmonth_comb">
    <?php for($i=1;$i<=12;$i++){
		 echo "<option value='$i' ";
		 if((substr($personnel_fetch["personnel_birthday"],5,2)+0)==$i) echo "selected='selected'";
		 echo " >$thmonth[$i]</option>";
	}?>
    </select> ปี <select name="birthyear_comb" id="birthyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."' ";
		 if(substr($personnel_fetch["personnel_birthday"],0,4)==(date('Y')-$i)) echo "selected='selected'";
		 echo" >".(date('Y')+543-$i)."</option>";
	}?>
    </select></div></li>
    <li><b>เชื่อชาติ : </b><input name="personnelnationality_txt" type="text" id="personnelnationality_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_nationality"];?>" /></li>
    <li><b>สัญชาติ : </b><input name="personnelorigin_txt" type="text" id="personnelorigin_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_origin"];?>" /></li>
    <li><b>ตำแหน่ง : </b><input name="personnelposition_txt" type="text" id="personnelposition_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_position"];?>" /></li>
    <li><b>เลขที่ตำแหน่ง : <input name="personnelpositionno_txt" type="text" id="personnelpositionno_txt" size="20" maxlength="50" value="<?php echo $personnel_fetch["personnel_positionno"];?>" /></b></li>
    <li><b>เริ่มทำงาน : </b><div align="center">วันที่ <select name="startworkdate_comb" id="startworkdate_comb">
    <?php for($i=1;$i<=31;$i++){
		 echo "<option value='$i' ";
		 if((substr($personnel_fetch["personnel_startwork"],8,2)+0)==$i) echo "selected='selected'";
		 echo" >$i</option>";
	}?>
    </select> เดือน <select name="startworkmonth_comb" id="startworkmonth_comb">
    <?php for($i=1;$i<=12;$i++){
		 echo "<option value='$i' ";
		 if((substr($personnel_fetch["personnel_startwork"],5,2)+0)==$i) echo "selected='selected'";
		 echo " >$thmonth[$i]</option>";
	}?>
    </select> ปี <select name="startworkyear_comb" id="startworkyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."' ";
		 if(substr($personnel_fetch["personnel_startwork"],0,4)==(date('Y')-$i)) echo "selected='selected'";
		 echo" >".(date('Y')+543-$i)."</option>";
	}?>
    </select></div></li>
</ul>
</div>
<div id="personnelinfo1">
<ul>
	<li><b>สถานศึกษา : </b><input name="personnelschool_txt" type="text" id="personnelschool_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_school"];?>" /></li>
    <li><b>สังกัด : </b><input name="personnelagency_txt" type="text" id="personnelagency_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_agency"];?>" /></li>
    <li><b>ระดับการศึกษาสูงสุด : </b><select name="personnellastedu_comb" id="personnellastedu_comb">
      <option value="">ไม่ระบุ</option>
      <option value="ปริญญาเอก" <?php if($personnel_fetch["personnel_lastedu"]=="ปริญญาเอก") echo "selected='selected'";?>>ปริญญาเอก</option>
      <option value="ปริญญาโท" <?php if($personnel_fetch["personnel_lastedu"]=="ปริญญาโท") echo "selected='selected'";?>>ปริญญาโท</option>
      <option value="ปริญญาตรี" <?php if($personnel_fetch["personnel_lastedu"]=="ปริญญาตรี") echo "selected='selected'";?>>ปริญญาตรี</option>
      <option value="อนุปริญญา" <?php if($personnel_fetch["personnel_lastedu"]=="อนุปริญญา") echo "selected='selected'";?>>อนุปริญญา</option>
      <option value="ปวท." <?php if($personnel_fetch["personnel_lastedu"]=="ปวท.") echo "selected='selected'";?>>ปวท.</option>
      <option value="ปวส." <?php if($personnel_fetch["personnel_lastedu"]=="ปวส.") echo "selected='selected'";?>>ปวส.</option>
      <option value="ปวช." <?php if($personnel_fetch["personnel_lastedu"]=="ปวช.") echo "selected='selected'";?>>ปวช.</option>
      <option value="ม.6" <?php if($personnel_fetch["personnel_lastedu"]=="ม.6") echo "selected='selected'";?>>ม.6</option>
      <option value="ม.3" <?php if($personnel_fetch["personnel_lastedu"]=="ม.3") echo "selected='selected'";?>>ม.3</option>
      <option value="ป.6" <?php if($personnel_fetch["personnel_lastedu"]=="ป.6") echo "selected='selected'";?>>ป.6</option>
      <option value="ป.3" <?php if($personnel_fetch["personnel_lastedu"]=="ป.3") echo "selected='selected'";?>>ป.3</option>
      </select></li>
    <li><b>วุฒิการศึกษา : </b><input name="personnellastedumajor_txt" type="text" id="personnellastedumajor_txt" size="30" maxlength="50" value="<?php echo $personnel_fetch["personnel_lastedumajor"];?>" /></li>
    <li><b>ที่อยู่ตามทะเบียนบ้าน : </b><div align="center"><textarea name="personneladdbr_txt" cols="35" rows="5" id="personneladdbr_txt"><?php echo $personnel_fetch["personnel_addbr"];?></textarea></div></li>  
    <li><b>ที่อยู่ปัจจุบัน : </b><div align="center"><textarea name="personneladdnow_txt" cols="35" rows="5" id="personneladdnow_txt"><?php echo $personnel_fetch["personnel_addnow"];?></textarea></div></li>
    <li><b>เบอร์โทรศัพท์(มือถือ) : </b><input name="personnelphone_txt" id="personnelphone_txt" value="<?php echo $personnel_fetch["personnel_phone"];?>" size="15" maxlength="10"></li>
    <li><b>E-mail : </b><input name="personnelemail_txt" id="personnelemail_txt" value="<?php echo $personnel_fetch["personnel_email"];?>" size="30"></li>
    <li><b>ผลงานที่ภาคภูมิใจ : </b><div align="center"><textarea name="personnelaward_txt" cols="35" rows="5" id="personnelaward_txt"><?php echo $personnel_fetch["personnel_award"];?></textarea></div></li>
</ul>
</div>
<div align="right" style="padding-right:40px"><input name="update_bt" type="submit" id="update_bt" value="บันทึก" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" /></div>
</div></form>