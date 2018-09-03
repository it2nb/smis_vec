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
	$('#addteachdayform').ajaxForm({ 
        target: '#teachday',
		beforeSubmit: function(){
			$('#teachday_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<?php include("../includefiles/datalist.php");?>
<form id="addteachdayform" action="teachday.php" method="post">
    <table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="2" cellspacing="0">
    <tr height="25" bgcolor="#EEEEEE">
    	<td align="left" valign="middle">
    	  <select name="day_comb" id="day_comb">
          <option value="1">วันจันทร์</option>
          <option value="2">วันอังคาร</option>
          <option value="3">วันพุธ</option>
          <option value="4">วันพฤหัสบดี</option>
          <option value="5">วันศุกร์</option>
  	    </select></td>
        <td width="15%" align="center" valign="middle">
          <select name="daystart_comb" id="daystart_comb">
          <option value="08:00">08:00</option>
          <option value="09:00">09:00</option>
          <option value="10:00">10:00</option>
          <option value="11:00">11:00</option>
          <option value="12:00">12:00</option>
          <option value="13:00">13:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="16:00">16:00</option>
        </select> น.</td>
        <td width="15%" align="center" valign="middle">
          <select name="daystop_comb" id="daystop_comb">
          <option value="09:00">09:00</option>
          <option value="10:00">10:00</option>
          <option value="11:00">11:00</option>
          <option value="12:00">12:00</option>
          <option value="13:00">13:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="16:00">16:00</option>
          <option value="17:00">17:00</option>
        </select> น.</td>
        <td width="10%" align="center" valign="middle">&nbsp;</td>
        <td width="25%" align="left" valign="middle">&nbsp;</td>
        <td width="10%" align="center"><input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $_GET["teach_ID"];?>" /><input type="submit" name="add_bt" id="add_bt" value="บันทึก" />
        <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" /></td>
    </tr></table>
    </form>