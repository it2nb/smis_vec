<?php
session_start();
require_once('../includefiles/connectdb.php');
include '../classes/Affective.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$teach_ID=$_GET["teach_ID"];
$affective = new Affective($conn);
?>
<script type="text/javascript">

$(document).ready(function() { 
	$.ajaxSetup({cache:false});
	$('#addteachaffectiveform').ajaxForm({ 
        target: '#affectivescoretype',
		beforeSubmit: function(){
			$('#teachaffective_add').html("<center>กำลังประมวลผลข้อมูล<br><img src='../images/progressbar.gif' /></center>");
		},
		success: function(){
		}
    });
});

</script>
        <form id="addteachaffectiveform" action="affectivescoretype.php" method="post">
          <p>เลือกหัวข้อจิตพิสัย :
            
            <select name="affective_ID" id="addteachaffectiveform">
            <?php
			$affective->queryAllByEnable();
			while($affective->fetchRow()){
				echo '<option value="'.$affective->affective_ID.'">'.$affective->affective_name.'</option>';
			}
			?>
            </select>
&nbsp;คะแนน : <input name="teachaffective_score" type="text" id="teachaffective_score" size="5" maxlength="3" />
<input name="teach_ID" type="hidden" id="teach_ID" value="<?php echo $teach_ID;?>" />
<br />
<input type="submit" name="addteachaffective_bt" id="addteachaffective_bt" value="บันทึก" />
&nbsp;&nbsp;
<input type="submit" name="cancel_bt" id="cancel_bt" value="ยกเลิก" />
          </p>
</form>
