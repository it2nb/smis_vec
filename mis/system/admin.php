<?php
ob_start();
session_start();
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
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
</head>

<body class="ssris">
<div id="contener">
	<div id="headerssr">
	  <?php include("../header.php");?>
	</div>
	<div id="systemcontent">
    	<?php $contentpage=$_GET["content"].".php";
			if(!empty($_GET["content"]))
			include($contentpage);
			?>
    </div>
    <div id="systemleftside"><div class="headmenusty"><center>เมนูหลัก</center></div>
	<?php include("adminmenu.php"); ?>
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