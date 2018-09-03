<?php 
session_start();
header("Content-Type: text/html; charset=utf-8"); 
include_once 'recordclass.php';
include_once 'recordgrade.php';
include_once 'recordscorepoint.php';
include_once 'recordaffective.php';
include_once 'recordsummary.php'
;?>
<script type="text/javascript">
	print();
</script>
<div class="noprint">
    <a href="javascript:window.print()"><img src="../../images/icons/64/printer.png" width="64" height="64"/></a>
</div>