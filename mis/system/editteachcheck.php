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
list($teach_year,$teach_month,$teach_day) = split("-",$check_date);
$teach_ID = $_GET["teach_ID"];
$teachday_ID = $_GET["teachday_ID"];
$teachcheck_week = $_GET["teachcheck_week"];
$query = "Select * From teach,subject Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.teach_ID='$teach_ID'";
$teach_query = mysql_query($query,$conn)or die(mysql_error());
$teach_fetch = mysql_fetch_array($teach_query);

$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID'";
$student_query = mysql_query($query,$conn)or die(mysql_error());

$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='$teach_ID' group by teachstd.class_ID";
$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//edit
	$('#editteachcheck').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
        <form id="editteachcheck" action="teachcheck.php" method="post">
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12pt">
                  <th height="50" colspan="5" bgcolor="#CCCCCC">
                  <?php
				  list($teach_term,$teach_tyear) = split("/",$check_period);
				  echo "แก้ไขข้อมูลการเข้าเรียน<br>ภาคเรียนที่ ".$teach_term." ปีการศึกษา ".($teach_tyear+543);
				  echo " วัน".$thday[jddayofweek(gregoriantojd($teach_month,$teach_day,$teach_year),0)]." ที่ ".(int)$teach_day." ".$thmonth[(int)$teach_month]." ".((int)$teach_year+543);
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
		  $query = "Select * From teachcheck Where teachday_ID='$teachday_ID' and teachcheck_week='$teachcheck_week' and student_ID='".$student_fetch["student_ID"]."'";
		  $teachcheck_query = mysql_query($query,$conn)or die(mysql_error());
		  $teachcheck_fetch = mysql_fetch_array($teachcheck_query);
  ?>
  <tr <?php if($n%2==1) echo "bgcolor='#F5F5F5'";?>>
    <td width="5%" height="30" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle">
    <select name="teachin_comb[<?php echo $student_fetch["student_ID"];?>]" id="teachin_comb[<?php echo $student_fetch["student_ID"];?>]">
    	<option value="0" <?php if($teachcheck_fetch["teachcheck_result"]==0)echo "selected='selected'";?>>ขาด</option>
        <option value="1" <?php if($teachcheck_fetch["teachcheck_result"]==1)echo "selected='selected'";?>>มา</option>
        <option value="2" <?php if($teachcheck_fetch["teachcheck_result"]==2)echo "selected='selected'";?>>มาสาย</option>
        <option value="3" <?php if($teachcheck_fetch["teachcheck_result"]==3)echo "selected='selected'";?>>ลาป่วย</option>
        <option value="4" <?php if($teachcheck_fetch["teachcheck_result"]==4)echo "selected='selected'";?>>ลากิจ</option>
    </select>
    <input name="teachcheckID_txt[<?php echo $student_fetch["student_ID"];?>]" type="hidden" id="teachcheckID_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php  echo $teachcheck_fetch["teachcheck_ID"];?>" />
      </td>
    </tr>
  <?php 
  	}
  } 
  ?>
  <tr >
    <td height="50" colspan="5" align="center" valign="middle"><input name="checkdate_txt" type="hidden" id="checkdate_txt" value="<?php echo $check_date;?>" />
<input name="teachID_txt" type="hidden" id="teachID_txt" value="<?php echo $teach_ID;?>" />
<input name="week_txt" type="hidden" id="week_txt" value="<?php echo $teachcheck_week;?>" />
<input name="teachdayID_txt" type="hidden" id="teachdayID_txt" value="<?php echo $teachday_ID;?>" />
<input type="submit" name="editteachcheck_bt" id="editteachcheck_bt" value="บันทึก" /><input name="canceledit_bt" type="submit" id="canceledit_bt" value="ยกเลิก" /></td>
    </tr>
</table>
</form>