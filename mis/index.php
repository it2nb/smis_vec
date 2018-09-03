<?php
ob_start();
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("includefiles/connectdb.php");
$_SESSION["userID"]=0;
$showpage=0;
	if($_POST["login_bt"]=="เข้าสู่ระบบ")
	{
		require_once("includefiles/formvalidator.php");
		$validator = new FormValidator();
		$validator->addValidation("username_txt","req","กรุณากรอกชื่อผู้ใช้");
		$validator->addValidation("password_txt","req","กรุณากรอกรหัสผ่าน");
		if($validator->ValidateForm())
    	{
			$membername=addslashes(strip_tags(trim($_POST["username_txt"])));
			$memberpassword=addslashes(strip_tags(trim($_POST["password_txt"])));
			$query = "Select * From member Where member_name='$membername' and member_password=md5('$memberpassword')";
			$login_query=mysql_query($query,$conn) or die(mysql_error());
			$login_fetch=mysql_fetch_assoc($login_query);
			$personnel_ID = $login_fetch['personnel_ID'];
			if(mysql_num_rows($login_query))
			{
				$query='Select * From personnel Where personnel_ID="'.$personnel_ID.'"';
				$personnel_query=mysql_query($query,$conn)or die(mysql_error());
				$personnel_fetch=mysql_fetch_array($personnel_query);
				if($personnel_fetch['personnel_status']=='work'||empty($personnel_fetch['personnel_status'])){
					//$login_fetch=mysql_fetch_array($login_query);
					//session_register("userID","user_name","user_status","teacher_ID");
					$_SESSION["userID"]=$login_fetch["member_ID"];
					$_SESSION["user_name"]=$login_fetch["member_name"];
					$_SESSION["user_status"]=$login_fetch["member_status"];
					$_SESSION["user_personnelID"]=$login_fetch["personnel_ID"];
					session_write_close();
					$member_ID = $_SESSION["userID"];
					$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system) Values ('$member_ID','login','main_mis')";
					$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
					echo "<meta http-equiv='refresh' content='0;url=system'>";
				}
				else{
					$showpage=1;
					$error_pass="ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง";
				}
			}
			else
			{
				$showpage=1;
				$error_pass="ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง";
			}
    	}
   		else
    	{
        	$error_txt = $validator->GetErrors(); 
			$showpage=1;      
   		}
	}
	else
	{
		$showpage=1;
	}

if($showpage==1)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบเทคโนโลยีสารสนเทศ การประกันคุณภาพภายในสถานศึกษา	(รายบุคคล)</title>
<link href="includefiles/stylesh.css" rel="stylesheet" type="text/css" />
</head>

<body class="ssris">
<div id="contener"><div id="headerssr">
<?php include("header.php");?>
</div>
<div id="content">
    &nbsp;<br />
    </div>
    <div id="leftside"><br />
    <br />
    <br />
    <br />
    <br /><br />
    <div class="BlackBold12"> <center>ลงชื่อเข้าสู่ระบบ</center></div><br />
    <div id="loginform">
   
    <form action="index.php" method="post">
      &lt;&lt; ชื่อผู้ใช้ &gt;&gt;<br />
      <label>
      <input name="username_txt" type="text" id="username_txt" size="30" maxlength="50" />
      </label>
      <br />
      <div class="RedRegula10"><?php if(!empty($error_txt["username_txt"])) echo $error_txt["username_txt"]."<br>";?></div><br/>
    &lt;&lt; รหัสผ่าน &gt;&gt;<br />
    <label>
    <input name="password_txt" type="password" id="password_txt" size="30" maxlength="50" />
    </label>
    <br />
    <div class="RedRegula10"><?php if(!empty($error_txt["password_txt"])) echo $error_txt["password_txt"]."<br>";?></div>
    <br />
    <label>
    <input type="submit" name="login_bt" id="login_bt" value="เข้าสู่ระบบ" />
    </label>
    </form>
    </div><br /><div class="RedRegula10"><center><?php if(!empty($error_pass)) echo $error_pass."<br>";?></center></div>
    <br />
    <label></label>
    </div> <div id="footerssr">
	<?php include("footer.php");?>
</div></div>
</body>
</html>
<?php } ?>