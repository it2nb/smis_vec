<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$check_date = $_GET["check_date"];
$check_period = $_GET["check_period"];
$class_ID = $_GET["class_ID"];

$query = "Select * From student Where class_ID='$class_ID'  Order By student_ID ASC";
$student_query = mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//edit
	$('#editflagpolecheck').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
        <form id="editflagpolecheck" action="flagpolecheck.php" method="post">
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12pt">
                  <th height="50" colspan="5" bgcolor="#CCCCCC">
                  <?php
				  list($flag_term,$flag_tyear) = split("/",$check_period);
				  echo "แก้ไขข้อมูลกิจกรรมหน้าเสาธง<br>ภาคเรียนที่ ".$flag_term." ปีการศึกษา ".($flag_tyear+543);
				  echo " วัน".$thday[jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)]." ที่ ".(int)$flag_day." ".$thmonth[(int)$flag_month]." ".((int)$flag_year+543);
				  ?>
                  </th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="30%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มาเข้าร่วมกิจกรรมหน้าเสาธง</td>
    </tr>
  <?php
  $check_num=0;
  while($student_fetch=mysql_fetch_array($student_query))
  {
	 
	  if($student_fetch["student_endstatus"]==0){
		  $query = "Select * From flagcheck Where flagcheck_date='$check_date' and student_ID='".$student_fetch["student_ID"]."'";
		  $flagcheck_query = mysql_query($query,$conn)or die(mysql_error());
		  $flagcheck_fetch = mysql_fetch_array($flagcheck_query);
  ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td width="5%" height="30" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle">
    <?php if($flagcheck_fetch["flagcheck_result"]==1){?>
    <input name="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" type="checkbox" id="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" value="1" checked="checked"/>
    <?php }else{?>
    <input name="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" type="checkbox" id="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" value="1"/>
    <?php } ?><input name="flagcheckID_txt[<?php echo $student_fetch["student_ID"];?>]" type="hidden" id="flagcheckID_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php  echo $flagcheck_fetch["flagcheck_ID"];?>" />
      </td>
    </tr>
  <?php 
  	}
  } 
  ?>
  <tr >
    <td height="50" colspan="5" align="center" valign="middle"><input name="checkdate_txt" type="hidden" id="checkdate_txt" value="<?php echo $check_date;?>" />
<input name="checkperiod_txt" type="hidden" id="checkperiod_txt" value="<?php echo $check_period;?>" />
<input name="classID_txt" type="hidden" id="classID_txt" value="<?php echo $class_ID;?>" />
<input type="submit" name="editflagpolecheck_bt" id="editflagpolecheck_bt" value="บันทึก" /><input name="canceledit_bt" type="submit" id="canceledit_bt" value="ยกเลิก" /></td>
    </tr>
</table>
</form>