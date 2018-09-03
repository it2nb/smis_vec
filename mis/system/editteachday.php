<?php
session_start();
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
include("../includefiles/connectdb.php");
$tagid=$_GET["tagid"];
$teachday_ID=$_GET["teachday_ID"];
$query="Select * From teachday Where teachday_ID='$teachday_ID'";
$teachday_query=mysql_query($query,$conn)or die(mysql_error());
$teachday_fetch=mysql_fetch_array($teachday_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editteachdayform').ajaxForm({ 
        target: '#teachday',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<?php include("../includefiles/datalist.php");?>
<form id="editteachdayform" action="teachday.php" method="post">
    <table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="2" cellspacing="0">
    <tr height="25" bgcolor="#EEEEEE">
    	<td align="left" valign="middle">
    	  <select name="day_comb" id="day_comb">
          <option value="1" <?php if($teachday_fetch["teachday_day"]==1)echo "selected='selected'";?>>วันจันทร์</option>
          <option value="2" <?php if($teachday_fetch["teachday_day"]==2)echo "selected='selected'";?>>วันอังคาร</option>
          <option value="3" <?php if($teachday_fetch["teachday_day"]==3)echo "selected='selected'";?>>วันพุธ</option>
          <option value="4" <?php if($teachday_fetch["teachday_day"]==4)echo "selected='selected'";?>>วันพฤหัสบดี</option>
          <option value="5" <?php if($teachday_fetch["teachday_day"]==5)echo "selected='selected'";?>>วันศุกร์</option>
  	    </select></td>
        <td width="15%" align="center" valign="middle">
          <select name="daystart_comb" id="daystart_comb">
          <option value="08:00" <?php if($teachday_fetch["teachday_start"]=="08:00:00")echo "selected='selected'";?>>08:00</option>
          <option value="09:00" <?php if($teachday_fetch["teachday_start"]=="09:00:00")echo "selected='selected'";?>>09:00</option>
          <option value="10:00" <?php if($teachday_fetch["teachday_start"]=="10:00:00")echo "selected='selected'";?>>10:00</option>
          <option value="11:00" <?php if($teachday_fetch["teachday_start"]=="11:00:00")echo "selected='selected'";?>>11:00</option>
          <option value="12:00" <?php if($teachday_fetch["teachday_start"]=="12:00:00")echo "selected='selected'";?>>12:00</option>
          <option value="13:00" <?php if($teachday_fetch["teachday_start"]=="13:00:00")echo "selected='selected'";?>>13:00</option>
          <option value="14:00" <?php if($teachday_fetch["teachday_start"]=="14:00:00")echo "selected='selected'";?>>14:00</option>
          <option value="15:00" <?php if($teachday_fetch["teachday_start"]=="15:00:00")echo "selected='selected'";?>>15:00</option>
          <option value="16:00" <?php if($teachday_fetch["teachday_start"]=="16:00:00")echo "selected='selected'";?>>16:00</option>
        </select> น.</td>
        <td width="15%" align="center" valign="middle">
          <select name="daystop_comb" id="daystop_comb">
          <option value="09:00" <?php if($teachday_fetch["teachday_stop"]=="09:00:00")echo "selected='selected'";?>>09:00</option>
          <option value="10:00" <?php if($teachday_fetch["teachday_stop"]=="10:00:00")echo "selected='selected'";?>>10:00</option>
          <option value="11:00" <?php if($teachday_fetch["teachday_stop"]=="11:00:00")echo "selected='selected'";?>>11:00</option>
          <option value="12:00" <?php if($teachday_fetch["teachday_stop"]=="12:00:00")echo "selected='selected'";?>>12:00</option>
          <option value="13:00" <?php if($teachday_fetch["teachday_stop"]=="13:00:00")echo "selected='selected'";?>>13:00</option>
          <option value="14:00" <?php if($teachday_fetch["teachday_stop"]=="14:00:00")echo "selected='selected'";?>>14:00</option>
          <option value="15:00" <?php if($teachday_fetch["teachday_stop"]=="15:00:00")echo "selected='selected'";?>>15:00</option>
          <option value="16:00" <?php if($teachday_fetch["teachday_stop"]=="16:00:00")echo "selected='selected'";?>>16:00</option>
          <option value="17:00" <?php if($teachday_fetch["teachday_stop"]=="17:00:00")echo "selected='selected'";?>>17:00</option>
        </select> น.</td>
        <td width="10%" align="center" valign="middle">&nbsp;</td>
        <td width="25%" align="left" valign="middle">&nbsp;</td>
        <td width="10%" align="center"><input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $_GET["teach_ID"];?>" /><input name="teachday_ID" type="hidden" id="teachday_ID" value="<?php echo $teachday_ID;?>" /><input type="submit" name="edit_bt" id="edit_bt" value="แก้ไข" />
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" /></td>
    </tr></table>
    </form>