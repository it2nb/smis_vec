<?php
if(session_id()=='')
	session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("../includefiles/connectdb.php");
require_once '../classes/stdaffectivescore.class.old.php';
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
$main_obj = new Stdaffectivescore_class($conn,$teach_ID);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
	$('#editstdaffectivescoreform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function teachscore(teach_ID){
	$.get('teachscore.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
}
</script>
<style type="text/css">
.verticaltext {
	filter: flipv fliph;
	-webkit-transform: rotate(-90deg);
  	-moz-transform: rotate(-90deg);
  	-ms-transform: rotate(-90deg);
  	-o-transform: rotate(-90deg);
  	transform: rotate(-90deg);
  	
  	float: left;
  	white-space:nowrap;
  	width: 20px;
  	padding-left: 3px;
}
</style>
    <div id="admincontent"><br />

  <center>
  <form action="stdaffectivescore_old.php" method="post" id="editstdaffectivescoreform">
  <table width="95%" border="1" cellspacing="0" cellpadding="2" bordercolor="#000000" >
    <th height="50" colspan="<?php echo $main_obj->getTeacaffectiveQty()+2;?>" align="center" valign="middle" bgcolor="#CCCCCC">คะแนนจิตพิสัย<br />
      วิชา<?php $main_obj->querySubject();echo $main_obj->subject_name;?></th>
  <tr>
    <td width="3%" height="150" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
    <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - นามสกุล</td>
    <?php $main_obj->getTeacaffectiveQty(); while($main_obj->fetchTeachaffective()){ ?>
    <td height="150" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php echo $main_obj->affective_name;?></span></td>
    <?php } ?>
    </tr>
  <tr>
   <?php $main_obj->getTeacaffectiveQty(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->teachaffective_score;?></td>
    <?php } ?>
    </tr>
  <?php $main_obj->queryStudent(); while($main_obj->fetchStudent()){ ?>
  <tr>
    <td height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td><?php echo $main_obj->student_name.' '.$main_obj->student_ser;?></td>
    <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle">
      <select name="stdaffective_score[<?php echo $main_obj->student_ID;?>][<?php echo $main_obj->affective_ID;?>]" id="stdaffective_score[][]">
      <?php $main_obj->queryStudentaffective();
	  	for($i=$main_obj->teachaffective_score;$i>=0;$i--){
			
			if($i==$main_obj->stdaffective_score&&is_numeric($main_obj->stdaffective_score))
				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			else
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
	  ?>
      </select></td>
    <?php } ?>
    </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="<?php echo $main_obj->getTeacaffectiveQty()+2;?>" align="center" valign="middle"><input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" /></td>
    </tr>
</table>
</form>
</center></div>