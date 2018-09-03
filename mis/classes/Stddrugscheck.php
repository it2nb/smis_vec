<?php
require_once 'Db_Table.php';
class Stddrugscheck extends Db_Table{
	public $stddrugscheck_ID;
	public $stddrugscheck_found;
	public $stddrugscheck_comment;
	public $stddrugscheck_date;
	public $personnel_ID;
	public $student_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'stddrugscheck';
		$this->ID = 'stddrugscheck_ID';
	}

	public function queryByStudentID($student_ID){
		return parent::queryByFk('student_ID',$student_ID);
	}
	
	public function queryByPersonnelID($personnel_ID){
		return parent::queryByFk('personnel_ID',$personnel_ID);
	}
	
	public function fetchRow(){
		$stddrugscheck_fetch = parent::fetchRow();
		$this->stddrugscheck_ID=$stddrugscheck_fetch['stddrugscheck_ID'];
		$this->stddrugscheck_found=$stddrugscheck_fetch['stddrugscheck_found'];
		$this->stddrugscheck_comment=$stddrugscheck_fetch['stddrugscheck_comment'];
		$this->stddrugscheck_date=$stddrugscheck_fetch['stddrugscheck_date'];
		$this->personnel_ID=$stddrugscheck_fetch['personnel_ID'];
		$this->student_ID=$stddrugscheck_fetch['student_ID'];
		return $stddrugscheck_fetch;
	}
	
	public function insertData($stddrugscheck_found,$stddrugscheck_comment,$stddrugscheck_date,$personnel_ID,$student_ID){
		$fieldData_Array = array('stddrugscheck_found'=>$stddrugscheck_found,
								'stddrugscheck_comment'=>$stddrugscheck_comment,
								'stddrugscheck_date'=>$stddrugscheck_date,
								'personnel_ID'=>$personnel_ID,
								'student_ID'=>$student_ID);
		parent::insertData($fieldData_Array);
	}	
}
?>