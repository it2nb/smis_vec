<?php
session_start();
$area_ID = $_GET["area_ID"];
$tagid=$_GET["tagid"];
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select * From area Where area_ID='$area_ID'";
$area_query = mysql_query($query,$conn) or die(mysql_error());
$area_fetch = mysql_fetch_array($area_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editareaform').ajaxForm({ 

        target: '#systemcontent',

		beforeSubmit: function(){

			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");

		},

		success: function(){

		}

    });

});

</script>
    	<center><form id="editareaform" action="manageareamajor.php" method="post">
        สาขาวิชา
          <input name="areaname_txt" type="text" id="areaname_txt" value="<?php echo $area_fetch["area_name"];?>" size="20" />
          ระดับ
          <select name="arealevel_comb" id="arealevel_comb">
            <option value="ปวช" <?php if($area_fetch["area_level"]=="ปวช") echo "selected='selected'";?>>ปวช</option>
            <option value="ปวส" <?php if($area_fetch["area_level"]=="ปวส") echo "selected='selected'";?>>ปวส</option>
          </select>
          <input name="area_ID" type="hidden" id="area_ID" value="<?php echo $area_ID;?>" />
          <input name="areaedit_bt" type="submit" id="areaedit_bt" value="บันทึก" /><input name="areacancel_bt" type="submit" id="areacancel_bt" value="ยกเลิก" />
        </form></center>