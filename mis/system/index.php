<?php
ob_start();
session_start();
include '../includefiles/sms.php';
$sms = new siccsms();
$showpage=0;
if(!empty($_SESSION["userID"]))
{
	$showpage=1;
	include("../includefiles/connectdb.php");
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
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบเทคโนโลยีสารสนเทศ การประกันคุณภาพภายในสถานศึกษา	(รายบุคคล)</title>
<link href="../includefiles/stylesh.css" rel="stylesheet" type="text/css" />
<?php include("../includefiles/ajaxfunc.php");?>
<script type="text/javascript" src="../includefiles/jquery.js"></script>
<script type="text/javascript" src="../includefiles/popupdiv.js"></script>
<script type="text/javascript" src="../includefiles/jquery.form.js"></script>
</head>

<body class="ssris">
<div id="contener">
	<div id="headerssr">
	  <?php include("../header.php");?>
      <?php if(substr($_SESSION["user_status"],1,1)||substr($_SESSION["user_status"],0,1)){?>
     <div align="center"><?php //echo $sms->getCredit(); ?></div>
     <?php } ?>
	</div>
	<div id="systemcontent">
		<?php include("timeline.php"); ?>
    </div>
    
    <div id="systemleftside"><div class="headmenusty"><center>เมนูหลัก</center></div>
	<div id="leftmenu"><?php include("systemmenu.php"); ?></div>
    </div> 
    <div id="footerssr">
		<?php include("../footer.php");?>
    </div>
        <div id="blanket" style="display:none" onclick="Javascript:toggle('blanket');toggle('info')"></div>
    <div id="info" style="display:none" ></div>
</div>
</body>
</html>
<?php } ?>