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
if($_POST["sbjsearch_bt"]=="ค้นหา")
	$sbjsearch_txt = $_POST["sbjsearch_txt"];
else
	$sbjsearch_txt = $_GET["sbjsearch_txt"];
if(empty($sbjsearch_txt)){
	$query="Select count(subject_ID) as totalsubject From subject";
	$subjectnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From subject Order by subject_ID Limit $n,25";
}
else{
	$query="Select count(subject_ID) as totalsubject From subject Where subject_ID like '%$sbjsearch_txt%' or subject_name like '%sbjsearch_txt%'";
	$subjectnum_query=mysql_query($query,$conn) or die(mysql_error());
	$query="Select * From subject Where subject_ID like '%$sbjsearch_txt%' or subject_name like '%$sbjsearch_txt%' Order by subject_ID Limit $n,25";
}
$subjectnum_fetch=mysql_fetch_array($subjectnum_query);
$subjectnum = $subjectnum_fetch["totalsubject"];
			
$subject_query=mysql_query($query,$conn) or die(mysql_error());
?>

<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	$('#managecourse').click(function(){
		$('#systemcontent').load("managecourse.php");
	});
	$('#addsubject').click(function(){
		$('#systemcontent').load("addsubject.php");
	});
	$('#importsubject').click(function(){
		$('#systemcontent').load("importsubject.php");
	});
	//search
	$('#sbjsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

function sbjinfo(id){
	$.get('subjectinfo.php',{'subject_ID' : id},function(data) {
		$('#info').html(data);
		blanket_size();
		toggle('blanket');
		window_pos('info',0.5);
		toggle('info');
	});
}

function editsubject(id,course_ID){
	$.get('editsubject.php',{'subject_ID':id,
	'course_ID':course_ID},function(data){$('#systemcontent').html(data)});
}

function deletesubject(id,course_ID){
	$.get('deletesubject.php',{'subject_ID':id,
	'course_ID':course_ID},function(data){$('#systemcontent').html(data)});
}
function changepage(npage,sbjsearch_txt){
	//$('#systemcontent').load(url);
	$.get('managesubject.php',{
		'n':npage,
		'sbjsearch_txt':sbjsearch_txt},function(data){$('#systemcontent').html(data)});
}
</script>
   	<div id="statusbar">จัดการข้อมูลรายวิชา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="managecourse"><img src="../images/icons/64/course.png" width="64" height="64" /></a><a href="#" id="addsubject"><img src="../images/icons/64/add.png" width="64" height="64" /></a>  <a href="#" id="importsubject"><img src="../images/icons/64/import.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center><br />
	<form id="sbjsearchform" action="managesubject.php" method="post">
        	<b>ค้นหา</b> <input name="sbjsearch_txt" type="text" id="sbjsearch_txt" size="50" value="<?php echo $sbjsearch_txt;?>"/>
            <input name="sbjsearch_bt" type="submit" id="sbjsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <th height="50" colspan="9" bgcolor="#CCCCCC">ข้อมูลรายวิชา ( ทั้งหมด <?php echo $subjectnum;?> รายวิชา )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="12%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ทฤฎี</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ปฏิบัติ</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หน่วยกิต</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($subject_fetch=mysql_fetch_array($subject_query))
  {
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><a href="#" onclick="sbjinfo('<?php echo $subject_fetch["subject_ID"];?>');"><?php echo $subject_fetch["subject_ID"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="sbjinfo('<?php echo $subject_fetch["subject_ID"];?>');"><?php echo $subject_fetch["subject_name"];?></a></td>
    <td align="center" valign="middle"><?php echo $subject_fetch["subject_hourt"];?></td>
    <td align="center" valign="middle"><?php echo $subject_fetch["subject_hourp"];?></td>
    <td align="center" valign="middle"><?php echo $subject_fetch["subject_unit"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="editsubject('<?php echo $subject_fetch["subject_ID"];?>','<?php echo $subject_fetch["course_ID"];?>');"><img src="../images/icons/32/edit.png" width="32" height="32" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deletesubject('<?php echo $subject_fetch["subject_ID"];?>','<?php echo $subject_fetch["course_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($subjectnum/25);
if($totalpage>1)
{
	echo "หน้า ";
	for($i=1;$i<=$totalpage;$i++)
	{
		
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\",\"".$sbjsearch_txt."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\",\"".$sbjsearch_txt."\")'>$i</a>";
	}
} 
?>
</center></div>