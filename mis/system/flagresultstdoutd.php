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
$query = "Select * From period Where period_start=(Select max(period_start) From period)";
$period_query = mysql_query($query,$conn)or die(mysql_error());
$period_fetch = mysql_fetch_array($period_query);
$last_year = $period_fetch["period_year"];
$last_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
if($_POST["periodsearch_bt"]=="ค้นหา"){
	$check_date = $_POST["date_comb"];
	$check_period = $_POST["period_comb"];
	$check_year = substr($_POST["period_comb"],2,4);
}
if(empty($check_date)){
	$check_date=date("Y-m-d");
}
if(empty($check_period)){
	$check_year = $last_year;
	$check_period = $last_period;
}
$styear=$check_year-3;
$query = "Select class.*,flagcheck.flagcheck_result,student.* From class,flagcheck,student Where class.class_ID=student.class_ID and student.student_ID=flagcheck.student_ID and flagcheck.flagcheck_date='$check_date' and flagcheck_result='0' and student.class_ID like '__2_____' Order By student.class_ID DESC";
$studentvo_query=mysql_query($query,$conn) or die(mysql_error());	
$query = "Select class.*,flagcheck.flagcheck_result,student.* From class,flagcheck,student Where class.class_ID=student.class_ID and student.student_ID=flagcheck.student_ID and flagcheck.flagcheck_date='$check_date' and flagcheck_result='0' and student.class_ID like '__3_____' Order By student.student_ID DESC";
$studentde_query=mysql_query($query,$conn) or die(mysql_error());	
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#studentresult').click(function(){
		$('#systemcontent').load('studentresult.php');
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
function consultdata(id){
	$.get('consultdata.php',{'class_ID':id},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">ข้อมูลผู้ขาดการเข้าร่วมกิจกรรมหน้าเสาธงแบบรายวัน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="128"><a href="#" id="studentresult"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
	<form id="periodsearchform" action="flagresultstdoutd.php" method="post">
        	<b>ค้นหา ภาคเรียนที่</b>
       	  &nbsp;
          <select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_array($period_query)){
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
			  $date_fetch = mysql_fetch_array($date_query);
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
            &nbsp;
       	  <input name="periodsearch_bt" type="submit" id="periodsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <?php
        list($flag_term,$flag_tyear) = split("/",$check_period);
		if(jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=0&&jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=6){
		?>
         <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="6" bgcolor="#CCCCCC">
			  รายงานจำนวนผู้ขาดการเข้าร่วมกิจกรรมหน้าเสาธงประจำวัน<br />
			  <?php		  
				  echo " วัน".$thday[jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)]." ที่ ".(int)$flag_day." ".$thmonth[(int)$flag_month]." ".((int)$flag_year+543);
				  ?></th>
              
          <tr>
            <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
            <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
            <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - สกุล</td>
            <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขา</td>
    <td width="25%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
          </tr>
  <?php
  $allvo=0;
  while($student_fetch=mysql_fetch_array($studentvo_query))
  {
	  	$student_show=$check_year-$student_fetch["year"];
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_array($personnel_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_array($personnel_query);
		$allvo++;
  ?>
  <tr >
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><?php echo "ปวช ".($student_show+1)." สาขา".$student_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php 
  }
  	$query = "Select count(student_ID) as sumvo From student,class Where student.class_ID=class.class_ID and student.student_endstatus='0' and student.student_ID like '__2_______' and class.year>'$styear'";
	$sumvo_query = mysql_query($query,$conn)or die(mysql_error());
	$sumvo_fetch = mysql_fetch_array($sumvo_query);
	$sumvo = $sumvo_fetch["sumvo"];
	$percentvo = round(($allvo/$sumvo)*100,2);
  ?><tr bgcolor="#FFFF99">
     <td height="25" colspan="3" align="center" valign="middle"><b>รวม ปวช.</b></td>
     <td height="25" colspan="3" align="center" valign="middle"><b><?php echo "ขาดจำนวน $allvo คน จาก $sumvo คน คิดเป็น $percentvo %";?></b></td>
     </tr>
  
   <?php
   $allde=0;
  while($student_fetch=mysql_fetch_array($studentde_query))
  {
	  	$student_show=$check_year-$student_fetch["year"];
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_array($personnel_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$student_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_array($personnel_query);
		$allde++;
  ?>
  <tr >
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><?php echo "ปวส ".($student_show+1)." สาขา".$student_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php 
  }
  	$query = "Select count(student_ID) as sumde From student,class Where student.class_ID=class.class_ID and student.student_endstatus='0' and student.student_ID like '__3_______' and class.year>'".($styear+1)."'";
	$sumde_query = mysql_query($query,$conn)or die(mysql_error());
	$sumde_fetch = mysql_fetch_array($sumde_query);
	$sumde = $sumde_fetch["sumde"];
	$percentde = round(($allde/$sumde)*100,2);
  ?><tr bgcolor="#FFFF99">
     <td height="25" colspan="3" align="center" valign="middle"><b>รวม ปวส.</b></td>
     <td height="25" colspan="3" align="center" valign="middle"><b><?php echo "ขาดจำนวน $allde คน จาก $sumde คน คิดเป็น $percentde %";?></b></td>
     </tr>
   <tr bgcolor="#FFFF99">
     <td height="25" colspan="3" align="center" valign="middle"><b>รวม ทั้งหมด</b></td>
     <td height="25" colspan="3" align="center" valign="middle"><b><?php echo "ขาด ".($allvo+$allde)." คน จาก ".($sumvo+$sumde)." คน คิดเป็น ".(round((($allvo+$allde)/($sumvo+$sumde))*100,2))." %";?></b></td>
     </tr>
</table><?php }?><br />
</center></div>