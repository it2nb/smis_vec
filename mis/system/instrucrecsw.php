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
	list($term_comb,$year_comb) = split("/",$_POST["period_comb"]);
	$last_period = $_POST["period_comb"];
}else{
	list($term_comb,$year_comb) = split("/",$last_period);
}
$query="Select DISTINCT subject_ID,course_ID From teach Where teach_term='$term_comb' and teach_year='$year_comb' and personnel_ID='$personnel_ID'";
$subjectID_query=mysql_query($query,$conn) or die(mysql_error());
$subjectnum = mysql_num_rows($subjectID_query);

$thisyear=substr($year_comb+543,2,2);
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	$('#teachdata').click(function(){
		$('#systemcontent').load("teachdata.php");
	});
	//search
	$('#instrucrecswsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function instrucrecswdetail(sjid,csid,term,year){
	$.get('instrucrecswdetail.php',{'subject_ID':sjid,
		'course_ID':csid,
		'instrucrecsw_term':term,
		'instrucrecsw_year':year},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลการเรียนการสอน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="128">
       	  <a href="#" id="teachdata"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle"><b>ความคุม</b></td>
        
        <td>&nbsp;</td>
    </tr>
	</table>
</div>
    <div id="admincontent">
  <center><br />
  		<form id="instrucrecswsearchform" action="instrucrecsw.php" method="post">
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
                  <th height="50" colspan="6" bgcolor="#CCCCCC">ข้อมูลการเรียนการสอน ภาคเรียนที่  ( ทั้งหมด <?php echo $subjectnum;?> วิชา )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ระดับชั้น สาขางาน</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไขบันทึกหลังการสอน</td>
  </tr>
  <?php
  while($subjectID_fetch=mysql_fetch_assoc($subjectID_query))
  {
	$subject_ID=$subjectID_fetch["subject_ID"];
	$course_ID=$subjectID_fetch["course_ID"];
	$query="Select subject_name From subject Where subject_ID='$subject_ID' and course_ID='$course_ID'";
	$subject_query=mysql_query($query,$conn)or die(mysql_error());
	$subject_fetch=mysql_fetch_assoc($subject_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $subject_ID;?></td>
    <td align="left" valign="middle"><?php echo $subject_fetch["subject_name"];?></td>
    <td align="left" valign="middle">
	<?php 
		$query="Select teach_ID From teach Where subject_ID='$subject_ID' and course_ID='$course_ID' and teach_term='$term_comb' and teach_year='$year_comb' and personnel_ID='$personnel_ID'";
		$teach_query = mysql_query($query,$conn)or die(mysql_error());
		while($teach_fetch=mysql_fetch_assoc($teach_query)){
			$query="Select * From teachstd,major,area,class Where teachstd.class_ID=class.class_ID and class.major_ID=major.major_ID and area.area_ID=major.area_ID and teach_ID='".$teach_fetch["teach_ID"]."' group by teachstd.class_ID";
			$teachstd_query=mysql_query($query,$conn)or die(mysql_error());
			while($teachstd_fetch=mysql_fetch_assoc($teachstd_query)){
				echo $teachstd_fetch["area_level"].".".($thisyear-substr($teachstd_fetch["class_ID"],0,2)+1)."/".substr($teachstd_fetch["class_ID"],7,1)." ".$teachstd_fetch["major_name"]."<br>";
			}
		}
	?>
    </td>
    <td align="center" valign="middle"><a href="#" onclick="instrucrecswdetail('<?php echo $subject_ID;?>','<?php echo $course_ID;?>','<?php echo $term_comb;?>','<?php echo $year_comb;?>')"><img src="../images/icons/32/instrucrec.png" width="32" height="32" /></a></td>
  </tr>
  <?php } ?>
</table><br />
</center></div>