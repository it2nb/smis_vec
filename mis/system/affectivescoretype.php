<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/affectivescoretype.class.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
if(empty($teach_ID))
	$teach_ID=$_POST['teach_ID'];
$affetivetype_obj= new Affectivescoretype_class($conn,$teach_ID);
if($_POST["addteachaffective_bt"]=="บันทึก"){
	$affetivetype_obj->insertTeachAffective($_POST['teach_ID'],$_POST['affective_ID'],$_POST['teachaffective_score']);
}
else if($_POST["editaffectscoretype_bt"]=="บันทึก"){
	$affetivetype_obj->updateTeachAffectiveScore($_POST["teach_ID"],$_POST["affective_ID"],$_POST["teachaffectscore"]);
}
else if($_GET["deleteaffective_bt"]=="ลบ"){
	$affetivetype_obj->deleteTeachAffective($_GET["affective_ID"],$_GET['teach_ID']);
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#addteachaffective').click(function(){
		$.get('addteachaffective.php',{'teach_ID':teach_ID},function(data){$('#teachaffective_add').html(data)});
	});
});
function stdaffectivescore(teachid,id){
	$.get('stdaffectivescore.php',{'teach_ID':teachid,'affective_ID':id},function(data){$('#stdscore').html(data)});
}
function editteachaffectivescore(teachid, id, tag){
	$.get('editaffectivescoretype.php',{'teach_ID':teachid,'affective_ID':id,'tagid':tag},function(data){$('#'+tag).html(data)});
}
function deleteteachaffective(id, txt, teach_ID){
	var conf = confirm("คุณแน่ใจว่าจะลบหัวข้อจิตพิสัย "+txt+"\nข้อมูลอื่นๆ ที่เกี่ยวข้องกับหัวข้อคะแนนจิตพิสัยนี้จะถูกลบด้วย");
	if(conf==true){
		$.get('affectivescoretype.php',{
			'affective_ID':id,
			'teach_ID':teach_ID,
			'deleteaffective_bt':'ลบ'},function(data){$('#affectivescoretype').html(data)});
		$('#stdscore').html("");
	}
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
    <td height="50" colspan="4" align="center" valign="middle" bgcolor="#CCCCCC"><h2>รายการคะแนนจิตพิสัย</h2></td>
  </tr>
    <tr>
      <td width="6%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><strong>ที่</strong></td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><strong>หัวข้อจิตพิสัย</strong></td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10"><strong>คะแนน</strong></td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
  </tr>
  <?php
  $affetivetype_obj->queryTeachAffective();
  $n=1;
  while($affetivetype_obj->fetchTeachaffective()){
  ?>
  <tr>
  	<td align="center" valign="middle" bgcolor="#EEEEEE"><b><?php echo $n++;?></b></td>
    <td height="30" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="left" valign="middle">
        <div id="<?php echo "affective".$affetivetype_obj->affective_ID;?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td height="30" align="left" valign="middle" bgcolor="#EEEEEE"><b><a href="#" onclick="stdaffectivescore('<?php echo $teach_ID;?>','<?php echo $affetivetype_obj->affective_ID; ?>')"><?php echo $affetivetype_obj->affective_name;?></a></b></td>
            <td width="20%" align="right" valign="middle" bgcolor="#DDDDDD" ><b><?php echo $affetivetype_obj->affective_score;?></b></td>
            <td width="15%" align="center" valign="middle" bgcolor="#EEEEEE"><a href="#" onclick="editteachaffectivescore('<?php echo $teach_ID;?>','<?php echo $affetivetype_obj->affective_ID;?>','<?php echo "affective".$affetivetype_obj->affective_ID;?>')"><img src="../images/icons/16/edit.png" width="16" height="16" /></a>&nbsp;&nbsp;<a href="#" onclick="deleteteachaffective('<?php echo $affetivetype_obj->affective_ID;?>','<?php echo $affetivetype_obj->affective_name;?>','<?php echo $teach_ID;?>')"><img src="../images/icons/16/delete.png" width="16" height="16" /></a></td>
          </tr>
        </table>
        </div>
        </td>
      </tr>
    </table></td>
  </tr>
  <?php }?>
  <tr>
    <td height="30" colspan="4" align="center" valign="middle"><div id="teachaffective_add"><a href="#" id="addteachaffective"><img src="../images/icons/16/add.png" width="16" height="16" align="absmiddle" />เพิ่มหัวข้อหลัก</a></div></td>
  </tr>
</table>
