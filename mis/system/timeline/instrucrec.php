<?php
session_start();
include("../../includefiles/connectdb.php");
include("../../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../../'>";
}
$timeline_ID = $_GET["timeline_ID"];
$tagid=$_GET["tagid"];
if($_POST["addcommdetail_bt"]=="บันทึก"){
	$timeline_ID=$_POST["timeline_ID"];
	$tagid=$_POST["tagid"];
	$instrucrec_ID=$_POST["instrucrec_ID"];
	$personnel_ID=$_POST["personnel_ID"];
	$instruccomm_detail=$_POST["instruccommdetail_txt"];
	$update_date=date("Y-m-d H:i:s");
	$query="Insert Into instruccomm(instruccomm_detail,instruccomm_date,instrucrec_ID,personnel_ID) Values ('$instruccomm_detail','$update_date','$instrucrec_ID','$personnel_ID')";
	$instruccomm_insert=mysql_query($query,$conn)or die(mysql_error());
	
	$query="Delete From timeline Where timeline_type='instrucrec' and timeline_typeID='$instrucrec_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_ID,personnel_name,personnel_ser From personnel Where personnel_ID=(Select personnel_ID From instrucrec,teach Where teach.teach_ID=instrucrec.teach_ID and instrucrec_ID='$instrucrec_ID')"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	if($personnel_ID==mysql_result($personnel_query,0,"personnel_ID")){
		$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
		$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของเขาเอง";
	}
	else{
		$recname=mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser");
		$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
		$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของ".$recname;
	}
	
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrec','$instrucrec_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccomm_detail." รหัสบันทึกหลังการสอน ".$instrucrec_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccomm','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$query="Select max(timeline_ID) as lasttimeline From timeline";
	$lastimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$lasttimeline_fetch=mysql_fetch_assoc($lastimeline_query);
	$timeline_ID=$lasttimeline_fetch["lasttimeline"];
}
else if($_GET["addinstruccommkn_bt"]=="save"){
	$instrucrec_ID=$_GET["instrucrec_ID"];
	$timeline_ID=$_GET["timeline_ID"];
	$personnel_ID=$_GET["personnel_ID"];
	$tagid=$_GET["tagid"];
	$instruccomm_detail="ทราบ";
	$update_date=date("Y-m-d H:i:s");
	$query="Insert Into instruccomm(instruccomm_detail,instruccomm_date,instrucrec_ID,personnel_ID) Values ('$instruccomm_detail','$update_date','$instrucrec_ID','$personnel_ID')";
	$instruccomm_insert=mysql_query($query,$conn)or die(mysql_error());
	
	$query="Delete From timeline Where timeline_type='instrucrec' and timeline_typeID='$instrucrec_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_ID,personnel_name,personnel_ser From personnel Where personnel_ID=(Select personnel_ID From instrucrec,teach Where teach.teach_ID=instrucrec.teach_ID and instrucrec_ID='$instrucrec_ID')"; 
	$personnel_query=mysql_query($query,$conn)or die(mysql_error());
	if($personnel_ID==mysql_result($personnel_query,0,"personnel_ID")){
		$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
		$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของเขาเอง";
	}
	else{
		$recname=mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser");
		$query="Select personnel_name,personnel_ser From personnel Where personnel_ID='".$_SESSION["user_personnelID"]."'"; 
		$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		$timeline_title = mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ได้แสดงความคิดเห็นในบันทึกการสอนของ".$recname;
	}
	
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrec','$instrucrec_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccomm_detail." รหัสบันทึกหลังการสอน ".$instrucrec_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccomm','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$query="Select max(timeline_ID) as lasttimeline From timeline";
	$lastimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$lasttimeline_fetch=mysql_fetch_assoc($lastimeline_query);
	$timeline_ID=$lasttimeline_fetch["lasttimeline"];
}
else if($_POST["cancel_bt"]=="ยกเลิก"){
	$timeline_ID=$_POST["timeline_ID"];
	$tagid=$_POST["tagid"];
}
$query="Select * From timeline Where timeline_ID='$timeline_ID'";
$timeline_query=mysql_query($query,$conn)or die(mysql_error());
$timeline_fetch=mysql_fetch_assoc($timeline_query);
$instrucrec_ID=$timeline_fetch["timeline_typeID"];
$query="Select * From instrucrec Where instrucrec_ID='$instrucrec_ID'";
$instrucrec_query=mysql_query($query,$conn)or die(mysql_error());
$instrucrec_fetch=mysql_fetch_assoc($instrucrec_query);
$query = "Select * From teachday,teach Where teachday.teach_ID=teach.teach_ID and teachday_ID='".$instrucrec_fetch["teachday_ID"]."'";
$teachday_query=mysql_query($query,$conn)or die(mysql_error());
$teachday_fetch=mysql_fetch_assoc($teachday_query);
$query="Select * From period Where period_term='".$teachday_fetch["teach_term"]."' and period_year='".$teachday_fetch["teach_year"]."'";
$period_query=mysql_query($query,$conn)or die(mysql_error());
$period_fetch=mysql_fetch_assoc($period_query);
$stdate = new DateTime($period_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
date_modify($stdate,("+".(($teachday_fetch["teachday_day"]-1)+(($instrucrec_fetch["week"]-1)*7))." day"));
$date_instrucrec=$stdate->format("Y-m-d");
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	
	//headmenu
	//$('#instrucrec').load('teachscoretype.php?teach_ID='+teach_ID);
});
function addinstruccomm(id, recid, perid, tag, tagid){
	$.get('timeline/addinstruccomm.php',{'timeline_ID':id,
		'instrucrec_ID':recid,
		'personnel_ID':perid,
		'tagid':tagid},function(data){$('#'+tag).html(data)});
}
function addinstruccommkn(id, recid, perid, tagid){
	$.get('timeline/instrucrec.php',{'timeline_ID':id,
		'instrucrec_ID':recid,
		'personnel_ID':perid,
		'tagid':tagid,
		'addinstruccommkn_bt':'save'},function(data){$('#'+tagid).html(data)});
}
</script>
<div id="instrucrec">
    <?php
		list($rec_year,$rec_month,$rec_day) = split("-",$date_instrucrec);
		$query="Select personnel_name,personnel_ser,personnel_picfile From personnel Where personnel_ID='".$teachday_fetch["personnel_ID"]."'"; 
		$personnel_query=mysql_query($query,$conn)or die(mysql_error());
		list($timeline_date,$timeline_time) = split(" ",$timeline_fetch["timeline_date"]);
		list($timeline_year,$timeline_month,$timeline_day) = split("-",$timeline_date);
	?>
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td height="30" colspan="2" bgcolor="#FFDD99"><b><?php echo $timeline_fetch["timeline_title"]." เมื่อวัน".$thday[jddayofweek(gregoriantojd($timeline_month,$timeline_day,$timeline_year),0)]." ที่ ".(int)$timeline_day." ".$thmonth[(int)$timeline_month]." ".((int)$timeline_year+543)." เวลา ".$timeline_time;?><br /></b>
 		</td>
        </tr>
        <tr>
          <td height="100" colspan="2" bgcolor="#DDDDDD">
          <div id="<?php echo "instrucrec".$instrucrec_fetch["instrucrec_ID"];?>">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
              <td width="60" rowspan="2" align="center" valign="top" bgcolor="#EEEEEE"><img src="../../images/personnel/<?php echo mysql_result($personnel_query,0,"personnel_picfile");?>" width="60" /></td>
              <td>
              <p>
              <b>บันทึกหลังการสอนวิชา
          <?php
		  $query="Select * From subject Where subject_ID='".$teachday_fetch["subject_ID"]."' and course_ID='".$teachday_fetch["course_ID"]."'";
		  $subject_query=mysql_query($query,$conn)or die(mysql_error());
		  echo mysql_result($subject_query,0,"subject_name")." สัปดาห์ที่ ".$instrucrec_fetch["week"]." วัน".$thday[jddayofweek(gregoriantojd($rec_month,$rec_day,$rec_year),0)]." ที่ ".(int)$rec_day." ".$thmonth[(int)$rec_month]." ".((int)$rec_year+543);
          ?></b><br />
          <?php 
		//$query="Select teach_ID From teach Where subject_ID='".$teachday_fetch["subject_ID"]."' and course_ID='".$teachday_fetch["course_ID"]."' and teach_term='".$teachday_fetch["teach_term"]."' and teach_year='".$teachday_fetch["teach_year"]."' and personnel_ID='".$teachday_fetch["personnel_ID"]."'";
		//$teach_query = mysql_query($query,$conn)or die(mysql_error());
		//while($teach_fetch=mysql_fetch_assoc($teach_query)){
			$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='".$teachday_fetch["teach_ID"]."' group by teachstd.class_ID";
			$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
			while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)){
				echo $teachstd_fetch["area_level"].".".(substr($teachday_fetch["teach_year"]+543,2,2)-substr($teachstd_fetch["class_ID"],0,2)+1)."/".substr($teachstd_fetch["class_ID"],7,1)." ".$teachstd_fetch["major_name"].", ";
			}
		//}
	?>
          </p>
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
            </tr>
          </table>
          </div>
          </td>
        </tr>
        <?php if(substr($_SESSION["user_status"],1,1)){ ?>
        <tr>
          <td>&nbsp;</td>
          <td height="30" align="right" valign="middle" bgcolor="#EEEEEE">
          <a href="<?php echo "#addcommpkn".$instrucrec_fetch["instrucrec_ID"];?>" name="<?php echo "addcommpkn".$instrucrec_fetch["instrucrec_ID"];?>" onclick="addinstruccommkn('<?php echo $timeline_ID;?>','<?php echo $instrucrec_fetch["instrucrec_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo $tagid;?>')"><img src="../images/icons/timeline/know.png" width="60" height="30" /></a>&nbsp;&nbsp;
          </td>
        </tr>
        <?php
		}
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
              <td bgcolor="#FAFAFA"><?php echo nl2br($instruccomm_fetch["instruccomm_detail"]);?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#FAFAFA"><?php echo mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ( ".(int)$instruccomm_day." ".$thmountbf[(int)$instruccomm_month]." ".((int)$instruccomm_year+543)." ".$instruccomm_time." )";?>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <?php } 
		if(!empty($instrucrec_date)){?>
        <tr>
          <td width="10%">&nbsp;</td>
          <td height="50" align="right" valign="middle" bgcolor="#EEEEEE">
          <div id="<?php echo "addcomm".$instrucrec_fetch["instrucrec_ID"];?>"><a href="<?php echo "#addcommp".$instrucrec_fetch["instrucrec_ID"];?>" name="<?php echo "addcommp".$instrucrec_fetch["instrucrec_ID"];?>" onclick="addinstruccomm('<?php echo $timeline_ID;?>','<?php echo $instrucrec_fetch["instrucrec_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo "addcomm".$instrucrec_fetch["instrucrec_ID"];?>','<?php echo $tagid;?>')"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มความคิดเห็น&nbsp;&nbsp;</a>
          </div>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
	</center>
</div><br />