<?php
session_start();
include("../includefiles/connectdb.php");
include '../classes/Personnel.php';
header("Content-type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$personnel = new Personnel($conn);
$personnel->queryBySql('Select DISTINCT teach.personnel_ID,personnel.* From teach,personnel Where teach.personnel_ID=personnel.personnel_ID and teach.teach_term="'.$_GET['teach_term'].'" and teach.teach_year="'.$_GET['teach_year'].'" and personnel.personnel_status="work" Order By personnel_name ASC');
echo '<option value="all">ทั้งหมด</option>';
while($personnel->fetchRow()){
	if($personnel->personnel_ID==$_GET['personnel_ID'])
		echo "<option value='".$personnel->personnel_ID."' selected='selected'>".$personnel->personnel_name." ".$personnel->personnel_ser."</option>";
	else
		echo "<option value='".$personnel->personnel_ID."'>".$personnel->personnel_name." ".$personnel->personnel_ser."</option>";
}
?>