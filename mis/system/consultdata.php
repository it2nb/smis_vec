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
if($_POST["classsearch_bt"]=="ค้นหา"){
	$class_ID = $_POST["classID_comb"];
}
else{
	$class_ID = $_GET["class_ID"];
	if(empty($class_ID)){
		$query = "Select max(class_ID) as maxclass_ID From class Where personnel_ID='$personnel_ID' or personnel_ID2='$personnel_ID'";
		$maxclassID_query = mysql_query($query,$conn)or die(mysql_error());
		$maxclassID_fetch = mysql_fetch_assoc($maxclassID_query);
		$class_ID = $maxclassID_fetch["maxclass_ID"];
	}
}
if(empty($check_period)){
	$query = "Select * From period Where period_start=(Select max(period_start) From period)";
	$period_query = mysql_query($query,$conn)or die(mysql_error());
	$period_fetch = mysql_fetch_assoc($period_query);
	$check_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
	$thisyear=substr($period_fetch["period_year"]+543,2,2);
}
$query = "Select * From student Where class_ID='$class_ID' Order By student_ID ASC";
$student_query = mysql_query($query,$conn)or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
$query="Select * From teachstd";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
echo "<script type='text/javascript'>
		var class_ID='".$class_ID."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#stdparentft').click(function(){
		$.get('stdparentft.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data);});
	});
	$('#teachdatacons').click(function(){
		$.get('teachdatacons.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachresultmissdayc').click(function(){
		$.get('teachresultmissdayc.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachresultmisstermc').click(function(){
		$.get('teachresultmisstermc.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#flagpoleact').click(function(){
		$.get('flagpoleact.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#flagpolecheck').click(function(){
		$.get('flagpolecheck.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#consultrec').click(function(){
		$.get('consultrec.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data)});
	});
	//search
	$('#classsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#addconsultationform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function deleteconsult(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบนักศึกษาในที่ปรึกษาชื่อ "+txt);
	if(conf==true)
		$.get('consultdata.php',{
			'student_ID':id,
			'year':year,
			'term':term,
			'consultdelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
function deleteconsultation(id){
	var conf = confirm("คุณแน่ใจว่าจะลบการพบที่ปรึกษา");
	if(conf==true)
		$.get('consultdata.php',{
			'consultation_ID':id,
			'year':year,
			'term':term,
			'consultationdelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลครูที่ปรึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    <td align="left" valign="middle" width="64">
        	<a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
        </td>
      <td align="left" valign="middle" width="64"><a href="#" id="stdparentft"><img src="../images/icons/64/stdparent.png" width="64" height="64" /></a></td>
      <td align="left" valign="middle" width="192"><a href="#" id="teachdatacons"><img width="64" height="64" src="../images/icons/64/stdlearn.png"/></a><a href="#" id="teachresultmissdayc"><img src="../images/icons/64/stdlearnmissday.png" width="64" height="64" /></a><a href="#" id="teachresultmisstermc"><img src="../images/icons/64/stdlearnmissterm.png" width="64" height="64" /></a></td>
    	<td align="left" valign="middle" width="128">
        	<a href="#" id="flagpoleact"><img src="../images/icons/64/flagact.png" width="64" height="64" /></a><a href="#" id="flagpolecheck"><img src="../images/icons/64/flagcheck.png" width="64" height="64" /></a>
        </td>
    	<td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    <td align="center" valign="middle"><b>ความคุม</b></td>
      <td align="center" valign="middle"><strong>ข้อมูล</strong></td>
      <td align="center" valign="middle"><strong>การเรียน</strong></td>
    	<td align="center" valign="middle"><b>กิจกรรมหน้าเสาธง</b></td>
    	<td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center><br />
  		<form id="classsearchform" action="consultdata.php" method="post">
        	<b>ค้นหา นักศึกษาในที่ปรึกษา กลุ่มเรียน </b>
       	  <select name="classID_comb" id="classID_comb">
        	  <?php
			  $query="Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and (personnel_ID='$personnel_ID' or personnel_ID2='$personnel_ID') Order By year DESC";
			  $class_query=mysql_query($query,$conn)or die(mysql_error());
			  while($class_fetch=mysql_fetch_assoc($class_query)){
				if($class_ID==$class_fetch["class_ID"])
				  	echo "<option value='".$class_fetch["class_ID"]."' selected='selected'>".$class_fetch["area_level"].".".($thisyear-substr($class_fetch["class_ID"],0,2)+1)."/".substr($class_fetch["class_ID"],7,1)." สาขา".$class_fetch["major_name"]."</option>";
				else
					echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["area_level"].".".($thisyear-substr($class_fetch["class_ID"],0,2)+1)."/".substr($class_fetch["class_ID"],7,1)." สาขา".$class_fetch["major_name"]."</option>";
			  }
			  ?>
       	  </select><b> </b>
       	  &nbsp;
       	  <input name="classsearch_bt" type="submit" id="classsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <?php
		$query = "Select * From class Where class_ID='$class_ID'";
		$class_query=mysql_query($query,$conn)or die(mysql_error());
		$class_fetch=mysql_fetch_assoc($class_query);
		?>
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <th height="50" colspan="6" bgcolor="#CCCCCC">ข้อมูลนักเรียนนักศึกษาในที่ปรึกษา ระดับ <?php echo $class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." รหัส ".substr($class_fetch["class_ID"],0,2);?> ( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การเข้ากิจกรรมหน้าเสาธง</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การเข้าร่วมกิจกรรมกลาง</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ผลการเรียน</td>
    </tr>
  <?php
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
  ?>
  <tr <?php
  if($student_fetch["student_endstatus"]!=0)
  	echo "bgcolor='#666666'";
  else
  	if($n%2)
		echo 'bgcolor="#FFFFCC"';
  ?> >
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle">
	<?php 
	$student_startyear = $student_fetch["student_startyear"];
	$student_endyear = $student_fetch["student_endyear"];
	if(empty($student_endyear))
		$student_endyear = (date("Y")+543);
	else
		$student_endyear +=543;
	$query = "Select * From period Where period_year Between '$student_startyear' And '$student_endyear' Order By period_start ASC";
  	$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
  	while($yearterm_fetch = mysql_fetch_assoc($yearterm_query)){
  	$allday=0;
  	list($st_year,$st_month,$st_day) = split("-",$yearterm_fetch["period_start"]);
  	list($sp_year,$sp_month,$sp_day) = split("-",$yearterm_fetch["period_end"]);
  	$date_st = ($st_year*10000)+($st_month*100)+$st_day;
	$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
	list($flag_year,$flag_month,$flag_day) = split("-",$check_date);
	while($date_st<=$date_sp){
	  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=6){
			$allday++;
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
	$allday=$allday-5;
	if($student_fetch["student_endstatus"]==0){
		  $student_ID = $student_fetch["student_ID"];
		  $query = "Select count(student_ID) as flagcheck,sum(flagcheck_result) as flagresult From flagcheck Where student_ID='$student_ID' and flagcheck_date between '".$yearterm_fetch["period_start"]."' And '".$yearterm_fetch["period_end"]."'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_assoc($checkday_query);
		  $result_percent = round((($checkday_fetch["flagresult"]+($allday-$checkday_fetch["flagcheck"]))/$allday)*100,2);
		  echo $result_percent." (".$yearterm_fetch["period_term"]."/".($yearterm_fetch["period_year"]+543).")<br>";
		  }
	}
	?></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">
	<?php 
	$student_ID=$student_fetch['student_ID'];
	$query = "Select * From period Where period_start=(Select max(period_start) From period)";
  	$lastterm_query = mysql_query($query,$conn)or die(mysql_error());
	$lastterm_fetch = mysql_fetch_assoc($lastterm_query);
	$g=1;
	$start_term=1;
	$start_year=$student_startyear;
  	//do{
	for($g=1;$g<=9;$g++){
		$dbconnection->setDbName($grade_db);
		$query = 'Select tolpoint,tolpoint'.$g.',point'.$g.' from avgrade where code="'.$student_ID.'"';
		$grade_query = mysql_query($query,$conn)or die(mysql_error());
		$grade_fetch = mysql_fetch_assoc($grade_query);
		if($grade_fetch['tolpoint'.$g]>0){
			echo $grade_fetch['point'.$g];
			echo " (เทอม ".$start_term.")<br>";
		}
		$dbconnection->setDbName($smis_db);
		//$g++;
		$start_term++;
		//if($start_term>2){
			//$start_year++;
			//$start_term=1;
		//}
	}//while($start_year<=$lastterm_fetch['period_year']);
	$dbconnection->setDbName($grade_db);
	echo '<b>เกรดเฉลี่ย '.$grade_fetch['tolpoint'].'</b>';
	$dbconnection->setDbName($smis_db);
	?>
    </td>
    </tr>
  <?php } ?>
</table><br />
</div>