<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$query="Select * From teach Where teach_ID='$teach_ID'";
$teach_query=mysql_query($query,$conn)or die(mysql_error());
$teach_fetch=mysql_fetch_assoc($teach_query);
echo "<script>var subject_ID='".$teach_fetch["subject_ID"]."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#manageteach').click(function(){
		$('#systemcontent').load('manageteach.php');		
    });
	$('#editteachform').ajaxForm({ 
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
				comb_txt2:'subject_name',
				select_ID: subject_ID},function(data){
				$('#subjectID_comb').html(data);
			});
    });
	$('#courseID_comb').change();
});
</script>
    	<div id="statusbar">แก้ไขข้อมูลรายวิชาที่สอน</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="64">
        <a href="#" id="manageteach"><img src="../images/icons/64/back.png" width="64" height="64"></a>
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
        <form id="editteachform" action="manageteach.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">แก้ไขข้อมูลการเรียนการสอน</th>
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
				if($period_fetch["period_term"]==$teach_fetch["teach_term"]&&$period_fetch["period_year"]==$teach_fetch["teach_year"])
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
	  while($course_fetch=mysql_fetch_array($course_query)){
		  if($course_fetch["course_ID"]==$teach_fetch["course_ID"])
	  		echo "<option value='".$course_fetch["course_ID"]."' selected='selected'>".$course_fetch["course_des"]."</option>";
		  else
		  	echo "<option value='".$course_fetch["course_ID"]."'>".$course_fetch["course_des"]."</option>";
	  }
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="subjectID_comb" id="subjectID_comb">
      </select>
    </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ครูผู้สอน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="personnelID_comb" id="personnelID_comb">
    <?php
	  $query="Select * From personnel Where personnel_status='work' Order By personnel_name ASC";
	  $personnel_query=mysql_query($query,$conn)or die(mysql_error());
	  while($personnel_fetch=mysql_fetch_array($personnel_query)){
		  if($personnel_fetch["personnel_ID"]==$teach_fetch["personnel_ID"])
	  		echo "<option value='".$personnel_fetch["personnel_ID"]."' selected='selected'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
		  else
		  	echo "<option value='".$personnel_fetch["personnel_ID"]."'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
	  }
	  ?>
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
      <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
      <input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
    </label></td>
    </tr>
</table></form>
        </center>
</div>