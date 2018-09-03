<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/stdscore.class.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
if(empty($teach_ID))
	$teach_ID=$_POST['teach_ID'];
$scoredetail_ID=$_GET["scoredetail_ID"];
if(empty($scoredetail_ID))
	$scoredetail_ID=$_POST['scoredetail_ID'];

$stdscore_obj = new Stdscore_class($conn,$teach_ID,$scoredetail_ID);
if($_POST["stdscoresave_bt"]=="บันทึก"){
	$stdscore_obj->insertStdscore($_POST["scoredetail_ID"],$_POST["stdscorescore_comb"]);
}

echo "<script type='text/javascript'>var scoredetail_ID='".$scoredetail_ID."';var teach_ID='".$teach_ID."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#editstdscore').click(function(){
		$.get('editstdscore.php',{'scoredetail_ID':scoredetail_ID,'teach_ID':teach_ID},function(data){$('#stdscore').html(data)});
	});
});
</script>
<center>
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="5" bgcolor="#CCCCCC"><?php echo $stdscore_obj->scoregroup_name."<br>".$stdscore_obj->scoredetail_name;?></th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="25%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คะแนน</td>
    </tr>
  <?php
  $stdscore_obj->queryStudent();
  while($stdscore_obj->fetchStudent())
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $stdscore_obj->student_ID;?></td>
    <td valign="middle"><?php echo $stdscore_obj->student_name.' '.$stdscore_obj->student_ser;?></td>
    <td align="center" valign="middle"><?php echo $stdscore_obj->stdscore_score;?></td>
    </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="5" align="center" valign="middle"><a href="#" id="editstdscore"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle" /> แก้ไข</a></td>
    </tr>
</table>
<br />
</center>