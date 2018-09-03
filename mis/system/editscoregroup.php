<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/Scoregroup.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$scoregroup_ID=$_GET["scoregroup_ID"];
$scoregroup = new Scoregroup($conn);
$scoregroup->queryByID($scoregroup_ID);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editscoregroupform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="editscoregroupform" action="teachscoretype.php" method="post">
ชื่อหัวข้อหลัก : <input name="scoregroupname_txt" type="text" id="scoregroupname_txt" value="<?php echo $scoregroup->scoregroup_name;?>" size="40" maxlength="100" />
 &nbsp;คะแนน : <input name="scoregroupscore_txt" type="text" id="scoregroupscore_txt" value="<?php echo $scoregroup->scoregroup_score;?>" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $scoregroup->teach_ID;?>" />
<input name="scoregroup_ID" type="hidden" id="scoregroup_ID" value="<?php echo $scoregroup->scoregroup_ID;?>" />
<br />
<input type="submit" name="editscoregroup_bt" id="editscoregroup_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
