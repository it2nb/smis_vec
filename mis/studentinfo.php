<?php
require_once("includefiles/connectdb.php");
include("includefiles/datalist.php");
include("includefiles/datetimefunc.php");
if($_POST["search_bt"]=="ค้นหา"){
	$studentcode = $_POST["studentID_txt"];
	if(strlen($studentcode)==10){
		$display="half";
		$query="Select * From student Where student_ID='$studentcode'";
	}
	else if(strlen($studentcode)==13){
		$display="full";
		$query="Select * From student Where personnelcard_ID='$studentcode' and student_ID=(Select max(student_ID) From student Where personnelcard_ID='$studentcode')";
	}
	else{
		$display="none";
	}
	if($display=="half"||$display=="full"){
		$student_query=mysql_query($query,$conn)or die(mysql_error());
		$student_ID=mysql_result($student_query,0,"student_ID");
		if(empty($student_ID))
			$display="none";
	}
}
else
	$display="none";

$caldatetime = new datetimefunc();
$today=date("Y-m-d");
list($year,$month,$day) = split("-",$today);
$dayt=jddayofweek(gregoriantojd($month,$day,$year),0);
$query = "Select * From period Where period_start=(Select max(period_start) From period)";
$period_query = mysql_query($query,$conn)or die(mysql_error());
$period_fetch = mysql_fetch_array($period_query);
$thisperiod = $period_fetch["period_term"]."/".$period_fetch["period_year"];
list($pterm,$pyear) = split("/",$thisperiod);
$thisweek = $caldatetime->getweek($today,$period_fetch["period_start"],$period_fetch["period_end"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ข้อมูลนักเรียนนักศึกษา</title>
<style type="text/css">
#maindiv {
	width: 100%;
	text-align: center;
}
#maindiv #formdiv {
	width: 100%;
	background-color: #06C;
	color: #FFF;
	padding-top: 20px;
	padding-right: 0px;
	padding-bottom: 20px;
	padding-left: 0px;
}
#maindiv #infodiv {
	width: 100%;
	padding-top: 20px;
	padding-right: 0px;
	padding-bottom: 20px;
	padding-left: 0px;
}
.table_dash_bt {
	border-bottom-width: thin;
	border-bottom-style: dashed;
	border-bottom-color: #000;
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="maindiv">
  <div id="formdiv">
    	<h1>ตรวจสอบข้อมูลการเรียนของนักเรียนนักศึกษา</h1>
      <h2>วิทยาลัย...</h2>
        <hr color="#333333"/>
        <br />
    	<form action="studentinfo.php" method="post" >
        	<b>ป้อนรหัส :</b> <input name="studentID_txt" type="text" id="studentID_txt" size="20" maxlength="20" />
            <input type="submit" value="ค้นหา" name="search_bt" id="search_bt" />
      </form>
    </div>
    <div id="infodiv">
    <?php
	if($display!="none"){
		echo "<h3>รหัสนักศึกษา ".mysql_result($student_query,0,"student_ID")." ชื่อ ".mysql_result($student_query,0,"student_prefix").mysql_result($student_query,0,"student_name")." ".mysql_result($student_query,0,"student_ser");
		$query="Select * From major Where major_ID='".mysql_result($student_query,0,"major_ID")."'";
		$major_query = mysql_query($query,$conn)or die(mysql_error());
		$major_fetch = mysql_fetch_assoc($major_query);
		echo " สาขางาน ".$major_fetch["major_name"]."</h3>";
		echo "<hr width='80%'>";
		echo "<b>วัน".$thday[$dayt]." ที่ ".(int)$day." เดือน ".$thmonth[(int)$month]." พ.ศ ".($year+543)."</b><br>";
		if($dayt!=6&&$dayt!=0){
			$query = "Select * From flagcheck Where flagcheck_date='$today' and student_ID='$student_ID'";
			$flagcheck_query = mysql_query($query,$conn)or die(mysql_error());
	?>
    <table width="70%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td height="30" colspan="2" align="left" valign="middle" class="table_dash_bt">การเข้าร่วมกิจกรรมหน้าเสาธง</td>
    <td width="20%" align="center" valign="middle" class="table_dash_bt" <?php 
	if(mysql_num_rows($flagcheck_query)>0){
		if(mysql_result($flagcheck_query,0,"flagcheck_result")==1)
  			echo "bgcolor='#99FF99'";
		else
			echo "bgcolor='#FF6666'";
	}
	else{
			echo "bgcolor='#FFFFCC'";
	}
  ?>>
    <?php
		if(mysql_num_rows($flagcheck_query)==0)
			echo "-";
		else{
			if(mysql_result($flagcheck_query,0,"flagcheck_result")==1)
				echo "มา";
			else
				echo "ขาด";
		}
	?>
    </td>
  </tr>
  <tr class="table_dash_bt">
    <td height="30" colspan="2" align="left" valign="middle" class="table_dash_bt">การเข้าชั้นเรียน</td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <?php
  	$query="Select teach.*,teachstd.student_ID,teachday.* From teach,teachstd,teachday Where student_ID='$student_ID' and teach_term='$pterm' and teach_year='$pyear' and teachday_day='$dayt' and teach.teach_ID=teachstd.teach_ID and teach.teach_ID=teachday.teach_ID Order By teachday_start ASC";
	$teach_query = mysql_query($query,$conn)or die(mysql_error());
	while($teach_fetch=mysql_fetch_assoc($teach_query)){
		$query="Select * From subject Where subject_ID='".$teach_fetch["subject_ID"]."' and course_ID='".$teach_fetch["course_ID"]."'";
		$subject_query = mysql_query($query,$conn)or die(mysql_error());
		$query = "Select * From teachcheck Where teachday_ID='".$teach_fetch["teachday_ID"]."' and teachcheck_week='$thisweek' and student_ID='$student_ID'";
		$teachcheck_query = mysql_query($query,$conn)or die(mysql_error());
		$teachcheck_fetch = mysql_fetch_assoc($teachcheck_query);
  ?>
  <tr>
    <td width="10%" height="30" align="right">&nbsp;</td>
    <td align="left" valign="middle" class="table_dash_bt"><?php echo substr($teach_fetch["teachday_start"],0,5)."-".substr($teach_fetch["teachday_stop"],0,5)." : วิชา".mysql_result($subject_query,0,"subject_name");?></td>
    <td align="center" valign="middle" class="table_dash_bt" <?php 
	if(mysql_num_rows($teachcheck_query)>=1){
		if($teachcheck_fetch["teachcheck_result"]==0)
  			echo "bgcolor='#FF6666'";
		else if($teachcheck_fetch["teachcheck_result"]==1)
  			echo "bgcolor='#99FF99'";
		else if($teachcheck_fetch["teachcheck_result"]==2)
  			echo "bgcolor='#FFCC99'";
		else if($teachcheck_fetch["teachcheck_result"]>2)
			echo "bgcolor='#FFFF66'";
		else
			echo "bgcolor='#FFFFCC'";
	}
	else{
			echo "bgcolor='#FFFFCC'";
	}
  ?>>
    <?php if(mysql_num_rows($teachcheck_query)<1){
		echo "-";
	}
	else{
		if($teachcheck_fetch["teachcheck_result"]==1)
			echo "มา";
		else if($teachcheck_fetch["teachcheck_result"]==2)
			echo "มาสาย";
		else if($teachcheck_fetch["teachcheck_result"]==3)
			echo "ลาป่วย";
		else if($teachcheck_fetch["teachcheck_result"]==4)
			echo "ลากิจ";
		else
			echo "ขาด";
	}
	?>
    </td>
  </tr>
  <?php } ?>
</table>
   <hr width="80%"/>
    <?php 
		}
	} 
	if($display!="none"){
		if(substr($student_ID,2,1)=='2')
			$lyear="25".(substr($student_ID,0,2)+7);
		else
			$lyear="25".(substr($student_ID,0,2)+3);
		for($dyear=$lyear;substr($dyear,2,2)>=substr($student_ID,0,2);$dyear--){
			if($dyear<=($period_fetch["period_year"]+543)){
				for($dterm=2;$dterm>=1;$dterm--){
					if($dyear!=($period_fetch["period_year"]+543)||$dterm<=$period_fetch["period_term"]){
						$query = "Select * From period Where period_year='".($dyear-543)."' and period_term='$dterm'";
  						$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
  						$yearterm_fetch = mysql_fetch_assoc($yearterm_query);
						if(mysql_num_rows($yearterm_query)>0)
							$allday = $caldatetime->getalldayinperiod($yearterm_fetch["period_start"],$yearterm_fetch["period_end"]);

						//เข้าแถว
						$query = "Select count(student_ID) as flagcheck,sum(flagcheck_result) as flagresult From flagcheck Where student_ID='$student_ID' and flagcheck_date between '".$yearterm_fetch["period_start"]."' And '".$yearterm_fetch["period_end"]."'";
		  				$checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  				$checkday_fetch = mysql_fetch_assoc($checkday_query);
		  				$result_percent = round((($checkday_fetch["flagresult"]+($allday-$checkday_fetch["flagcheck"]-5))/($allday-5))*100,2);
						//การเรียน
						$query="Select * From teach,teachstd Where teach.teach_ID=teachstd.teach_ID and student_ID='$student_ID' and teach_term='$dterm' and teach_year='".($dyear-543)."' Order By subject_ID ASC";
						$teach_query=mysql_query($query,$conn) or die(mysql_error());
	?>
    <hr width="80%"/>
      <h3>ภาคเรียนที่ <?php echo $dterm."/".$dyear;?></h3>
   <b>กิจกรรมหน้าเสาธง</b>
   <table width="50%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000" align="center">
   <tr>
   	<td width="25%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>มา</strong></td>
    <td width="25%" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ขาด</strong></td>
    <td width="25%" align="center" valign="middle" bgcolor="#CCCCCC"><strong>เปอร์เซนต์การเข้าร่วม</strong></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><strong>ผลลัพธ์</strong></td>
   </tr>
   <tr>
   	<td height="30" align="center" valign="middle"><?php echo $checkday_fetch["flagresult"];?></td>
    <td align="center" valign="middle"><?php echo $checkday_fetch["flagcheck"]-$checkday_fetch["flagresult"];?></td>
    <td align="center" valign="middle"><?php echo $result_percent;?></td>
    <td align="center" valign="middle"
	<?php
  	if($result_percent<80)
		echo "bgcolor='#FF6666'";
	else if($result_percent<85)
		echo "bgcolor='#FFCC99'";
	else if($result_percent<90)
		echo "bgcolor='#FFFF99'";
	else
		echo "bgcolor='#99FF99'";
  ?>>
    <?php
	if($result_percent>=80)
		echo "ผ่าน";
	else
		echo "ไม่ผ่าน";
    ?>
    </td>
   </tr>
   <tr>
     <td height="30" colspan="4" align="left" valign="middle">
     <details>
		<summary>วันที่ขาดการเข้าร่วมกิจกรรมหน้าเสาธง (คลิ๊กเพื่อดู)</summary>
        <?php
		$query = "Select flagcheck_date From flagcheck Where student_ID='$student_ID' and flagcheck_date between '".$yearterm_fetch["period_start"]."' And '".$yearterm_fetch["period_end"]."' and flagcheck_result='0' Order By flagcheck_date ASC";
		$missflag_query=mysql_query($query,$conn)or die(mysql_error());
		while($missflag_fetch=mysql_fetch_assoc($missflag_query)){
			list($missflag_year,$missflag_month,$missflag_day) = split("-",$missflag_fetch["flagcheck_date"]);
			$missflag_dayt=jddayofweek(gregoriantojd($missflag_month,$missflag_day,$missflag_year),0);
			echo "วัน".$thday[$missflag_dayt]." ที่ ".(int)$missflag_day." เดือน ".$thmonth[(int)$missflag_month]." พ.ศ ".($missflag_year+543)."<br>";
		}
		?>
     </details>
     </td>
     </tr>
   </table>
   <br />
   <b>เวลาเรียน</b>
   <table width="80%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000">
   <tr>
   	<td width="10%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>รหัสวิชา</strong></td>
    <td height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ชื่อวิชา</strong></td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>วัน เวลา</strong></td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ครูผู้สอน</strong></td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>มา</strong></td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>มาสาย</strong></td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ลาป่วย</strong></td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ลากิจ</strong></td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ขาด</strong></td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>เปอร์เซ็นการเข้าเรียน</strong></td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>ผลลัพธ์</strong></td>
   </tr>
   <?php
   while($teach_fetch=mysql_fetch_assoc($teach_query)){
	   	$query="Select subject_name From subject Where subject_ID='".$teach_fetch["subject_ID"]."'";
	   	$subject_query=mysql_query($query,$conn)or die(mysql_error());
	   	$query="Select * From teachday Where teach_ID='".$teach_fetch["teach_ID"]."' Order By teachday_day ASC";
		$teachday_query=mysql_query($query,$conn)or die(mysql_error());
	   	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$teach_fetch["personnel_ID"]."'";
	   	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		$query="Select count(teachcheck_ID) as come From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='1'";
		$come_query = mysql_query($query,$conn)or die(mysql_error());
		$query="Select count(teachcheck_ID) as late From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='2'";
		$late_query = mysql_query($query,$conn)or die(mysql_error());
		$query="Select count(teachcheck_ID) as sick From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='3'";
		$sick_query = mysql_query($query,$conn)or die(mysql_error());
		$query="Select count(teachcheck_ID) as buss From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='4'";
		$buss_query = mysql_query($query,$conn)or die(mysql_error());
		$query="Select count(teachcheck_ID) as miss From teachcheck Where teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='0'";
		$miss_query = mysql_query($query,$conn)or die(mysql_error());
	   	$query = "Select sum(teachday_hour) as summisshour From teachday,teachcheck Where teachcheck.teach_ID='".$teach_fetch["teach_ID"]."' and student_ID='$student_ID' and teachcheck_result='0' and teachday.teachday_ID=teachcheck.teachday_ID";
		$summisshour_query = mysql_query($query,$conn)or die(mysql_error());
		$query="Select sum(teachday_hour) as sumteachhour From teachday Where teach_ID='".$teach_fetch["teach_ID"]."' Order By teachday_day ASC";
		$sumteachhour_query=mysql_query($query,$conn)or die(mysql_error());
		$percent = (((mysql_result($sumteachhour_query,0,"sumteachhour")*18)-mysql_result($summisshour_query,0,"summisshour"))/(mysql_result($sumteachhour_query,0,"sumteachhour")*18))*100;
   ?>
   <tr>
     <td height="30" align="center" valign="middle"><?php echo $teach_fetch["subject_ID"];?></td>
     <td height="30" align="left" valign="middle"><?php echo mysql_result($subject_query,0,"subject_name");?></td>
     <td height="30" align="left" valign="middle">
	 <?php
		while($teachday_fetch=mysql_fetch_assoc($teachday_query)){
			echo "วัน".$thday[$teachday_fetch["teachday_day"]]." (".substr($teachday_fetch["teachday_start"],0,5)."-".substr($teachday_fetch["teachday_stop"],0,5).")<br>";
		}
    ?>
    </td>
     <td height="30" align="left" valign="middle"><?php echo mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser");?></td>
     <td height="30" align="center" valign="middle"><?php echo mysql_result($come_query,0,"come");?></td>
     <td height="30" align="center" valign="middle"><?php echo mysql_result($late_query,0,"late");?></td>
     <td height="30" align="center" valign="middle"><?php echo mysql_result($sick_query,0,"sick");?></td>
     <td height="30" align="center" valign="middle"><?php echo mysql_result($buss_query,0,"buss");?></td>
     <td height="30" align="center" valign="middle"><?php echo mysql_result($miss_query,0,"miss");?></td>
     <td height="30" align="center" valign="middle"><?php echo round($percent,2);?></td>
     <td height="30" align="center" valign="middle"
     <?php
  	if($percent<80)
		echo "bgcolor='#FF6666'";
	else if($percent<85)
		echo "bgcolor='#FFCC99'";
	else if($percent<90)
		echo "bgcolor='#FFFF99'";
	else
		echo "bgcolor='#99FF99'";
  ?>><?php 
  	if($percent>=80)
		echo "เวลาเรียนครบ";
	else
		echo "เวลาเรียนไม่ครบ";
	?></td>
   </tr>
   <?php }?>
   <tr>
     <td height="30" colspan="11" align="left" valign="middle">
     <details>
		<summary>วันที่ขาดการเรียน (คลิ๊กเพื่อดู)</summary>
		<?php
		$query = "Select teachcheck_week,teachday_day,subject_ID From teachcheck,teachday,teach Where student_ID='$student_ID' and teach_term='$dterm' and teach_year='".($dyear-543)."' and teachcheck_result='0' and teach.teach_ID=teachcheck.teach_ID and teachcheck.teachday_ID=teachday.teachday_ID Order By teachcheck_week ASC,teachday_day ASC";
		$missteach_query=mysql_query($query,$conn)or die(mysql_error());
		while($missteach_fetch=mysql_fetch_assoc($missteach_query)){
			//$spdate = new DateTime($yearterm_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
			$missdate = new DateTime($yearterm_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
			date_modify($missdate,("+".((($missteach_fetch["teachcheck_week"]-1)*7)+($missteach_fetch["teachday_day"]-1))." day"));
			$missdate = $missdate->format("Y-m-d");
			list($missflag_year,$missflag_month,$missflag_day) = split("-",$missdate);
			$missflag_dayt=jddayofweek(gregoriantojd($missflag_month,$missflag_day,$missflag_year),0);
			echo "วัน".$thday[$missflag_dayt]." ที่ ".(int)$missflag_day." เดือน ".$thmonth[(int)$missflag_month]." พ.ศ ".($missflag_year+543);
			$query = "Select subject_name From subject Where subject_ID='".$missteach_fetch["subject_ID"]."'";
			$subjectname_query = mysql_query($query,$conn)or die(mysql_error());
			echo " ( วิชา".mysql_result($subjectname_query,0,"subject_name")." )<br>"; 
		}
		?>
     </details>
     </td>
     </tr>
   </table>
   <hr width="80%"/>
    <?php
					}
				}
			}
		}
	} ?>
  </div>
</div>
</body>
</html>