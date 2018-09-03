<?php
session_start();
$tagid=$_GET["tagid"];
$personneledu_ID=$_GET["personneledu_ID"];
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select * From personneledu Where personneledu_ID='$personneledu_ID'";
$personneledu_query = mysql_query($query,$conn) or die(mysql_error());
$personneledu_fetch = mysql_fetch_array($personneledu_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editpereduform').ajaxForm({ 
        target: '#personneledu',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<form id="editpereduform" action="personneledu.php" method="post">
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
<tr height="25" bgcolor="#EEEEEE">
    	<td align="center" width="20%"><select name="personneledulevel_comb" id="personneleduส_comb">
      <option value="ปริญญาเอก" <?php if($personneledu_fetch["personneledu_level"]=="ปริญญาเอก") echo "selected='selected'";?>>ปริญญาเอก</option>
      <option value="ปริญญาโท" <?php if($personneledu_fetch["personneledu_level"]=="ปริญญาโท") echo "selected='selected'";?>>ปริญญาโท</option>
      <option value="ปริญญาตรี" <?php if($personneledu_fetch["personneledu_level"]=="ปริญญาตรี") echo "selected='selected'";?>>ปริญญาตรี</option>
      <option value="อนุปริญญา" <?php if($personneledu_fetch["personneledu_level"]=="อนุปริญญา") echo "selected='selected'";?>>อนุปริญญา</option>
      <option value="ปวท." <?php if($personneledu_fetch["personneledu_level"]=="ปวท.") echo "selected='selected'";?>>ปวท.</option>
      <option value="ปวส." <?php if($personneledu_fetch["personneledu_level"]=="ปวส.") echo "selected='selected'";?>>ปวส.</option>
      <option value="ปวช." <?php if($personneledu_fetch["personneledu_level"]=="ปวช.") echo "selected='selected'";?>>ปวช.</option>
      <option value="ม.6" <?php if($personneledu_fetch["personneledu_level"]=="ม.6") echo "selected='selected'";?>>ม.6</option>
      <option value="ม.3" <?php if($personneledu_fetch["personneledu_level"]=="ม.3") echo "selected='selected'";?>>ม.3</option>
      <option value="ป.6" <?php if($personneledu_fetch["personneledu_level"]=="ป.6") echo "selected='selected'";?>>ป.6</option>
      <option value="ป.3" <?php if($personneledu_fetch["personneledu_level"]=="ป.3") echo "selected='selected'";?>>ป.3</option>
      </select></td>
        <td align="left" width="55%"><b>วุฒิ/สาขา : </b><input name="personneledumajor_txt" type="text" id="personneledumajor_txt" value="<?php echo $personneledu_fetch["personneledu_major"];?>" size="25" maxlength="50" /><br />
        <b>สถาบัน : </b><input name="personneleduschool_txt" type="text" id="personneleduschool_txt" value="<?php echo $personneledu_fetch["personneledu_school"];?>" size="25" maxlength="50" /></td>
        <td align="center" width="15%"><select name="personneleduyear_comb" id="personneleduyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."' ";
		 if(substr($personneledu_fetch["personneledu_year"],0,4)==(date('Y')-$i)) echo "selected='selected'";
		 echo" >".(date('Y')+543-$i)."</option>";
	}?>
    </select></td>
         <td align="center"></td>
</tr>
<tr>
<td align="center" colspan="4"><input name="personneleduID_txt" type="hidden" id="personneleduID_txt" value="<?php echo $personneledu_fetch["personneledu_ID"];?>" /><input name="editedu_bt" type="submit" value="แก้ไข" id="editedu_bt" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" /></td>
</tr>
</table>
</form>