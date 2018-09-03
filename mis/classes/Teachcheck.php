<?php
require_once 'Db_Table.php';
class Teachcheck extends Db_Table{
	public $teachcheck_ID;
	public $teachday_ID;
	public $teachcheck_week;
	public $teachcheck_result;
	public $teach_ID;
	public $student_ID;	
	public $teachcheck_checkdate;
	public $teachcheck_checkip;
	
	function __construct($dbconnecttion){
		$this->table = 'teachcheck';
		$this->ID = 'teachcheck_ID';
	}
	
	public function fetchRow(){
		$teachcheck_fetch = parent::fetchRow();
		$this->teachcheck_ID=$teachcheck_fetch['teachcheck_ID'];
		$this->teachday_ID=$teachcheck_fetch['teachday_ID'];
		$this->teachcheck_week=$teachcheck_fetch['teachcheck_week'];
		$this->teachcheck_result=$teachcheck_fetch['teachcheck_result'];
		$this->teach_ID=$teachcheck_fetch['teach_ID'];
		$this->student_ID=$teachcheck_fetch['student_ID'];
		$this->teachcheck_checkdate=$teachcheck_fetch['teachcheck_checkdate'];
		$this->teachcheck_checkip=$teachcheck_fetch['teachcheck_checkip'];
		return $teachcheck_fetch;
	}
	
	public function insertData($teachday_ID,$teachcheck_week,$teachcheck_result,$teach_ID,$student_ID,$teachcheck_checkdate,$teachcheck_checkip){
		$fieldData_Array = array('teachday_ID'=>$teachday_ID,
								'teachcheck_week'=>$teachcheck_week,
								'teachcheck_result'=>$teachcheck_result,
								'teach_ID'=>$teach_ID,
								'student_ID'=>$student_ID,
								'teachcheck_checkdate'=>$teachcheck_checkdate,
								'teachcheck_checkip'=>$teachcheck_checkip);
		parent::insertData($fieldData_Array);
	}
	
}
?>