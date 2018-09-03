<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$scoregroup_ID=$_GET["scoregroup_ID"];
$query = "Select * From scoregroup Where scoregroup_ID='$scoregroup_ID'";
$scoregroup_query=mysql_query($query,$conn)or die(mysql_error());
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addscoredetailform').ajaxForm({ 
        target: '#teachscoretype',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script><center>
        <form id="addscoredetailform" action="teachscoretype.php" method="post">
ชื่อหัวข้อย่อย : <input name="scoredetailname_txt" type="text" id="scoredetailname_txt" size="40" maxlength="100" />
 &nbsp;คะแนน : <input name="scoredetailscore_txt" type="text" id="scoredetailscore_txt" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo mysql_result($scoregroup_query,0,"teach_ID");?>" />
<input name="scoregroup_ID" type="hidden" id="scoregroup_ID" value="<?php echo mysql_result($scoregroup_query,0,"scoregroup_ID");?>" />
<br />
<input type="submit" name="addscoredetail_bt" id="addscoredetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
