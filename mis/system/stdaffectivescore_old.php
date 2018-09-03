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
if(empty($teach_ID))
	$teach_ID = $_POST['teach_ID'];
$main_obj = new Stdaffectivescore_class($conn,$teach_ID);

if($_POST['save_bt']=='บันทึก'){
	$main_obj->addStudentAffective($_POST['stdaffective_score']);
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
	$('#classsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
function affectivescore(teach_ID){
	$.get('affectivescore.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
}
function editstdaffectivescore(id){
	$.get('editstdaffectivescore.old.php',{'teach_ID':id},function(data){$('#admincontent').html(data)});
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
   	<div id="statusbar">บันทึกคะแนนจิตพิสัย</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" onclick="affectivescore('<?php echo $teach_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/stdaffectivescorereport.php?teach_ID=$teach_ID";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent"><br />

  <center><table width="95%" border="1" cellspacing="0" cellpadding="2" bordercolor="#000000" >
    <th height="50" colspan="<?php echo $main_obj->getTeacaffectiveQty()+3;?>" align="center" valign="middle" bgcolor="#CCCCCC">คะแนนจิตพิสัย<br />
      วิชา<?php $main_obj->querySubject();echo $main_obj->subject_name;?></th>
  <tr>
    <td width="3%" height="150" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
    <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - นามสกุล</td>
    <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td height="120" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php echo $main_obj->affective_name;?></span></td>
    <?php } ?>
    <td width="12%" align="center" valign="bottom" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
  </tr>
  <tr>
   <?php $main_obj->getTeacaffectiveQty(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->teachaffective_score;?></td>
    <?php } ?>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->affective_score;?></td>
  </tr>
  <?php $main_obj->queryStudent(); while($main_obj->fetchStudent()){ ?>
  <tr>
    <td height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td><?php echo $main_obj->student_name.' '.$main_obj->student_ser;?></td>
    <?php $main_obj->queryTeachaffective(); while($main_obj->fetchTeachaffective()){ ?>
    <td align="center" valign="middle"><?php $main_obj->queryStudentaffective(); echo $main_obj->stdaffective_score;?></td>
    <?php } ?>
    <td align="center" valign="middle"><?php echo $main_obj->getSumScore();?></td>
  </tr>
  <?php } ?>
</table><br />
<div align="right"><a href="#" onclick="editstdaffectivescore('<?php echo $teach_ID;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

</center></div>