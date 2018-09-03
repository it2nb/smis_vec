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
if($_POST["addcommswdetail_bt"]=="บันทึก"){
	$timeline_ID=$_POST["timeline_ID"];
	$tagid=$_POST["tagid"];
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
	$query="Select personnel_ID,personnel_name,personnel_ser From personnel Where personnel_ID=(Select personnel_ID From instrucrecsw Where instrucrecsw_ID='$instrucrecsw_ID')"; 
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
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrecsw','$instrucrecsw_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccommsw_detail." รหัสบันทึกหลังการสอน ".$instrucrecsw_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccommsw','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$query="Select max(timeline_ID) as lasttimeline From timeline";
	$lastimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$lasttimeline_fetch=mysql_fetch_assoc($lastimeline_query);
	$timeline_ID=$lasttimeline_fetch["lasttimeline"];
	
}
else if($_GET["addinstruccommkn_bt"]=="save"){
	$timeline_ID=$_GET["timeline_ID"];
	$instrucrecsw_ID=$_GET["instrucrecsw_ID"];
	$subject_ID=$_GET["subject_ID"];
	$course_ID=$_GET["course_ID"];
	$instrucrecsw_term=$_GET["instrucrecsw_term"];
	$instrucrecsw_year=$_GET["instrucrecsw_year"];
	$personnel_ID=$_GET["personnel_ID"];
	$tagid=$_GET["tagid"];
	$instruccommsw_detail="ทราบ";
	$update_date=date("Y-m-d H:i:s");
	$query="Insert Into instruccommsw(instruccommsw_detail,instruccommsw_date,instrucrecsw_ID,personnel_ID) Values ('$instruccommsw_detail','$update_date','$instrucrecsw_ID','$personnel_ID')";
	$instruccommsw_insert=mysql_query($query,$conn)or die(mysql_error());
	
	$query="Delete From timeline Where timeline_type='instrucrecsw' and timeline_typeID='$instrucrecsw_ID'";
	$timeline_delete = mysql_query($query,$conn)or die(mysql_error());
	$query="Select personnel_ID,personnel_name,personnel_ser From personnel Where personnel_ID=(Select personnel_ID From instrucrecsw Where instrucrecsw_ID='$instrucrecsw_ID')"; 
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
	$query="Insert Into timeline(timeline_title,timeline_date,timeline_type,timeline_typeID) Values ('$timeline_title','$update_date','instrucrecsw','$instrucrecsw_ID')";
	$timeline_insert = mysql_query($query,$conn)or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des='บันทึกความคิดเห็น '.$instruccommsw_detail." รหัสบันทึกหลังการสอน ".$instrucrecsw_ID;
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Instruccommsw','teach_mis','$userlogs_des')";
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
$instrucrecsw_ID=$timeline_fetch["timeline_typeID"];
$query="Select * From instrucrecsw Where instrucrecsw_ID='$instrucrecsw_ID'";
$instrucrecsw_query=mysql_query($query,$conn)or die(mysql_error());
$instrucrecsw_fetch=mysql_fetch_assoc($instrucrecsw_query);
//$query = "Select * From teach Where subject_ID";
//$teachday_query=mysql_query($query,$conn)or die(mysql_error());
//$teachday_fetch=mysql_fetch_assoc($teachday_query);
//$query="Select * From period Where period_term='".$teachday_fetch["teach_term"]."' and period_year='".$teachdaysw_fetch["teach_year"]."'";
//$period_query=mysql_query($query,$conn)or die(mysql_error());
//$period_fetch=mysql_fetch_assoc($period_query);
//$stdate = new DateTime($period_fetch["period_start"],new DateTimeZone('Asia/Bangkok'));
//date_modify($stdate,("+".(($teachday_fetch["teachday_day"]-1)+(($instrucrec_fetch["week"]-1)*7))." day"));
//$date_instrucrec=$stdate->format("Y-m-d");
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	
	//headmenu
	//$('#instrucrec').load('teachscoretype.php?teach_ID='+teach_ID);
});
function addinstruccommsw(id, recid, perid, sjid, csid, term, year, tag, tagid){
	$.get('timeline/addinstruccommsw.php',{'timeline_ID':id,
		'instrucrecsw_ID':recid,
		'personnel_ID':perid,
		'subject_ID':sjid,
		'course_ID':csid,
		'instrucrecsw_term':term,
		'instrucrecsw_year':year,
		'tagid':tagid},function(data){$('#'+tag).html(data)});
}
function addinstruccommswkn(id, recid, perid, sjid, csid, term, year, tagid){
	$.get('timeline/instrucrecsw.php',{'timeline_ID':id,
		'instrucrecsw_ID':recid,
		'personnel_ID':perid,
		'subject_ID':sjid,
		'course_ID':csid,
		'instrucrecsw_term':term,
		'instrucrecsw_year':year,
		'tagid':tagid,
		'addinstruccommkn_bt':'save'},function(data){$('#'+tagid).html(data)});
}
</script>
<style type="text/css">


</style>


<div id="instrucrec">
    <?php
		//list($rec_year,$rec_month,$rec_day) = split("-",$date_instrucrec);
		$query="Select personnel_name,personnel_ser,personnel_picfile From personnel Where personnel_ID='".$instrucrecsw_fetch["personnel_ID"]."'"; 
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
          <div id="<?php echo "instrucrecsw".$instrucrec_fetch["instrucrecsw_ID"];?>">
          <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
              <td width="60" rowspan="2" align="center" valign="top" bgcolor="#EEEEEE"><img src="../../images/personnel/<?php echo mysql_result($personnel_query,0,"personnel_picfile");?>" width="60" /></td>
              <td>
              <p>
              <b>บันทึกหลังการสอนวิชา
          <?php
		  $query="Select * From subject Where subject_ID='".$instrucrecsw_fetch["subject_ID"]."' and course_ID='".$instrucrecsw_fetch["course_ID"]."'";
		  $subject_query=mysql_query($query,$conn)or die(mysql_error());
		  echo mysql_result($subject_query,0,"subject_name")." สัปดาห์ที่ ".$instrucrecsw_fetch["instrucrecsw_week"];
          ?></b><br />
          <?php 
		$query="Select teach_ID From teach Where subject_ID='".$instrucrecsw_fetch["subject_ID"]."' and course_ID='".$instrucrecsw_fetch["course_ID"]."' and teach_term='".$instrucrecsw_fetch["instrucrecsw_term"]."' and teach_year='".$instrucrecsw_fetch["instrucrecsw_year"]."' and personnel_ID='".$instrucrecsw_fetch["personnel_ID"]."'";
		$teach_query = mysql_query($query,$conn)or die(mysql_error());
		while($teach_fetch=mysql_fetch_assoc($teach_query)){
			$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='".$teach_fetch["teach_ID"]."' group by teachstd.class_ID";
			$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
			while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)){
				echo $teachstd_fetch["area_level"].".".(substr($instrucrecsw_fetch["instrucrecsw_year"]+543,2,2)-substr($teachstd_fetch["class_ID"],0,2)+1)."/".substr($teachstd_fetch["class_ID"],7,1)." ".$teachstd_fetch["major_name"].", ";
			}
		}
	?>
          </p>
			  <?php echo $instrucrecsw_fetch["instrucrecsw_detail"];?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#EEEEEE">บันทึกเมื่อวัน
                <?php 
			  list($instrucrecsw_date,$instrucrecsw_time) = split(" ",$instrucrecsw_fetch["instrucrecsw_date"]);
			  if(!empty($instrucrecsw_date)){
			  list($instrucrecsw_year,$instrucrecsw_month,$instrucrecsw_day) = split("-",$instrucrecsw_date);
			  	echo $thday[jddayofweek(gregoriantojd($instrucrecsw_month,$instrucrecsw_day,$instrucrecsw_year),0)]." ที่ ".(int)$instrucrecsw_day." ".$thmonth[(int)$instrucrecsw_month]." ".((int)$instrucrecsw_year+543)." เวลา ".$instrucrecsw_time;
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
          <a href="<?php echo "#addcommpskn".$instrucrecsw_fetch["instrucrecsw_ID"];?>" name="<?php echo "addcommpskn".$instrucrecsw_fetch["instrucrecsw_ID"];?>" onclick="addinstruccommswkn('<?php echo $timeline_ID;?>','<?php echo $instrucrecsw_fetch["instrucrecsw_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $instrucrecsw_term;?>','<?php echo $instrucrecsw_year;?>','<?php echo $tagid;?>')"><img src="../images/icons/timeline/know.png" width="60" height="30" /></a>&nbsp;&nbsp;
          </td>
        </tr>
        <?php
		}
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
              <td bgcolor="#FAFAFA"><?php echo nl2br($instruccommsw_fetch["instruccommsw_detail"]);?></td>
              </tr>
            <tr>
              <td align="right" valign="middle" bgcolor="#FAFAFA"><?php echo mysql_result($personnel_query,0,"personnel_name")." ".mysql_result($personnel_query,0,"personnel_ser")." ( ".(int)$instruccommsw_day." ".$thmountbf[(int)$instruccommsw_month]." ".((int)$instruccommsw_year+543)." ".$instruccommsw_time." )";?>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <?php } 
		if(!empty($instrucrecsw_date)){?>
        <tr>
          <td width="10%">&nbsp;</td>
          <td height="50" align="right" valign="middle" bgcolor="#EEEEEE">
          <div id="<?php echo "addcommsw".$instrucrecsw_fetch["instrucrecsw_ID"];?>"><a href="<?php echo "#addcommps".$instrucrecsw_fetch["instrucrecsw_ID"];?>" name="<?php echo "addcommps".$instrucrecsw_fetch["instrucrecsw_ID"];?>" onclick="addinstruccommsw('<?php echo $timeline_ID;?>','<?php echo $instrucrecsw_fetch["instrucrecsw_ID"];?>','<?php echo $_SESSION["user_personnelID"];?>','<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $instrucrecsw_term;?>','<?php echo $instrucrecsw_year;?>','<?php echo "addcommsw".$instrucrecsw_fetch["instrucrecsw_ID"];?>','<?php echo $tagid;?>')"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มความคิดเห็น&nbsp;&nbsp;</a>
          </div>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
	</center>
</div><br />