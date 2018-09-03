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
	$('#admincontent').load('timelinelist.php?listpos=first');
});
function timelinelist(id, tagid, listpos){
	$.get('timelinelist.php',{'timeline_ID':id,'listpos':listpos},function(data){$('#'+tagid).html(data)});
}
</script>
    	<div id="statusbar">หน้าหลัก(ข้อมูลส่วนตัว)</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu" align="center"></div>
        <div id="admincontent">
		</div>