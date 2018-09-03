<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
$check_date=$_GET["check_date"];
$check_period=$_GET["check_period"];
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];

if($_POST["teachsearch_bt"]=="ค้นหา"){
	$check_period = $_POST["period_comb"];
	$check_date = $_POST["date_comb"];
	$urlsrc=$_POST["urlsrc"];
}
if(empty($check_date)){
	$check_date=date("Y-m-d");
}
if(empty($check_period)){
	//$query = "Select * From period Where period_start>=$check_date";
	$query = "Select * From period Where period_start=(Select max(period_start) From period)";
	$period_query = mysql_query($query,$conn)or die(mysql_error());
	$period_fetch = mysql_fetch_assoc($period_query);
	$check_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
}
list($n_year,$n_month,$n_day) = split("-",$check_date);
$day=jddayofweek(gregoriantojd($n_month,$n_day,$n_year),0);
list($n_term,$n_year) = split("/",$check_period);
$query="Select teach.teach_ID,teach.subject_ID,subject_name,teachday_start,teachday_stop,personnel_name,personnel_ser From teach,subject,teachday,personnel Where teach.teach_ID=teachday.teach_ID and teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.personnel_ID=personnel.personnel_ID and teachday_day='$day' and teach.teach_term='$n_term' and teach_year='$n_year' Order By teachday_start";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
$thisyear=substr($n_year+543,2,2);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#period_comb').change(function (){
		var period = $('#period_comb').select().val();
		$.get('perioddate.php',{'check_period':period},function(data){$('#date_comb').html(data)}); 
	});
	//headmenu
	$('#goback').click(function(){
		$("#systemcontent").load('studentresult.php');
	});
	//search
	$('#teachsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function teachcheckreportdayb(id,check_date,check_period){
	$.get('teachcheckreportdayb.php',{'teach_ID':id,
	'check_date':check_date,
	'check_period':check_period},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลการเรียนการสอน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="128"><a href="#" id="goback"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle"><b>ความคุม</b></td>
        <td></td>
    </tr>
	</table>
</div>
    <div id="admincontent">
  <center><br />
  		<form id="teachsearchform" action="teachdatab.php" method="post">
        	<b>ค้นหา ภาคเรียนที่ </b><select name="period_comb" id="period_comb">
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
        	</select>
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
       	  &nbsp;<input name="urlsrc" type="hidden" id="urlsrc" value="<?php echo $urlsrc;?>" />
        	<input name="teachsearch_bt" type="submit" id="teachsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="95%" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
                    <th height="50" colspan="9" bgcolor="#CCCCCC">ข้อมูลการเรียนการสอน ภาคเรียนที่ วันที่ </th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เวลา</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ระดับชั้น สาขางาน</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูผู้สอน</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนผู้เรียน</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มา</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ไม่มา</td>
  </tr>
  <?php
  $allcome=0;
  $allmiss=0;
  $allstd=0;
  while($teach_fetch=mysql_fetch_assoc($teach_query))
  {
	$query="Select count(teachstd.student_ID) as studentnum From teachstd,student Where student.student_ID=teachstd.student_ID and teach_ID='".$teach_fetch["teach_ID"]."' and student_endstatus='0'";
	$studentnum_query=mysql_query($query,$conn)or die(mysql_error());
	$studentnum_fetch=mysql_fetch_assoc($studentnum_query);
	$query="Select * From teachday Where teach_ID='".$teach_fetch["teach_ID"]."' and teachday_day='
$day' Order By teachday_day ASC";
	$teachday_query=mysql_query($query,$conn)or die(mysql_error());
	$teachday_fetch=mysql_fetch_assoc($teachday_query);
	$query="Select teachcheck_ID From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and teachcheck_week='$thisweek' and teachday_ID='".$teachday_fetch["teachday_ID"]."' and teachcheck_result='0'";
	$miss_query=mysql_query($query,$conn)or die(mysql_error());
	$miss = mysql_num_rows($miss_query);
	$query="Select teachcheck_ID From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and teachcheck_week='$thisweek' and teachday_ID='".$teachday_fetch["teachday_ID"]."' and teachcheck_result='2'";
	$late_query=mysql_query($query,$conn)or die(mysql_error());
	$late = mysql_num_rows($late_query);
	$query="Select teachcheck_ID From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and teachcheck_week='$thisweek' and teachday_ID='".$teachday_fetch["teachday_ID"]."' and teachcheck_result='3'";
	$sick_query=mysql_query($query,$conn)or die(mysql_error());
	$sick = mysql_num_rows($sick_query);
	$query="Select teachcheck_ID From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and teachcheck_week='$thisweek' and teachday_ID='".$teachday_fetch["teachday_ID"]."' and teachcheck_result='4'";
	$business_query=mysql_query($query,$conn)or die(mysql_error());
	$business = mysql_num_rows($business_query);
	
	$allstd += $studentnum_fetch["studentnum"];
	$allmiss += ($miss+$sick+$business);
	$allcome += ($studentnum_fetch["studentnum"]-($miss+$sick+$business));
	$query="Select teach_ID From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and teachcheck_week='$thisweek' and teachday_ID='".$teachday_fetch["teachday_ID"]."'";
	$techcheck_query=mysql_query($query,$conn)or die(mysql_error()); 
  ?>
  <tr <?php if(mysql_num_rows($techcheck_query)<=0) echo"bgcolor='#CCCCCC'";?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><a href="#" onclick="teachcheckreportdayb('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $check_date;?>','<?php echo $check_period;?>');" ><?php echo $teach_fetch["subject_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="teachcheckreportdayb('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $check_date;?>','<?php echo $check_period;?>');" ><?php echo $teach_fetch["subject_name"];?></a></td>
    <td align="center" valign="middle">
    <?php echo substr($teachday_fetch["teachday_start"],0,5)."-".substr($teachday_fetch["teachday_stop"],0,5);?></td>
    <td align="left" valign="middle"><?php 
	$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='".$teach_fetch["teach_ID"]."' group by teachstd.class_ID";
	$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
	while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)){
		echo $teachstd_fetch["area_level"].".".($thisyear-substr($teachstd_fetch["class_ID"],0,2)+1)."/".substr($teachstd_fetch["class_ID"],7,1)." ".$teachstd_fetch["major_name"]."<br>";
	}
	
	?></td>
    <td align="left" valign="middle"><?php echo $teach_fetch["personnel_name"]." ".$teach_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $studentnum_fetch["studentnum"];?></td>
    <td align="center" valign="middle"><?php echo $studentnum_fetch["studentnum"]-($miss+$sick+$business);?></td>
    <td align="center" valign="middle"><?php echo $miss+$sick+$business;?></td>
  </tr>
  <?php } ?>
</table><br />
</center></div>