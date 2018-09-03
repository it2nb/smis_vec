<?php
if(session_id()=='')
    session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("../includefiles/connectdb.php");
require_once '../classes/teachrecord.class.php';
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel_ID = $_SESSION["user_personnelID"];
$teach_ID = $_GET["teach_ID"];
if(empty($teach_ID))
	$teach_ID = $_POST['teach_ID'];
$main_obj = new Teachrecord_class($conn,$teach_ID);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	//search
	$('#addscoreform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
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
  <br />

  <center><form id="addscoreform" action="teachrecord.php" method="post"><table width="95%" border="1" cellspacing="0" cellpadding="2" bordercolor="#000000" >
      <th height="50" colspan="16" align="center" valign="middle" bgcolor="#CCCCCC">ผลการเรียน<br />
      วิชา<?php $main_obj->querySubject();echo $main_obj->subject_name;?></th>
      <tr>
        <td width="5%" height="150" rowspan="3" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
        <td rowspan="3" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - นามสกุล</td>
        <td height="25" colspan="8" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คะแนนระหว่างภาค</td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext">รวมระหว่างภาค</span></td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext">จิตพิสัย</span></td>
        <td width="6%" rowspan="2" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext">สอบปลายภาค</span></td>
        <td width="6%" rowspan="2" align="center" valign="bottom" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
        <td width="10%" rowspan="3" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext">ระดับคะแนน</span></td>
      </tr>
      <tr>
    <td width="5%" height="120" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->queryScoregroup();$main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    <td width="5%" align="left" valign="bottom" bgcolor="#FFCC33" class="BlackBold10"><span class="verticaltext"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_name;?></span></td>
    </tr>
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->queryScoregroup();$main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php $main_obj->fetchScoregroup();echo $main_obj->scoregroup_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->teachpoint_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->affective_score;?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->teachfinal_score?></td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><?php echo $main_obj->teachpoint_score+$main_obj->teachfinal_score+$main_obj->affective_score;?></td>
    </tr>
  <?php $main_obj->queryStudent();
   while($main_obj->fetchStudent()){ 
  	$main_obj->queryScoregroup();
  ?>
  <tr>
    <td height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td><?php echo $main_obj->student_name.' '.$main_obj->student_ser;?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php $main_obj->fetchScoregroup(); echo $main_obj->getStdscorepoint($main_obj->scoregroup_ID);?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getStdsumscorepoint();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getSumAffective();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getStdfinalscore();?></td>
    <td align="center" valign="middle"><?php echo ($main_obj->getStdsumscorepoint()+$main_obj->getSumAffective()+$main_obj->getStdfinalscore());?></td>
    <td align="center" valign="middle">
	<?php 
		echo '<select id="grade['.$main_obj->student_ID.']" name="grade['.$main_obj->student_ID.']">';
		echo '<option value="'.$main_obj->getStdgrade().'" ';
		if($main_obj->student_grade==$main_obj->getStdgrade())
			echo 'selected="selected"';
		echo '>'.$main_obj->getStdgrade().'</option>';
		echo '<option value="ขร" ';
		if($main_obj->student_grade=='ขร')
			echo 'selected="selected"';
		echo '>ขร.</option>';
		echo '<option value="มส" ';
		if($main_obj->student_grade=='มส')
			echo 'selected="selected"';
		echo '>มส.</option>';
		echo '<option value="ขส" ';
		if($main_obj->student_grade=='ขส')
			echo 'selected="selected"';
		echo '>ขส.</option>';
		echo '<option value="ท" ';
		if($main_obj->student_grade=='ท')
			echo 'selected="selected"';
		echo '>ท.</option>';
		echo '</section>';
	?>
    </td>
  </tr>
  
  <?php }?>
  <tr>
    <td height="50" colspan="15" align="center" valign="middle"><input type="submit" name="save_bt" id="save_bt" value="บันทึกผลการเรียน" />
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID; ?>" /></td>
    </tr>
</table></form>
  </center>