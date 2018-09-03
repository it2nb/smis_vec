<?php
require_once 'Db_Table.php';
class Flagcheck extends Db_Table{
	public $flagcheck_ID;
	public $flagcheck_date;
	public $flagcheck_time;
	public $flagcheck_result;
	public $student_ID;
	public $personnel_ID;
	public $flagcheck_checkdate;
	public $flagcheck_checkip;
	
	function __construct($dbconnecttion){
		$this->table = 'flagcheck';
		$this->ID = 'flagcheck_ID';
	}

	public function queryBystudentID($student_ID){
		return parent::queryByFk('student_ID',$student_ID);
	}
	
	public function queryBypersonnelID($personnel_ID){
		return parent::queryByFk('personnel_ID',$personnel_ID);
	}
	
	public function fetchRow(){
		$flagcheck_fetch = parent::fetchRow();
		$this->flagcheck_ID=$flagcheck_fetch['flagcheck_ID'];
		$this->flagcheck_date=$flagcheck_fetch['flagcheck_date'];
		$this->flagcheck_time=$flagcheck_fetch['flagcheck_time'];
		$this->flagcheck_result=$flagcheck_fetch['flagcheck_result'];
		$this->student_ID=$flagcheck_fetch['student_ID'];
		$this->personnel_ID=$flagcheck_fetch['personnel_ID'];
		$this->flagcheck_checkdate=$flagcheck_fetch['flagcheck_checkdate'];
		$this->flagcheck_checkip=$flagcheck_fetch['flagcheck_checkip'];
		return $flagcheck_fetch;
	}
	
	public function insertData($flagcheck_date,$flagcheck_time,$flagcheck_result,$student_ID,$personnel_ID,$flagcheck_checkdate,$flagcheck_checkip){
		$fieldData_Array = array('flagcheck_date'=>$flagcheck_date,
								'flagcheck_time'=>$flagcheck_time,
								'flagcheck_result'=>$flagcheck_result,
								'student_ID'=>$student_ID,
								'personnel_ID'=>$personnel_ID,
								'flagcheck_checkdate'=>$flagcheck_checkdate,
								'flagcheck_checkip'=>$flagcheck_checkip);
		parent::insertData($fieldData_Array);
	}
	
}
?>