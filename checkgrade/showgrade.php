<?php
include("connect.php");
include("../includefiles/datalist.php");
header("Content-type: text/html;charset=utf-8");
$sumunit = 0;
$sumgrade = 0;
$tsumunit = 0;
$tsumgrade = 0;
$totalunit = 0;
if(is_numeric($_POST["code"]))
	$code=$_POST["code"];
if($code!="")
{
	$st_year = substr($code,0,2);
	$query = "Select * from avgrade where code = '$code'";
	$student_query = mysql_query($query,$conn) or die(mysql_error());
	$student = mysql_fetch_array($student_query);
	$query = "Select  semes from grade where code = '$code' Group By semes ASC";
	$sem_query = mysql_query($query,$conn) or die(mysql_error());
}
?>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#336699">
  <!--DWLayoutTable-->
  <tr>
    <td width="760" height="40" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#009933">
        <!--DWLayoutTable-->
        <tr>
          <td width="50" height="20" align="center" valign="middle"><strong>รหัส</strong></td>
          <td width="150" valign="middle"><?php echo $student['code'];?></td>
          <td width="60" align="center" valign="middle"><strong>ชื่อ - สกุล</strong></td>
          <td width="300" valign="middle"><?php echo $student['name'];?></td>
          <td width="100" align="right" valign="middle"><strong>หน่วยกิตสะสม</strong></td>
          <td width="100" align="center" valign="middle"><?php echo $student["tolcre"];?></td>
        </tr>
        <tr>
          <td height="20"></td>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" valign="middle"><strong>เกรดเฉลี่ย</strong></td>
          <td align="center" valign="middle" bgcolor="#FFCC00"><b><?php echo $student["tolpoint"];?></b></td>
        </tr>
                </table></td>
  </tr>
  <tr>
    <td height="16" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="152" valign="top">
	<?php
	if($student)
	{
		while($sem = mysql_fetch_array($sem_query))
		{
			if(empty($i)){
				$year = substr($sem['semes'],4,2) - substr($student['code'],0,2);
				$i=($year*2)+substr($sem['semes'],0,1);
			}
			$tsumunit=0;
			$ttotalunit=0;
			$tsumgrade=0;
			$query = "Select  * From grade where code = '$code' and semes = '".$sem['semes']."' Order By semes ASC";
			$grade_query = mysql_query($query,$conn);
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <!--DWLayoutTable-->
        <tr bgcolor="#FFCC66">
          <td height="20" colspan="3" align="center" valign="middle"><h3>ภาคเรียนที่ <?php echo $sem['semes'];?></h3></td>
        </tr>
        <tr>
          <td width="151" height="80">&nbsp;</td>
          <td width="450" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#33EEEE">
              <!--DWLayoutTable-->
              <tr>
                <td width="100" height="30" align="center" valign="middle" bgcolor="#999999"><strong><span class="style1">รหัสวิชา</span></strong></td>
                <td width="250" align="center" valign="middle" bgcolor="#999999"><strong><span class="style1">ชื่อวิชา</span></strong></td>
                <td width="50" align="center" valign="middle" bgcolor="#999999"><strong><span class="style1">หน่วยกิต</span></strong></td>
                <td width="50" align="center" valign="middle" bgcolor="#999999"><strong><span class="style1">เกรด</span></strong></td>
              </tr>
			  <?php
			  $j=1;
			  while($grade = mysql_fetch_array($grade_query))
			  {
				  $tsumunit+=$grade['credit'];
			  ?>
              <tr>
                <td height="25" align="center" valign="middle" <?php if($j%2)echo 'bgcolor="#22BBEE"';?>><?php echo $grade['tcode']; ?></td>
                <td valign="middle" <?php if($j%2)echo 'bgcolor="#22BBEE"';?>><?php echo $grade['tsubject']; ?></td>
                <td align="center" valign="middle" <?php if($j%2)echo 'bgcolor="#22BBEE"';?>><?php echo $grade['credit']; ?></td>
                <td align="center" valign="middle" <?php if($j%2)echo 'bgcolor="#22BBEE"';?>><?php echo $grade['level']; ?></td>
              </tr>
			  <?php $j++;}
			  if($i==1){
				  $ttotalunit=$student['cre1'];
				  $tavrgrade=$student['point1'];
			  }
			  else if($i==2){
				  $ttotalunit=$student['cre2'];
				  $tavrgrade=$student['point2'];
			  }
			  else if($i==3){
				  $ttotalunit=$student['cre3'];
				  $tavrgrade=$student['point3'];
			  }
			  else if($i==4){
				  $ttotalunit=$student['cre4'];
				  $tavrgrade=$student['point4'];
			  }
			  else if($i==5){
				  $ttotalunit=$student['cre5'];
				  $tavrgrade=$student['point5'];
			  }
			  else if($i==6){
				  $ttotalunit=$student['cre6'];
				  $tavrgrade=$student['point6'];
			  }
			  else if($i==7){
				  $ttotalunit=$student['cre7'];
				  $tavrgrade=$student['point7'];
			  }
			  else if($i==8){
				  $ttotalunit=$student['cre8'];
				  $tavrgrade=$student['point8'];
			  }
			  else if($i==9){
				  $ttotalunit=$student['cre9'];
				  $tavrgrade=$student['point9'];
			  }
			  $i++;
			  ?>
              <tr>
                <td height="25" colspan="2" align="right" valign="middle" bgcolor="#CCCCCC"><strong>หน่วยกิตที่เรียน <?php echo $tsumunit; ?> || หน่วยกิตที่ได้</strong></td>
                <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><strong><?php echo $ttotalunit; ?></strong></td>
              </tr>
              <tr>
                <td height="25" colspan="2" align="right" valign="middle" bgcolor="#999999"><strong>เกรดเฉลี่ย</strong></td>
                <td colspan="2" align="center" valign="middle" bgcolor="#999999"><strong><?php echo $tavrgrade; ?></strong></td>
              </tr>
          </table></td>
        <td width="159">&nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="3" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        </tr>
        </table>	<?php
		}
	}
	?>	</td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
</table>
