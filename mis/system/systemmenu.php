<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//user
	$('#mainlink').click(function(){
		$.get('systemmenu.php',{'navname':'navmain'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('timeline.php');
			});
	});
	$('#userdatalink').click(function(){
		$.get('systemmenu.php',{'navname':'navuserdata'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('userdata.php');
			});
	});
	$('#userpasslink').click(function(){
		$.get('systemmenu.php',{'navname':'navuserpass'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('edituserindi.php');
			});
	});
	$('#teachlink').click(function(){
		$.get('systemmenu.php',{'navname':'navteach'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('teachdata.php');
			});
	});
	$('#consultlink').click(function(){
		$.get('systemmenu.php',{'navname':'navconsult'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('consultdata.php');
			});
	});
	$('#selfdeveloplink').click(function(){
		$.get('systemmenu.php',{'navname':'navselfdevelop'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('selfdevelopdata.php');
			});
	});
	$('#researchlink').click(function(){
		$.get('systemmenu.php',{'navname':'navresearch'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('researchdata.php');
			});
	});
	$('#activitylink').click(function(){
		$.get('systemmenu.php',{'navname':'navactivity'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('activitydata.php');
			});
	});
	$('#servicelink').click(function(){
		$.get('systemmenu.php',{'navname':'navservice'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('servicedata.php');
			});
	});
	//boss
	$('#studentresultlink').click(function(){
		$.get('systemmenu.php',{'navname':'navstudentresult'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('studentresult.php');
			});
	});
	$('#teacherresultlink').click(function(){
		$.get('systemmenu.php',{'navname':'navteacherresult'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('teacherresult.php');
			});
	});
	$('#sarresultlink').click(function(){
		$.get('systemmenu.php',{'navname':'navsarresult'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('sarresult.php');
			});
	});
		$('#smsblink').click(function(){
		$.get('systemmenu.php',{'navname':'navsmsb'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('managesms.php');
			});
	});
	//report
	$('#presultlink').click(function(){
		$.get('systemmenu.php',{'navname':'navpresult'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('presult.php');
			});
	});
	$('#preportlink').click(function(){
		$.get('systemmenu.php',{'navname':'navpreport'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('preport.php');
			});
	});
	//admin
	$('#periodlink').click(function(){
		$.get('systemmenu.php',{'navname':'navperiod'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageperiod.php');
			});
	});
	$('#userlink').click(function(){
		$.get('systemmenu.php',{'navname':'navuser'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageuser.php');
			});
	});
	$('#partylink').click(function(){
		$.get('systemmenu.php',{'navname':'navparty'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageparty.php');
			});
	});
	$('#majorlink').click(function(){
	$.get('systemmenu.php',{'navname':'navmajor'},function(data){
		$('#leftmenu').html(data);
		$('#systemcontent').load('manageareamajor.php');
		});
	});
	$('#departlink').click(function(){
		$.get('systemmenu.php',{'navname':'navdepart'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('managedepart.php');
			});
	});
	$('#boardlink').click(function(){
		$.get('systemmenu.php',{'navname':'navboard'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('addeduboard.php');
			});
	});
	$('#stdlink').click(function(){
		$.get('systemmenu.php',{'navname':'navstd'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('managestudent.php');
			});
	});
	$('#subjectlink').click(function(){
		$.get('systemmenu.php',{'navname':'navsubject'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('managesubject.php');
			});
	});
	$('#maffectivelink').click(function(){
		$.get('systemmenu.php',{'navname':'navmaffective'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageaffective.php');
			});
	});
	$('#mteachlink').click(function(){
		$.get('systemmenu.php',{'navname':'navmteach'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageteach.php');
			});
	});
	$('#actlink').click(function(){
		$.get('systemmenu.php',{'navname':'navact'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageactnews.php');
			});
	});
	$('#announlink').click(function(){
		$.get('systemmenu.php',{'navname':'navannoun'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageannounced.php');
			});
	});
	$('#informlink').click(function(){
		$.get('systemmenu.php',{'navname':'navinform'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('manageinformation.php');
			});
	});
	$('#smsalink').click(function(){
		$.get('systemmenu.php',{'navname':'navsmsa'},function(data){
			$('#leftmenu').html(data);
			$('#systemcontent').load('managesms.php');
			});
	});
});
</script>
<link href="../includefiles/styleadminmenu.css" rel="stylesheet" type="text/css" />
<div id="adminmenu">
<ul class="navigation" id="<?php if(!empty($_GET["navname"]))echo $_GET["navname"]; else echo "navmain"; ?>">
<center><div class="headmenu">ผู้ใช้ระบบ</div></center>
<li class="menulist" id="mainlink"><a href="#">หน้าหลัก</a></li>
<li class="menulist" id="userdatalink"><a href="#">ข้อมูลส่วนตัว</a></li>
<li class="menulist" id="userpasslink"><a href="#">เปลี่ยนชื่อผู้ใช้ รหัสผ่าน</a></li>
<?php if(substr($_SESSION["user_status"],2,1) || substr($_SESSION["user_status"],3,1)){ ?>
<li class="menulist" id="consultlink"><a href="#">ครูที่ปรึกษา</a></li>
<li class="menulist" id="teachlink"><a href="#">การเรียนการสอน</a></li>
<!--li class="menulist" id="selfdeveloplink"><a href="#">การพัฒนาตนเอง</a></li>
<li class="menulist" id="researchlink"><a href="#">งานวิจัย</a></li>
<li class="menulist" id="activitylink"><a href="#">การร่วมกิจกรรม</a></li>
<li class="menulist" id="servicelink"><a href="#">การบริการวิชาชีพ</a></li-->
<?php } ?>
</ul>

<?php if(substr($_SESSION["user_status"],1,1)||substr($_SESSION["user_status"],0,1)){ ?>
<ul class="navigation" id="<?php if(!empty($_GET["navname"]))echo $_GET["navname"]; else echo "navmain"; ?>">
<center><div class="headmenu">ผู้บริหาร</div></center>
<!--li class="menulist" id="sarresultlink"><a href="#">ผลการดำเนินการประเมินตนเอง</a></li-->
<li class="menulist" id="studentresultlink"><a href="#">ข้อมูลนักเรียนนักศึกษา</a></li>
<li class="menulist" id="teacherresultlink"><a href="#">ข้อมูลครู</a></li>
<li class="menulist" id="smsblink"><a href="#">ส่งข้อความ</a></li>
</ul>
<?php } ?>
<?php if(substr($_SESSION["user_status"],2,1)){ ?>
<!--ul class="navigation" id="<?php if(!empty($_GET["navname"]))echo $_GET["navname"]; else echo "navmain"; ?>">
<center><div class="headmenu">รายงาน</div></center>
<li class="menulist" id="presultlink"><a href="#">ผลการประเมินตนเอง</a></li>
</ul-->
<?php } ?>
<?php if(substr($_SESSION["user_status"],0,1)){ ?>
<ul class="navigation" id="<?php if(!empty($_GET["navname"]))echo $_GET["navname"]; else echo "navmain"; ?>">
<center><div class="headmenu">ผู้ดูแลระบบ</div></center>
<li class="menulist" id="periodlink"><a href="#">ตั้งค่าภาคเรียน</a></li>
<li class="menulist" id="userlink"><a href="#">ข้อมูลผู้ใช้</a></li>
<!--li class="menulist" id="partylink"><a href="#">ข้อมูลฝ่ายงาน</a></li-->
<li class="menulist" id="majorlink"><a href="#">ข้อมูลสาขาวิชา สาขางาน</a></li>
<li class="menulist" id="departlink"><a href="#">ข้อมูลแผนกวิชา</a></li>
<!--li class="menulist" id="boardlink"><a href="#">ข้อมูลกรรมการบริหารสถานศึกษา</a></li-->
<li class="menulist" id="stdlink"><a href="#">ข้อมูลนักเรียนนักศึกษา</a></li>
<li class="menulist" id="subjectlink"><a href="#">ข้อมูลรายวิชา</a></li>
<li class="menulist" id="maffectivelink"><a href="#">ข้อมูลจิตพิสัย</a></li>
<li class="menulist" id="mteachlink"><a href="#">ข้อมูลการเรียนการสอน</a></li>
<!--li class="menulist" id="actlink"><a href="#">ข้อมูลข่าวกิจกรรม</a></li>
<li class="menulist" id="announlink"><a href="#">ข้อมูลข่าวประกาศ</a></li>
<li class="menulist" id="informlink"><a href="#">ข้อมูลข่าวประชาสัมพันธ์</a></li-->
<li class="menulist" id="smsalink"><a href="#">ส่งข้อความ</a></li>
<?php } ?>
</ul>
</div>