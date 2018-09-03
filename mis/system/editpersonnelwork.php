<?php
session_start();
$tagid=$_GET["tagid"];
$personnelwokrh_ID=$_GET["personnelwokrh_ID"];
include("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select * From personnelwokrh Where personnelwokrh_ID='$personnelwokrh_ID'";
$personnelwork_query = mysql_query($query,$conn) or die(mysql_error());
$personnelwork_fetch = mysql_fetch_array($personnelwork_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#editperworkform').ajaxForm({ 
        target: '#personnelwork',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
<?php include("../includefiles/datalist.php");?>
<form id="editperworkform" action="personnelwork.php" method="post">
<table width="100%" bgcolor="#CCCCCC" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0">
<tr height="25" bgcolor="#EEEEEE">
    	<td align="left" width="55%"><b>ตำแหน่ง : </b><input name="personnelwokrhposition_txt" type="text" id="personnelwokrhposition_txt" value="<?php echo $personnelwork_fetch["personnelwokrh_position"]; ?>" size="20" maxlength="20" /><br />
        <b>วิทยฐานะ : </b><select name="personnelwokrhstanding_comb" id="personnelwokrhstanding_comb">
      <option value="">-</option>
      <option value="ชำนาญการ" <?php if($personnelwork_fetch["personnelwokrh_standing"]=="ชำนาญการ") echo "selected='selected'";?>>ชำนาญการ</option>
      <option value="ชำนาญการพิเศษ" <?php if($personnelwork_fetch["personnelwokrh_standing"]=="ชำนาญการพิเศษ") echo "selected='selected'";?>>ชำนาญการพิเศษ</option>
      <option value="เชี่ยวชาญ" <?php if($personnelwork_fetch["personnelwokrh_standing"]=="เชี่ยวชาญ") echo "selected='selected'";?>>เชี่ยวชาญ</option>
      <option value="เชี่ยวชาญพิเศษ" <?php if($personnelwork_fetch["personnelwokrh_standing"]=="เชี่ยวชาญพิเศษ") echo "selected='selected'";?>>เชี่ยวชาญพิเศษ</option>
      </select><br />
      <b>สถานศึกษา : </b><input name="personnelwokrhschool_txt" type="text" id="personnelwokrhschool_txt" value="<?php echo $personnelwork_fetch["personnelwokrh_school"]; ?>" size="22" maxlength="50" /></td>
        <td align="center" width="15%"><input name="personnelwokrhsalary_txt" type="text" id="personnelwokrhsalary_txt" value="<?php echo $personnelwork_fetch["personnelwokrh_salary"]; ?>" size="5" maxlength="50" /> บาท</td>
        <td align="left">วันที่ <select name="personnelwokrhday_comb" id="personnelwokrhday_comb">
    <?php for($i=1;$i<=31;$i++){
		 echo "<option value='$i' ";
		 if(substr($personnelwork_fetch["personnelwokrh_date"],8,2)==$i) echo "selected='selected'";
		 echo " >$i</option>";
	}?>
    </select><br />
        เดือน <select name="personnelwokrhmonth_comb" id="personnelwokrhmonth_comb">
    <?php for($i=1;$i<=12;$i++){
		 echo "<option value='$i' ";
		 if(substr($personnelwork_fetch["personnelwokrh_date"],5,2)==$i) echo "selected='selected'";
		 echo " >$thmonth[$i]</option>";
		 
	}?>
    </select><br />
       พ.ศ <select name="personnelwokrhyear_comb" id="personnelwokrhyear_comb">
    <?php for($i=0;$i<=100;$i++){
		 echo "<option value='".(date('Y')-$i)."' ";
		 if(substr($personnelwork_fetch["personnelwokrh_date"],0,4)==(date('Y')-$i)) echo "selected='selected'";
		 echo" >".(date('Y')+543-$i)."</option>";
	}?>
      </select></td>
</tr>
<tr>
<td align="center" colspan="3"><input name="personnelwokrhID_txt" type="hidden" id="personnelwokrhID_txt" value="<?php echo $personnelwork_fetch["personnelwokrh_ID"];?>" /><input name="editwork_bt" type="submit" value="แก้ไข" id="editwork_bt" /><input name="cancel_bt" type="submit" id="cancel_bt" value="ยกเลิก" /></td>
</tr>
</table>
</form>