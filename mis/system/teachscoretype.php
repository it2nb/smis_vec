<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/teachscoretype.class.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
if(empty($teach_ID))
	$teach_ID=$_POST['teach_ID'];
$scoretype_obj= new Teachscoretype_class($conn,$teach_ID);
if($_POST["editfinalscore_bt"]=="บันทึก"){
	$scoretype_obj->updateFinalscore($_POST["scoregroup_ID"],$_POST["scoregroupscore_txt"]);
}
else if($_POST["editaffectscore_bt"]=="บันทึก"){
	$scoretype_obj->updateAffectivescore($_POST["affectscore"]);
}
else if($_POST["addscoregroup_bt"]=="บันทึก"){
	$scoretype_obj->insertScoregroup($_POST["scoregroupname_txt"],$_POST["scoregroupscore_txt"]);
}
else if($_POST["editscoregroup_bt"]=="บันทึก"){
	$scoretype_obj->updateScoregroup($_POST["scoregroup_ID"],$_POST["scoregroupname_txt"],$_POST["scoregroupscore_txt"]);
}
else if($_GET["deletescoregroup_bt"]=="ลบ"){
	$scoretype_obj->deleteScoregroup($_GET["scoregroup_ID"]);
}
else if($_POST["addscoredetail_bt"]=="บันทึก"){
	$scoretype_obj->insertScoredetail($_POST["scoredetailname_txt"],$_POST["scoredetailscore_txt"],$_POST["scoregroup_ID"]);
}
else if($_POST["editscoredetail_bt"]=="บันทึก"){
	$scoretype_obj->updateScoredetail($_POST["scoredetail_ID"],$_POST["scoredetailname_txt"],$_POST["scoredetailscore_txt"]);
}
else if($_GET["deletescoredetail_bt"]=="ลบ"){
	$scoretype_obj->deleteScoredetail($_GET["scoredetail_ID"]);
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#addscoregroup').click(function(){
		$.get('addscoregroup.php',{'teach_ID':teach_ID},function(data){$('#scoregroup_add').html(data)});
	});
	$('#editfinalscore').click(function(){
		$.get('editfinalscore.php',{'teach_ID':teach_ID},function(data){$('#finalscore').html(data)});
	});
	$('#editaffectivescore').click(function(){
		$.get('editaffectivescore.php',{'teach_ID':teach_ID},function(data){$('#affectivescore').html(data)});
	});
});
function stdscore(id){
	$.get('stdscore.php',{'scoredetail_ID':id,'teach_ID':teach_ID},function(data){$('#stdscore').html(data)});
}
function editscoregroup(id, tag){
	$.get('editscoregroup.php',{'scoregroup_ID':id,'tagid':tag},function(data){$('#'+tag).html(data)});
}
function deletescoregroup(id, txt, teach_ID){
	var conf = confirm("คุณแน่ใจว่าจะลบหัวข้อคะแนนหลัก "+txt+"\nข้อมูลอื่นๆ ที่เกี่ยวข้องกับหัวข้อคะแนนหลักนี้จะถูกลบด้วย");
	if(conf==true){
		$.get('teachscoretype.php',{
			'scoregroup_ID':id,
			'teach_ID':teach_ID,
			'deletescoregroup_bt':'ลบ'},function(data){$('#teachscoretype').html(data)});
		$('#stdscore').html("");
	}
}
function addscoredetail(id, tag){
	$.get('addscoredetail.php',{'scoregroup_ID':id,'tagid':tag},function(data){$('#'+tag).html(data)});
}
function editscoredetail(id, tag){
	$.get('editscoredetail.php',{'scoredetail_ID':id,'tagid':tag},function(data){$('#'+tag).html(data)});
}
function deletescoredetail(id, txt, teach_ID){
	var conf = confirm("คุณแน่ใจว่าจะลบหัวข้อคะแนนย่อย "+txt+"\nข้อมูลอื่นๆ ที่เกี่ยวข้องกับหัวข้อคะแนนหลักนี้จะถูกลบด้วย");
	if(conf==true){
		$.get('teachscoretype.php',{
			'scoredetail_ID':id,
			'teach_ID':teach_ID,
			'deletescoredetail_bt':'ลบ'},function(data){$('#teachscoretype').html(data)});
		$('#stdscore').html("");
	}
}
function stdaffectivescore(id){
	$.get('stdaffectivescore.php',{'teach_ID':id},function(data){$('#systemcontent').html(data)});
}
function affectivescore(id){
	$.get('affectivescore.php',{'teach_ID':id},function(data){$('#systemcontent').html(data)});
}

</script>
<style type="text/css">
.table_dash_bt {
	border-bottom-width: thin;
	border-bottom-style: dashed;
	border-bottom-color: #000;
}
</style>
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50" colspan="3" align="center" valign="middle" bgcolor="#CCCCCC"><h2>รายการคะแนน</h2></td>
  </tr>
    <tr>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><strong>เรื่อง</strong></td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><strong>คะแนน</strong></td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="3">
    <div id="finalscore"><table width="100%" cellspacing="0" cellpadding="5">
    <?php
		$scoretype_obj->queryFinalscore();
	?>    
      <tr>
        <td height="30" align="left" valign="middle" bgcolor="#DDDDDD" ><a href="#" onclick="stdscore('<?php echo $scoretype_obj->scoredetail_ID; ?>')"><b>คะแนนสอบปลายภาคเรียน</b></a></td>
        <td width="15%" align="right" valign="middle" bgcolor="#CCCCCC"><b>
        <?php
		echo $scoretype_obj->scoregroup_score;
		?></b>
        </td>
        <td width="15%" align="center" valign="middle" bgcolor="#DDDDDD"><a href="#" id="editfinalscore"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle">แก้ไข</a></td>
      </tr>
    </table>
    </div></td>
  </tr>
  <?php
  $scoretype_obj->queryScoregroup();
  while($scoretype_obj->fetchScoregroup()){
  ?>
  <tr>
    <td height="30" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="left" valign="middle">
        <div id="<?php echo "scoregroup".$scoretype_obj->scoregroup_ID;?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td height="30" align="left" valign="middle" bgcolor="#EEEEEE" class="table_dash_bt"><b><?php echo $scoretype_obj->scoregroup_name;?></b></td>
            <td width="15%" align="right" valign="middle" bgcolor="#DDDDDD" class="table_dash_bt"><b><?php echo $scoretype_obj->scoregroup_score;?></b></td>
            <td width="15%" align="center" valign="middle" bgcolor="#EEEEEE" class="table_dash_bt"><a href="#" onclick="editscoregroup('<?php echo $scoretype_obj->scoregroup_ID;?>','<?php echo "scoregroup".$scoretype_obj->scoregroup_ID;?>')"><img src="../images/icons/16/edit.png" width="16" height="16" /></a>&nbsp;&nbsp;<a href="#" onclick="deletescoregroup('<?php echo $scoretype_obj->scoregroup_ID;?>','<?php echo $scoretype_obj->scoregroup_name;?>','<?php echo $teach_ID;?>')"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
          </tr>
        </table>
        </div>
        </td>
      </tr>
      <?php
	  $scoretype_obj->queryScoredetail();
	  while($scoretype_obj->fetchScoredetail()){
		   ?>
      <tr>
        <td height="30" align="left" valign="middle">
        <div id="<?php echo "scoredetail".$scoretype_obj->scoredetail_ID;?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="5%" height="30">&nbsp;</td>
            <td align="left" valign="middle" class="table_dash_bt"><a href="#" onclick="stdscore('<?php echo $scoretype_obj->scoredetail_ID; ?>')"><?php echo $scoretype_obj->scoredetail_name;?></a></td>
            <td width="10%" align="right" valign="middle" bgcolor="#EEEEEE" class="table_dash_bt"><?php echo $scoretype_obj->scoredetail_score;?></td>
            <td width="20%" align="center" valign="middle" class="table_dash_bt"><a href="#" onclick="editscoredetail('<?php echo $scoretype_obj->scoredetail_ID;?>','<?php echo "scoredetail".$scoretype_obj->scoredetail_ID;?>')"><img src="../images/icons/16/edit.png" width="16" height="16" /></a>&nbsp;&nbsp;<a href="#" onclick="deletescoredetail('<?php echo $scoretype_obj->scoredetail_ID;?>','<?php echo $scoretype_obj->scoredetail_name;?>','<?php echo $teach_ID;?>')"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
          </tr>
        </table>
        </div>
        </td>
      </tr>
      <?php }?>
      <tr>
        <td height="30" align="left" valign="middle">
        <div id="<?php echo "scoredetail".$scoretype_obj->scoregroup_ID."_add";?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30">&nbsp;</td>
            <td width="20%" align="center" valign="middle"><a href="#" onclick="addscoredetail('<?php echo $scoretype_obj->scoregroup_ID;?>','<?php echo "scoredetail".$scoretype_obj->scoregroup_ID."_add";?>')"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มหัวข้อย่อย</a></td>
          </tr>
        </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <?php }?>
  <tr>
    <td height="30" colspan="3" align="center" valign="middle"><div id="scoregroup_add"><a href="#" id="addscoregroup"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มหัวข้อหลัก</a></div></td>
  </tr>
  <tr>
    <td height="30" colspan="3" align="center" valign="middle">
    <div id="affectivescore">
    <table width="100%" cellspacing="0" cellpadding="5">
      <tr>
        <td height="30" align="left" valign="middle" bgcolor="#DDDDDD" ><a href="#" onclick="affectivescore('<?php echo $teach_ID; ?>')"><b>คะแนนจิตพิสัย</b></a></td>
        <td width="15%" align="right" valign="middle" bgcolor="#CCCCCC"><b>
        <?php echo $scoretype_obj->getAffectivescore();?></b>
        </td>
        <td width="15%" align="center" valign="middle" bgcolor="#DDDDDD"><a href="#" id="editaffectivescore"><img src="../images/icons/32/edit.png" width="32" height="32" align="absmiddle">แก้ไข</a></td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
  <tr>
  	<td height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>รวม</strong></td>
    <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><b><?php echo $scoretype_obj->totalscore+$scoretype_obj->getAffectivescore();?></b>&nbsp;</td>
  </tr>
</table>
