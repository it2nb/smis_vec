<?php
ob_start();
session_start();
$showpage=0;
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
if(!empty($_SESSION["userID"]))
{
	if($_SESSION["user_status"]!="admin")
			echo "<meta http-equiv='refresh' content='0;url=../'>";
	else
	{
			$showpage=1;
			require_once("../includefiles/connectdb.php");
			if(empty($_GET["n"]))
				$n=0;
			else
				$n = $_GET["n"];
			$query="Select count(member_ID) as totalmember From member Where member_status='teach'";
			$usernum_query=mysql_query($query,$conn) or die(mysql_error());
			$usernum_fetch=mysql_fetch_assoc($usernum_query);
			$usernum = $usernum_fetch["totalmember"];
			
			$query="Select * From member Where member_status='teach' Order by member_ID Limit $n,25";
			$member_query=mysql_query($query,$conn) or die(mysql_error());
	}
}
else
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}

if($showpage==1)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบเทคโนโลยีสารสนเทศ การประกันคุณภาพภายในสถานศึกษา	(รายบุคคล)</title>
<link href="../includefiles/stylesh.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.ssris #blanket {
	position: absolute;
	width: 100%;
	left: 0px;
	top: 0px;
	background-color:#111;
	opacity: 0.65;
	filter:alpha(opacity=65);
	z-index: 9001;
}
.ssris #memberinfo {
	position: absolute;
	z-index: 9002;
	top:150px;
}
</style>
<?php include("../includefiles/ajaxfunc.php");?>
<script type="text/javascript" src="../includefiles/popupdiv.js">
</script>
<script type="text/javascript">
function show_memberinfo(member_ID)
{
	var xmlSearch=createXMLHttpRequest();
	var url="memberinfo.php?member_ID="+member_ID;
	xmlSearch.open("get",url,true);
	xmlSearch.onreadystatechange=function()
	{
		showTag(xmlSearch,"memberinfo");
		blanket_size();
		toggle('blanket');
		window_pos('memberinfo',0.5);
		toggle('memberinfo');
		
	};
	xmlSearch.send(null);	
}
</script>
</head>

<body class="ssris">
<div id="contener">
<div id="headerssr">
<?php include("../header.php");?>
</div>
<div id="systemcontent">
   	<div id="statusbar">จัดการข้อมูลผู้ใช้&nbsp;</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">&nbsp;<a href="adduser.php">เพิ่มข้อมูลผู้ใช้</a> | <a href="adminlist.php">รายชื่อผู้ดูแลระบบ</a> | <a href="teacherlist.php">รายชื่อครู</a> | <a href="index.php">กลับหน้าผู้ดูแลระบบ</a></div>
    <div id="admincontent">
  <center>
        <table width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="7" bgcolor="#CCCCCC">ข้อมูลครู ( ทั้งหมด <?php echo $usernum;?> ชื่อผู้ใช้ )</th>
  <tr>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="5%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อผู้ใช้</td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อ-สกุล</td>
    <td width="20%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แผนกวิชา</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แก้ไข</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ลบ</td>
  </tr>
  <?php
  while($member_fetch=mysql_fetch_assoc($member_query))
  {
	  $teacher_ID = $member_fetch["teacher_ID"];
	  $query="Select * From teacher Where teacher_ID='$teacher_ID'";
	  $teacher_query = mysql_query($query,$conn)or die(mysql_error());
	  $teacher_fetch = mysql_fetch_assoc($teacher_query);
  ?>
  <tr>
    <td width="5%" height="25" valign="middle">&nbsp;</td>
    <td width="5%" align="center" valign="middle"><?php echo ++$n;?></td>
    <td valign="middle"><a href="#" onclick="Javascript:show_memberinfo('<?php echo $member_fetch["member_ID"];?>');"><?php echo $member_fetch["member_name"];?></a></td>
    <td valign="middle"><a href="#" onclick="Javascript:show_memberinfo('<?php echo $member_fetch["member_ID"];?>');"><?php echo $teacher_fetch["teacher_name"]." ".$teacher_fetch["teacher_ser"];?></a></td>
    <td align="center" valign="middle"><?php echo $teacher_fetch["teacher_depart"];?></td>
    <td align="center" valign="middle"><a href="edituser.php?member_ID=<?php echo $member_fetch["member_ID"];?>">แก้ไข</a></td>
    <td align="center" valign="middle"><a href="deleteuser.php?member_ID=<?php echo $member_fetch["member_ID"];?>">ลบ</a></td>
  </tr>
  <?php } ?>
</table><br />
<?php
$totalpage=ceil($usernum/25);
if($totalpage>1)
{
	for($i=1;$i<=$totalpage;$i++)
	{
		echo "หน้า ";
		if($i>1)
			echo " | ";
		$npage=25*($i-1);
		if(ceil($n/25)==$i)
			echo "(<a href='manageuser.php?n=$npage'>$i</a>)";
		else
			echo "<a href='manageuser.php?n=$npage'>$i</a>";
	}
} 
?>
</center></div>
<br />
    </div>
    <div id="systemleftside"><center>เมนูหลัก</center>
	<?php include("adminmenu.php"); ?>
    </div> 
    <div id="footerssr">
		<?php include("../footer.php");?>
    </div></div>
    <div id="blanket" style="display:none" onclick="Javascript:toggle('blanket');toggle('memberinfo')"></div>
    <div id="memberinfo" style="display:none" ></div>
</body>
</html>
<?php } ?>