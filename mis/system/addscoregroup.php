<?php
session_start();
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addscoregroupform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#scoregroup_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
        <form id="addscoregroupform" action="teachscoretype.php" method="post">
ชื่อหัวข้อหลัก : <input name="scoregroupname_txt" type="text" id="scoregroupname_txt" size="40" maxlength="100" />
 &nbsp;คะแนน : <input name="scoregroupscore_txt" type="text" id="scoregroupscore_txt" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
<br />
<input type="submit" name="addscoregroup_bt" id="addscoregroup_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form>
