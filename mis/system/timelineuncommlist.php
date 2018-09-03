<?php
session_start();
include("../includefiles/connectdb.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$listpos=$_GET["listpos"];
$enable=1;
if($listpos=="first"){
	$query="Select max(timeline_ID) As maxid From timeline";
	$maxtimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$maxtimeline_fetch=mysql_fetch_assoc($maxtimeline_query);
	$maxtimeline_ID=$maxtimeline_fetch["maxid"];
	$query="Select * From timeline Order By timeline_ID DESC Limit 0,20";
	$timeline_query=mysql_query($query,$conn)or die(mysql_error());
}
else if($listpos=="next"){
	$timeline_ID=$_GET["timeline_ID"];
	$query="Select max(timeline_ID) As maxid From timeline";
	$maxtimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$maxtimeline_fetch=mysql_fetch_assoc($maxtimeline_query);
	$maxtimeline_ID=$maxtimeline_fetch["maxid"];
	if($timeline_ID<$maxtimeline_ID){
		$query="Select * From timeline Where timeline_ID>'$timeline_ID' Order By timeline_ID DESC Limit 0,20";
		$timeline_query=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		$enable=0;
	}
}
else if($listpos=="prev"){
	$timeline_ID=$_GET["timeline_ID"];
	$query="Select min(timeline_ID) As minid From timeline";
	$mintimeline_query=mysql_query($query,$conn)or die(mysql_error());
	$mintimeline_fetch=mysql_fetch_assoc($mintimeline_query);
	$mintimeline_ID=$mintimeline_fetch["minid"];
	if($timeline_ID>$mintimeline_ID){
		$query="Select * From timeline Where timeline_ID<'$timeline_ID' Order By timeline_ID DESC Limit 0,20";
		$timeline_query=mysql_query($query,$conn)or die(mysql_error());
	}
	else{
		$enable=0;
	}
}
?>
<style type="text/css">
.roundrectanhead {
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-webkit-border-top-right-radius:10px;
	-webkit-border-top-left-radius:10px;
	-webkit-border-bottom-left-radius:10px;
	-webkit-border-bottom-right-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border:thin solid #CDCDCD;
	width: 80%;
	background-color: #EEEEEE;
}
.roundrectantimeline {
	-moz-border-radius-topleft:10px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-webkit-border-top-right-radius:10px;
	-webkit-border-top-left-radius:10px;
	-webkit-border-bottom-left-radius:10px;
	-webkit-border-bottom-right-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border:thin solid #ECECEC;
	width: 90%;
	background-color: #F5F5F5;
	padding: 10px;
}
table {
	font-size: 11pt;
}
</style>
<script type="text/javascript">
$(document).ready(function() { 
	$.ajaxSetup({cache:false});
});
function loadtimeline(id, fktable, tag){
	if(fktable=="instrucrec"){
		$.get('timeline/instrucrec.php',{'timeline_ID':id,
		'tagid':tag},function(data){$('#'+tag).html(data)});
	}
	else if(fktable=="instrucrecsw"){
		$.get('timeline/instrucrecsw.php',{'timeline_ID':id,
		'tagid':tag},function(data){$('#'+tag).html(data)});
	}
	else if(fktable=="actnews"){
		$.get('timeline/actnews.php',{'timeline_ID':id,
		'tagid':tag},function(data){$('#'+tag).html(data)});
	}
}
</script>
<div align="center">
<?php
if($listpos=="first"||$listpos=="next"){
	if($enable){
?>
<div id="<?php echo "list".$maxtimeline_ID;?>">
<?php } ?>
<div class="roundrectanhead">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><h2><a href="#" onclick="timelinelist('<?php echo $maxtimeline_ID;?>','<?php echo "list".$maxtimeline_ID;?>','next')">โหลดเหตุการณ์ใหม่</a></h2></td>
  </tr>
</table>
</div>
<br />
</div>
<?php 
}
if($enable){ 
 ?>
<?php 
	while($timeline_fetch=mysql_fetch_assoc($timeline_query)){
		$timeline_ID=$timeline_fetch["timeline_ID"];
?>
<div class="roundrectantimeline">
	<div id="<?php echo "line".$timeline_ID;?>">
    	<script>
			loadtimeline('<?php echo $timeline_ID;?>','<?php echo $timeline_fetch["timeline_type"];?>','<?php echo "line".$timeline_ID;?>');
		</script>
   </div>
</div>
<br>
<?php } ?>
<?php 
}
if($listpos=="first"||$listpos=="prev"){
	if($enable){
?>
<div id="<?php echo "list".$timeline_ID;?>">
<?php } ?>
<div class="roundrectanhead">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><h2><a href="<?php echo "#list".$timeline_ID;?>" onclick="timelinelist('<?php echo $timeline_ID;?>','<?php echo "list".$timeline_ID;?>','prev')">โหลดเหตุการณ์ก่อนหน้า</a></h2></td>
  </tr>
</table>
</div>
</div>
<?php } ?>
</div>