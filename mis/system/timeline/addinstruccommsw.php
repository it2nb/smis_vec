<?php
session_start();
require_once("../../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$timeline_ID=$_GET["timeline_ID"];
$instrucrecsw_ID=$_GET["instrucrecsw_ID"];
$subject_ID=$_GET["subject_ID"];
$course_ID=$_GET["course_ID"];
$instrucrecsw_term=$_GET["instrucrecsw_term"];
$instrucrecsw_year=$_GET["instrucrecsw_year"];
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
	$('#addinstruccommswform').ajaxForm({ 
        target: '#'+tagid,
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
        <form id="addinstruccommswform" action="timeline/instrucrecsw.php" method="post">
          <textarea class="textwrapper" name="instruccommswdetail_txt" cols="2" rows="2" id="instruccommswdetail_txt"></textarea>
 &nbsp;
 <input name="timeline_ID" type="hidden" id="timeline_ID" value="<?php echo $timeline_ID;?>" />
 <input name="instrucrecsw_ID" type="hidden" id="instrucrecsw_ID" value="<?php echo $instrucrecsw_ID;?>" />
 <input name="subject_ID" type="hidden" id="subject_ID" value="<?php echo $subject_ID;?>" />
<input name="course_ID" type="hidden" id="course_ID" value="<?php echo $course_ID;?>" />
<input name="instrucrecsw_term" type="hidden" id="instrucrecsw_term" value="<?php echo $instrucrecsw_term;?>" />
<input name="instrucrecsw_year" type="hidden" id="instrucrecsw_year" value="<?php echo $instrucrecsw_year;?>" />
<input name="personnel_ID" type="hidden" id="personnel_ID" value="<?php echo $personnel_ID;?>" />
<br />
<input type="submit" name="addcommswdetail_bt" id="addcommswdetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form>
