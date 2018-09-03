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
	$('#addperworkform').ajaxForm({ 
        target: '#personnelwork',
		beforeSubmit: function(){
			$('#work_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<?php include("../includefiles/datalist.php");?>
<form id="addperworkform" action="personnelwork.php" method="post">
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
<tr height="25" bgcolor="#EEEEEE">
    	<td align="left" width="55%"><b>ตำแหน่ง : </b><input name="personnelwokrhposition_txt" type="text" size="20" maxlength="20" id="personnelwokrhposition_txt" /><br />
        <b>วิทยฐานะ : </b><select name="personnelwokrhstanding_comb" id="personnelwokrhstanding_comb">
      <option value="">-</option>
      <option value="ชำนาญการ">ชำนาญการ</option>
      <option value="ชำนาญการพิเศษ">ชำนาญการพิเศษ</option>
      <option value="เชี่ยวชาญ">เชี่ยวชาญ</option>
      <option value="เชี่ยวชาญพิเศษ">เชี่ยวชาญพิเศษ</option>
      </select><br />
      <b>สถานศึกษา : </b><input name="personnelwokrhschool_txt" type="text" size="22" maxlength="50" id="personnelwokrhschool_txt" /></td>
        <td align="center" width="15%"><input name="personnelwokrhsalary_txt" type="text" id="personnelwokrhsalary_txt" size="5" maxlength="50" /> บาท</td>
        <td align="left">วันที่ <select name="personnelwokrhday_comb" id="personnelwokrhday_comb">
    <?php for($i=1;$i<=31;$i++){
		 echo "<option value='$i'>$i</option>";
	}?>
    </select><br />
        เดือน <select name="personnelwokrhmonth_comb" id="personnelwokrhmonth_comb">
    <?php for($i=1;$i<=12;$i++){
		 echo "<option value='$i'>$thmonth[$i]</option>";
	}?>
    </select><br />
       พ.ศ <select name="personnelwokrhyear_comb" id="personnelwokrhyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."'>".(date('Y')+543-$i)."</option>";
	}?>
      </select></td>
</tr>
<tr>
<td align="center" colspan="3"><input name="addwork_bt" type="submit" value="เพิ่ม" id="addwork_bt" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" /></td>
</tr>
</table>
</form>