<?php
session_start();
$department_ID=$_GET["department_ID"];
header("Content-type: text/html; charset=utf-8");
echo "<script type='text/javascript'>var tagid='".$tagid."';</script>";
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
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
	$('#arealevel_comb').change();
	$('#adddepartmajorform').ajaxForm({ 
        target: '#areamajor',
		beforeSubmit: function(){
			$('#adddepartmajor').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
    	<center><form id="adddepartmajorform" action="majordepart.php" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000">
    <tr>
      <td width="5%" height="25" align="center" valign="top"></td>
      <td width="10%" align="left" valign="top"><select name="arealevel_comb" id="arealevel_comb">
            <option value="ปวช">ปวช</option>
            <option value="ปวส">ปวส</option>
          </select></td>
      <td width="40%" height="25" align="left" valign="top"><select name="area_comb" id="area_comb" >
      </select></td>
      <td width="30%" height="25" align="left" valign="top"><select name="major_comb" id="major_comb">
      </select></td>
      <td align="center" valign="top"><input name="department_ID" type="hidden" id="department_ID" value="<?php echo $department_ID; ?>" /><input name="departmajorsave_bt" type="submit" id="departmajorsave_bt" value="บันทึก" /><input name="departmajorcancel_bt" type="submit" id="departmajorcancel_bt" value="ยกเลิก" /></td>
    </tr>
    </table>   
        </form></center>