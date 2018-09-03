<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$class_ID=$_GET["class_ID"];
$teach_ID=$_GET["teach_ID"];
echo "<script type='text/javascript'>
		var class_ID='".$class_ID."';
		var teach_ID='".$teach_ID."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#teachdatacons').click(function(){
		$('#systemcontent').load("teachdatacons.php?class_ID="+class_ID);
	});
	$('#teachcheck').load('teachcheckreportc.php?class_ID='+class_ID+"&teach_ID="+teach_ID);
	$('#teachevaluate').load('teachevareportc.php');
	$('#teachkarma').load('teachkarmac.php');
});
</script>
<link href="../includefiles/stylepersonnel.css" rel="stylesheet" type="text/css" />
    	<div id="statusbar">หน้าหลัก(ข้อมูลส่วนตัว)</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    <td align="left" valign="middle" width="192"><a id="teachdatacons" href="#"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/stdteachdetailpdf.php?teach_ID=$teach_ID&class_ID=$class_ID";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></td>
    <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle"><b>ความคุม</b></td>
        <td></td>
    </tr>
	</table>
    </div>
        <div id="admincontent">
        	<div id="teachcheck">
            
        	</div>
            <div id="teachevaluate">
            
        	</div>
            <div id="teachkarma">
            
        	</div>
		</div>