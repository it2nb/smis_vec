<?php
session_start();
$department_ID=$_GET["department_ID"];
$major_ID=$_GET["major_ID"];
$tagid=$_GET["tagid"];
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query="Select * From area,major Where area.area_ID=major.area_ID and major.major_ID='$major_ID'";
$areamajor_query=mysql_query($query,$conn)or die(mysql_error());
$areamajor_fetch=mysql_fetch_array($areamajor_query);
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#arealevel_comb').change(function() {
		if($('#arealevel_comb').select().val()=="ปวช")
        	$.get('comboval.php',{
				table:'area',
				where:'area_level',
				whereval:'ปวช',
				value:'area_ID',
				comb_txt:'area_name'},function(data){
				$('#area_comb').html(data);
				$('#area_comb').change();
			});
		else if($('#arealevel_comb').select().val()=="ปวส")
        	$.get('comboval.php',{
				table:'area',
				where:'area_level',
				whereval:'ปวส',
				value:'area_ID',
				comb_txt:'area_name'},function(data){
				$('#area_comb').html(data);
				$('#area_comb').change();
			});
		else
			$('#area_comb').html("");
    });
	$('#area_comb').change(function() {
		var area_ID = $('#area_comb').select().val();
        	$.get('comboval.php',{
				table:'major',
				where:'area_ID',
				whereval:area_ID,
				value:'major_ID',
				comb_txt:'major_name'},function(data){
				$('#major_comb').html(data);
			});
    });
	$('#editdepartmajorform').ajaxForm({ 
        target: '#areamajor',
		beforeSubmit: function(){
			$('#'+tagid).html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
    	<center><form id="editdepartmajorform" action="majordepart.php" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000">
    <tr>
      <td width="5%" height="25" align="center" valign="top"></td>
      <td width="10%" align="left" valign="top"><select name="arealevel_comb" id="arealevel_comb">
            <option value="ปวช" <?php if($areamajor_fetch["area_level"]=="ปวช") echo "selected='selected'";?>>ปวช</option>
            <option value="ปวส" <?php if($areamajor_fetch["area_level"]=="ปวส") echo "selected='selected'";?>>ปวส</option>
          </select></td>
      <td width="40%" height="25" align="left" valign="top"><select name="area_comb" id="area_comb" >
       <?php
	  	$area_level=$areamajor_fetch["area_level"];
	   	$query="Select * From area Where area_level='$area_level'";
		$area_query=mysql_query($query,$conn)or die(mysql_error());
		while($area_fetch=mysql_fetch_array($area_query)){
	  ?>
      <option value="<?php echo $area_fetch["area_ID"];?>" <?php if($areamajor_fetch["area_ID"]==$area_fetch["area_ID"]) echo "selected='selected'";?>><?php echo $area_fetch["area_name"];?></option>
      <?php } ?>
      </select></td>
      <td width="30%" height="25" align="left" valign="top"><select name="major_comb" id="major_comb">
      <?php
	  	$area_ID=$areamajor_fetch["area_ID"];
	   	$query="Select * From major Where area_ID='$area_ID'";
		$major_query=mysql_query($query,$conn)or die(mysql_error());
		while($major_fetch=mysql_fetch_array($major_query)){
	  ?>
      <option value="<?php echo $major_fetch["major_ID"];?>" <?php if($areamajor_fetch["major_ID"]==$major_fetch["major_ID"]) echo "selected='selected'";?>><?php echo $major_fetch["major_name"];?></option>
      <?php } ?>
      </select></td>
      <td align="center" valign="top"><input name="department_ID" type="hidden" id="department_ID" value="<?php echo $department_ID; ?>" /><input name="oldmajor_ID" type="hidden" id="oldmajor_ID" value="<?php echo $areamajor_fetch["major_ID"]; ?>" /><input name="departmajoredit_bt" type="submit" id="departmajoredit_bt" value="บันทึก" /><input name="departmajorcancel_bt" type="submit" id="departmajorcancel_bt" value="ยกเลิก" /></td>
    </tr>
    </table>   
        </form></center>