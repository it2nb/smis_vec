<?php
require_once 'Db_Table.php';
class Teachday extends Db_Table{
	public $teachday_ID;
	public $teachday_day;
	public $teachday_start;
	public $teachday_stop;
	public $teachday_hour;
	public $teach_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'teachday';
		$this->ID = 'teachday_ID';
	}

	public function queryByTeachID($teach_ID){
		return parent::queryByFk('teach_ID',$teach_ID);
	}
	
	public function fetchRow(){
		$teacher_fetch = parent::fetchRow();
		$this->teachday_ID=$teacher_fetch['teachday_ID'];
		$this->teachday_day=$teacher_fetch['teachday_day'];
		$this->teachday_start=$teacher_fetch['teachday_start'];
		$this->teachday_stop=$teacher_fetch['teachday_stop'];
		$this->teachday_hour=$teacher_fetch['teachday_hour'];
		$this->teach_ID=$teacher_fetch['teach_ID'];
		return $teacher_fetch;
	}
	
	public function insertData($teachday_day,$teachday_start,$period_start,$period_end,$teach_ID){
		$fieldData_Array = array('teachday_day'=>$teachday_day,
								'teachday_start'=>$teachday_start,
								'teachday_stop'=>$teachday_stop,
								'teachday_hour'=>$period_end,
								'teach_ID'=>$teach_ID);
		parent::insertData($fieldData_Array);
	}
	
}
?>