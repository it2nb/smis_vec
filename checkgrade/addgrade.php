<?php
include("connect.php");
header("Content-type: text/html;charset=utf-8");
if(empty($_POST["Submit"]))
	$_POST["Submit"]='';
$Submit=$_POST["Submit"];
if($Submit == "บันทึก")
{
	$grade = $_FILES["grade"]["tmp_name"];
	$tgrade = $_FILES["tgrade"]["tmp_name"];
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
		if($st_year == $st_year2)
		{
				$fopen1 = fopen( $grade,"r" );
				while ( !feof ($fopen1))
				{
					$graderecord = fgets($fopen1,200);
					if(strlen($graderecord)>50){
						$stdgrade = explode(",",$graderecord);
						$std_ID = explode('"',$stdgrade[0]);
						$term = explode('"',$stdgrade[1]);
						$subject_ID = explode('"',$stdgrade[2]);
						$level = explode('"',$stdgrade[3]);
						$tsubject = explode('"',$stdgrade[4]);
						$credit = explode('"',$stdgrade[5]);
						$query = 'Select count(code) as chstd from grade where code="'.$std_ID[1].'" and semes="'.$term[1].'" and tcode="'.$subject_ID[1].'"';
						$chstd = mysql_query($query,$conn)or die(mysql_error());
						$chstd_fetch = mysql_fetch_assoc($chstd);
						if($chstd_fetch['chstd']>0){
							$query = 'Select count(code) as chstd from grade where code="'.$std_ID[1].'" and semes="'.$term[1].'" and tcode="'.$subject_ID[1].'" and level="'.$level[1].'" and credit="'.$credit[0].'"';
							$chstd = mysql_query($query,$conn)or die(mysql_error());
							$chstd_fetch = mysql_fetch_assoc($chstd);
							if($chstd_fetch['chstd']<1){
								$query = 'Update grade Set level="'.$level[1].'",credit="'.$credit[0].'" Where code="'.$std_ID[1].'" and semes="'.$term[1].'" and tcode="'.$subject_ID[1].'"';
								$Update = mysql_query($query,$conn);
							}
						}
						else{
							$query = 'Insert into grade values ("'.$std_ID[1].'",
								"'.$term[1].'",
								"'.$subject_ID[1].'",
								"'.$level[1].'",
								"'.$tsubject[1].'",
								"'.$credit[0].'")';
							$Insert = mysql_query($query,$conn);
						}
					}
					$query='Delete From grade Where code=""';
					$Delete = mysql_query($query,$conn);
				}
				fclose($fopen1);
				
				$fopen2 = fopen( $tgrade,"r" );
				while ( !feof ($fopen2))
				{
					$graderecord = fgets($fopen2,300);
					if(strlen($graderecord)>100){
						$stdgrade = explode(",",$graderecord);
						$addcre = explode('"',$stdgrade[0]);
						$addpoint = explode('"',$stdgrade[1]);
						$tolcre =explode('"',$stdgrade[2]);
						$tolpoint = explode('"',$stdgrade[3]);
						$std_ID = explode('"',$stdgrade[4]);
						$std_name = explode('"',$stdgrade[5]);
						$cre1 = explode('"',$stdgrade[6]);
						$cre2 =explode('"',$stdgrade[7]);
						$cre3 =explode('"',$stdgrade[8]);
						$cre4 =explode('"',$stdgrade[9]);
						$cre5 =explode('"',$stdgrade[10]);
						$cre6 =explode('"',$stdgrade[11]);
						$cre7 =explode('"',$stdgrade[12]);
						$cre8 =explode('"',$stdgrade[13]);
						$cre9 =explode('"',$stdgrade[14]);
						$tolcre1 =explode('"',$stdgrade[15]);
						$tolcre2 =explode('"',$stdgrade[16]);
						$tolcre3 =explode('"',$stdgrade[17]);
						$tolcre4 =explode('"',$stdgrade[18]);
						$tolcre5 =explode('"',$stdgrade[19]);
						$tolcre6 =explode('"',$stdgrade[20]);
						$tolcre7 =explode('"',$stdgrade[21]);
						$tolcre8 =explode('"',$stdgrade[22]);
						$tolcre9 = explode('"',$stdgrade[23]);
						$point1 =explode('"',$stdgrade[24]);
						$point2 =explode('"',$stdgrade[25]);
						$point3 =explode('"',$stdgrade[26]);
						$point4 =explode('"',$stdgrade[27]);
						$point5 =explode('"',$stdgrade[28]);
						$point6 =explode('"',$stdgrade[29]);
						$point7 =explode('"',$stdgrade[30]);
						$point8 =explode('"',$stdgrade[31]);
						$point9 =explode('"',$stdgrade[32]);
						$tolpoint1 =explode('"',$stdgrade[33]);
						$tolpoint2 =explode('"',$stdgrade[34]);
						$tolpoint3 =explode('"',$stdgrade[35]);
						$tolpoint4 =explode('"',$stdgrade[36]);
						$tolpoint5 =explode('"',$stdgrade[37]);
						$tolpoint6 =explode('"',$stdgrade[38]);
						$tolpoint7 =explode('"',$stdgrade[39]);
						$tolpoint8 =explode('"',$stdgrade[40]);
						$tolpoint9 =explode('"',$stdgrade[41]);
						$query='Select count(code) as chstd from avgrade where code="'.$std_ID[1].'"';
						$chstd = mysql_query($query,$conn);
						$chstd_fetch = mysql_fetch_assoc($chstd);
						if($chstd_fetch['chstd']>0){
							$query = 'Update avgrade Set addcre='.$addcre[1].',
								addpoint='.$addpoint[1].',
								tolcre='.$tolcre[1].',
								tolpoint='.$tolpoint[1].',
								cre1='.$cre1[1].',
								cre2='.$cre2[1].',
								cre3='.$cre3[1].',
								cre4='.$cre4[1].',
								cre5='.$cre5[1].',
								cre6='.$cre6[1].',
								cre7='.$cre7[1].',
								cre8='.$cre8[1].',
								cre9='.$cre9[1].',
								tolcre1='.$tolcre1[1].',
								tolcre2='.$tolcre2[1].',
								tolcre3='.$tolcre3[1].',
								tolcre4='.$tolcre4[1].',
								tolcre5='.$tolcre5[1].',
								tolcre6='.$tolcre6[1].',
								tolcre7='.$tolcre7[1].',
								tolcre8='.$tolcre8[1].',
								tolcre9='.$tolcre9[1].',
								point1='.$point1[1].',
								point2='.$point2[1].',
								point3='.$point3[1].',
								point4='.$point4[1].',
								point5='.$point5[1].',
								point6='.$point6[1].',
								point7='.$point7[1].',
								point8='.$point8[1].',
								point9='.$point9[1].',
								tolpoint1='.$tolpoint1[1].',
								tolpoint2='.$tolpoint2[1].',
								tolpoint3='.$tolpoint3[1].',
								tolpoint4='.$tolpoint4[1].',
								tolpoint5='.$tolpoint5[1].',
								tolpoint6='.$tolpoint6[1].',
								tolpoint7='.$tolpoint7[1].',
								tolpoint8='.$tolpoint8[1].',
								tolpoint9='.$tolpoint9[1].' Where code="'.$std_ID[1].'"';
							$Update = mysql_query($query,$conn);
						}
						else{
							$query = 'Insert into avgrade values ("'.$addcre[1].'",
								"'.$addpoint[1].'",
								"'.$tolcre[1].'",
								"'.$tolpoint[1].'",
								"'.$std_ID[1].'",
								"'.$std_name[1].'",
								"'.$cre1[1].'",
								"'.$cre2[1].'",
								"'.$cre3[1].'",
								"'.$cre4[1].'",
								"'.$cre5[1].'",
								"'.$cre6[1].'",
								"'.$cre7[1].'",
								"'.$cre8[1].'",
								"'.$cre9[1].'",
								"'.$tolcre1[1].'",
								"'.$tolcre2[1].'",
								"'.$tolcre3[1].'",
								"'.$tolcre4[1].'",
								"'.$tolcre5[1].'",
								"'.$tolcre6[1].'",
								"'.$tolcre7[1].'",
								"'.$tolcre8[1].'",
								"'.$tolcre9[1].'",
								"'.$point1[1].'",
								"'.$point2[1].'",
								"'.$point3[1].'",
								"'.$point4[1].'",
								"'.$point5[1].'",
								"'.$point6[1].'",
								"'.$point7[1].'",
								"'.$point8[1].'",
								"'.$point9[1].'",
								"'.$tolpoint1[1].'",
								"'.$tolpoint2[1].'",
								"'.$tolpoint3[1].'",
								"'.$tolpoint4[1].'",
								"'.$tolpoint5[1].'",
								"'.$tolpoint6[1].'",
								"'.$tolpoint7[1].'",
								"'.$tolpoint8[1].'",
								"'.$tolpoint9[1].'")';
							$Insert = mysql_query($query,$conn);
						}
					}
				}
				$query='Delete From avgrade Where code=""';
				$Delete = mysql_query($query,$conn);
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
<title>บันทึกเกรด</title>
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
    <td width="760" height="42" align="center" valign="middle" bgcolor="#990000"><span class="style2">บันทึกเกรดนักศึกษา</span></td>
  </tr>
  <tr>
    <td height="98" valign="top">
	<form action="addgrade.php" method="post" enctype="multipart/form-data" >
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