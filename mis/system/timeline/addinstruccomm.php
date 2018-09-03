<?php
session_start();
require_once("../../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$instrucrec_ID=$_GET["instrucrec_ID"];
$timeline_ID=$_GET["timeline_ID"];
$personnel_ID=$_GET["personnel_ID"];
$tagid=$_GET["tagid"];
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<style type="text/css">
textarea
{
    width:100%;
}
.textwrapper
{
    border:1px solid #999999;
    margin:5px 0;
    padding:3px;
}
</style>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addinstruccommform').ajaxForm({ 
        target: '#'+tagid,
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	
});
</script>
        <form id="addinstruccommform" action="timeline/instrucrec.php" method="post">
          <textarea class="textwrapper" name="instruccommdetail_txt" cols="2" rows="2" id="instruccommdetail_txt"></textarea>
 &nbsp;
 <input name="instrucrec_ID" type="hidden" id="instrucrec_ID" value="<?php echo $instrucrec_ID;?>" />
 <input name="timeline_ID" type="hidden" id="timeline_ID" value="<?php echo $timeline_ID;?>" />
<input name="personnel_ID" type="hidden" id="personnel_ID" value="<?php echo $personnel_ID;?>" />
<br />
<input type="submit" name="addcommdetail_bt" id="addcommdetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form>
