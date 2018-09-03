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
$teach_ID = $_GET["teach_ID"];

$check_date=date("Y-m-d");

$query = "Select * From teach,subject Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.teach_ID='$teach_ID'";
$teach_query = mysql_query($query,$conn)or die(mysql_error());
$teach_fetch = mysql_fetch_assoc($teach_query);
$check_period = $teach_fetch["teach_term"]."/".$teach_fetch["teach_year"];

$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID'";
$student_query = mysql_query($query,$conn)or die(mysql_error());

$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='$teach_ID' group by teachstd.class_ID";
$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
	$('#classsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function teachdetaildata(id){
	$.get('teachdetaildata.php',{'teach_ID':id},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">รายงานการเข้าเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" onclick="teachdetaildata('<?php echo $teach_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/teachcheckreportpdf.php?teach_ID=$teach_ID";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center><br />
        	<b> รหัสวิชา <?php echo $teach_fetch["subject_ID"];?> วิชา <?php echo $teach_fetch["subject_name"];?> กลุ่มเรียน </b><?php while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)) echo $teachstd_fetch["area_level"].".".(substr(($teach_fetch["teach_year"]+543),2,2)-substr($teachstd_fetch["class_ID"],0,2)+1)." ".$teachstd_fetch["major_name"].", ";?><b> ภาคเรียนที่</b>
       	  &nbsp;<?php echo $teach_fetch["teach_term"]."/".($teach_fetch["teach_year"]+543);?>
        <br /><br />
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <th height="50" colspan="13" bgcolor="#CCCCCC">รายงานการเข้าเรียน ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></th>
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ทั้งหมด(วัน)</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนวันที่ทำการเช็คชื่อ</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มา(วัน)</td>
    <td width="6%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลาป่วย(วัน)</td>
    <td width="6%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลากิจ(วัน)</td>
    <td width="6%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มาสาย(วัน)</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ขาด(วัน)</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การเข้าเรียน</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ผลลัพธ์</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
    </tr>
  <?php
  	list($teach_term,$teach_tyear) = split("/",$check_period);
  	$query = "Select * From period Where period_year='$teach_tyear' and period_term='$teach_term'";
  	$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
  	$yearterm_fetch = mysql_fetch_assoc($yearterm_query);
  	$allday=0;
  	list($st_year,$st_month,$st_day) = split("-",$yearterm_fetch["period_start"]);
  	list($sp_year,$sp_month,$sp_day) = split("-",$yearterm_fetch["period_end"]);
  	$date_st = ($st_year*10000)+($st_month*100)+$st_day;
	$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
	list($teach_year,$teach_month,$teach_day) = split("-",$check_date);
	$week = 1;
	$day = 1;
	while($date_st<=$date_sp){
		$query="Select teachday_ID From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)."'";
		$teachday_query=mysql_query($query,$conn)or die(mysql_error());
	  if(mysql_num_rows($teachday_query)){
			$allday++;
			if($day%$dayofweek==0)
				$week++;
			$day++;
	  }
	  $st_day++;
	  if($st_day>cal_days_in_month(CAL_GREGORIAN, $st_month, $st_year)){
		$st_day=1;
	  	$st_month++;
	  }
	  if($st_month>12){
		  $st_month=1;
		  $st_year++;
	  }
	  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
	}
	$allday=$allday;
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
	  if($student_fetch["student_endstatus"]==0){
		  $student_ID = $student_fetch["student_ID"];
		  for($i=1;$i<$week;$i++){
			$query="Select teachday_day,teachday_start,teachday_stop From teachday Where teach_ID='$teach_ID'";
			$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
	      	while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
		  	}
		  }
		  $query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='0'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $out = $checkday_fetch["teachcheck"];
		  $query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='1'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $present = $checkday_fetch["teachcheck"];
		  $query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='2'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $late = $checkday_fetch["teachcheck"];
		  $query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='3'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $sick = $checkday_fetch["teachcheck"];
		  $query = "Select count(student_ID) as teachcheck From teachcheck Where student_ID='$student_ID' and teach_ID='$teach_ID' and teachcheck_result='4'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $business = $checkday_fetch["teachcheck"];
		  $checkday=$out+$present+$late+$sick+$business;
		  $result_percent = round((($allday-($out+(floor($late/2))))/$allday)*100,2);
  ?>
  <tr
  <?php
  	if($result_percent<80)
		echo "bgcolor='#FF0000'";
	else if($result_percent<85)
		echo "bgcolor='#FF6600'";
	else if($result_percent<90)
		echo "bgcolor='#FFFF99'";
  ?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $allday;?></td>
    <td align="center" valign="middle"><?php echo $checkday;?></td>
    <td align="center" valign="middle"><?php echo $present;?></td>
    <td align="center" valign="middle"><?php echo $sick;?></td>
    <td align="center" valign="middle"><?php echo $business;?></td>
    <td align="center" valign="middle"><?php echo $late;?></td>
    <td align="center" valign="middle"><?php echo $out;?></td>
    <td align="center" valign="middle"><?php echo $result_percent;?></td>
    <td align="center" valign="middle">
    <?php
	if($result_percent>=80)
		echo "ผ่าน";
	else
		echo "ไม่มีสิทธิ์สอบ";
    ?>
    </td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php }} ?>
</table><br />
</center></div>