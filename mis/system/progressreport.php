<?php
if(session_id()=='')
    session_start();
require_once("../includefiles/connectdb.php");
require_once("../includefiles/datalist.php");
require_once '../classes/progressreport.class.php';
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$main_obj = new Progressreport_class($conn);
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
            $('#teacherresult').click(function() {
                $('#systemcontent').load("teacherresult.php");
            });
            //search
            $('#pregresssearchform').ajaxForm({
                target: '#systemcontent',
                beforeSubmit: function() {
                    $('#systemcontent').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
                },
                success: function() {}
            });
            $('#period_comb').change(function() {
                var period = $('#period_comb').select().val();
                period = period.split("/");
                $.get('comboteacherperterm.php', {
                    teach_term: period[0],
                    teach_year: period[1],
                    personnel_ID: personnel_ID
                }, function(data) {
                    $('#personnelID_comb').html(data);
                });
            });
            $('#period_comb').change();
        });

        function instrucrecdetailb(teach_ID) {
            $.get('instrucrecdetailb.php', {
                'teach_ID': teach_ID
            }, function(data) {
                $('#systemcontent').html(data)
            });
        }

        function uinfo(id) {
            $.get('instrucrecreportpop.php', {
                'teach_ID': id
            }, function(data) {
                $('#info').html(data);
                blanket_size();
                toggle('blanket');
                window_pos('info', 0.5);
                toggle('info');
            });
        }

    </script>
    <div id="statusbar" class="uk-panel uk-panel-title uk-panel-box uk-panel-box-primary"><b><big>
        รายงานการวัดผลประเมินผล</big></b></div>
	<div id="namebar"><?php echo "ยินดีต้อนรับ คุณ ".$_SESSION["user_name"]; ?>&nbsp;(<a href="../logout.php">ออกจากระบบ</a>)</div>
    <div id="headmenu">
    <table width="100%" cellpadding="0" cellspacing="0" bordercolor="#009999" border="1">
    <tr>
   	  <td align="left" valign="middle" width="192"><a href="#" id="teacherresult"><img src="../images/icons/64/back.png" width="64" height="64" /></a><a href="index.php"><img src="../images/icons/64/home.png" width="64" height="64"></a></td>
        <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#009999">
    	<td align="center" valign="middle"><strong>ความคุม</strong></td>
      <td></td>
    </tr>
	</table>
</div>
    <hr>
    <div id="admincontent">
        <center>
            <div class="uk-width-medium-2-3 uk-width-small-1-1" style="padding: 10px">
               <form id="pregresssearchform" action="progressreport.php" method="post">
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
            </div>
            <div style="padding: 10px">
                <table class="uk-table uk-table-hover uk-table-striped" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
                    <th height="50" colspan="7" style="background-color: #CCCCCC" class="uk-text-center">ข้อมูลการบันทึกคะแนนวัดผลประเมินผล ภาคเรียนที่
                        <?php echo substr($period,0,2).(substr($period,2,4)+543);?>
                    </th>
                    <?php
		 $main_obj->setSearch($personnel_ID); 
		 $main_obj->queryPersonnel(); 
		 while($main_obj->fetchPersonnel()){
		?>
                        <tr>
                            <td height="30" colspan="7" align="center" valign="middle" style="background-color: #00CC99" class="uk-text-bold">
                                <?php echo $main_obj->personnel_name.' '.$main_obj->personnel_ser; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="1%" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold">ที่</td>
                            <td width="10%" height="30" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold uk-hidden-small">รหัสวิชา</td>
                            <td align="center" valign="middle" bgcolor="#FFCC33" class="uk-text-bold">ชื่อวิชา</td>
                            <td width="20%" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold uk-hidden-small">สอนระดับชั้น สาขางาน</td>
                            <td width="10%" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold">กำหนดคะแนน
                                <br /> (%)
                            </td>
                            <td width="10%" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold">การเก็บคะแนน
                                <br /> เทียบกับ 100 (%)</td>
                            <td width="10%" align="center" valign="middle" style="background-color: #FFCC33" class="uk-text-bold">คะแนนเฉลี่ยผู้เรียน
                                <br /> (%)
                            </td>
                        </tr>
                        <?php $n=1;
	$main_obj->queryTeach();while($main_obj->fetchTeach()){?>
                            <tr>
                                <td width="1%" height="25" align="center" valign="middle">
                                    <?php echo $n++;?>
                                </td>
                                <td align="center" valign="middle" class="uk-hidden-small">
                                    <?php echo $main_obj->subject_ID;?>
                                </td>
                                <td align="left" valign="middle">
                                    <b><?php echo $main_obj->subject_name;?></b>
                                    <div class="uk-visible-small">
                                        <?php 
	$main_obj->queryClass();
	while($main_obj->fetchClass()){
		echo $main_obj->class_level.".".((substr($year_comb+543,2,2))-substr($main_obj->class_ID,0,2)+1)."/".substr($main_obj->class_ID,7,1)." ".$main_obj->major_name."<br>";
	}
	
	?>
                                    </div>
                                </td>
                                <td align="left" valign="middle" class="uk-hidden-small">
                                    <?php 
	$main_obj->queryClass();
	while($main_obj->fetchClass()){
		echo $main_obj->class_level.".".((substr($year_comb+543,2,2))-substr($main_obj->class_ID,0,2)+1)."/".substr($main_obj->class_ID,7,1)." ".$main_obj->major_name."<br>";
	}
	
	?>
                                </td>
                                <td align="center" valign="middle">
                                    <?php echo $main_obj->getAllScorePercent();?>
                                </td>
                                <td align="center" valign="middle">
                                    <?php echo $main_obj->getStoreScorePercent();?>
                                </td>
                                <td align="center" valign="middle" style="background-color: #CCCCCC"><b><?php echo $main_obj->getStdscorePercent();?></b></td>
                            </tr>
                            <?php }} ?>
                </table>
            </div>
        </center>
    </div>
