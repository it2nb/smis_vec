<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(empty($_GET["n"]))
	$n=0;
else
	$n = $_GET["n"];
if($_POST["stdsearch_bt"]=="ค้นหา")
	$stdsearch_txt = $_POST["stdsearch_txt"];
else
	$stdsearch_txt = $_GET["stdsearch_txt"];
if(empty($stdsearch_txt)){
	$query="Select count(student_ID) as totalstudent From student";
	$studentnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From student Order by student_ID Limit $n,25";
}
else{
	$query="Select count(student_ID) as totalstudent From student Where student_ID like '%$stdsearch_txt%' or student_name like '%stdsearch_txt%' or student_ser like '%$stdsearch_txt%'";
	$studentnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From student Where student_ID like '%$stdsearch_txt%' or student_name like '%stdsearch_txt%' or student_ser like '%$stdsearch_txt%' Order by student_ID Limit $n,25";
}

			$studentnum_fetch=mysql_fetch_array($studentnum_query);
			$studentnum = $studentnum_fetch["totalstudent"];
			
			$student_query=mysql_query($query,$conn) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	
	$('#manageclass').click(function(){
		$('#systemcontent').load("manageclass.php");
	});
	$('#addstudent').click(function(){
		$('#systemcontent').load("addstudent.php");
	});
	$('#importstd').click(function(){
		$('#systemcontent').load("importstd.php");
	});
	$('#studentresult').click(function(){
		$('#systemcontent').load('studentresult.php');
	});
	//search
	$('#stdsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

function stdinfo(id){
	$.get('studentinfo.php',{'student_ID' : id},function(data) {
		$('#info').html(data);
		blanket_size();
		toggle('blanket');
		window_pos('info',0.5);
		toggle('info');
	});
}

function editstudent(id){
	$.get('editstudent.php',{'student_ID':id},function(data){$('#systemcontent').html(data)});
}

function deletestudent(id){
	$.get('deletestudent.php',{'student_ID':id},function(data){$('#systemcontent').html(data)});
}
function changepage(npage, stdsearch_txt){
	//$('#systemcontent').load(url);
	$.get('managestudent.php',{
		'n':npage,
		'stdsearch_txt':stdsearch_txt},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลนักเรียนนักศึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
        <td align="left" valign="middle" width="192"><a href="#" id="manageclass"><img src="../images/icons/64/stdgroup.png" width="64" height="64" /></a><a href="#" id="addstudent"><img src="../images/icons/64/add.png" width="64" height="64"></a><a href="#" id="importstd"><img src="../images/icons/64/import.png" width="64" height="64" /></a></a></td>
        <td align="left" valign="middle" width="64"><a href="#" id="studentresult"><img src="../images/icons/64/stdresult.png" width="64" height="64" /></a></td>
        <td align="left" valign="middle" width="64"><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle">จัดการข้อมูล</td>
    	<td width="64" align="center" valign="middle">รายงาน</td>
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center><br />
  		<form id="stdsearchform" action="managestudent.php" method="post">
        	<b>ค้นหา</b> <input name="stdsearch_txt" type="text" id="stdsearch_txt" size="50" value="<?php echo $stdsearch_txt;?>"/>
            <input name="stdsearch_bt" type="submit" id="stdsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="7" bgcolor="#CCCCCC">ข้อมูลนักเรียนนักศึกษา ( ทั้งหมด <?php echo $studentnum;?> คน )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสนักศึกษา</td>
    <td width="30%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สาขาวิชา</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($student_fetch=mysql_fetch_array($student_query))
  {
	$query="Select area_name From area Where area_ID='".$student_fetch["area_ID"]."'";
	$area_query=mysql_query($query,$conn)or die(mysql_error());
	$area_fetch=mysql_fetch_array($area_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><a href="#" onclick="stdinfo('<?php echo $student_fetch["student_ID"];?>');"><?php echo $student_fetch["student_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="stdinfo('<?php echo $student_fetch["student_ID"];?>');"><?php echo $student_fetch["student_name"]." ".$student_fetch["student_ser"];?></a></td>
    <td align="center" valign="middle"><?php echo $area_fetch["area_name"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editstudent('<?php echo $student_fetch["student_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32"></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deletestudent('<?php echo $student_fetch["student_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32"></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($studentnum/25);
if($totalpage>1)
{
	echo "หน้า ";
	for($i=1;$i<=$totalpage;$i++)
	{
		
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\",\"".$stdsearch_txt."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\",\"".$stdsearch_txt."\")'>$i</a>";
	}
} 
?>
</center></div>