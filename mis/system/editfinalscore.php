<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/Teach.php';
include '../classes/Scoregroup.php';
include '../classes/Scoredetail.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$teach = new Teach($conn);
$scoregroup = new Scoregroup($conn);
$scoredetail = new Scoredetail($conn);
$teach->queryByID($teach_ID);
if($teach->scoregroup_ID==0){
	$scoregroup->insertData('finalID'.$teach->teach_ID,0,$teach->teach_ID);
	$scoregroup->queryByFk('scoregroup_name','finalID'.$teach->teach_ID);
	$scoregroup->fetchRow();
	$scoredetail->insertData('finalID'.$teach->teach_ID,0,$scoregroup->scoregroup_ID);
	$teach->updateScoregroupID($teach->teach_ID,$scoregroup->scoregroup_ID);
}
else{
	$scoregroup->queryByID($teach->scoregroup_ID);
}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editfinalscoreform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#finalscore').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="editfinalscoreform" action="teachscoretype.php" method="post">
        <b>คะแนนสอบปลายภาค
          &nbsp;คะแนน : </b>
          <input name="scoregroupscore_txt" type="text" id="scoregroupscore_txt" value="<?php echo $scoregroup->scoregroup_score;?>" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $scoregroup->teach_ID;?>" />
<input name="scoregroup_ID" type="hidden" id="scoregroup_ID" value="<?php echo $scoregroup->scoregroup_ID;?>" />
<br />
<input type="submit" name="editfinalscore_bt" id="editfinalscore_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
