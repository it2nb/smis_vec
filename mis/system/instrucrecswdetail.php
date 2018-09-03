<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
include("../includefiles/datetimefunc.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$subject_ID = $_GET["subject_ID"];
$course_ID = $_GET["course_ID"];
$instrucrecsw_term = $_GET["instrucrecsw_term"];
$instrucrecsw_year = $_GET["instrucrecsw_year"];
$personnel_ID=$_SESSION["user_personnelID"];
if($_POST["addinstrucrecswdetail_bt"]=="บันทึก"){
	$subject_ID=$_POST["subject_ID"];
	$course_ID=$_POST["course_ID"];
	$instrucrecsw_week = $_POST["instrucrecsw_week"];
	$instrucrecsw_term = $_POST["instrucrecsw_term"];
	$instrucrecsw_year = $_POST["instrucrecsw_year"];
	$instrucrecsw_ID=$_POST["instrucrecsw_ID"];
	$instrucrecsw_detail=$_POST["instrucrecswdetail_txt"];
	$update_date=date("Y-m-d H:i:s");
	if(!empty($instrucrecsw_ID)){
		
		$query="Update instrucrecsw Set instrucrecsw_detail='$instrucrecsw_detail', instrucrecsw_date='$update_date' Where instrucrecsw_ID='$instrucrecsw_ID'";
		$instrucrecsw_update=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		$query="Insert Into instrucrecsw(instrucrecsw_detail,instrucrecsw_date,instrucrecsw_week,instrucrecsw_term,instrucrecsw_year,subject_ID,course_ID,personnel_ID) Values ('$instrucrecsw_detail','$update_date','$instrucrecsw_week','$instrucrecsw_term','$instrucrecsw_year','$subject_ID','$course_ID','$personnel_ID')";
		$instrucrecsw_insert=mysql_query($query,$conn)or die(mysql_error());
		$query="Select instrucrecsw_ID From instrucrecsw Where instrucrecsw_week='$instrucrecsw_week' and instrucrecsw_term='$instrucrecsw_term' and instrucrecsw_year='$instrucrecsw_year' and subject_ID='$subject_ID' and course_ID='$course_ID' and personnel_ID='$personnel_ID'";
		$instrucrecsw_query=mysql_query($query,$conn)or die(mysql_error());
		$instrucrecsw_ID = mysql_result($instrucrecsw_query,0,"instrucrecsw_ID");
	}
	
	$query="Delete From timeline Where timeline_type='instrucrecsw' and timeline_typeID='$instrucrecsw_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='$personnel_ID'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้บันทึกหลังการสอน";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrecsw','$instrucrecsw_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกหลังการสอนสัปดาห์ที่ '.$instrucrecsw_week." รหัสวิชา ".$subject_ID." รหัสหลักสูตร ".$course_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instrucrecsw','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["addcommswdetail_bt"]=="บันทึก"){
	$subject_ID=$_POST["subject_ID"];
	$course_ID=$_POST["course_ID"];
	$instrucrecsw_term = $_POST["instrucrecsw_term"];
	$instrucrecsw_year = $_POST["instrucrecsw_year"];
	$instrucrecsw_ID=$_POST["instrucrecsw_ID"];
	$personnel_ID=$_POST["personnel_ID"];
	$instruccommsw_detail=$_POST["instruccommswdetail_txt"];
	$update_date=date("Y-m-d H:i:s");
	$query="Insert Into instruccommsw(instruccommsw_detail,instruccommsw_date,instrucrecsw_ID,personnel_ID) Values ('$instruccommsw_detail','$update_date','$instrucrecsw_ID','$personnel_ID')";
	$instruccommsw_insert=mysql_query($query,$conn)or die(mysql_error());
	
	$query="Delete From timeline Where timeline_type='instrucrecsw' and timeline_typeID='$instrucrecsw_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของเขาเอง";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrecsw','$instrucrecsw_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccommsw_detail." รหัสบันทึกหลังการสอน ".$instrucrecsw_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccommsw','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_GET["deleteinstruccommsw_bt"]=="ลบ"){
	$subject_ID=$_GET["subject_ID"];
	$course_ID=$_GET["course_ID"];
	$instrucrecsw_term = $_GET["instrucrecsw_term"];
	$instrucrecsw_year = $_GET["instrucrecsw_year"];
	$instruccommsw_ID=$_GET["instruccommsw_ID"];
	$update_date=date("Y-m-d H:i:s");
	$query="Select instrucrecsw_ID From instruccommsw Where instruccommsw_ID='$instruccommsw_ID'";
	$instrucrecswID_query=mysql_query($query,$conn)or die(mysql_error());
	$query = "Delete From instruccommsw Where instruccommsw_ID='$instruccommsw_ID'";
	$delete_instruccommsw = mysql_query($query,$conn)or die(mysql_error());
	$query="Delete From timeline Where timeline_type='instrucrecsw' and timeline_typeID='".mysql_result($instrucrecswID_query,0,"instrucrecsw_ID")."'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้บันทึกหลังการสอน";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrecsw','".mysql_result($instrucrecswID_query,0,"instrucrecsw_ID")."')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des="ลบหัวความคิดเห็น ".$instruccomm_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Instruccommsw','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["cancel_bt"]=="ยกเลิก"){
	$subject_ID=$_POST["subject_ID"];
	$course_ID=$_POST["course_ID"];
	$instrucrecsw_term = $_POST["instrucrecsw_term"];
	$instrucrecsw_year = $_POST["instrucrecsw_year"];
}
$query="Select * From subject Where course_ID='$course_ID' and subject_ID='$subject_ID'";
$subject_query=mysql_query($query,$conn)or die(mysql_error());
$subject_fetch=mysql_fetch_assoc($subject_query);
$query="Select * From period Where period_term='$instrucrecsw_term' and period_year='$instrucrecsw_year'";
$period_query=mysql_query($query,$conn)or die(mysql_error());
$period_fetch=mysql_fetch_assoc($period_query);
$datetimefunc = new datetimefunc();
$thisweek =  $datetimefunc->getweek(date("Y-m-d"),$period_fetch["period_start"],$period_fetch["period_end"]);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#instrucrecsw').click(function(){
		$('#systemcontent').load('instrucrecsw.php');
	});
	//$('#instrucrec').load('teachscoretype.php?teach_ID='+teach_ID);
});
function addinstrucrecsw(id ,sjid, csid, week, term, year, tag){
	$.get('addinstrucrecsw.php',{'instrucrecsw_ID':id,
		'subject_ID':sjid,
		'course_ID':csid,
		'instrucrecsw_week':week,
		'instrucrecsw_term':term,
		'instrucrecsw_year':year,
		'tagid':tag},function(data){$('#'+tag).html(data)});
}
function addinstruccommsw(recid, perid, sjid, csid, term, year, tag){
	$.get('addinstruccommsw.php',{'instrucrecsw_ID':recid,
		'personnel_ID':perid,
		'subject_ID':sjid,
		'course_ID':csid,
		'instrucrecsw_term':term,
		'instrucrecsw_year':year,
		'tagid':tag},function(data){$('#'+tag).html(data)});
}
function deleteinstruccommsw(id, sjid, csid, term, year){
	var conf = confirm("คุณแน่ใจว่าจะลบความคิดเห็น");
	if(conf==true){
		$.get('instrucrecswdetail.php',{
			'instruccommsw_ID':id,
			'subject_ID':sjid,
			'course_ID':csid,
			'instrucrecsw_term':term,
			'instrucrecsw_year':year,
			'deleteinstruccommsw_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
	}
}
</script>
   	<div id="statusbar">บันทึกหลังการสอนวิชา <?php echo $teach_fetch["subject_name"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="128"><a href="#" id="instrucrecsw"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
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
  <center><br /><b>
  		<?php echo "รหัสวิชา ".$subject_fetch["subject_ID"]." ชื่อวิชา ".$subject_fetch["subject_name"]." จำนวน ".$subject_fetch["subject_unit"]." หน่วยกิต ทฤษฎี ".$subject_fetch["subject_hourt"]." ชั่วโมง ปฏิบัติ ".$subject_fetch["subject_hourp"]." ชั่วโมง";?></b>
    <br /><hr />
    <div id="header">
    </div>
    <div id="instrucrec">
    <?php
	for($week=$thisweek;$week>=1;$week--){
		$query="Select * From instrucrecsw Where instrucrecsw_week='$week' and instrucrecsw_term='$instrucrecsw_term' and instrucrecsw_year='$instrucrecsw_year' and subject_ID='$subject_ID' and course_ID='$course_ID' and personnel_ID='$personnel_ID'";
		$instrucrecsw_query=mysql_query($query,$conn)or die(mysql_error());
		$instrucrecsw_fetch=mysql_fetch_assoc($instrucrecsw_query);
	?>
      <table width="80%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td height="30" colspan="2" bgcolor="#FFCC33"><b><?php echo "สัปดาห์ที่ ".$week;?></b></td>
        </tr>
        <tr>
          <td height="100" colspan="2" bgcolor="#DDDDDD">
          <div id="<?php echo "instrucrecsw".$week;?>">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
              <td colspan="2"><?php echo $instrucrecsw_fetch["instrucrecsw_detail"];?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#EEEEEE">บันทึกเมื่อวัน
			  <?php 
			  list($instrucrecsw_date,$instrucrecsw_time) = split(" ",$instrucrecsw_fetch["instrucrecsw_date"]);
			  if(!empty($instrucrecsw_date)){
			  list($instrucrecsw_iyear,$instrucrecsw_imonth,$instrucrecsw_iday) = split("-",$instrucrecsw_date);
			  	echo $thday[jddayofweek(gregoriantojd($instrucrecsw_imonth,$instrucrecsw_day,$instrucrecsw_iyear),0)]." ที่ ".(int)$instrucrecsw_iday." ".$thmonth[(int)$instrucrecsw_imonth]." ".((int)$instrucrecsw_iyear+543)." เวลา ".$instrucrecsw_time;
			  }
			  ?>
              </td>
              <td width="20%" align="center" valign="middle" bgcolor="#EEEEEE"><?php if($thisweek<18){?><a href="#" onclick="addinstrucrecsw('<?php echo $instrucrecsw_fetch["instrucrecsw_ID"];?>','<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $week;?>','<?php echo $instrucrecsw_term;?>','<?php echo $instrucrecsw_year;?>','<?php echo "instrucrecsw".$week;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle" />แก้ไขบันทึก</a><?php } ?></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
        <?php
			$query="Select * From instruccommsw Where instrucrecsw_ID='".$instrucrecsw_fetch["instrucrecsw_ID"]."' Order By instruccommsw_ID ASC";
			$instruccommsw_query=mysql_query($query,$conn)or die(mysql_error());
			while($instruccommsw_fetch=mysql_fetch_assoc($instruccommsw_query)){
				list($instruccommsw_date,$instruccommsw_time) = split(" ",$instruccommsw_fetch["instruccommsw_date"]);
			  	if(!empty($instruccommsw_date)){
			  		list($instruccommsw_year,$instruccommsw_month,$instruccommsw_day) = split("-",$instruccommsw_date);
				}
				$query="Select personnel_name,personnel_ser,personnel_picfile From personnel Where personnel_ID='".$instruccommsw_fetch["personnel_ID"]."'"; 
			  	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		?>
        <tr>
          <td>&nbsp;</td>
          <td height="50" bgcolor="#EEEEEE"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="60" rowspan="2" align="center" valign="middle" bgcolor="#FAFAFA"><img src="../../images/personnel/<?php echo mysql_result($personnel_query,0,"personnel_picfile");?>" width="50"/></td>
              <td colspan="2" bgcolor="#FAFAFA"><?php echo nl2br($instruccommsw_fetch["instruccommsw_detail"]);?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#FAFAFA"><?php echo mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_name")." ( ".(int)$instruccommsw_day." ".$thmountbf[(int)$instruccommsw_month]." ".((int)$instruccommsw_year+543)." ".$instruccommsw_time." )";?>
              </td>
              <td width="100" align="center" valign="middle" bgcolor="#FAFAFA"><a href="#" onclick="deleteinstruccommsw('<?php echo $instruccommsw_fetch["instruccommsw_ID"];?>','<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $instrucrecsw_term;?>','<?php echo $instrucrecsw_year;?>')"><img src="../images/icons/16/delete.png" width="16" height="16" align="absmiddle" /> ลบ</a></td>
            </tr>
          </table>
          </td>
        </tr>
        <?php } 
		if(!empty($instrucrecsw_date)){?>
        <tr>
          <td width="10%">&nbsp;</td>
          <td height="50" align="right" valign="middle" bgcolor="#EEEEEE">
          <div id="<?php echo "addcommsw".$instrucrecsw_fetch["instrucrecsw_ID"];?>"><a href="<?php echo "#addcommp".$instrucrecsw_fetch["instrucrecsw_ID"];?>" name="<?php echo "addcommp".$instrucrecsw_fetch["instrucrecsw_ID"];?>" onclick="addinstruccommsw('<?php echo $instrucrecsw_fetch["instrucrecsw_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $instrucrecsw_term;?>','<?php echo $instrucrecsw_year;?>','<?php echo "addcommsw".$instrucrecsw_fetch["instrucrecsw_ID"];?>')"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มความคิดเห็น&nbsp;&nbsp;</a>
          </div>
          </td>
        </tr>
        <?php } ?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?php } ?>
    </div>
	</center>
</div><br />
</div>