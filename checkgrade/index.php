<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../includefiles/jquery.js"></script>
<script type="text/javascript" src="../includefiles/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#checkgrade').ajaxForm({ 
        target: '#showgrade',
		beforeSubmit: function(){
			$('#showgrade').html("<center>กำลังประมวลผลข้อมูล<br><img src='images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
<title>ตรวจสอบผลการเรียน</title>
<style type="text/css">
<!--
body {
	margin-left: 0pt;
	margin-top: 0pt;
	margin-right: 0pt;
	margin-bottom: 0pt;
	font-size: 10pt;
	background-image: url(../images/bg.jpg);
	background-repeat: repeat-x;
	background-attachment: fixed;
}
.style2 {
	font-size: 24pt;
	color: #FF0000;
}
.style3 {
	color: #FFFFFF;
	font-size: 12pt;
	font-weight: bold;
}
.style4 {color: #FFF}
-->
</style>
</head>

<body>
<div align="center">
<img src="images/header.jpg" width="1000" height="150" />
<form id="checkgrade" action="showgrade.php" method="post">
	<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#336699">
      <!--DWLayoutTable-->
      <tr>
        <td height="16" colspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        </tr>
      <tr>
        <td height="16" colspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr>
        <td width="300" height="22" align="right" valign="middle">รหัสนักศึกษา</td>
        <td width="10">&nbsp;</td>
        <td colspan="2" valign="top"><input name="code" type="text" size="20" maxlength="10">
          <span class="style4">          *รหัสนักศึกษา 10 หลัก เริ่มต้นด้วยเลขปีที่เข้าเรียน</span></td>
      </tr>
      <tr>
        <td height="46">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="190" valign="middle"><input type="submit" name="Submit" value="ตรวจสอบ">
          <input type="reset" name="Reset" value="ล้าง"></td>
      <td width="260" align="right" valign="bottom"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
    </table>
	</form>
</div>
<div align="center" id="showgrade"></div>
</body>
</html>