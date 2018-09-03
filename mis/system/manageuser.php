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
if($_POST["usersearch_bt"]=="ค้นหา")
{
	$usersearch_txt = $_POST["usersearch_txt"];
	$wkstatus_comb = $_POST["wkstatus_comb"];
}
else
{
	$usersearch_txt = $_GET["usersearch_txt"];
	$wkstatus_comb = $_GET["wkstatus_comb"];
}
	if(empty($usersearch_txt)&&$wkstatus_comb=="")
	{
		$query="Select count(member_ID) as totalmember From member";
		$usernum_query=mysql_query($query,$conn) or die(mysql_error());
		
		$query = "Select * From member, personnel Where member.personnel_ID=personnel.personnel_ID Order by member_ID Limit $n,25";
	}
	else if($wkstatus_comb=="")
	{
		$query="Select count(member_ID) as totalmember From member,personnel Where (member.member_name like '%$usersearch_txt%' or personnel.personnel_name like '%$usersearch_txt%' or personnel.personnel_ser like '%$usersearch_txt%') and member.personnel_ID=personnel.personnel_ID";
		$usernum_query=mysql_query($query,$conn) or die(mysql_error());
		
		$query = "Select * From member,personnel Where(member.member_name like '%$usersearch_txt%' or personnel.personnel_name like '%$usersearch_txt%' or personnel.personnel_ser like '%$usersearch_txt%') and member.personnel_ID=personnel.personnel_ID Order by member.member_ID Limit $n,25";
	}
	else
	{
		$query="Select count(member_ID) as totalmember From member,personnel Where personnel_status='$wkstatus_comb' and (member.member_name like '%$usersearch_txt%' or personnel.personnel_name like '%$usersearch_txt%' or personnel.personnel_ser like '%$usersearch_txt%') and member.personnel_ID=personnel.personnel_ID";
		$usernum_query=mysql_query($query,$conn) or die(mysql_error());
		
		$query = "Select * From member,personnel Where personnel_status='$wkstatus_comb' and (member.member_name like '%$usersearch_txt%' or personnel.personnel_name like '%$usersearch_txt%' or personnel.personnel_ser like '%$usersearch_txt%') and member.personnel_ID=personnel.personnel_ID Order by member.member_ID Limit $n,25";
	}
$usernum_fetch=mysql_fetch_array($usernum_query);
$usernum = $usernum_fetch["totalmember"];
$member_query=mysql_query($query,$conn) or die(mysql_error());

?>


<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	//headmenu
	$('#manageusertype').click(function(){
		$('#systemcontent').load("manageusertype.php");
	});
	$('#adduser').click(function(){
		$('#systemcontent').load("adduser.php");
	});
	$('#usersearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

function uinfo(id){
	$.get('memberinfo.php',{'member_ID' : id},function(data) {
		$('#info').html(data);
		blanket_size();
		toggle('blanket');
		window_pos('info',0.5);
		toggle('info');
	});
}

function edituser(id){
	//var url = "edituser.php?member_ID="+id;
	//$('#systemcontent').load(url);
	$.get('edituser.php',{'member_ID': id},function(data){$('#systemcontent').html(data);});
}

function deleteuser(id){
	//var url = "deleteuser.php?member_ID="+id;
	//$('#systemcontent').load(url);
	$.get('deleteuser.php',{'member_ID':id},function(data){$('#systemcontent').html(data);});
}
function changepage(npage, usersearch_txt, wkstatus_comb){
	//var url = "manageuser.php?n="+npage+"&usersearch_txt="+usersearch_txt;
	//$('#systemcontent').load(url);
	$.get('manageuser.php',{
		'n':npage,
		'usersearch_txt':usersearch_txt,
		'wkstatus_comb':wkstatus_comb},function(data){$('#systemcontent').html(data);});
}
</script>
   	<div id="statusbar">จัดการข้อมูลผู้ใช้&nbsp;</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="#" id="manageusertype"><img src="../images/icons/64/usergroup.png" width="64" height="64" /></a> <a href="#" id="adduser"><img src="../images/icons/64/add.png" width="64" height="64" /></a> <a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a></div>
    <div id="admincontent">
  <center>
  <br />
  <form id="usersearchform" action="manageuser.php" method="post">
 <b>ค้นหา</b> <input name="usersearch_txt" type="text" id="usersearch_txt" size="50" value="<?php echo $usersearch_txt;?>"/> 
 <select name="wkstatus_comb" id="wkstatus_comb">
 	<option value="">ทั้งหมด</option>
 	<option value="work" <?php if($wkstatus_comb=="work")echo "selected='selected'";?>>ทำงาน</option>
    <option value="help" <?php if($wkstatus_comb=="help")echo "selected='selected'";?>>ช่วยราชการ</option>
    <option value="move" <?php if($wkstatus_comb=="help")echo "selected='selected'";?>>ย้าย</option>
    <option value="quit" <?php if($wkstatus_comb=="help")echo "selected='selected'";?>>ออก</option>
 </select>
 <input name="usersearch_bt" type="submit" id="usersearch_bt" value="ค้นหา" /></form>
  <br /><br />
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" id="ainfo">
          <th height="50" colspan="8" bgcolor="#CCCCCC">ข้อมูลผู้ใช้ ( ทั้งหมด <?php echo $usernum;?> ชื่อผู้ใช้ )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อผู้ใช้</td>
    <td width="25%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ - สกุล</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">เบอร์โทร</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สถานะ</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($member_fetch=mysql_fetch_array($member_query))
  {
  ?>
  <tr >
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle" ><a href="#" onclick="uinfo('<?php echo $member_fetch["member_ID"];?>');" ><?php echo $member_fetch["member_name"];?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="uinfo('<?php echo $member_fetch["member_ID"];?>');" ><?php echo $member_fetch["personnel_name"];?> &nbsp;<?php echo $member_fetch["personnel_ser"];?></a></td>
    <td align="center" valign="middle"><?php echo $member_fetch["personnel_phone"];?></td>
    <td align="center" valign="middle"><?php echo $member_fetch["member_status"];?></td>
    <td align="center" valign="middle"><a href="#" onclick="edituser('<?php echo $member_fetch["member_ID"];?>');" ><img src="../images/icons/32/edit.png" alt="แก้ไข" width="32" height="32" /></a></td>
    <td align="center" valign="middle"><a href="#" onclick="deleteuser('<?php echo $member_fetch["member_ID"];?>');"><img src="../images/icons/32/delete.png" width="32" height="32" alt="ลบ" /></a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($usernum/25);
if($totalpage>1)
{
	echo "หน้า ";
	for($i=1;$i<=$totalpage;$i++)
	{
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='#' onclick='changepage(\"".$npage."\",\"".$usersearch_txt."\",\"".$wkstatus_comb."\")'>$i</a>)";
		else
			echo "<a href='#' onclick='changepage(\"".$npage."\",\"".$usersearch_txt."\",\"".$wkstatus_comb."\")'>$i</a>";
	}
} 
?>
</center></div>