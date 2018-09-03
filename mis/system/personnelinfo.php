<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$query="Select * From personnel Where personnel_ID='$personnel_ID'";
$personnel_query = mysql_query($query,$conn)or die(mysql_error());
$personnel_fetch = mysql_fetch_array($personnel_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#updatepersonnelinfo').click(function(){
		$('#perinfo').load('updatepersonnelinfo.php');
	});
	$('#updateperimg').click(function(){
		$('#personnelimg').load('updateperimg.php');
	});
	$('#personnelimg img').attr('src', $('#personnelimg img').attr('src') + '?' + Math.random());
});
</script>
<?php include("../includefiles/datalist.php");?>
<div id="perinfo">
<span class="BlueDark"><h3>&nbsp;&nbsp;ประวัติส่วนตัวทั่วไป</h3></span>
 <div id="personnelimg" align="center"><img src="../../images/personnel/<?php echo $personnel_fetch["personnel_picfile"];?>" /><br /><a href="#" id="updateperimg">เปลี่ยนรูปภาพ</a></div>
<div id="personnelinfo1">
<ul>
	<li><b>ชื่อ - สกุล : </b><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?></li>
    <li><b>เพศ : </b><?php echo $personnel_fetch["personnel_gender"];?></li>
    <li><b>วันเดือนปี เกิด : </b><?php echo (substr($personnel_fetch["personnel_birthday"],8,2)+0)." ".$thmonth[(substr($personnel_fetch["personnel_birthday"],5,2)+0)]." ".(substr($personnel_fetch["personnel_birthday"],0,4)+543);?></li>
    <li><b>อายุ : </b><?php echo (date('Y')-substr($personnel_fetch["personnel_birthday"],0,4));?> ปี</li>
    <li><b>เชื่อชาติ : </b><?php echo $personnel_fetch["personnel_nationality"];?></li>
    <li><b>สัญชาติ : </b><?php echo $personnel_fetch["personnel_origin"];?></li>
    <li><b>ตำแหน่ง : </b><?php echo $personnel_fetch["personnel_position"];?></li>
    <li><b>เลขที่ตำแหน่ง : </b><?php echo $personnel_fetch["personnel_positionno"];?></li>
    <li><b>วันที่เริ่มทำงาน : </b><?php echo (substr($personnel_fetch["personnel_startwork"],8,2)+0)." ".$thmonth[(substr($personnel_fetch["personnel_startwork"],5,2)+0)]." ".(substr($personnel_fetch["personnel_startwork"],0,4)+543);?></li>
</ul>
</div>
<div id="personnelinfo1">
<ul>
	<li><b>สถานศึกษา : </b><?php echo $personnel_fetch["personnel_school"];?></li>
    <li><b>สังกัด : </b><?php echo $personnel_fetch["personnel_agency"];?></li>
    <li><b>ระดับการศึกษาสูงสุด : </b><?php echo $personnel_fetch["personnel_lastedu"];?></li>
    <li><b>วุฒิการศึกษา : </b><?php echo $personnel_fetch["personnel_lastedumajor"];?></li>
    <li><b>ที่อยู่ตามทะเบียนบ้าน : </b><br /><?php echo nl2br($personnel_fetch["personnel_addbr"]);?></li>  
    <li><b>ที่อยู่ปัจจุบัน : </b><br /><?php echo nl2br($personnel_fetch["personnel_addnow"]);?></li>
    <li><b>เบอร์โทรศัพท์(มือถือ) : </b><?php echo $personnel_fetch["personnel_phone"];?></li>
    <li><b>E-mail : </b><?php echo $personnel_fetch["personnel_email"];?></li>
    <li><b>ผลงานที่ภาคภูมิใจ : </b><br /><?php echo nl2br($personnel_fetch["personnel_award"]);?></li>
</ul><div align="right"><a href="#" id="updatepersonnelinfo"><img src="../images/icons/16/edit.png" width="16" height="16"/> แก้ไข</a>&nbsp;&nbsp;</div>
</div>
</div>