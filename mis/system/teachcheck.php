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
$teach_ID = $_GET["teach_ID"];
if($_POST["teachcheck_bt"]=="บันทึก"){
	$teachday_ID = $_POST["teachdayID_txt"];
	$week = $_POST["week_txt"];
	$check_date = $_POST["checkdate_txt"];
	$teach_ID = $_POST["teachID_txt"];
	$query = "Select * From teach,subject Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.teach_ID='$teach_ID'";
	$teach_query = mysql_query($query,$conn)or die(mysql_error());
	$teach_fetch = mysql_fetch_assoc($teach_query);
	$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID' and student.student_endstatus=0";
	$student_query = mysql_query($query,$conn)or die(mysql_error());
	$stdn=0;
	list($ch_year,$ch_month,$ch_day) = split('-',$check_date);
	while($student_fetch=mysql_fetch_assoc($student_query)){
		$student_ID = $student_fetch["student_ID"];
		if(empty($_POST["teachin_comb"][$student_ID])){
			$student_parphone[$stdn] = $student_fetch["student_parphone"];
			$student_fullname[$stdn] = $student_fetch["student_name"]." ".$student_fetch["student_ser"];
			$stdn++;
		}
		$query = "Select * From teachcheck Where teachday_ID='$teachday_ID' and teachcheck_week='$week' and student_ID='$student_ID'";
		$existcheck_query = mysql_query($query,$conn)or die(mysql_error());
		if(mysql_num_rows($existcheck_query)<1){
			$query = "Insert into teachcheck(teachday_ID,teachcheck_week,teachcheck_result,student_ID,teach_ID,teachcheck_checkdate) Values('$teachday_ID','$week','".$_POST["teachin_comb"][$student_ID]."','$student_ID','$teach_ID','".date("Y-m-d H:i:s")."')";
			$teachcheck_inster = mysql_query($query,$conn)or die(mysql_error());
		}
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกการเช็คชื่อเข้าชั้นเรียนวิชา'.$teach_fetch["subject_name"]." ".$check_date;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Teachcheck','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$sms = new siccsms();
	for($i=0;$i<$stdn;$i++){
		if(!empty($student_parphone[$i])){
			$smstxt = $student_fullname[$i]." ไม่เข้าเรียนวิชา".$teach_fetch["subject_name"]." วันที่ ".(int)$ch_day." ".$thmountbf[(int)$ch_month]." ".($ch_year+543)." ".$sms->sms_from;
			$smsphone = $student_parphone[$i];
			$smsresult = $sms->sendsms($smsphone,$smstxt);
			if(substr($smsresult,7,1)=="0"){
				$userlogs_des="ส่ง sms แจ้งขาดเรียนวิชา".$teach_fetch["subject_name"]." วันที่ ".$check_date." ของ ".$student_fullname[$i];
				$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Send SMS','teach_mis','$userlogs_des')";
				$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
			}
		}
	}
	echo "<script type='text/javascript'>
			alert('บันทึกข้อมูลเรียบร้อย');
			</script>";
}
if($_POST["editteachcheck_bt"]=="บันทึก"){
	$check_date = $_POST["checkdate_txt"];
	$teach_ID = $_POST["teachID_txt"];
	$week = $_POST["week_txt"];
	$teachday_ID = $_POST["teachdayID_txt"];
	$query = "Select * From teach,subject Where teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.teach_ID='$teach_ID'";
	$teach_query = mysql_query($query,$conn)or die(mysql_error());
	$teach_fetch = mysql_fetch_assoc($teach_query);
	$query = "Select * From student,teachstd Where student.student_ID=teachstd.student_ID and teachstd.teach_ID='$teach_ID' and student.student_endstatus=0";
	$student_query = mysql_query($query,$conn)or die(mysql_error());
	$n=0;
	while($student_fetch=mysql_fetch_assoc($student_query)){
		$student_ID = $student_fetch["student_ID"];
		if(!empty($_POST["teachcheckID_txt"][$student_ID]))
			$query = "Update teachcheck Set teachcheck_result='".$_POST["teachin_comb"][$student_ID]."',teachcheck_checkdate='".date("Y-m-d H:i:s")."' Where teachcheck_ID='".$_POST["teachcheckID_txt"][$student_ID]."' and teachcheck_result!='".$_POST["teachin_comb"][$student_ID]."'";
		else
			$query = "Insert into teachcheck(teachday_ID,teachcheck_week,teachcheck_result,student_ID,teach_ID,teachcheck_checkdate) Values('$teachday_ID','$week','".$_POST["teachin_comb"][$student_ID]."','$student_ID','$teach_ID','".date("Y-m-d H:i:s")."')";
		$teachcheck_update = mysql_query($query,$conn)or die(mysql_error());
	}
	$member_ID = $_SESSION["userID"];
	$userlogs_des='แก้ไขการเช็คชื่อเข้าชั้นเรียนวิชา'.$teach_fetch["subject_name"]." ".$check_date;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Teachcheck','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	echo "<script type='text/javascript'>
			alert('แก้ไขข้อมูลเรียบร้อย');
			</script>";
}
if($_POST["canceledit_bt"]=="ยกเลิก"){
	$check_date = $_POST["checkdate_txt"];
	$check_period = $_POST["checkperiod_txt"];
	$teach_ID = $_POST["teachID_txt"];
}
if($_POST["datesearch_bt"]=="ค้นหา"){
	list($check_date,$teachday_ID) = split("/",$_POST["date_comb"]);
	$teach_ID = $_POST["teach_ID"];
}
if(empty($check_date)){
	$check_date=date("Y-n-j");
}
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
	$('#teachcheck').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	//edit
});
function teachdetaildata(id){
	$.get('teachdetaildata.php',{'teach_ID':id},function(data){$('#systemcontent').html(data)});
}
function editteachcheck(teach_ID, teachday_ID, teachcheck_week, date){
	$.get('editteachcheck.php',{
		'teach_ID':teach_ID,
		'teachday_ID':teachday_ID,
		'teachcheck_week':teachcheck_week,
		'check_date':date},function(data){$('#teachcheckarea').html(data)});
}
</script>
	<div id="statusbar">การเช็คชื่อเข้าเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="130"><a href="#" onclick="teachdetaildata('<?php echo $teach_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
  		<h2>เช็คชื่อเข้าเรียน</h2>
	<form id="datesearchform" action="teachcheck.php" method="post">
    		<?php echo "<b>รหัส ".$teach_fetch["subject_ID"]." วิชา ".$teach_fetch["subject_name"]."</b><br>";?>
        	<b> กลุ่มเรียน <?php while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)) echo $teachstd_fetch["area_level"].".".(substr(($teach_fetch["teach_year"]+543),2,2)-substr($teachstd_fetch["class_ID"],0,2)+1)." ".$teachstd_fetch["major_name"].", ";?></b><br />
            <b>ภาคเรียนที่ <?php echo $teach_fetch["teach_term"]."/".($teach_fetch["teach_year"]+543);?></b><b> วัน </b><select name="date_comb" id="date_comb">
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
			  $date_ch = ($teach_year*10000)+($teach_month*100)+$teach_day;
			  $query="Select teachday_ID From teachday Where teach_ID='$teach_ID'";
			  $dayofweek_query=mysql_query($query,$conn)or die(mysql_error());
			  $dayofweek=mysql_num_rows($dayofweek_query);
			  $week = 1;
			  $day = 1;
			  while($date_st<=$date_sp&&$date_st<=$todaydate){
				  $query="Select teachday_ID From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)."' Order By teachday_start ASC";
				  $teachday_query=mysql_query($query,$conn)or die(mysql_error());
				  while($teachday_fetch=mysql_fetch_assoc($teachday_query)){//;			  
				  //if(mysql_num_rows($teachday_query)){
				  	if(($st_year==$teach_year&&$st_month==$teach_month&&$st_day==$teach_day&&$teachday_ID==$teachday_fetch["teachday_ID"])||($st_year==$teach_year&&$st_month==$teach_month&&$st_day==$teach_day&&empty($teachday_ID))){
				  		echo "<option value='".$st_year."-".$st_month."-".$st_day."/".$teachday_fetch["teachday_ID"]."' selected='selected'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
						$teachday_ID=$teachday_fetch["teachday_ID"];
						$thisweek=$week;
					}
					else
						echo "<option value='".$st_year."-".$st_month."-".$st_day."/".$teachday_fetch["teachday_ID"]."'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
					if($day%$dayofweek==0)
					$week++;
					$day++;
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
          <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
        </form>
        <br /><br />
        <div id="teachcheckarea">
        <?php
		if($date_sp>=$date_ch){
		if(empty($teachday_ID))
			$query="Select * From teachday Where teach_ID='$teach_ID' and teachday_day='".jddayofweek(gregoriantojd($teach_month,$teach_day,$teach_year),0)."'";
		else
			$query="Select * From teachday Where teach_ID='$teach_ID' and teachday_ID='$teachday_ID'";
		$teachday_query=mysql_query($query,$conn)or die(mysql_error());	  
		if(mysql_num_rows($teachday_query)){
			$teachday_fetch=mysql_fetch_assoc($teachday_query);
		?>
        <form id="teachcheck" action="teachcheck.php" method="post">
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:12pt">
                  <th height="50" colspan="5" bgcolor="#CCCCCC">
                  <?php		  
				  echo "ภาคเรียนที่ ".$teach_fetch["teach_term"]." ปีการศึกษา ".($teach_fetch["teach_year"]+543);
				  echo " วัน".$thday[jddayofweek(gregoriantojd($teach_month,$teach_day,$teach_year),0)]." ที่ ".(int)$teach_day." ".$thmonth[(int)$teach_month]." ".((int)$teach_year+543);
				  ?>
                  </th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="30%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เข้าเรียน</td>
    </tr>
  <?php
  $check_num=0;
  if($check_date!=date("Y-n-j")||$teachday_fetch["teachday_start"]<=date("H:i:s")){
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
	 
	  if($student_fetch["student_endstatus"]==0){
		  $query = "Select * From teachcheck Where teachday_ID='$teachday_ID' and teachcheck_week='$thisweek' and student_ID='".$student_fetch["student_ID"]."'";
		  $teachcheck_query = mysql_query($query,$conn)or die(mysql_error());
		  $teachcheck_fetch = mysql_fetch_assoc($teachcheck_query);
  ?>
  <tr <?php 
	if(mysql_num_rows($teachcheck_query)>=1){
		if($teachcheck_fetch["teachcheck_result"]==0)
  			echo "bgcolor='#FF6666'";
		else if($teachcheck_fetch["teachcheck_result"]==2)
  			echo "bgcolor='#FFCC99'";
		else if($teachcheck_fetch["teachcheck_result"]>2)
			echo "bgcolor='#FFFF66'";
		else
			if($n%2==1)
				echo "bgcolor='#F5F5F5'";
	}
	else{
		if($n%2==1)
			echo "bgcolor='#F5F5F5'";
	}
  ?>>
    <td width="5%" height="30" valign="middle" >&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    
    <td align="center" valign="middle">
	<?php if(mysql_num_rows($teachcheck_query)<1){?>
    <select name="teachin_comb[<?php echo $student_fetch["student_ID"];?>]" id="teachin_comb[<?php echo $student_fetch["student_ID"];?>]">
    	<option value="0">ขาด</option>
        <option value="1" selected="selected">มา</option>
        <option value="2">มาสาย</option>
        <option value="3">ลาป่วย</option>
        <option value="4">ลากิจ</option>
    </select>
   	<?php }else{ 
			$check_num++;
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
		}?>
      </td>
    </tr>
  <?php 
  	}
 
  }
  if($check_num==0){?>
  <tr >
    <td height="50" colspan="5" align="center" valign="middle">
    <input name="teachdayID_txt" type="hidden" id="teachdayID_txt" value="<?php echo $teachday_fetch["teachday_ID"];?>" />
    <input name="week_txt" type="hidden" id="week_txt" value="<?php echo $thisweek;?>" />
    <input name="checkdate_txt" type="hidden" id="checkdate_txt" value="<?php echo $check_date;?>" />
<input name="teachID_txt" type="hidden" id="teachID_txt" value="<?php echo $teach_ID;?>" />
<input type="submit" name="teachcheck_bt" id="teachcheck_bt" value="บันทึก" /></td>
    </tr>
   <?php }   }
     else echo"<tr >
    <td height='50' colspan='5' align='center' valign='middle'><b>ยังไม่ถึงเวลาสอนในรายวิชานี้</b></td></tr>";?>
</table>
</form>
<?php }} ?>
<br />
<?php if($check_num>0){ ?>
<div align="right"><a href="#" onclick="editteachcheck('<?php echo $teach_ID;?>','<?php echo $teachday_fetch["teachday_ID"];?>','<?php echo $thisweek;?>','<?php echo $check_date;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<?php } ?>
</div>
</center></div>