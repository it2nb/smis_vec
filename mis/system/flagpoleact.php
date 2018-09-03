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
$last_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
$class_ID = $_GET["class_ID"];
if($_POST["classsearch_bt"]=="ค้นหา"){
	$check_date = $_POST["date_comb"];
	$check_period = $_POST["period_comb"];
	$class_ID = $_POST["classID_comb"];
}
if(empty($check_date)){
	$check_date=date("Y-m-d");
}
if(empty($check_period)){
	$check_period = $last_period;
}
$query = "Select * From student Where class_ID='$class_ID' Order By student_ID ASC";
$student_query = mysql_query($query,$conn)or die(mysql_error());
$query = "Select * From class Where class_ID='$class_ID'";
$class_query = mysql_query($query,$conn)or die(mysql_error());
$class_fetch = mysql_fetch_array($class_query);
$class_show=substr($check_period,2,4)-$class_fetch["year"];
if(substr($class_fetch["class_ID"],2,1)==2&&$class_show>2)
	$class_show=1;
else if(substr($class_fetch["class_ID"],2,1)==3&&$class_show>1)
	$class_show=1;
else
	$class_show=0;
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
function consultdata(id){
	$.get('consultdata.php',{'class_ID':id},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลครูที่ปรึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" onclick="consultdata('<?php echo $class_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/flagpoleactpdf.php?class_ID=$class_ID&check_period=$check_period";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
	<form id="classsearchform" action="flagpoleact.php" method="post">
        	<b>ค้นหา นักศึกษาในที่ปรึกษา กลุ่มเรียน </b>
       	  <select name="classID_comb" id="classID_comb">
        	  <?php
			  $query="Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and (personnel_ID='$personnel_ID' or personnel_ID2='$personnel_ID') Order By year DESC";
			  $class_query=mysql_query($query,$conn)or die(mysql_error());
			  while($class_fetch=mysql_fetch_array($class_query)){
				if($class_ID==$class_fetch["class_ID"])
				  	echo "<option value='".$class_fetch["class_ID"]."' selected='selected'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
				else
					echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
			  }
			  ?>
   	  </select>
       	  <b> ภาคเรียนที่</b>
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
        	</select>
            
       	  <input name="classsearch_bt" type="submit" id="classsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                    <th height="50" colspan="10" bgcolor="#CCCCCC">รายงานการเข้าร่วมกิจกรรมหน้าเสาธง ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></th>
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ทั้งหมด(วัน)</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนวันที่ทำการเช็คชื่อ</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มา(วัน)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ขาด(วัน)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การเข้าร่วม</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ผลลัพธ์</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
    </tr>
  <?php
  	list($flag_term,$flag_tyear) = split("/",$check_period);
  	$query = "Select * From period Where period_year='$flag_tyear' and period_term='$flag_term'";
  	$yearterm_query = mysql_query($query,$conn)or die(mysql_error());
  	$yearterm_fetch = mysql_fetch_array($yearterm_query);
  	$allday=0;
  	list($st_year,$st_month,$st_day) = split("-",$yearterm_fetch["period_start"]);
  	list($sp_year,$sp_month,$sp_day) = split("-",$yearterm_fetch["period_end"]);
  	$date_st = ($st_year*10000)+($st_month*100)+$st_day;
	$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
	list($flag_year,$flag_month,$flag_day) = split("-",$check_date);
	while($date_st<=$date_sp){
	  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,(int)$st_day,$st_year),0)!=6){
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
  while($student_fetch=mysql_fetch_array($student_query))
  {
	  if($student_fetch["student_endstatus"]==0||$class_show==1){
		  $student_ID = $student_fetch["student_ID"];
		  $query = "Select count(student_ID) as flagcheck,sum(flagcheck_result) as flagresult From flagcheck Where student_ID='$student_ID' and flagcheck_date between '".$yearterm_fetch["period_start"]."' And '".$yearterm_fetch["period_end"]."'";
		  $checkday_query = mysql_query($query,$conn)or die(mysql_error());
		  $checkday_fetch = mysql_fetch_array($checkday_query);
		  $result_percent = round((($checkday_fetch["flagresult"]+($allday-$checkday_fetch["flagcheck"]))/$allday)*100,2);
  ?>
  <tr
  <?php
  	if($result_percent<80)
		echo "bgcolor='#FF6666'";
	else if($result_percent<85)
		echo "bgcolor='#FFCC99'";
	else if($result_percent<90)
		echo "bgcolor='#FFFF99'";
  ?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle"><?php echo $allday;?></td>
    <td align="center" valign="middle"><?php echo $checkday_fetch["flagcheck"];?></td>
    <td align="center" valign="middle"><?php echo $checkday_fetch["flagresult"];?></td>
    <td align="center" valign="middle"><?php echo $checkday_fetch["flagcheck"]-$checkday_fetch["flagresult"];?></td>
    <td align="center" valign="middle"><?php echo $result_percent;?></td>
    <td align="center" valign="middle">
    <?php
	if($result_percent>=80)
		echo "ผ่าน";
	else
		echo "ไม่ผ่าน";
    ?>
    </td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php }} ?>
    </table><br />
</center></div>