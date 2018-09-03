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
$class_ID = $_GET["class_ID"];
$query = "Select * From period Where period_start=(Select max(period_start) From period)";
$period_query = mysql_query($query,$conn)or die(mysql_error());
$period_fetch = mysql_fetch_assoc($period_query);
$last_year = $period_fetch["period_year"];
$last_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
if($_POST["periodsearch_bt"]=="ค้นหา"){
	$check_date = $_POST["date_comb"];
	$check_period = $_POST["period_comb"];
	$check_year = substr($_POST["period_comb"],2,4);
	$class_ID = $_POST["classID_comb"];
}
if(empty($check_date)){
	$check_date=date("Y-m-d");
}
if(empty($check_period)){
	$check_year = $last_year;
	$check_period = $last_period;
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#consultdata').click(function(){
		$('#systemcontent').load('consultdata.php');
	});
	$('#period_comb').change(function (){
		var period = $('#period_comb').select().val();
		$.get('perioddate.php',{'check_period':period},function(data){$('#date_comb').html(data)}); 
	});
	//headmenu
	//search
	$('#periodsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
   	<div id="statusbar">ข้อมูลผู้ขาดเรียนแบบรายวัน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="128"><a href="#" id="consultdata"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
	<form id="periodsearchform" action="teachresultmissdayc.php" method="post">
        	<b>ค้นหา ภาคเรียนที่</b>
       	  &nbsp;
          <select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_assoc($period_query)){
				if($check_period==($period_fetch["period_term"]."/".$period_fetch["period_year"]))
				  	echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."' selected='selected'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
				else
					echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
			  }
			  ?>
        	</select><br />
            <b>วัน </b><select name="date_comb" id="date_comb">
        	  <?php
			  $query="Select * From period Where period_year='".substr($check_period,2,4)."' and period_term='".substr($check_period,0,1)."'";
			  $date_query=mysql_query($query,$conn)or die(mysql_error());
			  $date_fetch = mysql_fetch_assoc($date_query);
			  list($st_year,$st_month,$st_day) = split("-",$date_fetch["period_start"]);
			  list($sp_year,$sp_month,$sp_day) = split("-",$date_fetch["period_end"]);
			  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  $date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
			  list($flag_year,$flag_month,$flag_day) = split("-",$check_date);
			  $todaydate = (date("Y")*10000)+(date("m")*100)+date("j");
			  $dayofweek=5;
			  $week = 1;
			  $countday = 1;
			  while($date_st<=$date_sp&&$date_st<=$todaydate){
				  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=6){
				  	if($st_year==$flag_year&&$st_month==$flag_month&&$st_day==$flag_day){
				  		echo "<option value='".$st_year."-".$st_month."-".$st_day."' selected='selected'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
						$thisweek=$week;
						$thisday=jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0);
					}
					else
						echo "<option value='".$st_year."-".$st_month."-".$st_day."'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
					if($countday%$dayofweek==0)
					$week++;
					$countday++;
				  }
				  if($st_year==date("Y")&&$st_month==date("n")&&$st_day==date("j"))
					break;
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
			  ?>
        	</select>
            &nbsp;
            <select name="classID_comb" id="classID_comb">
        	  <?php
			  $query="Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and (personnel_ID='$personnel_ID' or personnel_ID2='$personnel_ID') Order By year DESC";
			  $class_query=mysql_query($query,$conn)or die(mysql_error());
			  while($class_fetch=mysql_fetch_assoc($class_query)){
				if($class_ID==$class_fetch["class_ID"])
				  	echo "<option value='".$class_fetch["class_ID"]."' selected='selected'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
				else
					echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
			  }
			  ?>
   	  </select>
   	  <input name="periodsearch_bt" type="submit" id="periodsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <?php
        list($flag_term,$flag_tyear) = split("/",$check_period);
		if(jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=0&&jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=6){
		?>
         <table width="85%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="5" bgcolor="#CCCCCC">
			  รายงานจำนวนผู้ขาดเรียนประจำวัน<br />
			  <?php		  
				  echo " วัน".$thday[jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)]." ที่ ".(int)$flag_day." ".$thmonth[(int)$flag_month]." ".((int)$flag_year+543);
				  ?></th>
              
          <tr>
            <td width="3%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
            <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
            <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - สกุล</td>
            <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">วิชา/ครูผู้สอน</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
          </tr>
  <?php
  	$styear=$check_year-3;
	$query = "Select DISTINCT student.student_ID,student_prefix,student_name,student_ser,student_parphone,class.* From class,teachcheck,student,teachday,teach Where class.class_ID=student.class_ID and student.student_ID=teachcheck.student_ID and teachcheck.teachday_ID=teachday.teachday_ID and teachcheck.teach_ID=teach.teach_ID and teachcheck.teachcheck_week='$thisweek' and teachday_day='$thisday' and teachcheck_result='0' and teach_year='".substr($check_period,2,4)."' and teach_term='".substr($check_period,0,1)."' and student.class_ID='$class_ID'";
	$student_query=mysql_query($query,$conn) or die(mysql_error());		
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
	  	$student_show=$check_year-$student_fetch["year"];
  ?>
  <tr >
    <td width="3%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle">
      <?php
	$student_ID=$student_fetch["student_ID"];
	$query = "Select * From teach,teachcheck,teachday,subject,personnel Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teachcheck.teach_ID=teach.teach_ID and teachcheck.teachday_ID=teachday.teachday_ID and teach.personnel_ID=personnel.personnel_ID and teachcheck_result=0 and student_ID='$student_ID' and teachcheck_week='$thisweek' and teachday_day='$thisday'";
	$teach_query = mysql_query($query,$conn)or die(mysql_error());
	while($teach_fetch=mysql_fetch_assoc($teach_query)){
		echo $teach_fetch["subject_name"]." (".$teach_fetch["personnel_name"]." ".$teach_fetch["personnel_ser"].")<hr>";
	}
	?>
    </td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
    <?php }?>
</table>
<?php }?>
<br />
</center></div>