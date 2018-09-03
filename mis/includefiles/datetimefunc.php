<?php
class datetimefunc {
	public function getweek($check_date,$period_start,$period_end){
		  list($st_year,$st_month,$st_day) = split("-",$period_start);
		  list($sp_year,$sp_month,$sp_day) = split("-",$period_end);
		  $date_st = ($st_year*10000)+($st_month*100)+(int)$st_day;
		  $date_sp = ($sp_year*10000)+($sp_month*100)+(int)$sp_day;
		  list($ch_year,$ch_month,$ch_day) = split("-",$check_date);
		  $chdate = ($ch_year*10000)+($ch_month*100)+$ch_day;
		  $dayofweek=7;
		  $week = 1;
		  $countday = 1;
		  if($chdate<=$date_sp){
		  while($date_st<=$date_sp&&$date_st<=$chdate){
			//if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=6){
			if(1){
				if($st_year==$ch_year&&$st_month==$ch_month&&$st_day==$ch_day){
					$thisweek=$week;
				}
				if($countday%$dayofweek==0)
					$week++;
				$countday++;
			}
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
		return $thisweek;
		}
		else{
			return 18;
		}
	}
	public function getalldayinperiod($period_start,$period_end){
		list($st_year,$st_month,$st_day) = split("-",$period_start);
		list($sp_year,$sp_month,$sp_day) = split("-",$period_end);
		$date_st = ($st_year*10000)+($st_month*100)+$st_day;
		$date_sp = ($sp_year*10000)+($sp_month*100)+$sp_day;
		$dayofweek=5;
		$week = 1;
		$countday = 1;
		while($date_st<=$date_sp){
	  		if(jddayofweek(gregoriantojd($st_month,$st_day,$st_year),0)!=0&&jddayofweek(gregoriantojd($st_month,(int)$st_day,$st_year),0)!=6){
				$allday++;
	  		}
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
		return $allday;
	}
}

?>