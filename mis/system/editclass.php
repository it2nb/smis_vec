<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if($_POST["save_bt"]=="บันทึก"){
	require_once("../includefiles/connectdb.php");
	require_once("../includefiles/formvalidator.php");
	$validator = new FormValidator();
	$validator->addValidation("classID_txt","req","กรุณากรอกรหัสกลุ่มเรียน");
	$validator->addValidation("classarea_comb","req","กรุณาเลือกสาขาวิชา");
	$validator->addValidation("classmajor_comb","req","กรุณาเลือกสาขางาน");
	if($validator->ValidateForm()){
		$class_ID = $_POST["classID_txt"];
		$major_ID = $_POST["classmajor_comb"];
		$oldclass_ID = $_POST["oldclassID_txt"];
		$personnel_ID=$_POST["teacher1_comb"];
		$personnel_ID2=$_POST["teacher2_comb"];
		$year = $_POST["classyear_comb"];
		$query="Select * From area,major Where area.area_ID=major.area_ID and major.major_ID='$major_ID'";
		$areamajor_query=mysql_query($query,$conn)or die(mysql_error());
		$areamajor_fetch=mysql_fetch_array($areamajor_query);
		$area_name = $areamajor_fetch["area_name"];
		$major_name = $areamajor_fetch["major_name"];
		$query="Select class_ID From class Where class_ID='$class_ID'";
		$checkclass_query = mysql_query($query,$conn)or die(mysql_error());
		if(mysql_num_rows($checkclass_query) && $class_ID!=$oldclass_ID){
			$error_txt["classID_txt"] = "รหัสกลุ่มเรียนนี้มีอยู่แล้ว";
			$class_ID=$oldclass_ID;
		}
		else{
			$query="Update class SET class_ID='$class_ID',year='$year',major_ID='$major_ID',personnel_ID='$personnel_ID',personnel_ID2='$personnel_ID2',area_name='$area_name',major_name='$major_name' Where class_ID='$oldclass_ID'";
			$class_update=mysql_query($query,$conn) or die(mysql_error());
			if($class_ID!=$oldclass_ID){
				$query="Update student SET class_ID='$class_ID' Where class_ID='$oldclass_ID'";
				$student_update=mysql_query($query,$conn) or die(mysql_error());
			}
			echo "<script type='text/javascript'>
					$('#admincontent').hide();
					alert('บันทึกข้อมูลเรียบร้อย');
					$('#systemcontent').load('manageclass.php');
					</script>";
		}
	}
	else
		$error_txt = $validator->GetErrors(); 
}
else
	$class_ID=$_GET["class_ID"];
//$query="Select * From class, major, area Where class_ID='$class_ID' and (class.major_ID=major.major_ID and major.area_ID=area.area_ID)";
$query="Select * From class Where class_ID='$class_ID'";
$class_query=mysql_query($query,$conn)or die(mysql_error());
$class_fetch=mysql_fetch_array($class_query);
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
    $('#manageclass').click(function(){
		$('#systemcontent').load('manageclass.php');		
    });
	$('#classarea_comb').change(function() {
		var area_ID = $('#classarea_comb').select().val();
        	$.get('comboval.php',{
				table:'major',
				where:'area_ID',
				whereval:area_ID,
				value:'major_ID',
				comb_txt:'major_name'},function(data){
				$('#classmajor_comb').html(data);
			});
    });
	$('#editclassform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
    	<div id="statusbar">เพิ่มข้อมูลกลุ่มเรียน</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="#" id="manageclass"><img src="../images/icons/64/back.png" width="64" height="64"></a></div>
        <div id="admincontent">
        <center>
        <form id="editclassform" action="editclass.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลกลุ่มเรียน</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC"><input type="hidden" name="oldclassID_txt" id="oldclassID_txt" value="<?php echo $class_fetch["class_ID"];?>"/></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสกลุ่มเรียน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
    <input name="classID_txt" type="text" id="classID_txt" value="<?php echo $class_fetch["class_ID"];?>" size="30" maxlength="8" />
    </label>
    <span class="RedRegula10"><?php echo $error_txt["classID_txt"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ปีการศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="classyear_comb" id="classyear_comb">
      <?php
	  for($i=date("Y");$i>=(date("Y")-50);$i--){
		  if($i==$class_fetch["year"])
		  	echo "<option value='$i' selected='selected'>".($i+543)."</option>";
		else
			echo "<option value='$i'>".($i+543)."</option>";
	  }
	  ?>
      </select> <span class="RedRegula10"><?php echo $error_txt["classyear_comb"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สาขาวิชา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="classarea_comb"></label>
      <select name="classarea_comb" id="classarea_comb">
      <?php
	  	$query="Select area_ID From major Where major_ID='".$class_fetch["major_ID"]."'";
		$areaID_query=mysql_query($query,$conn)or die(mysql_error());
		$areaID_fetch=mysql_fetch_array($areaID_query);
	   	$query="Select * From area";
		$area_query=mysql_query($query,$conn)or die(mysql_error());
		while($area_fetch=mysql_fetch_array($area_query)){
	  ?>
      <option value="<?php echo $area_fetch["area_ID"];?>" <?php if($areaID_fetch["area_ID"]==$area_fetch["area_ID"]) echo "selected='selected'";?>><?php echo $area_fetch["area_level"]." : ".$area_fetch["area_name"];?></option>
      <?php } ?>
      </select><span class="RedRegula10"><?php echo $error_txt["classarea_comb"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">สาขางาน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="classmajor_comb"></label>
      <select name="classmajor_comb" id="classmajor_comb">
      <?php
	  	$area_ID=$areaID_fetch["area_ID"];
	   	$query="Select * From major Where area_ID='$area_ID'";
		$major_query=mysql_query($query,$conn)or die(mysql_error());
		while($major_fetch=mysql_fetch_array($major_query)){
	  ?>
      <option value="<?php echo $major_fetch["major_ID"];?>" <?php if($class_fetch["major_ID"]==$major_fetch["major_ID"]) echo "selected='selected'";?>><?php echo $major_fetch["major_name"];?></option>
      <?php } ?>
      </select><span class="RedRegula10"><?php echo $error_txt["classmajor_comb"];?> </span></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">ครูที่ปรึกษา :&nbsp;&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="teacher1_comb" id="teacher1_comb">
      <option value="0">ไม่มีครูที่ปรึกษา</option>
      <?php
	  $query="Select * From personnel,member Where member.personnel_ID=personnel.personnel_ID and (member.member_status like '__1_' or member.member_status like '___1') and personnel.personnel_status='work' Order By personnel.personnel_name ASC";
	  $personnel_query=mysql_query($query,$conn)or die(mysql_error());
	  while($personnel_fetch=mysql_fetch_array($personnel_query)){
		  if($personnel_fetch["personnel_ID"]==$class_fetch["personnel_ID"])
		  	echo "<option value='".$personnel_fetch["personnel_ID"]."' selected='selected'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
		else
			echo "<option value='".$personnel_fetch["personnel_ID"]."'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
	  }
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" bgcolor="#CCCCCC">ครูที่ปรึกษา2 : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="RedRegula10">
      <select name="teacher2_comb" id="teacher2_comb">
      <option value="0">ไม่มีครูที่ปรึกษา</option>
      <?php
	  $query="Select * From personnel,member Where member.personnel_ID=personnel.personnel_ID and (member.member_status like '__1_' or member.member_status like '___1') and personnel.personnel_status='work' Order By personnel.personnel_name ASC";
	  $personnel_query=mysql_query($query,$conn)or die(mysql_error());
	  while($personnel_fetch=mysql_fetch_array($personnel_query)){
		  if($personnel_fetch["personnel_ID"]==$class_fetch["personnel_ID2"])
		  	echo "<option value='".$personnel_fetch["personnel_ID"]."' selected='selected'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
		else
			echo "<option value='".$personnel_fetch["personnel_ID"]."'>".$personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"]."</option>";
	  }
	  ?>
      </select>
    </span></td>
  </tr>
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
</table>
        </form>
        </center>
</div>