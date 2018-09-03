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
		if($_POST["confirm_bt"]=="ยืนยัน")
		{
			require_once("../includefiles/connectdb.php");
			$class_ID = $_POST["classID"];	
			
			$query="Delete From class Where class_ID='$class_ID'";
			$delete_member=mysql_query($query,$conn)or die(mysql_error());
				
			header("Content-type: text/html; charset=utf-8");
			echo "<script languege='java-script'>alert('ลบข้อมูลเรียบร้อย')</script>";
			echo "<meta http-equiv='refresh' content='0;url=manageclass.php'>";
		}
		else if($_POST["cancel_bt"]=="ยกเลิก")
		{
			echo "<meta http-equiv='refresh' content='0;url=manageclass.php'>";
		}
		else
		{
			require_once("../includefiles/connectdb.php");
			$class_ID=$_GET["class_ID"];
			
			$query="Select * From class Where class_ID='$class_ID'";
			$class_query=mysql_query($query,$conn) or die(mysql_error());
			$class_fetch=mysql_fetch_array($class_query);
			
			$class_ID = $class_fetch["class_ID"];
			$class_des =$class_fetch["class_des"];
			
			$showpage=1;
		}
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
</head>

<body class="ssris">
<div id="contener">
<div id="headerssr">
<?php include("../header.php");?>
	</div>
	<div id="systemcontent">
    	<div id="statusbar">ลบข้อมูลกลุ่มเรียน</div>
	  <div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">&nbsp;<a href="manageclass.php">ย้อนกลับ</a></div>
        <div id="admincontent">
        <center>
        <form action="deleteclass.php" method="post"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">ลบข้อมูลกลุ่มเรียน</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">รหัสกลุ่มเรียน : &nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC"><label><input name="classID" type="hidden" id="classID" value="<?php echo $class_ID;?>" /></label><?php echo $class_ID;?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">คำอธิบาย : &nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">
    <?php echo $class_des;?></td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><label>
      <input type="submit" name="confirm_bt" id="confirm_bt" value="ยืนยัน" />
    </label>
      <label>
      <input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
      </label></td>
    </tr>
</table>
</form>
        </center>
</div>
<br />
    </div>
    <div id="systemleftside"><center>เมนูหลัก</center>
	<?php include("adminmenu.php"); ?>
    </div> 
    <div id="footerssr">
		<?php include("../footer.php");?>
    </div>
</div>
</body>
</html>
<?php } ?>