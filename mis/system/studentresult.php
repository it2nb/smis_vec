<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$query = "Select DISTINCT period_year From period Where period_start=(Select max(period_start) From period)";
$period_query = mysql_query($query,$conn)or die(mysql_error());
$period_fetch = mysql_fetch_assoc($period_query);
$last_year = $period_fetch["period_year"];
if($_POST["yearsearch_bt"]=="ค้นหา"){
	$check_year = $_POST["year_comb"];
}

if(empty($check_year)){
	$check_year = $last_year;
}
$styear=$check_year-3;
$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and class.year>'$styear' and area.area_level='ปวช' Order By class_ID DESC";
$classvo_query=mysql_query($query,$conn) or die(mysql_error());	
$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and class.year>'$styear' and area.area_level='ปวส' Order By class_ID DESC";
$classde_query=mysql_query($query,$conn) or die(mysql_error());	
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({cache:false});
	$('#teachdatab').click(function(){
		$('#systemcontent').load('teachdatab.php');
	});
	$('#teachresultmissdayb').click(function(){
		$('#systemcontent').load('teachresultmissdayb.php');
	});
	$('#teachresultmisstermb').click(function(){
		$('#systemcontent').load('teachresultmisstermb.php');
	});
	$('#flagresultclass').click(function(){
		$('#systemcontent').load('flagresultclass.php');
	});
	$('#flagresultstdoutd').click(function(){
		$('#systemcontent').load('flagresultstdoutd.php');
	});
	$('#flagresultsumstdoutd').click(function(){
		$('#systemcontent').load('flagresultsumstdout.php');
	});
	//search
	$('#yearsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});
</script>
   	<div id="statusbar">ข้อมูลนักเรียนนักศึกษา</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="192"><a href="#" id="teachdatab"><img src="../images/icons/64/stdlearnsubday.png" width="64" height="64" /></a><a href="#" id="teachresultmissdayb"><img src="../images/icons/64/stdlearnmissday.png" width="64" height="64" /></a><a href="#" id="teachresultmisstermb"><img src="../images/icons/64/stdlearnmissterm.png" width="64" height="64" /></a></td>
        <td align="left" valign="middle" width="192"><a href="#" id="flagresultclass"><img src="../images/icons/64/flagresultclass.png" width="64" height="64" /></a><a href="#" id="flagresultstdoutd"><img src="../images/icons/64/flagstdout.png" width="64" height="64" /></a><a href="#" id="flagresultsumstdoutd"><img src="../images/icons/64/sumflagstdout.png" width="64" height="64" /></a></td>
        <td align="left" valign="middle" width="64"><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64" /></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle">การเรียน</td>
    	<td align="center" valign="middle">กิจกรรมหน้าเสาธง</td>
    	<td align="center" valign="middle">ความคุม</td>
        <td></td>
    </tr>
	</table>
    </div>
    <div id="admincontent">
  <center>
  <form id="yearsearchform" action="studentresult.php" method="post">
       	  <b> ปีการศึกษา </b>
       	  &nbsp;
          <select name="year_comb" id="year_comb">
        	  <?php
			  $query="Select DISTINCT period_year From period Order By period_year DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_assoc($period_query)){
				if($check_year==$period_fetch["period_year"])
				  	echo "<option value='".$period_fetch["period_year"]."' selected='selected'>".($period_fetch["period_year"]+543)."</option>";
				else
					echo "<option value='".$period_fetch["period_year"]."'>".($period_fetch["period_year"]+543)."</option>";
			  }
			  ?>
        	</select>
            
       	  <input name="yearsearch_bt" type="submit" id="yearsearch_bt" value="ค้นหา" />
        </form>
        <table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <th height="50" colspan="7" bgcolor="#CCCCCC">ข้อมูลกลุ่มเรียน ( ทั้งหมด <?php echo $classnum;?> กลุ่มเรียน )</th>
              <tr>
                <td width="5%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">&nbsp;</td>
                <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสกลุ่มเรียน</td>
                <td rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">คำอธิบาย</td>
                <td width="20%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ครูที่ปรึกษา</td>
                <td height="30" colspan="3" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">จำนวนผู้เรียน</td>
              </tr>
          <tr>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชาย</td>
    <td width="10%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">หญิง</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รวม</td>
    </tr>
  <?php
  $allvo=0;
  $allvoman=0;
  while($class_fetch=mysql_fetch_assoc($classvo_query))
  {
	  $class_show=$check_year-$class_fetch["year"];
	  if(substr($class_fetch["class_ID"],2,1)==2&&$class_show<=2){
	  	$query = "Select count(student_ID) As stdpclass From student Where class_ID='".$class_fetch["class_ID"]."' and student_endstatus='0'";
	  	$stdpclass_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclass_fetch = mysql_fetch_assoc($stdpclass_query);
		$query = "Select count(student_ID) As stdpclassman From student Where class_ID='".$class_fetch["class_ID"]."' and student_gender='ชาย' and student_endstatus='0'";
	  	$stdpclassman_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclassman_fetch = mysql_fetch_assoc($stdpclassman_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_assoc($personnel_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_assoc($personnel_query);
		$allvo+=$stdpclass_fetch["stdpclass"];
		$allvoman+=$stdpclassman_fetch["stdpclassman"];
  ?>
  <tr>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $class_fetch["class_ID"];?></td>
    <td align="left" valign="middle"><?php echo $class_fetch["area_level"]." ".($class_show+1)." สาขา".$class_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"]-$stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"];?></td>  
    </tr>
  <?php } }?><tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ปวช.</b></td>
     <td align="center" valign="middle"><b><?php echo $allvoman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $allvo-$allvoman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $allvo;?></b></td>
     </tr>
  
   <?php
   $allde=0;
   $alldeman=0;
  while($class_fetch=mysql_fetch_assoc($classde_query))
  {
	  $class_show=$check_year-$class_fetch["year"];
	  if(substr($class_fetch["class_ID"],2,1)==3&&$class_show<=1){
	  	$query = "Select count(student_ID) As stdpclass From student Where class_ID='".$class_fetch["class_ID"]."' and student_endstatus='0'";
	  	$stdpclass_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclass_fetch = mysql_fetch_assoc($stdpclass_query);
		$query = "Select count(student_ID) As stdpclassman From student Where class_ID='".$class_fetch["class_ID"]."' and student_gender='ชาย' and student_endstatus='0'";
	  	$stdpclassman_query = mysql_query($query,$conn) or die(mysql_error());
	  	$stdpclassman_fetch = mysql_fetch_assoc($stdpclassman_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel_fetch = mysql_fetch_assoc($personnel_query);
	  	$query = "Select personnel_name,personnel_ser From personnel Where personnel_ID='".$class_fetch["personnel_ID2"]."'";
	  	$personnel_query = mysql_query($query,$conn)or die(mysql_error());
	  	$personnel2_fetch = mysql_fetch_assoc($personnel_query);
		$allde+=$stdpclass_fetch["stdpclass"];
		$alldeman+=$stdpclassman_fetch["stdpclassman"];
  ?>
   <tr>
    <td width="5%" height="25" align="center" valign="middle"><?php echo ++$n;?></td>
    <td align="center" valign="middle"><?php echo $class_fetch["class_ID"];?></td>
    <td align="left" valign="middle"><?php echo $class_fetch["area_level"]." ".($class_show+1)." สาขา".$class_fetch["major_name"];?></td>
    <td align="center" valign="middle"><?php echo $personnel_fetch["personnel_name"]." ".$personnel_fetch["personnel_ser"];?>, <?php echo $personnel2_fetch["personnel_name"]." ".$personnel2_fetch["personnel_ser"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"]-$stdpclassman_fetch["stdpclassman"];?></td>
    <td align="center" valign="middle"><?php echo $stdpclass_fetch["stdpclass"];?></td>
    </tr>
  <?php } }?>
  <tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ปวส.</b></td>
     <td align="center" valign="middle"><b><?php echo $alldeman;?></b></td>
     <td align="center" valign="middle"><b><?php echo $allde-$alldeman;?></b></td> 
     <td align="center" valign="middle"><b><?php echo $allde;?></b></td>  
     </tr>
   <tr bgcolor="#FFFF99">
     <td height="25" colspan="4" align="center" valign="middle"><b>รวม ทั้งหมด</b></td>
     <td align="center" valign="middle"><b><?php echo $allvoman+$alldeman;?></b></td>
     <td align="center" valign="middle"><b><?php echo ($allde+$allvo)-($allvoman+$alldeman);?></b></td> 
     <td align="center" valign="middle"><b><?php echo $allde+$allvo;?></b></td>    
     </tr>
</table><br />
</center></div>