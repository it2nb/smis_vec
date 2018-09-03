<?php include("includefiles/college.php");?>
<p class="BlackBold12"><?php echo $department;?></p>
<p><strong><?php echo $college;?></strong><br>
<a href="<?php echo $collegeweburl;?>"><?php echo $collegewebtext;?></a>
<br />
<?php
if(!empty($_SESSION["userID"]))
	echo "<img src='../images/smis.png' width='100' />";
else
	echo "<img src='images/smis.png' width='100' />";
?>
</p>
