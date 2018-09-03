<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/stdaffectivescore.class.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$affective_ID=$_GET['affective_ID'];
$stdaffective_obj = new Stdaffectivescore_class($conn,$teach_ID,$affective_ID);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#editstdaffectivescoreform').ajaxForm({ 
        target: '#stdscore',
		beforeSubmit: function(){
			$('#stdscore').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
<center>
<form action="stdaffectivescore.php" method="post" id="editstdaffectivescoreform" >
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="5" bgcolor="#CCCCCC"><?php echo $stdaffective_obj->affective_name;?></th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="25%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คะแนน</td>
    </tr>
   <?php
  $stdaffective_obj->queryStudent();
  while($stdaffective_obj->fetchStudent())
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $stdaffective_obj->student_ID;?></td>
    <td valign="middle"><?php echo $stdaffective_obj->student_name.' '.$stdaffective_obj->student_ser;?></td>
    <td align="center" valign="middle">
		<select name="stdscoreaffectivescore_comb[<?php echo $stdaffective_obj->student_ID;?>]" id="stdscoreaffectivescore_comb[<?php echo $stdaffective_obj->student_ID;?>]">
		<?php 
		for($i=$stdaffective_obj->teachaffective_score;$i>=0;$i--){
			if($i==$stdaffective_obj->stdaffective_score&&!empty($stdaffective_obj->stdaffective_score))
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";
		}
		?>
    	</select>
    </td>
    </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="5" align="center" valign="middle">
    <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
    <input name="affective_ID" type="hidden" id="scoredetial_ID" value="<?php echo $affective_ID;?>" />
    <input type="submit" name="stdaffectivescoresave_bt" id="stdaffectivescoresave_bt" value="บันทึก" />
       &nbsp;
       <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" /></td>
    </tr>
</table>
</form>
<br />
</center>