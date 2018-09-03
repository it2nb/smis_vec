<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#personnelinfo').load('personnelinfo.php');
	$('#personneledu').load('personneledu.php');
	$('#personnelwork').load('personnelwork.php');
});
</script>
<link href="../includefiles/stylepersonnel.css" rel="stylesheet" type="text/css" />
    	<div id="statusbar">หน้าหลัก(ข้อมูลส่วนตัว)</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="reportpdf/personnelpdf.php" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a></div>
        <div id="admincontent">
        	<div id="personnelinfo">
            
        	</div>
            <div id="personneledu">
            
        	</div>
            <div id="personnelwork">
            
        	</div>
		</div>