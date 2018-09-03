<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["save_bt"]=="บันทึก")
{
	$teach_ID = $_POST["teach_ID"];
	$subject_ID = $_POST["subjectID_comb"];
	$class_ID = $_POST["classID_comb"];
	$teach_term = $_POST["term_comb"];
	$teach_year = $_POST["year_comb"];
	
	$personnel_ID = $_SESSION["user_personnelID"];
	$query="Select teach_ID From teach Where subject_ID='$subject_ID' and class_ID='$class_ID' and teach_term='$teach_term' and teach_year='$teach_year' and personnel_ID='$personnel_ID' and teach_ID!='$teach_ID'";
	$checkteach_query = mysql_query($query,$conn)or die(mysql_error());

	if(mysql_num_rows($checkteach_query))
		echo "<script type='text/javascript'>alert('รายวิชาและกลุ่มเรียนซ้ำ');</script>";
	else
	{

		$teach_activity = $_POST["activity_ch"];
		$teach_instruc = $_POST["instruct_ch"];
		$teach_measure = $_POST["measure_ch"];
		$teach_jobstd = $_POST["jobstd_ch"];
		$teach_eco = $_POST["eco_ch"];
		$teach_moral = $_POST["moral_ch"];
		$query="Update teach Set teach_term='$teach_term', teach_year='$teach_year', teach_jobstd='$teach_jobstd', teach_eco='$teach_eco', teach_moral='$teach_moral', subject_ID='$subject_ID', teach_activity='$teach_activity', teach_instruc='$teach_instruc', teach_measure='$teach_measure', class_ID='$class_ID' Where teach_ID='$teach_ID'";
		$teach_update=mysql_query($query,$conn) or die(mysql_error());
		if(!empty($_FILES["plan_file"]["name"]))
		{
			move_uploaded_file($_FILES["plan_file"]["tmp_name"],"../document/teach/".$teach_ID."/".$_FILES["plan_file"]["name"]);
		}
		if(!empty($_FILES["sched_file"]["name"]))
		{
			move_uploaded_file($_FILES["sched_file"]["tmp_name"][$i],"../document/teach/".$teach_ID."/".$_FILES["sched_file"]["name"]);
		}
		$query = "Update teach Set teach_plan='".$_FILES["plan_file"]["name"]."',teach_sched='".$_FILES["sched_file"]["name"]."' Where teach_ID='$teach_ID'";
		$teach_insert=mysql_query($query,$conn) or die(mysql_error());
		echo "<script type='text/javascript'>
				$('#admincontent').hide();
				alert('บันทึกข้อมูลเรียบร้อย');
				$('#systemcontent').load('teachdata.php');
				</script>";
	}
}
else
	$teach_ID = $_GET["teach_ID"];
$query = "Select * From teach Where teach_ID='$teach_ID'";
$teach_query = mysql_query($query,$conn)or die(mysql_error());
$teach_fetch = mysql_fetch_array($teach_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#teachdata').click(function(){
		$('#systemcontent').load('teachdata.php');		
    });
	$('#findsubject').click(function(){
		window.open("http://www.google.co.th","_blank","channelmode=yes,resizable=no,menubar=no,status=no");
	});
	$('#editteachform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">แก้ไขข้อมูลรายวิชาที่สอน</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="teachdata"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="editteachform" action="editteach.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลรายวิชาที่สอน</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ภาคเรียนที่ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="term_comb"></label>
      <select name="term_comb" id="term_comb">
        <option value="1" <?php if($teach_fetch["teach_term"]=="1") echo "selected='selected'";?>>1</option>
        <option value="2" <?php if($teach_fetch["teach_term"]=="2") echo "selected='selected'";?>>2</option>
        <option value="3" <?php if($teach_fetch["teach_term"]=="3") echo "selected='selected'";?>>3</option>
      </select>
      ปีการศึกษา : 
      <select name="year_comb" id="year_comb">
      <?php
	  for($i=date("Y");$i>=(date("Y")-50);$i--)
	  if($teach_fetch["teach_year"]==$i)
	  	echo "<option value='".$i."' selected='selected'>".($i+543)."</option>";
	  else
	  	echo "<option value='".$i."'>".($i+543)."</option>";
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รายวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="subjectID_comb" id="subjectID_comb">
    <?php
	  $query="Select * From subject Order By subject_ID ASC";
	  $subject_query=mysql_query($query,$conn)or die(mysql_error());
	  while($subject_fetch=mysql_fetch_array($subject_query))
	  if($teach_fetch["subject_ID"]==$subject_fetch["subject_ID"])
	  	echo "<option value='".$subject_fetch["subject_ID"]."' selected='selected'>".$subject_fetch["subject_ID"]." : ".$subject_fetch["subject_name"]."</option>";
	  else
	  	echo "<option value='".$subject_fetch["subject_ID"]."'>".$subject_fetch["subject_ID"]." : ".$subject_fetch["subject_name"]."</option>";
	  ?>
      </select> <a href="#" id="findsubject">ค้นหารายวิชา</a>
    </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">แผนการสอน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <input type="file" name="plan_file" id="plan_file" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><input name="jobstd_ch" type="checkbox" id="jobstd_ch" value="1" <?php if($teach_fetch["teach_jobstd"]=="1") echo "checked='checked'";?> />
      <label for="jopstd_ch"></label>
      มุ่งเน้นสรรถนะอาชีพ</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><input name="eco_ch" type="checkbox" id="eco_ch" value="1" <?php if($teach_fetch["teach_eco"]=="1") echo "checked='checked'";?>/>
      <label for="eco_ch"></label>
      บูรณาการเศรษฐกิจพอเพียง</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><input name="moral_ch" type="checkbox" id="moral_ch" value="1" <?php if($teach_fetch["teach_moral"]=="1") echo "checked='checked'";?>/>
      <label for="moral_ch"></label>
      บูรณาการคุณธรรมจริยธรรม</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">กำหนดการสอน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <input type="file" name="sched_file" id="sched_file" /></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <input name="activity_ch" type="checkbox" id="activity_ch" value="1" <?php if($teach_fetch["teach_activity"]=="1") echo "checked='checked'";?> />มีการนิเทศน์และกิจกรรมการเรียนการสอนที่หลากหลาย
      </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <input name="instruct_ch" type="checkbox" id="instruct_ch" value="1" <?php if($teach_fetch["teach_instruc"]=="1") echo "checked='checked'";?> />มีการใช้สื่อการสอน
      </td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <input name="measure_ch" type="checkbox" id="measure_ch" value="1" <?php if($teach_fetch["teach_measure"]=="1") echo "checked='checked'";?> />มีการแจ้งเกณฑ์และวัดผลตามแผนการสอน
</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">กลุ่มเรียน :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="classID_comb" id="classID_comb">
      <?php
	  $query="Select * From class Order By class_ID DESC";
	  $class_query=mysql_query($query,$conn)or die(mysql_error());
	  while($class_fetch=mysql_fetch_array($class_query))
	  if($teach_fetch["class_ID"]==$class_fetch["class_ID"])
	  	echo "<option value='".$class_fetch["class_ID"]."' selected='selected'>".$class_fetch["class_ID"]." : ".$class_fetch["class_des"]."</option>";
	  else 
	  	echo "<option value='".$class_fetch["class_ID"]."'>".$class_fetch["class_ID"]." : ".$class_fetch["class_des"]."</option>";
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" /><label>
      <input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
    </label>
      <label>
      <input type="reset" name="button2" id="button2" value="ล้างข้อมูล" />
      </label></td>
    </tr>
</table></form>
        </center>
</div>