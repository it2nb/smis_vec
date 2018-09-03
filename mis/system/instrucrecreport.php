<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
include '../classes/instrucrecreport.class.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$main_obj = new Instrucrecreport_class($conn);
if($_POST["instrucrecsearch_bt"]=="ค้นหา"){
	list($term_comb,$year_comb) = split("/",$_POST["period_comb"]);
	$period = $_POST["period_comb"];
	$personnel_ID=$_POST['personnelID_comb'];
	$main_obj->setPeriod($term_comb,$year_comb);
}else{
	$period = $main_obj->teach_term."/".$main_obj->teach_year;
	list($term_comb,$year_comb) = split("/",$period);
}
echo '<script>var personnel_ID="'.$personnel_ID.'";</script>';
?>
<script type="text/javascript">
$(document).ready(function() {
	//headmenu
	$('#teacherresult').click(function(){
		$('#systemcontent').load("teacherresult.php");
	});
	//search
	$('#instrucrecsearchform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#period_comb').change(function() {
		var period = $('#period_comb').select().val();
		period = period.split("/");
        	$.get('comboteacherperterm.php',{
				teach_term:period[0],
				teach_year:period[1],
				personnel_ID:personnel_ID},function(data){
				$('#personnelID_comb').html(data);
			});
    });
	$('#period_comb').change();
});
function instrucrecdetailb(teach_ID){
	$.get('instrucrecdetailb.php',{'teach_ID':teach_ID},function(data){$('#systemcontent').html(data)});
}
function uinfo(id){
	$.get('instrucrecreportpop.php',{'teach_ID' : id},function(data) {
		$('#info').html(data);
		blanket_size();
		toggle('blanket');
		window_pos('info',0.5);
		toggle('info');
	});
}
</script>
   	<div id="statusbar">
   	  รายงานการบันทึกหลังการสอน
   	</div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
   	  <td align="left" valign="middle" width="192"><a href="#" id="teacherresult"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="<?php echo "reportpdf/instrucreport.php?teach_term=&teach_year";?>" target="_blank"><img src="../images/icons/64/printer.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle"><strong>ความคุม</strong></td>
      <td></td>
    </tr>
	</table>
</div>
    <div id="admincontent">
  <center><br />
  		<form id="instrucrecsearchform" action="instrucrecreport.php" method="post">
        	<b>ค้นหา ภาคเรียนที่ </b><select name="period_comb" id="period_comb">
        	  <?php
			  $query="Select * From period Order By period_year,period_term DESC";
			  $period_query=mysql_query($query,$conn)or die(mysql_error());
			  while($period_fetch=mysql_fetch_assoc($period_query)){
				if($period==($period_fetch["period_term"]."/".$period_fetch["period_year"]))
				  	echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."' selected='selected'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
				else
					echo "<option value='".($period_fetch["period_term"]."/".$period_fetch["period_year"])."'>".($period_fetch["period_term"]."/".($period_fetch["period_year"]+543))."</option>";
			  }
			  ?>
        	</select>
			<strong>ครูผู้สอน</strong>
<select name="personnelID_comb" id="personnelID_comb">
        <option value="all">ทั้งหมด</option>
        </select>
   	      <input name="instrucrecsearch_bt" type="submit" id="instrucrecsearch_bt" value="ค้นหา" />
        </form>
        <br /><br />
        <table width="95%" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
                    <th height="50" colspan="13" bgcolor="#CCCCCC">ข้อมูลการบันทึกหลังการสอน ภาคเรียนที่  <?php echo substr($period,0,2).(substr($period,2,4)+543);?></th>
         <?php
		 $main_obj->setSearch($personnel_ID); 
		 $main_obj->queryPersonnel(); 
		 while($main_obj->fetchPersonnel()){
		?>
                  <tr>
                    <td height="30" colspan="4" align="center" valign="middle" bgcolor="#00CC99" class="BlackBold10"><?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser; ?></td>
                    <td colspan="4" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">บันทึกแบบรายวัน</td>
                    <td colspan="4" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">บันทึกแบบรายสัปดาห์</td>
                    <td width="8%" rowspan="2" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ผลลัพธ์</td>
                  </tr>
          <tr>
            <td width="3%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ที่</td>
    <td width="10%" height="30" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">รหัสวิชา</td>
    <td align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ชื่อวิชา</td>
    <td width="20%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สอนระดับชั้น สาขางาน</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สอน</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">บันทึก</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">%</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ต้องสงสัย</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">สอน</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">บันทึก</td>
    <td width="4%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">%</td>
    <td width="5%" align="center" valign="middle" bgcolor="#FFCC33" class="BlackBold10">ต้องสงสัย</td>
    </tr>
    <?php $n=1;
	$main_obj->queryTeach();while($main_obj->fetchTeach()){?>
  <tr>
    <td width="3%" height="25" align="center" valign="middle"><?php echo $n++;?></td>
    <td align="center" valign="middle"><a href="#"  onclick="uinfo('<?php echo $main_obj->teach_ID;?>')"><?php echo $main_obj->subject_ID;?></a></td>
    <td align="left" valign="middle"><a href="#" onclick="uinfo('<?php echo $main_obj->teach_ID;?>')"><?php echo $main_obj->subject_name;?></a></td>
    <td align="left" valign="middle"><?php 
	$main_obj->queryClass();
	while($main_obj->fetchClass()){
		echo $main_obj->class_level.".".((substr($year_comb+543,2,2))-substr($main_obj->class_ID,0,2)+1)."/".substr($main_obj->class_ID,7,1)." ".$main_obj->major_name."<br>";
	}
	
	?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountAllTeachDay();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountRecDay();?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><b><?php echo $main_obj->getPercentRecDay();?></b></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountWarningRecDay();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountAllTeachWeek();?></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountRecWeek();?></td>
    <td align="center" valign="middle" bgcolor="#CCCCCC"><b><?php echo $main_obj->getPercentRecWeek();?></b></td>
    <td align="center" valign="middle"><?php echo $main_obj->getCountWarningRecWeek();?></td>
    <td align="center" valign="middle" <?php if($main_obj->getRecResult()=='ผ่าน') echo 'bgcolor="#AAFFAA"'; else echo 'bgcolor="#FFBBBB"'; ?>><?php echo $main_obj->getRecResult();?></td>
    </tr>
    <?php }} ?>
</table><br />
</center></div>