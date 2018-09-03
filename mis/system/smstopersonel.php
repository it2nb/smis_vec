<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
include("../includefiles/sms.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$sms = new siccsms();
if($_POST["send_bt"]=="ส่งข้อความ"){
	if(!empty($_POST["sms_txt"])){
		if(!empty($_POST["boss_ch"])||!empty($_POST["teacher_ch"])||!empty($_POST["employee_ch"])){
			$smstxt = $_POST["sms_txt"];
			$member_ID = $_SESSION["userID"];
		 	for($i=0;$i<count($_POST["boss_ch"]);$i++){
				$query = "Select personnel_name,personnel_ser,personnel_phone From personnel Where personnel_ID='".$_POST["boss_ch"][$i]."'";
				$boss_query = mysql_query($query,$conn)or die(mysql_error());
				$boss_fetch = mysql_fetch_array($boss_query);
				if(!empty($boss_fetch["personnel_phone"])){
					$smsresult = $sms->sendsms($boss_fetch["personnel_phone"],$smstxt);
					if(substr($smsresult,7,1)=="0"){
						$userlogs_des="ส่ง sms ".$sms_txt." ไปยัง ".$boss_fetch["personnel_name"]." ".$boss_fetch["personnel_ser"];
						$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','sms_mis','$userlogs_des')";
						$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
					}
				}
			}
			for($i=0;$i<count($_POST["teacher_ch"]);$i++){
				$query = "Select personnel_name,personnel_ser,personnel_phone From personnel Where personnel_ID='".$_POST["teacher_ch"][$i]."'";
				$teacher_query = mysql_query($query,$conn)or die(mysql_error());
				$teacher_fetch = mysql_fetch_array($teacher_query);
				if(!empty($teacher_fetch["personnel_phone"])){
				$smsresult = $sms->sendsms($teacher_fetch["personnel_phone"],$smstxt);
					if(substr($smsresult,7,1)=="0"){
						$userlogs_des="ส่ง sms ".$sms_txt." ไปยัง ".$teacher_fetch["personnel_name"]." ".$teacher_fetch["personnel_ser"];
						$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','sms_mis','$userlogs_des')";
						$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
					}
				}
			}
			for($i=0;$i<count($_POST["employee_ch"]);$i++){
				$query = "Select personnel_name,personnel_ser,personnel_phone From personnel Where personnel_ID='".$_POST["employee_ch"][$i]."'";
				$employee_query = mysql_query($query,$conn)or die(mysql_error());
				$employee_fetch = mysql_fetch_array($employee_query);
				if(!empty($employee_fetch["personnel_phone"])){
					$smsresult = $sms->sendsms($employee_fetch["personnel_phone"],$smstxt);
					if(substr($smsresult,7,1)=="0"){
						$userlogs_des="ส่ง sms ".$_POST["sms_txt"]." ไปยัง ".$employee_fetch["personnel_name"]." ".$employee_fetch["personnel_ser"];
						$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','sms_mis','$userlogs_des')";
						$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
					}
				}
			}
			echo "<script type='text/javascript'>
				alert('ส่ง SMS เรียนร้อย');
				</script>";
		}
		else{
			echo "<script type='text/javascript'>
				alert('กรุณาเลือกผู้รับ');
				</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>
			alert('กรุณากรอกข้อความ');
			</script>";
	}
}
$query = "Select * From personnel,member Where member.personnel_ID=personnel.personnel_ID and member.member_status like '_1__' and personnel.personnel_status='work'";
$boss_query=mysql_query($query,$conn)or die(mysql_error());
$query = "Select * From personnel,member Where member.personnel_ID=personnel.personnel_ID and member.member_status like '__1_' and personnel.personnel_status='work'";
$teacher_query=mysql_query($query,$conn)or die(mysql_error());
$query = "Select * From personnel,member Where member.personnel_ID=personnel.personnel_ID and member.member_status like '___1' and personnel.personnel_status='work'";
$employee_query=mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//check_all
	$('#all_ch').change(function(){
		var checkboxes = $(this).closest('form').find(':checkbox');
		$('#boss_detail').attr('open','open');
		$('#teach_detail').attr('open','open');
		$('#emp_detail').attr('open','open');
		checkboxes.prop('checked',this.checked);
	});
	//sendsms
	$('#sendsmsper').ajaxForm({ 
        target: '#admincontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	//edit
});
</script>
<style type="text/css">
.div30per {
	background-color: #CCC;
	width: 32%;
	float: left;

}
</style>
  <center>
  		<h2>ส่งข้อความไปยัง <big><u>บุคลากร</u></big><br />
	    (<?php echo $sms->getCredit();?>) </h2>
	<form id="sendsmsper" action="smstopersonel.php" method="post">
    <div align="center">
	  <b> 
	  ข้อความ : </b>
	  <input name="sms_txt" type="text" id="sms_txt" size="60" maxlength="70" /> ไม่เกิน 70 ตัวอักษร
      </div>
      <div align="center">
      <br /><input name="send_bt" type="submit" id="send_bt" value="ส่งข้อความ" /><br /><br />
      <b>ผู้รับ</b><br />
      <input name="all_ch" type="checkbox" value="" id="all_ch" /> เลือกส่งใหัทุกคน<br />
   	  <div class="div30per">
      		<details id="boss_detail">
      			<summary>ผู้บริหาร</summary>
              <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
                <tr height="25" bgcolor="#999999">
                	<td width="10%"></td>
                    <td>ชื่อ-สกุล</td>
                    <td width="30%">เบอร์ไทร</td>
                </tr>
                <?php
				$n=1; 
				while($boss_fetch=mysql_fetch_array($boss_query)){
					?>
                <tr height="20">
                	<td width="10%" align="center" valign="middle"><input name="boss_ch[]" type="checkbox" id="boss_ch[]" value="<?php echo $boss_fetch["personnel_ID"];?>" /></td>
                    <td><?php echo $boss_fetch["personnel_prefix"].$boss_fetch["personnel_name"]." ".$boss_fetch["personnel_ser"];?></td>
                    <td width="30%"><?php echo $boss_fetch["personnel_phone"];?></td>
                </tr>
                <?php } ?>
              </table>
      		</details>
   	  </div>
   	  <div class="div30per">
      		<details id="teach_detail">
      			<summary>ครู</summary>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
                <tr height="25" bgcolor="#999999">
                	<td width="10%"></td>
                    <td>ชื่อ-สกุล</td>
                    <td width="30%">เบอร์ไทร</td>
                </tr>
                <?php
				$n=1; 
				while($teacher_fetch=mysql_fetch_array($teacher_query)){
					?>
                <tr height="20">
                	<td width="10%" align="center" valign="middle"><input name="teacher_ch[]" type="checkbox" id="teacher_ch[]" value="<?php echo $teacher_fetch["personnel_ID"];?>" /></td>
                    <td><?php echo $teacher_fetch["personnel_prefix"].$teacher_fetch["personnel_name"]." ".$teacher_fetch["personnel_ser"];?></td>
                    <td width="30%"><?php echo $teacher_fetch["personnel_phone"];?></td>
                </tr>
                <?php } ?>
              </table>
      		</details>
   	  </div>
   	  <div class="div30per">
      		<details id="emp_detail">
      			<summary>เจ้าหน้าที่</summary>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
                <tr height="25" bgcolor="#999999">
                	<td width="10%"></td>
                    <td>ชื่อ-สกุล</td>
                    <td width="30%">เบอร์ไทร</td>
                </tr>
                <?php
				$n=1; 
				while($employee_fetch=mysql_fetch_array($employee_query)){
					?>
                <tr height="20">
                	<td width="10%" align="center" valign="middle"><input name="employee_ch[]" type="checkbox" id="employee_ch[]" value="<?php echo $employee_fetch["personnel_ID"];?>" /></td>
                    <td><?php echo $employee_fetch["personnel_perfix"].$employee_fetch["personnel_name"]." ".$employee_fetch["personnel_ser"];?></td>
                    <td width="30%"><?php echo $employee_fetch["personnel_phone"];?></td>
                </tr>
                <?php } ?>
              </table>
      		</details>
   	  </div>
      <div>
	</form>
        <br /><br />
<br />
<?php if($check_num>0){ ?>
<div align="right"><a href="#" onclick="editflagpolecheck('<?php echo $class_ID;?>','<?php echo $check_period;?>','<?php echo $check_date;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<?php } ?>
</center>