<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID = $_GET["teach_ID"];
$query="Select * From teach, subject, class Where teach.course_ID=subject.course_ID and teach.subject_ID=subject.subject_ID and teach.teach_ID='$teach_ID'";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
$teach_fetch=mysql_fetch_assoc($teach_query);
echo "<script type='text/javascript'>var teach_ID='".$teach_ID."'</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#teachdata').click(function(){
		$('#systemcontent').load("teachdata.php");
	});
	$('#instrucrec').click(function(){
		$.get('instrucrec.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachscore').click(function(){
		$.get('teachscore.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachrecord').click(function(){
		$.get('teachrecord.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachcheck').click(function(){
		$.get('teachcheck.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachcheckreportday').click(function(){
		$.get('teachcheckreportday.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachday').load('teachday.php?teach_ID='+teach_ID);
	$('#teacheva').load('teacheva.php?teach_ID='+teach_ID);
	$('#teachstd').load('teachstd.php?teach_ID='+teach_ID);
});
</script>
   	<div id="statusbar">จัดการข้อมูลการเรียนการสอนวิชา <?php echo $teach_fetch["subject_name"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    <td align="left" valign="middle" width="128"><a href="#" id="teachdata"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
      </td>
      <td align="left" valign="middle" width="128"><a href="#" id="teachcheckreportday"><img width="64" height="64" src="../images/icons/64/teachcheckreportday.png"/></a><a href="#" id="teachcheck"><img src="../images/icons/64/teachcheck.png" width="64" height="64" /></a>
      </td>
      <td align="left" valign="middle" width="128">
      	<a href="#" id="teachscore"><img src="../images/icons/64/score.png" width="64" height="64" /></a><a href="#" id="teachrecord"><img src="../images/icons/64/record.png" width="64" height="64" /></a>
      </td>
      <td align="left" valign="middle" width="64">
      	<a href="#" id="instrucrec"><img src="../images/icons/64/instrucrec.png" width="64" height="64" /></a>
      </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    <td align="center" valign="middle"><b>ความคุม</b></td>
      <td align="center" valign="middle"><b>เวลาเรียน</b></td>
      <td align="center" valign="middle"><b>ผลการเรียน</b></td>
      <td align="center" valign="middle"><b>บันทึก</b></td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center><br /><b>
  		<?php echo "รหัสวิชา ".$teach_fetch["subject_ID"]." ชื่อวิชา ".$teach_fetch["subject_name"]." จำนวน ".$teach_fetch["subject_unit"]." หน่วยกิต ทฤษฎี ".$teach_fetch["subject_hourt"]." ชั่วโมง ปฏิบัติ ".$teach_fetch["subject_hourp"]." ชั่วโมง";?></b>
    <br /><hr />
    <div id="teachday">
    	</div>
        <div id="teacheva">
        </div>
        <div id="teachstd">
        </div></center>
</div><br />
</div>