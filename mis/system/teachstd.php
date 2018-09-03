<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID = $_GET["teach_ID"];
$query="Select max(period_year) as thisyear From period";
$period_query=mysql_query($query,$conn)or die(mysql_error());
$period_fetch=mysql_fetch_assoc($period_query);
$thisyear=substr($period_fetch["thisyear"]+543,2,2);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$.get('stdteach.php',{'teach_ID':teach_ID},function(data){$('#teachstd_tb').html(data);});
	$('#manageclass').click(function(){
		$('#systemcontent').load("manageclass.php");
	});
	$('#stdparent').click(function(){
		$.get('stdparent.php',{'class_ID':class_ID},function(data){$('#systemcontent').html(data);});
	});
	$('#stdsearchform').ajaxForm({ 
        target: '#stdsearch_tb',
		beforeSubmit: function(){
			$('#stdsearch_tb').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function add_stdclass(stdID){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'classID':class_ID,
		'type':'update'},function(data){$('#stdclass_tb').html(data);});
	$('#stdnoclassform').submit();
}
function delete_stdclass(stdID){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'type':'update'},function(data){$('#stdclass_tb').html(data);});
	$('#stdnoclassform').submit();
}
function update_stdstatus(stdID,stdStatus){
	$.get('stdclass.php',{
		'student_ID':stdID,
		'class_ID':class_ID,
		'student_endstatus':stdStatus,
		'type':'status'},function(data){$('#stdclass_tb').html(data);});
}
</script>
<div id="tstd">
<span class="BlueDark">
<h3>ผู้เรียน</h3></span>
<div id="admincontentleft">
<div id="teachstd_tb">
</div></div>
<div id="admincontentright">
<div>
<center>
<strong>ค้นหารายชื่อนักเรียนนักศึกษา</strong><br />
<br />
<form id="stdsearchform" action="stdnoteach.php" method="post">
	<select name="classID_comb" id="classID_comb">
    <option value="0">ทุกกลุ่มเรียน</option>
    <?php
	$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID Order By class_ID DESC";
$class_query=mysql_query($query,$conn) or die(mysql_error());
	while($class_fetch=mysql_fetch_assoc($class_query)){
			echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["area_level"].".".($thisyear-substr($class_fetch["class_ID"],0,2)+1)."/".substr($class_fetch["class_ID"],7,1)." สาขา".$class_fetch["major_name"]."</option>";
	}
	?>
    </select>
  <input type="text" name="stdsearch_txt" id="stdsearch_txt" />
  <input type="submit" name="stdsearch_bt" id="stdsearch_bt" value="ค้นหา" /><input name="teachID_txt" type="hidden" id="teachID_txt" value="<?php echo $teach_ID;?>" />
</form></center>
</div>
<br />
<div id="stdsearch_tb">
&nbsp;
</div></div>
</div>