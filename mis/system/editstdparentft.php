<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$class_ID=$_GET["class_ID"];
$query="Select * From student Where class_ID='$class_ID' Order By student_ID ASC";

$student_query=mysql_query($query,$conn) or die(mysql_error());
$studentnum = mysql_num_rows($student_query);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
	$('#editflagpolecheck').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
<center>
		<form id="editflagpolecheck" action="stdparentft.php" method="post">
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="7" bgcolor="#CCCCCC">นักเรียนนักศึกษาในกลุ่มเรียน <?php echo $class_ID;?>
                  <input type="hidden" name="class_ID" id="class_ID"  value="<?php echo $class_ID;?>"/>
( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="18%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล บิดา</td>
    <td width="18%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล มารดา</td>
    <td width="18%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล ผู้ปกครอง</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทรผู้ปกครอง</td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
  ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_prefix"].$student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="left" valign="middle"><strong>ชื่อ</strong>
      <input name="fatname_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="fatname_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_fatname"];?>" size="15" />
      <br />
      <strong>สกุล</strong>      <input name="fatser_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="fatser_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_fatser"];?>" size="15" /></td>
    <td align="left" valign="middle">
    <strong>ชื่อ</strong>
    <input name="motname_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="motname_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_motname"];?>" size="15" />
      <br />
      <strong>สกุล</strong>      <input name="motser_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="motser_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_motser"];?>" size="15" />
      </td>
    <td align="left" valign="middle">
    <strong>ชื่อ</strong>
    <input name="parname_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="parname_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_parname"];?>" size="15" />
      <br />
      <strong>สกุล</strong>      <input name="parser_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="parser_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_parser"];?>" size="15" />
      </td>
    <td align="center" valign="middle"><input name="phone_txt[<?php echo $student_fetch["student_ID"];?>]" type="text" id="phone_txt[<?php echo $student_fetch["student_ID"];?>]" value="<?php echo $student_fetch["student_parphone"];?>" size="15" maxlength="10" /></td>
  </tr>
    <?php } ?>
  <tr <?php if($student_fetch["student_endstatus"]!=0)echo "bgcolor='#666666'";?>>
    <td height="25" colspan="7" align="center" valign="middle" bgcolor="#CCCCCC"><input type="submit" name="update_bt" id="update_bt" value="บันทึก" />
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" /></td>
    </tr>
</table>
</form><br />
</center>