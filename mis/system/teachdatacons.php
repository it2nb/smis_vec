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
$period_fetch = mysql_fetch_assoc($period_query);
$last_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];
if($_POST["teachsearch_bt"]=="ค้นหา"){
	$class_ID = $_POST["classID_comb"];
	list($term_comb,$year_comb) = split("/",$_POST["period_comb"]);
	$last_period = $_POST["period_comb"];
}else{
	$class_ID = $_GET["class_ID"];
	list($term_comb,$year_comb) = split("/",$last_period);
}
$query="Select DISTINCT teachstd.teach_ID,subject.subject_ID,subject_name,personnel_name,personnel_ser From teachstd,teach,subject,personnel,student Where teachstd.teach_ID=teach.teach_ID and teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.personnel_ID=personnel.personnel_ID and teachstd.student_ID=student.student_ID and teach_term='$term_comb' and teach_year='$year_comb' and student.class_ID='$class_ID'";

$teach_query=mysql_query($query,$conn) or die(mysql_error());

$teachnum = mysql_num_rows($teach_query);
$thisyear=substr($year_comb+543,2,2);

echo "<script type='text/javascript'>
		var class_ID='".$class_ID."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	$('#consultdata').click(function(){
		$.get('consultdata.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data);})
	});
	
	//search
	$('#teachsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function teachdetail(teachid,classid){
	$.get('stdteachdetail.php',{'teach_ID':teachid,
		'class_ID':classid},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">ข้อมูลการเรียนของนักศึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="128">
       	  <a href="#" id="consultdata"><img src="../images/icons/64/back.png" width="64" height="64"></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
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
  <center><br />
  		<form id="teachsearchform" action="teachdatacons.php" method="post">
        <b>ค้นหา นักศึกษาในที่ปรึกษา กลุ่มเรียน </b>
       	  <select name="classID_comb" id="classID_comb">
        	  <?php
			  $query="Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and (personnel_ID='$personnel_ID' or personnel_ID2='$personnel_ID') Order By year DESC";
			  $class_query=mysql_query($query,$conn)or die(mysql_error());
			  while($class_fetch=mysql_fetch_assoc($class_query)){
				if($class_ID==$class_fetch["class_ID"])
				  	echo "<option value='".$class_fetch["class_ID"]."' selected='selected'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
				else
					echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["area_level"]." สาขา".$class_fetch["major_name"]." ".substr($class_fetch["class_ID"],0,2)."(".substr($class_fetch["class_ID"],7,1).")</option>";
			  }
			  ?>
       	  </select>
        	<b> ภาคเรียนที่ </b><select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_assoc($period_query)){
				if($last_period==($period_fetch["period_term"]."/".$period_fetch["period_year"]))
				  	echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."' selected='selected'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
				else
					echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
			  }
			  ?>
        	</select>
        	<input name="teachsearch_bt" type="submit" id="teachsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="80%" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
                    <th height="50" colspan="8" bgcolor="#CCCCCC">ข้อมูลรายวิชาของนักเรียนนักศึกษาในที่ปรึกษา ภาคเรียนที่  ( ทั้งหมด <?php echo $teachnum;?> วิชา )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">วัน เวลา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครููผู้สอน</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ห้องเรียน</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($teach_fetch=mysql_fetch_assoc($teach_query))
  {
	$query="Select count(student_ID) as studentnum From teachstd Where teach_ID='".$teach_fetch["teach_ID"]."'";
	$studentnum_query=mysql_query($query,$conn)or die(mysql_error());
	$studentnum_fetch=mysql_fetch_assoc($studentnum_query);
	$query="Select * From teachday Where teach_ID='".$teach_fetch["teach_ID"]."' Order By teachday_day ASC";
	$teachday_query=mysql_query($query,$conn)or die(mysql_error());
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><a href="#" onclick="teachdetail('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $class_ID;?>');" ><?php echo $teach_fetch["subject_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="teachdetail('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $class_ID;?>');" ><?php echo $teach_fetch["subject_name"];?></a></td>
    <td align="left" valign="middle">
    <?php
		while($teachday_fetch=mysql_fetch_assoc($teachday_query)){
			echo "วัน".$thday[$teachday_fetch["teachday_day"]]." (".substr($teachday_fetch["teachday_start"],0,5)."-".substr($teachday_fetch["teachday_stop"],0,5).")<br>";
		}
    ?></td>
    <td align="left" valign="middle"><?php echo $teach_fetch["personnel_name"]." ".$teach_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteteach('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $teach_fetch["subject_name"];?>');" ><img src="../images/icons/32/delete.png" width="32" height="32"></a></td>
  </tr>
  <?php } ?>
</table><br />
</center></div>