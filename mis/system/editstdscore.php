<?php
session_start();
require_once("../includefiles/connectdb.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$scoredetail_ID=$_GET["scoredetail_ID"];
$query="Select * From teachstd,student Where teachstd.student_ID=student.student_ID and teachstd.teach_ID='$teach_ID' and student_endstatus='0'";
$student_query=mysql_query($query,$conn) or die(mysql_error());

$query = "Select * From scoredetail Where scoredetail_ID='$scoredetail_ID'";
$scoredetail_query=mysql_query($query,$conn)or die(mysql_error());
$scoredetail_fetch=mysql_fetch_assoc($scoredetail_query);

$query = "Select count(teach_ID) as finalcheck From teach Where scoregroup_ID=(Select scoregroup_ID From scoredetail Where scoredetail_ID='$scoredetail_ID')";
$finalcheck_query=mysql_query($query,$conn)or die(mysql_error());
if(mysql_result($finalcheck_query,0,"finalcheck")>0){
	$scorename="สอบปลายภาคเรียน";
}
else{
	$query = "Select scoregroup_name From scoregroup Where scoregroup_ID=(Select scoregroup_ID From scoredetail Where scoredetail_ID='$scoredetail_ID')";
	$scoregroup_query=mysql_query($query,$conn)or die(mysql_error());
	$scoregroup_fetch=mysql_fetch_assoc($scoregroup_query);
	$scoregroupname=$scoregroup_fetch["scoregroup_name"];
	$scorename=$scoredetail_fetch["scoredetail_name"];
}

echo "<script type='text/javascript'>var scoredetail_ID='".$scoredetail_ID."'</script>";
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#editstdscoreform').ajaxForm({ 
        target: '#stdscore',
		beforeSubmit: function(){
			$('#stdscore').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
<center>
<form action="stdscore.php" method="post" id="editstdscoreform" >
        <table width="98%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                <th height="50" colspan="5" bgcolor="#CCCCCC"><?php echo $scoregroupname."<br>".$scorename;?></th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="25%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คะแนน</td>
    </tr>
  <?php
  while($student_fetch=mysql_fetch_assoc($student_query))
  {
	  $query="Select * From stdscore Where student_ID='".$student_fetch["student_ID"]."' and scoredetail_ID='$scoredetail_ID'";
	  $stdscore_query = mysql_query($query,$conn)or die(mysql_error());
	  $stdscore_fetch = mysql_fetch_assoc($stdscore_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $student_fetch["student_ID"];?></td>
    <td valign="middle"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></td>
    <td align="center" valign="middle">
		<select name="stdscorescore_comb[<?php echo $student_fetch["student_ID"];?>]" id="stdscorescore_comb[<?php echo $student_fetch["student_ID"];?>]">
		<?php 
		for($i=0;$i<=$scoredetail_fetch["scoredetail_score"];$i++){
			if($i==$stdscore_fetch["stdscore_score"])
				echo "<option value='$i' selected='selected'>$i</option>";
			else
				echo "<option value='$i'>$i</option>";
		}
		?>
    	</select>
    </td>
    </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="5" align="center" valign="middle">
    <input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
    <input name="scoredetail_ID" type="hidden" id="scoredetial_ID" value="<?php echo $scoredetail_ID;?>" />
    <input type="submit" name="stdscoresave_bt" id="stdscoresave_bt" value="บันทึก" />
       &nbsp;
       <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" /></td>
    </tr>
</table>
</form>
<br />
</center>