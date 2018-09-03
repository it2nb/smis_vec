<?php
session_start();
include("../includefiles/connectdb.php");
include '../classes/teachscore.class.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID = $_GET["teach_ID"];
$main_obj = new Teachscore_class($conn,$teach_ID);
$main_obj->queryTeach();
echo "<script type='text/javascript'>var teach_ID='".$teach_ID."'</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#teachdetaildata').click(function(){
		$.get('teachdetaildata.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
	});
	$('#teachscoretype').load('teachscoretype.php?teach_ID='+teach_ID);
	$('#stdscore').load('stdscore.php?teach_ID='+teach_ID);
});
</script>
   	<div id="statusbar">จัดการคะแนนวิชา <?php echo $teach_fetch["subject_name"];?></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="192"><a href="#" id="teachdetaildata"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="reportpdf/scorereport.php?teach_ID=<?php echo $teach_ID; ?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a>
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
  		<?php echo "รหัสวิชา ".$main_obj->subject_ID." ชื่อวิชา ".$main_obj->subject_name." จำนวน ".$main_obj->subject_unit." หน่วยกิต ทฤษฎี ".$main_obj->subject_hourt." ชั่วโมง ปฏิบัติ ".$main_obj->subject_hourp." ชั่วโมง";?></b>
    <br /><hr />
    <div id="header">
    	</div>
        <div id="admincontentleft">
        	<div id="teachscoretype"></div>
        </div>
        <div id="admincontentleft">
        	<div id="stdscore"></div>
        </div></center>
</div><br />
</div>