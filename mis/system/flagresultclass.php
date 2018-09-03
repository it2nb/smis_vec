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
$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and class.year>'$styear' and area.area_level='ปวช' Order By class_ID DESC";
$classvo_query=mysql_query($query,$conn) or die(mysql_error());	
$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and class.year>'$styear' and area.area_level='ปวส' Order By class_ID DESC";
$classde_query=mysql_query($query,$conn) or die(mysql_error());	
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
   	<div id="statusbar">จัดการข้อมูลครูที่ปรึกษา</div>
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
	<form id="periodsearchform" action="flagresultclass.php" method="post">
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
			  while($date_st<=$date_sp&&$date_st<=$todaydate){
				  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=6){
				  	if($st_year==$flag_year&&$st_month==$flag_month&&$st_day==$flag_day)
				  		echo "<option value='".$st_year."-".$st_month."-".$st_day."' selected='selected'>วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
					else
						echo "<option value='".$st_year."-".$st_month."-".$st_day."'>วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
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
              <th height="50" colspan="9" bgcolor="#CCCCCC">
			  รายงานการเช็คชื่อเข้าร่วมกิจกรรมหน้าเสาธงประจำวันแยกตามกลุ่มเรียน<br />
			  <?php		  
				  echo " วัน".$thday[jddayofweek(gregoriantojd($flag_month,$flag_day,$flag_year),0)]." ที่ ".(int)$flag_day." ".$thmonth[(int)$flag_month]." ".((int)$flag_year+543);
				  ?></th>
              <tr>
                <td width="5%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
                <td width="10%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสกลุ่มเรียน</td>
                <td rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คำอธิบาย</td>
                <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
                <td height="30" colspan="5" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">การเข้าร่วมกิจกรรมหน้าเลาธง</td>
              </tr>
          <tr>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">มา</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ขาด</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">Check</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">Edit</td>
          </tr>
  <?php
  $allvo=0;
  $allvoman=0;
  while($class_fetch=mysql_fetch_array($classvo_query))
  {
	  $class_show=$check_year-$class_fetch["year"];
	  if(substr($class_fetch["class_ID"],2,1)==2&&$class_show<=2){
	  	$query = "Select count(student_ID) As stdpclass From student Where class_ID='".$class_fetch["class_ID"]."' and student_endstatus='0'";
	  	$stdpclass_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclass_fetch = mysql_fetch_array($stdpclass_query);
		$query = "Select count(flagcheck.student_ID) As stdpclassman From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.flagcheck_result='0' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
	  	$stdpclassman_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclassman_fetch = mysql_fetch_array($stdpclassman_query);
	  	$query = "Select member_ID,personnel_name,personnel_ser From member,personnel Where member.personnel_ID=personnel.personnel_ID and personnel.personnel_ID='".$class_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_array($personnel_query);
	  	$query = "Select member_ID,personnel_name,personnel_ser From member,personnel Where member.personnel_ID=personnel.personnel_ID and personnel.personnel_ID='".$class_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_array($personnel_query);
		$allvo+=$stdpclass_fetch["stdpclass"];
		$allvoman+=$stdpclassman_fetch["stdpclassman"];
		
  		$query = "Select flagcheck.student_ID From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
	  	$techcheck_query = mysql_query($query,$conn) or die(mysql_error());
		$query = "Select min(flagcheck.flagcheck_checkdate) As checkdate, max(flagcheck.flagcheck_checkdate) As editdate From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
		$flagedit_query=mysql_query($query,$conn) or die(mysql_error());
		$flagedit_fetch=mysql_fetch_array($flagedit_query);
		
  ?>
   <tr <?php if(mysql_num_rows($techcheck_query)<=0) echo"bgcolor='#CCCCCC'";?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $class_fetch["class_ID"];?></td>
    <td align="left" valign="middle"><?php echo $class_fetch["area_level"]." ".($class_show+1)." สาขา".$class_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"]-$stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"];?></td>
    <td align="center" valign="middle"><?php echo $flagedit_fetch["checkdate"];?></td>
    <td align="center" valign="middle"><?php if($flagedit_fetch["checkdate"]!=$flagedit_fetch["editdate"])echo $flagedit_fetch["editdate"];?></td>  
    </tr>
  <?php } }?><tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ปวช.</b></td>
     <td align="center" valign="middle"><b><?php echo $allvo-$allvoman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $allvoman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $allvo;?></b></td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     </tr>
  
   <?php
   $allde=0;
   $alldeman=0;
  while($class_fetch=mysql_fetch_array($classde_query))
  {
	  $class_show=$check_year-$class_fetch["year"];
	  if(substr($class_fetch["class_ID"],2,1)==3&&$class_show<=1){
	  	$query = "Select count(student_ID) As stdpclass From student Where class_ID='".$class_fetch["class_ID"]."' and student_endstatus='0'";
	  	$stdpclass_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclass_fetch = mysql_fetch_array($stdpclass_query);
		$query = "Select count(flagcheck.student_ID) As stdpclassman From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.flagcheck_result='0' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
	  	$stdpclassman_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclassman_fetch = mysql_fetch_array($stdpclassman_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_array($personnel_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_array($personnel_query);
		$allde+=$stdpclass_fetch["stdpclass"];
		$alldeman+=$stdpclassman_fetch["stdpclassman"];
		
		$query = "Select flagcheck.student_ID From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
	  	$techcheck_query = mysql_query($query,$conn) or die(mysql_error());
		$query = "Select min(flagcheck.flagcheck_checkdate) As checkdate, max(flagcheck.flagcheck_checkdate) As editdate From flagcheck,student Where student.class_ID='".$class_fetch["class_ID"]."' and flagcheck.student_ID=student.student_ID and flagcheck.flagcheck_date='$check_date'";
		$flagedit_query=mysql_query($query,$conn) or die(mysql_error());
		$flagedit_fetch=mysql_fetch_array($flagedit_query);
  ?>
   <tr <?php if(mysql_num_rows($techcheck_query)<=0) echo"bgcolor='#CCCCCC'";?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $class_fetch["class_ID"];?></td>
    <td align="left" valign="middle"><?php echo $class_fetch["area_level"]." ".($class_show+1)." สาขา".$class_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"]-$stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"];?></td>
    <td align="center" valign="middle"><?php echo $flagedit_fetch["checkdate"];?></td>
    <td align="center" valign="middle"><?php if($flagedit_fetch["checkdate"]!=$flagedit_fetch["editdate"])echo $flagedit_fetch["editdate"];?></td> 
    </tr>
  <?php } }?>
  <tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ปวส.</b></td>
     <td align="center" valign="middle"><b><?php echo $allde-$alldeman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $alldeman;?></b></td> 
     <td align="center" valign="middle"><b><?php echo $allde;?></b></td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>  
     </tr>
   <tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ทั้งหมด</b></td>
     <td align="center" valign="middle"><b><?php echo ($allde+$allvo)-($allvoman+$alldeman);?></b></td>
     <td align="center" valign="middle"><b><?php echo $allvoman+$alldeman;?></b></td> 
     <td align="center" valign="middle"><b><?php echo $allde+$allvo;?></b></td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>    
     </tr>
</table><?php }?><br />
</center></div>