<?php
session_start();
include("../includefiles/connectdb.php");
include '../classes/teacherresult.class.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}	
$main_obj = new Teacherresult_class($conn);
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#instrucrecreport').click(function(){
        $('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		$('#systemcontent').load('instrucrecreport.php');
	});
    $('#progressreport').click(function() {
                $('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
                $('#systemcontent').load('progressreport.php');
            });
});
</script>
   	<div id="statusbar">ข้อมูลครู</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
    	<td align="left" valign="middle" width="64"><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a>
        </td>
      <td align="left" valign="middle" width="128"><a href="#" id="progressreport"><img src="../images/icons/64/score.png" width="64" height="64" /><a href="#" id="instrucrecreport"><img src="../images/icons/64/instrucrec.png" width="64" height="64" /></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    <td align="center" valign="middle"><strong>ความคุม</strong></td>
      <td align="center" valign="middle"><strong>การเรียนการสอน</strong></td>
    	<td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center>
        <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <th height="50" colspan="6" bgcolor="#CCCCCC">ข้อมูลแผนกวิชา</th>
              <tr>
                <td width="5%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
                <td rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">แผนกวิชา</td>
                <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หัวหน้าแผนก</td>
                <td height="30" colspan="3" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนครู</td>
              </tr>
          <tr>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชาย</td>
    <td width="15%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หญิง</td>
    <td width="15%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
    </tr>
    <?php $main_obj->queryDepartment(); while($main_obj->fetchDepartment()){?>
  <tr>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="left" valign="middle"><a href="#" onclick="departmentdetail('<?php echo $main_obj->department_ID;?>')"><?php echo $main_obj->department_name;?></a></td>
    <td align="center" valign="middle"><?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser; ?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountMenperDepart();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountWomenperDepart();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountMenperDepart()+$main_obj->getCountWomenperDepart();?></td>  
    </tr>
    <?php } ?>
  <tr bgcolor="#FFFF99">
     <td height="25" colspan="3" align="center" valign="middle"><b>รวม</b></td>
     <td align="center" valign="middle"><b><?php echo $main_obj->getCountMenTeacher();?></b></td>
     <td align="center" valign="middle"><b><?php echo $main_obj->getCountWomenTeacher();?></b></td>
     <td align="center" valign="middle"><b><?php echo $main_obj->getCountMenTeacher()+$main_obj->getCountWomenTeacher();?></b></td>
     </tr>
</table><br />
</center></div>