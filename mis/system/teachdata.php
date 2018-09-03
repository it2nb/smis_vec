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
if($_GET["teachdelete_bt"]=="ลบ"){
	$teach_ID = $_GET["teach_ID"];
	$query = "Select * From teach Where teach_ID='$teach_ID'";
	$teach_query = mysql_query($query,$conn) or die(mysql_error());
	$teach_fetch = mysql_fetch_assoc($teach_query);
	$subject_ID = $teach_fetch["subject_ID"];
	$course_ID = $teach_fetch["course_ID"];
	$query = "Delete From teach Where teach_ID='$teach_ID'";
	$teach_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From teachday Where teach_ID='$teach_ID'";
	$teachday_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From teachstd Where teach_ID='$teach_ID'";
	$teachstd_query = mysql_query($query,$conn) or die(mysql_error());
	$query = "Delete From teachcheck Where teach_ID='$teach_ID'";
	$teachcheck_query = mysql_query($query,$conn) or die(mysql_error());
	$member_ID = $_SESSION["userID"];
	$userlogs_des="ลบรายวิชาที่สอนรหัส ".$subject_ID." หลักสูตร ".$course_ID." ภาคเรียนที่ ".$_GET["period_comb"];
	$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Delete Teach','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	$last_period = $_GET["period_comb"];
}

if($_POST["teachsearch_bt"]=="ค้นหา"){
	list($term_comb,$year_comb) = split("/",$_POST["period_comb"]);
	$query="Select count(teach_ID) as totalteach From teach Where teach_term='$term_comb' and teach_year='$year_comb' and personnel_ID='$personnel_ID'";
	$teachnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From teach,subject Where teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.teach_term='$term_comb' and teach.teach_year='$year_comb' and personnel_ID='$personnel_ID' Order By subject.subject_ID ASC";
	$last_period = $_POST["period_comb"];
}else{
	list($term_comb,$year_comb) = split("/",$last_period);
	$query="Select count(teach_ID) as totalteach From teach Where teach_term='$term_comb' and teach_year='$year_comb' and personnel_ID='$personnel_ID'";
	$teachnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From teach,subject Where teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.teach_term='$term_comb' and teach.teach_year='$year_comb' and personnel_ID='$personnel_ID' Order By subject.subject_ID ASC";
}

$teachnum_fetch=mysql_fetch_assoc($teachnum_query);
$teachnum = $teachnum_fetch["totalteach"];

$teach_query=mysql_query($query,$conn) or die(mysql_error());
$thisyear=substr($year_comb+543,2,2);
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	$('#addteach').click(function(){
		$('#systemcontent').load("addteach.php");
	});
	$('#instrucrecsw').click(function(){
		//$.get('instrucrecsw.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
		$('#systemcontent').load("instrucrecsw.php");
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
function deleteteach(id, txt){
	var conf = confirm("คุณแน่ใจว่าจะลบรายวิชา "+txt);
	var period = document.getElementById("period_comb").value;
	if(conf==true)
		$.get('teachdata.php',{
			'teach_ID':id,
			'period_comb':period,
			'teachdelete_bt':'ลบ'},function(data){$('#systemcontent').html(data)});
}
function teachdetail(id){
	$.get('teachdetaildata.php',{'teach_ID':id},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลการเรียนการสอน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    <td align="left" valign="middle" width="128">
       	  <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a><a href="#" id="addteach"><img src="../images/icons/64/add.png" width="64" height="64"></a>
        </td>
    <td align="left" valign="middle" width="64">
       	  <a href="#" id="instrucrecsw"><img src="../images/icons/64/instrucrec.png" width="64" height="64" /></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    <td align="center" valign="middle"><b>ความคุม</b></td>
    <td align="center" valign="middle"><b>บันทึก</b></td>
        <td>&nbsp;</td>
    </tr>
	</table>
</div>
    <div id="admincontent">
  <center><br />
  		<form id="teachsearchform" action="teachdata.php" method="post">
        	<b>ค้นหา ภาคเรียนที่ </b><select name="period_comb" id="period_comb">
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
                  <th height="50" colspan="8" bgcolor="#CCCCCC">ข้อมูลการเรียนการสอน ภาคเรียนที่  ( ทั้งหมด <?php echo $teachnum;?> วิชา )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">วัน เวลา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ระดับชั้น สาขางาน</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนผู้เรียน</td>
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
    <td align="center" valign="middle"><a href="#" onclick="teachdetail('<?php echo $teach_fetch["teach_ID"];?>');" ><?php echo $teach_fetch["subject_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="teachdetail('<?php echo $teach_fetch["teach_ID"];?>');" ><?php echo $teach_fetch["subject_name"];?></a></td>
    <td align="left" valign="middle">
    <?php
		while($teachday_fetch=mysql_fetch_assoc($teachday_query)){
			echo "วัน".$thday[$teachday_fetch["teachday_day"]]." (".substr($teachday_fetch["teachday_start"],0,5)."-".substr($teachday_fetch["teachday_stop"],0,5).")<br>";
		}
    ?></td>
    <td align="left" valign="middle"><?php 
	$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='".$teach_fetch["teach_ID"]."' group by teachstd.class_ID";
	$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
	while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)){
		echo $teachstd_fetch["area_level"].".".($thisyear-substr($teachstd_fetch["class_ID"],0,2)+1)."/".substr($teachstd_fetch["class_ID"],7,1)." ".$teachstd_fetch["major_name"]."<br>";
	}
	
	?></td>
    <td align="center" valign="middle"><?php echo $studentnum_fetch["studentnum"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteteach('<?php echo $teach_fetch["teach_ID"];?>','<?php echo $teach_fetch["subject_name"];?>');" ><img src="../images/icons/32/delete.png" width="32" height="32"></a></td>
  </tr>
  <?php } ?>
</table><br />
</center></div>