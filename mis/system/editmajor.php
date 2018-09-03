<?php
session_start();
$major_ID=$_GET["major_ID"];
$tagid=$_GET['tagid'];
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select * From major Where major_ID='$major_ID'";
$major_query = mysql_query($query,$conn) or die(mysql_error());
$major_fetch = mysql_fetch_array($major_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editmajorform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });

});

</script>
    	<center><form id="editmajorform" action="manageareamajor.php" method="post">
        สาขางาน
          <input name="majorname_txt" type="text" id="majorname_txt" value="<?php echo $major_fetch["major_name"];?>" size="25" />
          <input name="major_ID" type="hidden" id="major_ID" value="<?php echo $major_ID;?>" />
          <input name="majoredit_bt" type="submit" id="majoredit_bt" value="บันทึก" /><input name="majorcancel_bt" type="submit" id="majorcancel_bt" value="ยกเลิก" />
</form></center>