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

if($_POST['save_bt']=='บันทึกผลการเรียน'){
	$main_obj->addStudentGrade($_POST['grade']);
}
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
function teachdetaildata(teach_ID){
	$.get('teachdetaildata.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
}
function editteachrecord(id){
	$.get('editteachrecord.php',{'teach_ID':id},function(data){$('#admincontent').html(data)});
}
function disprint(){
	$('#printicon').removeAttr("href");
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
   	<div id="statusbar">บันทึกผลการเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="192"><a href="#" onclick="teachdetaildata('<?php echo $teach_ID;?>')"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a id="printicon" href="<?php if($missgrade!=1)echo "reportpdf/teachrecordreport.php?teach_ID=$teach_ID";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent"><br />

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
    <?php
	if(strlen($main_obj->student_grade)>0){
		$firsttime=0;
	}
	else{
		$firsttime=1;
	}
	?>
    <td align="center" valign="middle" 
    <?php if($firsttime==0&&$main_obj->student_grade!=$main_obj->getStdgrade()&&is_numeric($main_obj->student_grade)){
		echo 'bgcolor="#FF6666"'; 
		$missgrade=1;
		} 
		?>
    >
	<?php 
	if($firsttime==0){
		echo $main_obj->student_grade;
	}
	else{
		echo '<select id="grade['.$main_obj->student_ID.']" name="grade['.$main_obj->student_ID.']">';
		echo '<option value="'.$main_obj->getStdgrade().'">'.$main_obj->getStdgrade().'</option>';
		echo '<option value="ขร">ขร.</option>';
		echo '<option value="มส">มส.</option>';
		echo '<option value="ขส">ขส.</option>';
		echo '<option value="ท">ท.</option>';
		echo '</section>';
	}
	?>
    </td>
  </tr>
  
  <?php }
  if($firsttime==1){ ?>
  <tr>
    <td height="50" colspan="15" align="center" valign="middle"><input type="submit" name="save_bt" id="save_bt" value="บันทึกผลการเรียน" />
      <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID; ?>" /></td>
    </tr>
   <?php } ?>
</table></form><br />
<div align="right"><a href="#" onclick="editteachrecord('<?php echo $teach_ID;?>')"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle"/>แก้ไข&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

</center></div>
<?php
if($missgrade==1)
	echo '<script>disprint();</script>';
?>