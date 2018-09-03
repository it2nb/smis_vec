<?php
session_start();
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addareaform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#area_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
    	<center><form id="addareaform" action="manageareamajor.php" method="post">
        รหัสสาขาวิชา 
            <label for="areaID_txt"></label>
            <input name="areaID_txt" type="text" id="areaID_txt" size="5" maxlength="4" />
สาขาวิชา
<input name="areaname_txt" type="text" id="areaname_txt" size="15" />
          ระดับ
          <select name="arealevel_comb" id="arealevel_comb">
            <option value="ปวช">ปวช</option>
            <option value="ปวส">ปวส</option>
          </select>
          <input name="areasave_bt" type="submit" id="areasave_bt" value="บันทึก" /><input name="areacancel_bt" type="submit" id="areacancel_bt" value="ยกเลิก" />
        </form></center>