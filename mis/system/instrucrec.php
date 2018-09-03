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
$teach_ID = $_GET["teach_ID"];
if($_POST["addscoredetail_bt"]=="บันทึก"){
	$teach_ID=$_POST["teach_ID"];
	$instrucrec_ID=$_POST["instrucrec_ID"];
	$instrucrec_detail=$_POST["instrucrecdetail_txt"];
	$update_date=date("Y-m-d H:i:s");
	$teachday_ID=$_POST["teachday_ID"];
	$week=$_POST["week"];
	$query='Select instrucrec_ID From instrucrec Where teachday_ID="'.$teachday_ID.'" and week="'.$week.'"';
	$instrucrec_check = mysql_query($query,$conn);
	if($instrucrec_check_fetch = mysql_fetch_assoc($instrucrec_check))
		$instrucrec_ID = $instrucrec_check_fetch['instrucrec_ID'];
	if(!empty($instrucrec_ID)){
		
		$query="Update instrucrec Set instrucrec_detail='$instrucrec_detail', instrucrec_date='$update_date' Where instrucrec_ID='$instrucrec_ID'";
		$instrucrec_update=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		$query="Insert Into instrucrec(instrucrec_detail,instrucrec_date,teach_ID,teachday_ID,week) Values ('$instrucrec_detail','$update_date','$teach_ID','$teachday_ID','$week')";
		$instrucrec_insert=mysql_query($query,$conn)or die(mysql_error());
		$query="Select instrucrec_ID From instrucrec Where teach_ID='$teach_ID' and teachday_ID='$teachday_ID' and week='$week'";
		$instrucrec_query=mysql_query($query,$conn)or die(mysql_error());
		$instrucrec_ID = mysql_result($instrucrec_query,0,"instrucrec_ID");
	}
	
	$query="Delete From timeline Where timeline_type='instrucrec' and timeline_typeID='$instrucrec_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้บันทึกหลังการสอน";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrec','$instrucrec_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกหลังการสอนสัปดาห์ที่ '.$week." รหัสการสอน ".$teach_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instrucrec','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["addcommdetail_bt"]=="บันทึก"){
	$teach_ID=$_POST["teach_ID"];
	$instrucrec_ID=$_POST["instrucrec_ID"];
	$personnel_ID=$_POST["personnel_ID"];
	$instruccomm_detail=$_POST["instruccommdetail_txt"];
	$update_date=date("Y-m-d H:i:s");
	$query="Insert Into instruccomm(instruccomm_detail,instruccomm_date,instrucrec_ID,personnel_ID) Values ('$instruccomm_detail','$update_date','$instrucrec_ID','$personnel_ID')";
	$instruccomm_insert=mysql_query($query,$conn)or die(mysql_error());
	
	$query="Delete From timeline Where timeline_type='instrucrec' and timeline_typeID='$instrucrec_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของเขาเอง";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrec','$instrucrec_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccomm_detail." รหัสบันทึกหลังการสอน ".$instrucrec_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccomm','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_GET["deleteinstruccomm_bt"]=="ลบ"){
	$teach_ID=$_GET["teach_ID"];
	$instruccomm_ID=$_GET["instruccomm_ID"];
	$update_date=date("Y-m-d H:i:s");
	$query="Select instrucrec_ID From instruccomm Where instruccomm_ID='$instruccomm_ID'";
	$instrucrecID_query=mysql_query($query,$conn)or die(mysql_error());
	$query = "Delete From instruccomm Where instruccomm_ID='$instruccomm_ID'";
	$delete_instruccomm = mysql_query($query,$conn)or die(mysql_error());
	$query="Delete From timeline Where timeline_type='instrucrec' and timeline_typeID='".mysql_result($instrucrecID_query,0,"instrucrec_ID")."'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้บันทึกหลังการสอน";
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrec','".mysql_result($instrucrecID_query,0,"instrucrec_ID")."')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des="ลบหัวความคิดเห็น ".$instruccomm_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Instruccomm','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
}
else if($_POST["cancel_bt"]=="ยกเลิก"){
	$teach_ID=$_POST["teach_ID"];
}
$query="Select * From teach, subject Where teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.teach_ID='$teach_ID'";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
$teach_fetch=mysql_fetch_assoc($teach_query);
$query="Select * From period Where period_term='".$teach_fetch["teach_term"]."' and period_year='".$teach_fetch["teach_year"]."'";
$period_query=mysql_query($query,$conn)or die(mysql_error());
$period_fetch=mysql_fetch_assoc($period_query);
$query = "Select * From teachday Where teach_ID='$teach_ID' Order By teachday_day ASC";
$teachday_query=mysql_query($query,$conn)or die(mysql_error());
$r=1;
while($teachday_fetch=mysql_fetch_assoc($teachday_query)){
	$stdate = new DateTime($period_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
	date_modify($stdate,("+".($teachday_fetch["teachday_day"]-1)." day"));
	for($i=$r;$i<=(18*mysql_num_rows($teachday_query));$i+=mysql_num_rows($teachday_query)){
		$recdate[$i]["date"]=$stdate->format("Y-m-d");
		date_modify($stdate,("+7 day"));
		$recdate[$i]["teachday_ID"]=$teachday_fetch["teachday_ID"];
	}
	$r++;
	
}
$datetimefunc = new datetimefunc();
$thisweek =  $datetimefunc->getweek(date("Y-m-d"),$period_fetch["period_start"],$period_fetch["period_end"]);
echo "<script type='text/javascript'>var teach_ID='".$teach_ID."'</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#teachdetaildata').click(function(){
		$.get('teachdetaildata.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	//$('#instrucrec').load('teachscoretype.php?teach_ID='+teach_ID);
});
function addinstrucrec(id, teach, teachday, week, tag){
	$.get('addinstrucrec.php',{'instrucrec_ID':id,
		'teach_ID':teach,
		'teachday_ID':teachday,
		'week':week,
		'tagid':tag},function(data){$('#'+tag).html(data)});
}
function addinstruccomm(recid, perid, tag){
	$.get('addinstruccomm.php',{'instrucrec_ID':recid,
		'personnel_ID':perid,
		'teach_ID':teach_ID,
		'tagid':tag},function(data){$('#'+tag).html(data)});
}
function deleteinstruccomm(id){
	var conf = confirm("คุณแน่ใจว่าจะลบความคิดเห็น");
	if(conf==true){
		$.get('instrucrec.php',{
			'instruccomm_ID':id,
			'teach_ID':teach_ID,
			'deleteinstruccomm_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
	}
}
</script>
<style type="text/css">
.instrucrecsw {
	display: block;
	padding: 5px;
	border: thin solid #C00;
}
</style>
   	<div id="statusbar">บันทึกหลังการสอนวิชา <?php echo $teach_fetch["subject_name"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="192"><a href="#" id="teachdetaildata"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="reportpdf/instrucrecreport.php?teach_ID=<?php echo $teach_ID; ?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
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
  		<?php echo "รหัสวิชา ".$teach_fetch["subject_ID"]." ชื่อวิชา ".$teach_fetch["subject_name"]." จำนวน ".$teach_fetch["subject_unit"]." หน่วยกิต ทฤษฎี ".$teach_fetch["subject_hourt"]." ชั่วโมง ปฏิบัติ ".$teach_fetch["subject_hourp"]." ชั่วโมง";?></b>
    <br /><hr />
    <div id="header">
    </div>
    <div id="instrucrec">
    <?php
	list($this_year,$this_month,$this_day)= split("-",date("Y-m-d"));
	$this_date = ($this_year*10000)+($this_month*100)+$this_day;
	for($j=($i-mysql_num_rows($teachday_query));$j>=1;$j--){
		list($rec_year,$rec_month,$rec_day) = split("-",$recdate[$j]["date"]);
		$rec_date = ($rec_year*10000)+($rec_month*100)+$rec_day;
		if($this_date>=$rec_date){
			$query="Select * From instrucrec Where teach_ID='$teach_ID' and week='".ceil($j/mysql_num_rows($teachday_query))."' and teachday_ID='".$recdate[$j]["teachday_ID"]."'";
			$instrucrec_query=mysql_query($query,$conn)or die(mysql_error());
			$instrucrec_fetch=mysql_fetch_assoc($instrucrec_query);
	?>
      <table width="80%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td height="30" colspan="2" bgcolor="#FFCC33"><b><?php echo "สัปดาห์ที่ ".ceil($j/mysql_num_rows($teachday_query))." วัน".$thday[jddayofweek(gregoriantojd($rec_month,$rec_day,$rec_year),0)]." ที่ ".(int)$rec_day." ".$thmonth[(int)$rec_month]." ".((int)$rec_year+543);?></b></td>
        </tr>
        <tr>
          <td height="100" colspan="2" bgcolor="#DDDDDD">
          <div id="<?php echo "instrucrec".$j.$recdate[$j]["teachday_ID"];?>">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
              <td colspan="2">
              <?php
			  	$query="Select * From instrucrecsw Where instrucrecsw_week='".ceil($j/mysql_num_rows($teachday_query))."' and instrucrecsw_term='".$teach_fetch["teach_term"]."' and instrucrecsw_year='".$teach_fetch["teach_year"]."' and subject_ID='".$teach_fetch["subject_ID"]."' and course_ID='".$teach_fetch["course_ID"]."' and personnel_ID='".$teach_fetch["personnel_ID"]."'";
				$instrucrecsw_query=mysql_query($query,$conn)or die(mysql_error());
				while($instrucrecsw_fetch=mysql_fetch_assoc($instrucrecsw_query)){
			  ?>
			  <div class="instrucrecsw">
              	<?php echo $instrucrecsw_fetch["instrucrecsw_detail"];?>
                <div align="right">บันทึกเมื่อวัน
                <?php 
			  list($instrucrecsw_date,$instrucrecsw_time) = split(" ",$instrucrecsw_fetch["instrucrecsw_date"]);
			  if(!empty($instrucrecsw_date)){
			  list($instrucrecsw_year,$instrucrecsw_month,$instrucrecsw_day) = split("-",$instrucrecsw_date);
			  	echo $thday[jddayofweek(gregoriantojd($instrucrecsw_month,$instrucrecsw_day,$instrucrecsw_year),0)]." ที่ ".(int)$instrucrecsw_day." ".$thmonth[(int)$instrucrecsw_month]." ".((int)$instrucrecsw_year+543)." เวลา ".$instrucrecsw_time;
			  }
			  ?>

                </div>
              </div>
              <?php } ?>
			  <?php echo $instrucrec_fetch["instrucrec_detail"];?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#EEEEEE">บันทึกเมื่อวัน
			  <?php 
			  list($instrucrec_date,$instrucrec_time) = split(" ",$instrucrec_fetch["instrucrec_date"]);
			  if(!empty($instrucrec_date)){
			  list($instrucrec_year,$instrucrec_month,$instrucrec_day) = split("-",$instrucrec_date);
			  	echo $thday[jddayofweek(gregoriantojd($instrucrec_month,$instrucrec_day,$instrucrec_year),0)]." ที่ ".(int)$instrucrec_day." ".$thmonth[(int)$instrucrec_month]." ".((int)$instrucrec_year+543)." เวลา ".$instrucrec_time;
			  }
			  ?>
              </td>
              <td width="20%" align="center" valign="middle" bgcolor="#EEEEEE"><?php if($thisweek<18){?><a href="#" onclick="addinstrucrec('<?php echo $instrucrec_fetch["instrucrec_ID"];?>','<?php echo $teach_ID;?>','<?php echo $recdate[$j]["teachday_ID"];?>','<?php echo ceil($j/mysql_num_rows($teachday_query));?>','<?php echo "instrucrec".$j.$recdate[$j]["teachday_ID"];?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle" />แก้ไขบันทึก</a><?php } ?></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
        <?php
			$query="Select * From instruccomm Where instrucrec_ID='".$instrucrec_fetch["instrucrec_ID"]."' Order By instruccomm_ID ASC";
			$instruccomm_query=mysql_query($query,$conn)or die(mysql_error());
			while($instruccomm_fetch=mysql_fetch_assoc($instruccomm_query)){
				list($instruccomm_date,$instruccomm_time) = split(" ",$instruccomm_fetch["instruccomm_date"]);
			  	if(!empty($instruccomm_date)){
			  		list($instruccomm_year,$instruccomm_month,$instruccomm_day) = split("-",$instruccomm_date);
				}
				$query="Select personnel_name,personnel_ser,personnel_picfile From personnel Where personnel_ID='".$instruccomm_fetch["personnel_ID"]."'"; 
			  	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		?>
        <tr>
          <td>&nbsp;</td>
          <td height="50" bgcolor="#EEEEEE"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="60" rowspan="2" align="center" valign="middle" bgcolor="#FAFAFA"><img src="../../images/personnel/<?php echo mysql_result($personnel_query,0,"personnel_picfile");?>" width="50"/></td>
              <td colspan="2" bgcolor="#FAFAFA"><?php echo nl2br($instruccomm_fetch["instruccomm_detail"]);?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#FAFAFA"><?php echo mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_name")." ( ".(int)$instruccomm_day." ".$thmountbf[(int)$instruccomm_month]." ".((int)$instruccomm_year+543)." ".$instruccomm_time." )";?>
              </td>
              <td width="100" align="center" valign="middle" bgcolor="#FAFAFA"><a href="#" onclick="deleteinstruccomm('<?php echo $instruccomm_fetch["instruccomm_ID"];?>')"><img src="../images/icons/16/delete.png" width="16" height="16" align="absmiddle" /> ลบ</a></td>
            </tr>
          </table>
          </td>
        </tr>
        <?php } 
		if(!empty($instrucrec_date)){?>
        <tr>
          <td width="10%">&nbsp;</td>
          <td height="50" align="right" valign="middle" bgcolor="#EEEEEE">
          <div id="<?php echo "addcomm".$instrucrec_fetch["instrucrec_ID"];?>"><a href="<?php echo "#addcommp".$instrucrec_fetch["instrucrec_ID"];?>" name="<?php echo "addcommp".$instrucrec_fetch["instrucrec_ID"];?>" onclick="addinstruccomm('<?php echo $instrucrec_fetch["instrucrec_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo "addcomm".$instrucrec_fetch["instrucrec_ID"];?>')"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มความคิดเห็น&nbsp;&nbsp;</a>
          </div>
          </td>
        </tr>
        <?php } ?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?php }} ?>
    </div>
	</center>
</div><br />
</div>