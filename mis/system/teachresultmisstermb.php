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
if($_POST["termsearch_bt"]=="ค้นหา"){
	$check_period = $_POST["period_comb"];
}
if(empty($_GET["n"]))
	$n=0;
else
	$n=$_GET["n"];
if(empty($check_period)){
	$check_period = $last_period;
}
list($flag_term,$flag_tyear) = split("/",$check_period);
$query = "select teachcheck.teach_ID From teachcheck,teach,teachday Where teachcheck.teach_ID=teach.teach_ID and teachcheck.teachday_ID=teachday.teachday_ID and teachcheck_result=0 and teach.teach_term='$flag_term' and teach.teach_year='$flag_tyear' Group By teachcheck.teach_ID,teachcheck.student_ID";
$nrow_query = mysql_query($query,$conn)or die(mysql_error());
$nrow = mysql_num_rows($nrow_query);
$query = "select teachcheck.teach_ID,teachcheck.student_ID,student_name,student_prefix,student_ser,class_ID,student_parphone,teach_hour,count(teachcheck_ID) as missday,sum(teachday_hour) as steachday_hour,(sum(teachday_hour)/(teach_hour*18)*100) as percent From teachcheck,teach,teachday,student Where teachcheck.teach_ID=teach.teach_ID and teachcheck.teachday_ID=teachday.teachday_ID and teachcheck.student_ID=student.student_ID and teachcheck_result=0 and teach.teach_term='$flag_term' and teach.teach_year='$flag_tyear' Group By teachcheck.teach_ID,teachcheck.student_ID Order By percent DESC Limit $n,30";
$student_query = mysql_query($query,$conn)or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#studentresult').click(function(){
		$('#systemcontent').load('studentresult.php');
	});
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
function changepage(npage){
	//var url = "manageuser.php?n="+npage+"&usersearch_txt="+usersearch_txt;
	//$('#systemcontent').load(url);
	$.get('teachresultmisstermb.php',{'n':npage},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">ข้อมูลผู้ขาดเรียนแบบรายภาคเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" id="studentresult"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/teachresultmisstermbpdf.php?check_period=$check_period";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
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
	<form id="periodsearchform" action="teachresultmisstermb.php" method="post">
        	<b>ค้นหา นักศึกษาขาดการเข้าเรียน </b><b> ภาคเรียนที่</b>
       	  &nbsp;
          <select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_assoc($period_query)){
				if($check_period==($period_fetch["period_term"]."/".$period_fetch["period_year"]))
				  	echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."' selected='selected'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
				else
					echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
			  }
			  ?>
        	</select>
            
       	  <input name="termsearch_bt" type="submit" id="termsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <th height="50" colspan="9" bgcolor="#CCCCCC">รายงานการขาดการเข้าเข้าเรียน<br />
ภาคเรียนที่ <?php echo substr($check_period,0,1);?> ปีการศึกษา <?php echo substr($check_period,2,4)+543;?></th>
  <tr>
    <td width="2%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อสกุล</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รายวิชา/ครูผู้สอน</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">วัน<br />
      ขาด/ทั้งหมด</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชั่วโมง<br />
      ขาด/ทั้งหมด</td>
    <td width="8%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">% การขาด</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
    </tr>
  <?php
  while($student_fetch=mysql_fetch_assoc($student_query))
  {  
	  if($student_fetch["student_endstatus"]==0){
		  $query = "Select personnel_name,personnel_ser From personnel,class Where personnel.personnel_ID=class.personnel_ID and class.class_ID='".$student_fetch["class_ID"]."'";
	  	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	  $personnel_fetch = mysql_fetch_assoc($personnel_query);
	  	  $query = "Select personnel_name,personnel_ser From personnel,class Where personnel.personnel_ID=class.personnel_ID2 and class.class_ID='".$student_fetch["class_ID"]."'";
	  	  $personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	  $personnel2_fetch = mysql_fetch_assoc($personnel_query);
		  $query="Select subject_name,personnel_name,personnel_ser,count(teachday_ID) as cteachday From teach,teachday,subject,personnel Where teach.teach_ID=teachday.teach_ID and teach.subject_ID=subject.subject_ID and teach.course_ID=subject.course_ID and teach.personnel_ID=personnel.personnel_ID and teach.teach_ID='".$student_fetch["teach_ID"]."' Group By teach.teach_ID";
		  $subject_query = mysql_query($query,$conn)or die(mysql_error());
		  $subject_fetch = mysql_fetch_assoc($subject_query);
  ?>
  <tr
  <?php
  	if((100-$student_fetch["percent"])<80)
		echo "bgcolor='#FF6666'";
	else if((100-$student_fetch["percent"])<85)
		echo "bgcolor='#FFCC99'";
	else if((100-$student_fetch["percent"])<90)
		echo "bgcolor='#FFFF99'";
  ?>>
    <td width="5%" height="25" align="center" valign="middle" bgcolor=""><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td align="left" valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><?php echo $subject_fetch["subject_name"]."<br>".$subject_fetch["personnel_name"]." ".$subject_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["missday"]." / ".($subject_fetch["cteachday"]*18);?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["steachday_hour"]." / ".($student_fetch["teach_hour"]*18);?></td>
    <td align="center" valign="middle"><?php echo round($student_fetch["percent"],2);?></td>
    <td align="left" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_parphone"];?></td>
    </tr>
  <?php }} ?>
</table><br />
<?php
$totalpage=ceil($nrow/30);
if($totalpage>1)
{
	echo "หน้า ";
	for($i=1;$i<=$totalpage;$i++)
	{
		if($i>1)
			echo " | ";
		$npage=30*($i-1);
		if(ceil($n/30)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>";
	}
} 
?>
</center></div>