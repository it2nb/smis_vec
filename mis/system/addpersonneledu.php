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
	$('#addpereduform').ajaxForm({ 
        target: '#personneledu',
		beforeSubmit: function(){
			$('#edu_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<form id="addpereduform" action="personneledu.php" method="post">
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
<tr height="25" bgcolor="#EEEEEE">
    	<td align="center" width="20%"><select name="personneledulevel_comb" id="personneledulevel_comb">
      <option value="ปริญญาเอก">ปริญญาเอก</option>
      <option value="ปริญญาโท">ปริญญาโท</option>
      <option value="ปริญญาตรี">ปริญญาตรี</option>
      <option value="อนุปริญญา">อนุปริญญา</option>
      <option value="ปวท.">ปวท.</option>
      <option value="ปวส.">ปวส.</option>
      <option value="ปวช.">ปวช.</option>
      <option value="ม.6">ม.6</option>
      <option value="ม.3">ม.3</option>
      <option value="ป.6">ป.6</option>
      <option value="ป.3">ป.3</option>
      </select></td>
        <td align="left" width="55%"><b>วุฒิ/สาขา : </b><input name="personneledumajor_txt" type="text" id="personneledumajor_txt" size="25" maxlength="50" /><br />
        <b>สถาบัน : </b><input name="personneleduschool_txt" type="text" id="personneleduschool_txt" size="25" maxlength="50" /></td>
        <td align="center" width="15%"><select name="personneleduyear_comb" id="personneleduyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."'>".(date('Y')+543-$i)."</option>";
	}?>
    </select></td>
         <td align="center"></td>
</tr>
<tr>
<td align="center" colspan="4"><input name="addedu_bt" type="submit" value="เพิ่ม" id="addedu_bt" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" /></td>
</tr>
</table>
</form>