<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
include("../includefiles/sms.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$class_ID = $_GET["class_ID"];
if($_POST["flagpolecheck_bt"]=="บันทึก"){
	$check_date = $_POST["checkdate_txt"];
	$check_period = $_POST["checkperiod_txt"];
	$class_ID = $_POST["classID_txt"];
	$query = "Select * From student Where class_ID='$class_ID' and student_endstatus='0'";
	$student_query = mysql_query($query,$conn)or die(mysql_error());
	$stdn=0;
	list($ch_year,$ch_month,$ch_day) = split("-",$check_date);
	while($student_fetch=mysql_fetch_array($student_query)){
		$student_ID = $student_fetch["student_ID"];
		if(empty($_POST["flagin_ch"][$student_ID])){
			$student_parphone[$stdn] = $student_fetch["student_parphone"];
			$student_fullname[$stdn] = $student_fetch["student_name"]." ".$student_fetch["student_ser"];
			$stdn++;
		}
		$query = "Select * From flagcheck Where flagcheck_date='$check_date' and student_ID='$student_ID'";
		$existcheck_query = mysql_query($query,$conn)or die(mysql_error());
		if(mysql_num_rows($existcheck_query)<1){
			$query = "Insert into flagcheck(flagcheck_date,flagcheck_time,flagcheck_result,student_ID,personnel_ID,flagcheck_checkdate) Values('$check_date','".date("H:i:s")."','".$_POST["flagin_ch"][$student_ID]."','$student_ID','$personnel_ID','".date("Y-m-d H:i:s")."')";
			$flagcheck_inster = mysql_query($query,$conn)or die(mysql_error());
		}
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกการเช็คชื่อหน้าเสาธง '.$check_date;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Flagpolecheck','flagpole_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$sms = new siccsms();
	for($i=0;$i<$stdn;$i++){
		if(!empty($student_parphone[$i])){
			$smstxt = $student_fullname[$i]." ไม่เข้าแถวหน้าเสาธงวันที่ ".(int)$ch_day." ".$thmountbf[(int)$ch_month]." ".($ch_year+543).$sms->sms_from;
			$smsphone = $student_parphone[$i];
			$smsresult = $sms->sendsms($smsphone,$smstxt);
			if(substr($smsresult,7,1)=="0"){
				$userlogs_des="ส่ง sms แจ้งขาดแถววันที่ ".$check_date." ของ ".$student_fullname[$i];
				$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','flagpole_mis','$userlogs_des')";
				$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
			}
		}
	}
	echo "<script type='text/javascript'>
			alert('บันทึกข้อมูลเรียบร้อย');
			</script>";
}
if($_POST["editflagpolecheck_bt"]=="บันทึก"){
	$check_date = $_POST["checkdate_txt"];
	$check_period = $_POST["checkperiod_txt"];
	$class_ID = $_POST["classID_txt"];
	$query = "Select * From student Where class_ID='$class_ID' and student_endstatus='0'";
	$student_query = mysql_query($query,$conn)or die(mysql_error());
	while($student_fetch=mysql_fetch_array($student_query)){
		$student_ID = $student_fetch["student_ID"];
		$query = "Update flagcheck Set flagcheck_result='".$_POST["flagin_ch"][$student_ID]."',flagcheck_checkdate='".date("Y-m-d H:i:s")."' Where flagcheck_ID='".$_POST["flagcheckID_txt"][$student_ID]."' and flagcheck_result!='".$_POST["flagin_ch"][$student_ID]."'";
		$flagcheck_update = mysql_query($query,$conn)or die(mysql_error());
		if(mysql_affected_rows()<=0){
			$query = "Insert into flagcheck(flagcheck_date,flagcheck_time,flagcheck_result,student_ID,personnel_ID,flagcheck_checkdate) Values('$check_date','".date("H:i:s")."','".$_POST["flagin_ch"][$student_ID]."','$student_ID','$personnel_ID','".date("Y-m-d H:i:s")."')";
			$flagcheck_inster = mysql_query($query,$conn)or die(mysql_error());
		}
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='แก้ไขการเช็คชื่อหน้าเสาธง '.$check_date;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Flagpolecheck','flagpole_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	echo "<script type='text/javascript'>
			alert('แก้ไขข้อมูลเรียบร้อย');
			</script>";
}
if($_POST["canceledit_bt"]=="ยกเลิก"){
	$check_date = $_POST["checkdate_txt"];
	$check_period = $_POST["checkperiod_txt"];
	$class_ID = $_POST["classID_txt"];
}
if($_POST["datesearch_bt"]=="ค้นหา"){
	$check_date = $_POST["date_comb"];
	$check_period = $_POST["period_comb"];
	$class_ID = $_POST["classID_comb"];
}
if(empty($check_date)){
	$check_date=date("Y-m-d");
}
if(empty($check_period)){
	//$query = "Select * From period Order By period_year,period_term DESC";
	$query = "Select * From period Where period_start=(Select max(period_start) From period)";
	$period_query = mysql_query($query,$conn)or die(mysql_error());
	$period_fetch = mysql_fetch_array($period_query);
	$check_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
}

$query = "Select * From student Where class_ID='$class_ID' Order By student_ID ASC";
$student_query = mysql_query($query,$conn)or die(mysql_error());
//echo $check_period;
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#period_comb').change(function (){
		var period = $('#period_comb').select().val();
		$.get('perioddate.php',{'check_period':period},function(data){$('#date_comb').html(data)}); 
	});
	//date_comb
	//search
	$('#datesearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	//add
	$('#flagpolecheck').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	//edit
});
function consultdata(id){
	$.get('consultdata.php',{'class_ID':id},function(data){$('#systemcontent').html(data)});
}
function editflagpolecheck(class_ID, period, date){
	$.get('editflagpolecheck.php',{
		'class_ID':class_ID,
		'check_period':period,
		'check_date':date},function(data){$('#flagcheckarea').html(data)});
}
</script>
	<div id="statusbar">จัดการข้อมูลครูที่ปรึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="130"><a href="#" onclick="consultdata('<?php echo $class_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center>
  		<h2>เช็คชื่อเข้าแถวหน้าเสาธง</h2>
	<form id="datesearchform" action="flagpolecheck.php" method="post">
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
   	  </select><br />
            <b>ภาคเรียนที่ </b><select name="period_comb" id="period_comb">
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
			   $date_ch = ($flag_year*10000)+($flag_month*100)+$flag_day;
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
       	  <input name="datesearch_bt" type="submit" id="datesearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <div id="flagcheckarea">
        <?php
		if($date_sp>=$date_ch&&$date_st<=$todaydate){
		list($flag_term,$flag_tyear) = split("/",$check_period);
		if(jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=0&&jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)!=6){
		?>
        <form id="flagpolecheck" action="flagpolecheck.php" method="post">
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12pt">
                  <th height="50" colspan="5" bgcolor="#CCCCCC">
                  <?php		  
				  echo "ภาคเรียนที่ ".$flag_term." ปีการศึกษา ".($flag_tyear+543);
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
  <tr <?php if($flagcheck_fetch["flagcheck_result"]==0&&mysql_num_rows($flagcheck_query)>=1)echo "bgcolor='#FF6666'";?>>
    <td width="5%" height="30" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    
    <td align="center" valign="middle">
	<?php if(mysql_num_rows($flagcheck_query)<1){?>
    <input name="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" type="checkbox" id="flagin_ch[<?php echo $student_fetch["student_ID"];?>]" value="1" checked="checked" class="largerCheckbox"/>
   	<?php }else{ 
			$check_num++;
			if($flagcheck_fetch["flagcheck_result"]==1)
				echo "มา";
			else
				echo "ขาด";
		}?>
      </td>
    </tr>
  <?php 
  	}
  } 
  if($check_num==0){?>
  <tr >
    <td height="50" colspan="5" align="center" valign="middle"><input name="checkdate_txt" type="hidden" id="checkdate_txt" value="<?php echo $check_date;?>" />
<input name="checkperiod_txt" type="hidden" id="checkperiod_txt" value="<?php echo $check_period;?>" />
<input name="classID_txt" type="hidden" id="classID_txt" value="<?php echo $class_ID;?>" />
<input type="submit" name="flagpolecheck_bt" id="flagpolecheck_bt" value="บันทึก" /></td>
    </tr>
   <?php } ?>
</table>
</form>
<?php }} ?>
<br />
<?php if($check_num>0){ ?>
<div align="right"><a href="#" onclick="editflagpolecheck('<?php echo $class_ID;?>','<?php echo $check_period;?>','<?php echo $check_date;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<?php } ?>
</div>
</center></div>