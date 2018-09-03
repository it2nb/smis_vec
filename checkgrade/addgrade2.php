<?php
include("connect.php");
header("Content-type: text/html;charset=utf-8");
$Submit=$_POST["Submit"];
$grade = $_FILES["grade"]["tmp_name"];
$tgrade = $_FILES["tgrade"]["tmp_name"];
if($Submit == "บันทึก")
{
	$st_year = 1;
	$st_year2 = 2;
	
	if($grade != "" && $tgrade != "")
	{
		$fopen1 = fopen( $grade,"r" );
		$st_year = fgets($fopen1,50);
		$fopen2 = fopen( $tgrade,"r" );
		$st_year2 = fgets($fopen2,50);
		fclose($fopen1);
		fclose($fopen2);
		$st_year = explode(",",$st_year);
		$st_year = explode('"',$st_year[0]);
		$st_year = substr($st_year[1],0,2);
		$st_year2 = explode(",",$st_year2);
		$st_year2 = explode('"',$st_year2[4]);
		$st_year2 = substr($st_year2[1],0,2);
		echo $st_year;
		if($st_year == $st_year2)
		{
				$query = "Delete from grade where code like '$st_year%'";
				mysql_query($query,$conn);
				$fopen1 = fopen( $grade,"r" );
				while ( !feof ($fopen1))
				{
					$show = fgets($fopen1,200);
					$year = explode(",",$show);
					$year = explode('"',$year[0]);
					$std_ID = $year[1];
					echo $std_sem."<br>";
					$year = substr($year[1],0,2);
					if($year==$st_year){
						$query = "Insert into grade values ($show)";
						$Insert = mysql_query($query,$conn);
						echo " ";
					}
				}
				fclose($fopen1);
				
				$query = "Delete from avgrade where code like '$st_year%'";
				mysql_query($query,$conn);
				$fopen2 = fopen( $tgrade,"r" );
				while ( !feof ($fopen2))
				{
					$show = fgets($fopen2,300);
					$year = explode(",",$show);
					$year = explode('"',$year[4]);
					$year = substr($year[1],0,2);
					if($year==$st_year2){
						$query = "Insert into avgrade values ($show)";
						$Insert = mysql_query($query,$conn);
						echo " ";
					}
				}
				fclose($fopen2);
				$message = "บันทึกเกรดนักศึกษารหัส ".$st_year." เรียบร้อยแล้ว";
		}
		else
		{
			$message = "กรุณาใส่ไฟล์ให้ถูกต้อง";
			
		}
	}
	else
	{
		$message = "กรุณาใส่ไฟล์ให้ครบทั้ง 2 ไฟล์ ";
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>บันทึกเกรดtest</title>
<style type="text/css">
<!--
.style2 {
	font-size: 18pt;
	color: #FFFFFF;
}
body {
	margin-left: 0px;
	margin-top: 10px;
	font-size: 10pt;
}
.style3 {color: #FF0000}
-->
</style>
</head>

<body>

<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="760" height="42" align="center" valign="middle" bgcolor="#990000"><span class="style2">บันทึกเกรดนักศึกษาtest</span></td>
  </tr>
  <tr>
    <td height="98" valign="top">
	<form action="addgrade2.php" method="post" enctype="multipart/form-data" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="16" colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr>
        <td width="226" height="21">&nbsp;</td>
        <td width="534" valign="top"><input type="file" name="grade" id="grade"> 
          <span class="style3">*ไฟล์ gradeXX.txt </span></td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td valign="top"><input type="file" name="tgrade" id="tgrade"> 
          <span class="style3">*ไฟล์ tgradeXX.txt</span>          </td>
      </tr>
      <tr>
        <td height="16">&nbsp;</td>
        <td valign="top" class="style3">หมายเหตุ ทั้ง 2 ไฟล์ เป็นเลขปี พ.ศ เีดียวกัน </td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td valign="top"><input type="submit" name="Submit" value="บันทึก"></td>
      </tr>
      <tr>
        <td height="13"></td>
        <td></td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
  <tr>
    <td height="22" align="center" valign="top"><?php echo $message;?></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>
</table>
</body>
</html>