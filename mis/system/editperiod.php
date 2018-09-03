<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}

if($_POST["save_bt"]=="บันทึก")
{
	$period_term = $_POST["term_comb"];
	$period_year = $_POST["tyear_comb"];
	$oldperiod_term = $_POST["oldperiod_term"];
	$oldperiod_year = $_POST["oldperiod_year"];
	$period_start = $_POST["year_comb"]."-".$_POST["month_comb"]."-".$_POST["day_comb"];
	$period_end = $_POST["spdate"];
	$query = "Select * From period Where period_term='$period_term' and period_year='$period_year'";
	$checkperiod_query = mysql_query($query,$conn)or die(mysql_error());
	if(mysql_num_rows($checkperiod_query)>0 && ($period_term!=$oldperiod_term || $period_year!=$oldperiod_year)){
		echo "<script>alert('ภาคเรียนและปีการศึกษาซ้ำ');</script>";
	}
	else if(jddayofweek(gregoriantojd($_POST["month_comb"],$_POST["day_comb"],$_POST["year_comb"]),0)!=1){
		echo "<script>alert('กรุณาเลือกวันเปิดภาคเรียนเป็นวันจันทร์');</script>";
	}
	else{
		$query = "Update period Set period_year='$period_year',period_term='$period_term',period_start='$period_start',period_end='$period_end' Where period_year='$oldperiod_year' and period_term='$oldperiod_term'";
		$update_period = mysql_query($query,$conn)or die(mysql_error());
		$member_ID = $_SESSION["userID"];
		$userlogs_des="แก้ไขเป็นภาคเรียนที่ ".$period_term." ปีการศึกษา ".($period_year+543)."เริ่ม ".$period_start." สิ้นสุด ".$period_end;
		$query="Insert Into userlogs(member_ID,userlogs_action,userlogs_system,userlogs_des) Values ('$member_ID','Edit Period','period_mis','$userlogs_des')";
		$Insert_userlogs=mysql_query($query,$conn)or die(mysql_error());
	
		echo "<script type='text/javascript'>
				$('#admincontent').hide();
				alert('บันทึกข้อมูลเรียบร้อย');
				$('#systemcontent').load('manageperiod.php');
				</script>";
	}
}
else{
	$period_term = $_GET["period_term"];
	$period_year = $_GET["period_year"];
	$oldperiod_term = $_GET["period_term"];
	$oldperiod_year = $_GET["period_year"];
	$query = "Select * From period Where period_year='$period_year' and period_term='$period_term'";
	$period_query = mysql_query($query,$conn)or die(mysql_error());
	$period_start = mysql_result($period_query,0,"period_start");
	$period_end = mysql_result($period_query,0,"period_end");
}
list($thisyear,$thismonth,$thisday) = split("-",$period_start);
$spdate=$period_end;
?>
<script type="text/javascript">
$(document).ready(function() { 
    $('#manageperiod').click(function(){
		$('#systemcontent').load('manageperiod.php');		
    });
	$('#editperiodform').ajaxForm({ 
        target: '#systemcontent',
		beforeSubmit: function(){
			$('#admincontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
	$('#day_comb, #month_comb, #year_comb').change(function() {
		var day = $('#day_comb').select().val();
		var month = $('#month_comb').select().val();
		var year = $('#year_comb').select().val();
        var stdate = year+"-"+month+"-"+day;
		$.get('comboendperiod.php',{'stdate':stdate},function(data){$('#enddateperiod').html(data);});
    });
	
});
</script>
    	<div id="statusbar">เพิ่มข้อมูลภาคเรียน</div>
		<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
        <div id="headmenu">
        <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
      <td align="left" valign="middle" width="64">
        <a href="#" id="manageperiod"><img src="../images/icons/64/back.png" width="64" height="64"></a>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
      <td align="center" valign="middle"><b>ความคุม</b></td>
        <td></td>
    </tr>
	</table>
        </div>
        <div id="admincontent">
        <center>
        <form id="editperiodform" action="editperiod.php" method="post" enctype="multipart/form-data"><table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th height="30" colspan="2" align="center" valign="middle" bgcolor="#FFCC33">กรอกข้อมูลภาคเรียน</th>
    </tr>
  <tr>
    <td width="40%" height="16" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
    <td valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ภาคเรียนที่ : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
      <select name="term_comb" id="term_comb">
        <option value="1" <?php if($period_term==1) echo "selected='selected'";?>>1</option>
        <option value="2" <?php if($period_term==2) echo "selected='selected'";?>>2</option>
        <option value="3" <?php if($period_term==3) echo "selected='selected'";?>>3</option>
   	  </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">ปีการศึกษา : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><label for="courseID_comb"></label>
      <select name="tyear_comb" id="tyear_comb">
      <?php
	  $styear=$period_year-10;
	  $spyear=$period_year+10;
	  for($y=$styear;$y<=$spyear;$y++){
		  if($y==$period_year)
		  	echo "<option value='$y' selected='selected'>".($y+543)."</option>";
		  else
		  	echo "<option value='$y'>".($y+543)."</option>";
	  }
	  ?>
      </select></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">วันที่เปิดภาคเรียน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC">
    <select name="day_comb" id="day_comb">
    <?php
	  for($d=1;$d<=31;$d++){
		  if($d==$thisday)
		  	echo "<option value='$d' selected='selected'>$d</option>";
		  else
		  	echo "<option value='$d'>$d</option>";
	  }
	  ?>
      </select>
    เดือน 
    <select name="month_comb" id="month_comb">
    <?php
	  for($m=1;$m<=12;$m++){
		  if($m==$thismonth)
		  	echo "<option value='$m' selected='selected'>".$thmonth[$m]."</option>";
		  else
		  	echo "<option value='$m'>".$thmonth[$m]."</option>";
	  }
	  ?>
    </select> 
    พ.ศ. 
    <select name="year_comb" id="year_comb">
    <?php
	  $styear=$thisyear-10;
	  $spyear=$thisyear+10;
	  for($y=$styear;$y<=$spyear;$y++){
		  if($y==$thisyear)
		  	echo "<option value='$y' selected='selected'>".($y+543)."</option>";
		  else
		  	echo "<option value='$y'>".($y+543)."</option>";
	  }
	  ?>
    </select>
    <strong>(เลือกให้ตรงกับวันจันทร์)</strong></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="middle" bgcolor="#CCCCCC">วันที่สิ้นสุดภาคเรียน : &nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><div id="enddateperiod">
	<?php 
	list($spy,$spm,$spd) = split("-",$spdate);
	echo ($spd*1)." ".$thmonth[($spm*1)]." ".($spy+543);
	echo "<input name='spdate' id='spdate' type='hidden' value='$spdate' />";
	?>
    </div></td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center" valign="bottom" bgcolor="#CCCCCC">&nbsp; </td> </tr>
  <tr>
    <td height="16" align="right" valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center" bgcolor="#CCCCCC"><label>
      <input type="submit" name="save_bt" id="save_bt" value="บันทึก" />
    </label>
      <label>
      <input type="reset" name="button2" id="button2" value="ล้างข้อมูล" />
      <input name="oldperiod_term" type="hidden" id="oldperiod_term" value="<?php echo $oldperiod_term;?>" />
      <input name="oldperiod_year" type="hidden" id="oldperiod_year" value="<?php echo $oldperiod_year;?>" />
      </label></td>
    </tr>
</table></form>
        </center>
</div>