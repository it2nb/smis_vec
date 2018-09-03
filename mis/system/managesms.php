<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#admincontent').load("smstopersonel.php");
	$('#smstopersonel').click(function(){
		$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		$('#admincontent').load("smstopersonel.php");
	});
	$('#smstoparent').click(function(){
		$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		$('#admincontent').load("smstoparent.php");
	});
	
});
</script>
<style type="text/css">
.div30per {
	background-color: #CCC;
	width: 32%;
	float: left;

}
</style>

	<div id="statusbar">ส่งข้อความ</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="64"><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
    	<td align="left" valign="middle" width="128"><a href="#" id="smstopersonel"><img src="../images/icons/64/smstopersonel.png" width="64" height="64"></a><a href="#" id="smstoparent"><img src="../images/icons/64/smstoparent.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
    	<td align="center" valign="middle">ส่งถึง</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
	</div>