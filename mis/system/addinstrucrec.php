<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$instrucrec_ID=$_GET["instrucrec_ID"];
$teach_ID=$_GET["teach_ID"];
$teachday_ID=$_GET["teachday_ID"];
$week=$_GET["week"];
$tagid=$_GET["tagid"];
if(!empty($instrucrec_ID)){
	$query = "Select * From instrucrec Where instrucrec_ID='$instrucrec_ID'";
	$instrucrec_query=mysql_query($query,$conn)or die(mysql_error());
	$instrucrec_fetch=mysql_fetch_assoc($instrucrec_query);
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
	$('#addinstrucrecform').ajaxForm({ 
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
        <form id="addinstrucrecform" action="instrucrec.php" method="post">
          <textarea class="textwrapper" name="instrucrecdetail_txt" cols="2" rows="5" id="instrucrecdetail_txt"><?php echo $instrucrec_fetch["instrucrec_detail"];?></textarea>
 &nbsp;
 <input name="instrucrec_ID" type="hidden" id="instrucrec_ID" value="<?php echo $instrucrec_ID;?>" />
 <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
<input name="teachday_ID" type="hidden" id="teachday_ID" value="<?php echo $teachday_ID;?>" />
<input name="week" type="hidden" id="week" value="<?php echo $week;?>" />
<br />
<input type="submit" name="addscoredetail_bt" id="addscoredetail_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
</form></center>
