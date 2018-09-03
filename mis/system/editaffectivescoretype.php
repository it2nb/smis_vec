<?php
session_start();
require_once("../includefiles/connectdb.php");
include '../classes/Teachaffective.php';
include '../classes/Affective.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$affective_ID=$_GET["affective_ID"];
$tag = $_GET['tag'];
$teachaffective = new Teachaffective($conn);
$affective = new Affective($conn);
$teachaffective->queryByID($teach_ID,$affective_ID);
$affective->queryByID($affective_ID);
echo "<script>var tag='".$tag."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editaffectscoretypeform').ajaxForm({ 
        target: '#affectivescoretype',
		beforeSubmit: function(){
			$('#'+tag).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="editaffectscoretypeform" action="affectivescoretype.php" method="post">
        <b><?php echo $affective->affective_name;?>
          &nbsp;คะแนน : </b>
          <input name="teachaffectscore" type="text" id="teachaffectscore" value="<?php echo $teachaffective->score;?>" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teachaffective->teach_ID;?>" />
<input name="affective_ID" type="hidden" id="affective_ID" value="<?php echo $teachaffective->affective_ID;?>" />
<br />
<input type="submit" name="editaffectscoretype_bt" id="editaffectscoretype_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
