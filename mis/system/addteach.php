<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select * From period Where period_start=(Select max(period_start) From period)";
$period_query = mysql_query($query,$conn)or die(mysql_error());
$period_fetch = mysql_fetch_array($period_query);
$last_period = $period_fetch["period_term"]."/".$period_fetch["period_year"];

if($_POST["save_bt"]=="บันทึก")
{
	$subject_ID = $_POST["subjectID_comb"];
	$course_ID = $_POST["courseID_comb"];
	list($teach_term,$teach_year) = split("/",$_POST["period_comb"]);
	$personnel_ID = $_SESSION["user_personnelID"];
	$query="Select max(teach_group) as maxgroup From teach Where teach_term='$teach_term' and teach_year='$teach_year' and subject_ID='$subject_ID' and course_ID='$course_ID' and personnel_ID='$personnel_ID'";
	$maxgroup_query=mysql_query($query,$conn)or die(mysql_error());
	$maxgroup_fetch=mysql_fetch_array($maxgroup_query);
	for($i=1;$i<=$_POST["group_comb"];$i++){
		$teach_group = $maxgroup_fetch["maxgroup"]+$i;
		$query="Insert Into teach(teach_term,teach_year,personnel_ID,subject_ID,course_ID,teach_group) Values('$teach_term','$teach_year','$personnel_ID','$subject_ID','$course_ID','$teach_group')";
		$insert_teach = mysql_query($query,$conn)or die(mysql_error());
		$member_ID = $_SESSION["userID"];
		$userlogs_des="เพิ่มรายวิชาที่สอนรหัส ".$subject_ID." หลักสูตร ".$course_ID." ภาคเรียนที่ ".$_POST["period_comb"];
		$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Add Teach','teach_mis','$userlogs_des')";
	$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	}
		echo "<script type='text/javascript'>
				$('#admincontent').hide();
				alert('บันทึกข้อมูลเรียบร้อย');
				$('#systemcontent').load('teachdata.php');
				</script>";
}
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#teachdata').click(function(){
		$('#systemcontent').load('teachdata.php');		
    });
	$('#findsubject').click(function(){
		window.open("http://www.google.co.th","_blank","channelmode=yes,resizable=no,menubar=no,status=no");
	});
	$('#addteachform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#courseID_comb').change(function() {
		var course_ID = $('#courseID_comb').select().val();
        	$.get('comboval.php',{
				table:'subject',
				where:'course_ID',
				whereval:course_ID,
				value:'subject_ID',
				comb_txt:'subject_ID',
				comb_atxt2:' : ',
				comb_txt2:'subject_name'},function(data){
				$('#subjectID_comb').html(data);
			});
    });
	$('#courseID_comb').change();
});
function findsubject(findvalue){
	var course_ID = $('#courseID_comb').select().val();
	$.get('findsubject.php',{'course_ID' : course_ID,'findvalue' : findvalue},function(data) {
		$('#info').html(data);
		blanket_size();
		toggle('blanket');
		window_pos('info',0.5);
		toggle('info');
	});
}
function finds(){
	var findvalue = $('#findvalue').val();
	toggle('blanket');
	toggle('info');
	findsubject(findvalue);
}
function selsubject(subject_ID){
	var course_ID = $('#courseID_comb').select().val();
    $.get('comboval.php',{
		table:'subject',
		where:'course_ID',
		whereval:course_ID,
		value:'subject_ID',
		comb_txt:'subject_ID',
		comb_atxt2:' : ',
		comb_txt2:'subject_name',
		select_ID : subject_ID},function(data){
		$('#subjectID_comb').html(data);
	});
	toggle('blanket');
	toggle('info');
}
</script>
    	<div id="statusbar">เพิ่มข้อมูลรายวิชาที่สอน</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="64">
        <a href="#" id="teachdata"><img src="../images/icons/64/back.png" width="64" height="64"></a>
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
        <center>
        <form id="addteachform" action="addteach.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลรายวิชาที่สอน</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ภาคเรียนที่ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_array($period_query)){
				if($last_period==($period_fetch["period_term"]."/".$period_fetch["period_year"]))
				  	echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."' selected='selected'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
				else
					echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
			  }
			  ?>
        	</select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">หลักสูตร : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="courseID_comb"></label>
      <select name="courseID_comb" id="courseID_comb">
      <?php
	  $query="Select * From course Order By course_year DESC";
	  $course_query=mysql_query($query,$conn)or die(mysql_error());
	  while($course_fetch=mysql_fetch_array($course_query))
	  	echo "<option value='".$course_fetch["course_ID"]."'>".$course_fetch["course_des"]."</option>";
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="subjectID_comb" id="subjectID_comb"><input type="button" id="findsubj_bt" value="ค้นหา" onclick="findsubject('')" />
      </select>
    </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">จำนวนกลุ่มเรียน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="group_comb" id="group_comb">
     <option value="1">1</option>
     <option value="2">2</option>
     <option value="3">3</option>
     <option value="4">4</option>
     <option value="5">5</option>
     <option value="6">6</option>
     <option value="7">7</option>
     <option value="8">8</option>
     <option value="9">9</option>
     <option value="10">10</option>
      </select>
    </td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><label>
      <input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
    </label>
      <label>
      <input type="reset" name="button2" id="button2" value="ล้างข้อมูล" />
      </label></td>
    </tr>
</table></form>
        </center>
</div>