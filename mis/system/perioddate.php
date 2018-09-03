<?php
session_start();
include("../includefiles/connectdb.php");
include("../includefiles/datalist.php");
header("Content-Type: text/html; charset=utf-8");
if(empty($_SESSION["userID"]))
{
	echo "<meta http-equiv='refresh' content='0;url=../'>";
}
$check_period = $_GET["check_period"];
			  $query="Select * From period Where period_year='".substr($check_period,2,4)."' and period_term='".substr($check_period,0,1)."'";
			  $date_query=mysql_query($query,$conn)or die(mysql_error());
			  $date_fetch = mysql_fetch_array($date_query);
			  list($st_year,$st_month,$st_day) = split("-",$date_fetch["period_start"]);
			  list($sp_year,$sp_month,$sp_day) = split("-",$date_fetch["period_end"]);
			  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  $date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
			  list($flag_year,$flag_month,$flag_day) = split("-",$check_date);
			  $todaydate = (date("Y")*10000)+(date("m")*100)+date("j");
			  $dayofweek=5;
			  $week = 1;
			  $countday = 1;
			  while($date_st<=$date_sp&&$date_st<=$todaydate){
				  if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=6){
				  	if($st_year==$flag_year&&$st_month==$flag_month&&$st_day==$flag_day){
				  		echo "<option value='".$st_year."-".$st_month."-".$st_day."' selected='selected'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
						$thisweek=$week;
					}
					else
						echo "<option value='".$st_year."-".$st_month."-".$st_day."'>(".$week.")วัน".$thday[jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)]." ที่ ".(int)$st_day." ".$thmonth[(int)$st_month]." ".($st_year+543)."</option>";
					if($countday%$dayofweek==0)
					$week++;
					$countday++;
				  }
				  if($st_year==date("Y")&&$st_month==date("n")&&$st_day==date("j"))
					break;
				  $st_day++;
				  if($st_day>cal_days_in_month(CAL_GREGORIAN, $st_month, $st_year)){
					  $st_day=1;
					  $st_month++;
				  }
				  if($st_month>12){
					  $st_month=1;
					  $st_year++;
				  }
				  $date_st = ($st_year*10000)+($st_month*100)+$st_day;
			  }
			  ?>