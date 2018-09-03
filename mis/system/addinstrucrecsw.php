<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$instrucrecsw_ID=$_GET["instrucrecsw_ID"];
$subject_ID=$_GET["subject_ID"];
$course_ID=$_GET["course_ID"];
$instrucrecsw_week=$_GET["instrucrecsw_week"];
$instrucrecsw_term=$_GET["instrucrecsw_term"];
$instrucrecsw_year=$_GET["instrucrecsw_year"];
$tagid=$_GET["tagid"];
if(!empty($instrucrecsw_ID)){
	$query = "Select * From instrucrecsw Where instrucrecsw_ID='$instrucrecsw_ID'";
	$instrucrecsw_query=mysql_query($query,$conn)or die(mysql_error());
	$instrucrecsw_fetch=mysql_fetch_assoc($instrucrecsw_query);
}
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
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#instrucrecswdetailform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('textarea.textwrapper').ckeditor(function(){},{
		toolbar :
[
	{ name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord'] },
	{ name: 'basicstyles',	items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
	{ name: 'paragraph',	items : [ 'BidiLtr','BidiRtl' ] },
	{ name: 'links',		items : [ 'Source','Link','Unlink' ] },
]
	});
});

</script><center>
        <form id="instrucrecswdetailform" action="instrucrecswdetail.php" method="post">
          <textarea class="textwrapper" name="instrucrecswdetail_txt" cols="2" rows="5" id="instrucrecswdetail_txt"><?php echo $instrucrecsw_fetch["instrucrecsw_detail"];?></textarea>
 &nbsp;
 <input name="instrucrecsw_ID" type="hidden" id="instrucrecsw_ID" value="<?php echo $instrucrecsw_ID;?>" />
 <input name="subject_ID" type="hidden" id="subject_ID" value="<?php echo $subject_ID;?>" />
<input name="course_ID" type="hidden" id="course_ID" value="<?php echo $course_ID;?>" />
<input name="instrucrecsw_week" type="hidden" id="instrucrecsw_week" value="<?php echo $instrucrecsw_week;?>" />
<input name="instrucrecsw_term" type="hidden" id="instrucrecsw_term" value="<?php echo $instrucrecsw_term;?>" />
<input name="instrucrecsw_year" type="hidden" id="instrucrecsw_year" value="<?php echo $instrucrecsw_year;?>" />
<br />
<input type="submit" name="addinstrucrecswdetail_bt" id="addinstrucrecswdetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
