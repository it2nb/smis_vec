<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(empty($_GET["n"]))
	$n=0;
else
	$n = $_GET["n"];
if($_GET["delete_bt"]=="ลบ"){
	$period_term = $_GET["period_term"];
	$period_year = $_GET["period_year"];
	$query = "Delete From period Where period_year='$period_year' and period_term='$period_term'";
	$delete_period = mysql_query($query,$conn)or die(mysql_error());
}
$query="Select count(period_year) as totalperiod From period";
$periodnum_query=mysql_query($query,$conn) or die(mysql_error());
$periodnum_fetch=mysql_fetch_array($periodnum_query);
$periodnum = $periodnum_fetch["totalperiod"];

$query="Select * From period Order by period_year DESC,period_term DESC Limit $n,25";
$period_query=mysql_query($query,$conn) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#addperiod').click(function(){
		$('#systemcontent').load("addperiod.php");
	});
});
function editperiod(year,term){
	$.get('editperiod.php',{'period_year': year,'period_term': term},function(data){$('#systemcontent').html(data);});
}
function deleteperiod(year,term){
	var conf = confirm("คุณแน่ใจที่จะลบภาคเรียนที่ "+term+" ปีการศึกษา "+(parseInt(year)+543));
	if(conf==true)
		$.get('manageperiod.php',{'period_year': year,'period_term': term,'delete_bt':'ลบ'},function(data){$('#systemcontent').html(data);});
}
function changepage(npage){
	$.get('manageinformation.php',{
		'n':npage,},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">จัดการข้อมูลภาคเรียน</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="addperiod"><img src="../images/icons/64/add.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <th height="50" colspan="8" bgcolor="#CCCCCC">ข้อมูลภาคเรียน</th>
  <tr>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ปีการศึกษา</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ภาคเรียน</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เริ่มว้นที่</td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สิ้นสุดวันที่</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($period_fetch=mysql_fetch_array($period_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $period_fetch["period_year"]+543;?></td>
    <td align="center" valign="middle"><?php echo $period_fetch["period_term"];?></td>
    <td align="center" valign="middle"><?php echo substr($period_fetch["period_start"],8,2)." ".$thmonth[substr($period_fetch["period_start"],5,2)*1]." ".(substr($period_fetch["period_start"],0,4)+543);?></td>
    <td align="center" valign="middle"><?php echo substr($period_fetch["period_end"],8,2)." ".$thmonth[substr($period_fetch["period_end"],5,2)*1]." ".(substr($period_fetch["period_end"],0,4)+543);?></td>
    <td align="center" valign="middle"><a href="#" onclick="editperiod('<?php echo $period_fetch["period_year"];?>','<?php echo $period_fetch["period_term"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" alt="แก้ไข" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteperiod('<?php echo $period_fetch["period_year"];?>','<?php echo $period_fetch["period_term"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($newsnum/25);
if($totalpage>1)
{
	for($i=1;$i<=$totalpage;$i++)
	{
		echo "หน้า ";
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\")'>$i</a>";
	}
} 
?>
</center></div>