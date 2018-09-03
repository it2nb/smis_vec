<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/Scoregroup.php';
include '../classes/Scoredetail.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$scoredetail_ID=$_GET["scoredetail_ID"];
$scoregroup = new Scoregroup($conn);
$scoredetail = new Scoredetail($conn);
$scoredetail->queryByID($scoredetail_ID);
$scoregroup->queryByID($scoredetail->scoregroup_ID);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editscoredetailform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="editscoredetailform" action="teachscoretype.php" method="post">
ชื่อหัวข้อย่อย : <input name="scoredetailname_txt" type="text" id="scoredetailname_txt" value="<?php echo $scoredetail->scoredetail_name; ?>" size="40" maxlength="100" />
 &nbsp;คะแนน : <input name="scoredetailscore_txt" type="text" id="scoredetailscore_txt" value="<?php echo $scoredetail->scoredetail_score; ?>" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $scoregroup->teach_ID;?>" />
<input name="scoredetail_ID" type="hidden" id="scoredetail_ID" value="<?php echo $scoredetail->scoredetail_ID;?>" />
<br />
<input type="submit" name="editscoredetail_bt" id="editscoredetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
