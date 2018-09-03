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
$check_date = $_GET["check_date"];

$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID'";
$student_query = mysql_query($query,$conn)or die(mysql_error());

$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='$teach_ID' group by teachstd.class_ID";
$teachstd_query=mysql_query($query,$conn)or die(mysql_error());

$query="Select teachday_ID From teachday Where teach_ID='$teach_ID'";
$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
$dayofweek=mysql_num_rows($dayofweek_query);
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
function teachdatab(check_date,check_period){
	$.get('teachdatab.php',{'check_date':check_date,
		'check_period':check_period},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">รายงานการเข้าเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" onclick="teachdatab('<?php echo $check_date;?>','<?php echo $check_period;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/teachcheckreportdaypdf.php?teach_ID=$teach_ID";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
                      <th height="50" colspan="<?php echo ($dayofweek*18)+4; ?>" bgcolor="#CCCCCC">รายงานการเข้าเรียน ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></th>
  <tr>
    <td width="3%" height="70" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <?php
			  $query="Select * From period Where period_year='".substr($check_period,2,4)."' and period_term='".substr($check_period,0,1)."'";
			  $date_query=mysql_query($query,$conn)or die(mysql_error());
			  $date_fetch = mysql_fetch_assoc($date_query);
			  list($st_year,$st_month,$st_day) = split("-",$date_fetch["period_start"]);
			  list($sp_year,$sp_month,$sp_day) = split("-",$date_fetch["period_end"]);
			  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  $date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
			  $todaydate = (date("Y")*10000)+(date("m")*100)+date("j");
			  list($teach_year,$teach_month,$teach_day) = split("-",$check_date);
			  $week = 1;
			  $day = 1;
			  while($date_st<=$date_sp&&$date_st<=$date_sp){
				  $query="Select teachday_ID From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)."'";
				  $teachday_query=mysql_query($query,$conn)or die(mysql_error());
				  while($teachday_fetch=mysql_fetch_assoc($teachday_query)){//;			  
				  //if(mysql_num_rows($teachday_query)){
					  ?>
				  	<td align="center" valign="middle" bgcolor="#FFCC33" class="blackRegula7"><?php echo $st_day."<br>".$thmountbf[(int)$st_month]."<br>".substr($st_year+543,2,2)."<hr color='#000000'>(".$week.")"; ?></td>
                    <?php
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
			  ?>
    <td width="3%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
    </tr>
  <?php
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
	  if($student_fetch["student_endstatus"]==0){
		$student_ID = $student_fetch["student_ID"];
	  	$query = "Select * From teachcheck,teachday Where teachcheck.teachday_ID=teachday.teachday_ID and teachcheck.teach_ID='$teach_ID' and teachcheck.student_ID='$student_ID' Order By teachcheck.teachcheck_week,teachday.teachday_day";
	  	$teachcheck_query = mysql_query($query,$conn)or die(mysql_error());
	  	while($teach_check=mysql_fetch_assoc($teachcheck_query)){
		  	$check_result[$teach_check["teachcheck_week"]][$teach_check["teachday_ID"]]=$teach_check["teachcheck_result"];
	  }
  ?>
  <tr>
    <td height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <?php
	$miss = 0;
	$all=0;
	for($i=1;$i<$week;$i++){
		$query="Select teachday_ID,teachday_day,teachday_start,teachday_stop From teachday Where teach_ID='$teach_ID' Order By teachday_day ASC";
		$dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
		while($dayofweek_fetch=mysql_fetch_assoc($dayofweek_query)){
    		echo "<td align='center' valign='middle' class='blackRegula7' ";
			if($check_result[$i][$dayofweek_fetch["teachday_ID"]]!=""){
				if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==1)
					echo "bgcolor='#99FF99'>/</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==2)
					echo "bgcolor='#FFCC99'>ส</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==3)
					echo "bgcolor='#FFFF66'>ป</td>";
				else if($check_result[$i][$dayofweek_fetch["teachday_ID"]]==4)
					echo "bgcolor='#FFFF66'>ก</td>";
				else{
						echo "bgcolor='#FF6666'>ข</td>";
						if(substr($dayofweek_fetch["teachday_start"],0,2)<=12&&substr($dayofweek_fetch["teachday_stop"],0,2)>=13)
							$miss+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"]-1;
						else 
							$miss+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"];
				}
			}
			else
				echo "></td>";
			if(substr($dayofweek_fetch["teachday_start"],0,2)<=12&&substr($dayofweek_fetch["teachday_stop"],0,2)>=13)
				$all+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"]-1;
			else 
				$all+=$dayofweek_fetch["teachday_stop"]-$dayofweek_fetch["teachday_start"];
		}
	}
	?>
    <td align="center" valign="middle"><?php echo $all-$miss;?></td>
    </tr>
  <?php }} ?>
</table><br />
</center></div>