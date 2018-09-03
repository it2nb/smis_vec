<?php
session_start();
$area_ID=$_GET["area_ID"];
$tagid=$_GET['tagid'];
header("Content-type: text/html; charset=utf-8");
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addmajorform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
    	<center><form id="addmajorform" action="manageareamajor.php" method="post">
        รหัสสาขางาน 
            <label for="majorID_txt"></label>
            <input name="majorID_txt" type="text" id="majorID_txt" size="6" maxlength="6" />
สาขางาน
<input name="majorname_txt" type="text" id="majorname_txt" size="15" />
          <input name="area_ID" type="hidden" id="area_ID" value="<?php echo $area_ID;?>" />
          <input name="majorsave_bt" type="submit" id="majorsave_bt" value="บันทึก" /><input name="majorcancel_bt" type="submit" id="majorcancel_bt" value="ยกเลิก" />
</form></center>