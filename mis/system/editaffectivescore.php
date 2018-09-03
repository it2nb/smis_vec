<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/Teach.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$teach = new Teach($conn);
$teach->queryByID($teach_ID);
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editaffectscoreform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#affectscore').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="editaffectscoreform" action="teachscoretype.php" method="post">
        <b>คะแนนจิตพิสัย
          &nbsp;คะแนน : </b>
          <input name="affectscore" type="text" id="affectscore" value="<?php echo $teach->affectscore;?>" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach->teach_ID;?>" />
<br />
<input type="submit" name="editaffectscore_bt" id="editaffectscore_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
