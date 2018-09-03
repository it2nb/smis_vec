<?php
require_once 'Db_Table.php';
class Centralactstdcheck extends Db_Table{
	public $centralact_ID;
	public $student_ID;
	public $class_ID;
	public $centralactstdcheck_status;
	public $centralactstdcheck_date;
	public $personnel_ID;
	public $personnel_ID_boss;
	
	function __construct($dbconnecttion){
		$this->table = 'centralactstdcheck';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$centralactstdcheck_fetch = parent::fetchRow();
		$this->centralact_ID=$centralactstdcheck_fetch['centralact_ID'];
		$this->student_ID=$centralactstdcheck_fetch['student_ID'];
		$this->class_ID=$centralactstdcheck_fetch['class_ID'];
		$this->centralactstdcheck_status=$centralactstdcheck_fetch['centralactstdcheck_status'];
		$this->centralactstdcheck_date=$centralactstdcheck_fetch['centralactstdcheck_date'];
		$this->personnel_ID=$centralactstdcheck_fetch['personnel_ID'];
		$this->personnel_ID_boss=$centralactstdcheck_fetch['personnel_ID_boss'];
		return $centralactstdcheck_fetch;
	}
	
	public function insertData($centralact_ID,$student_ID,$class_ID,$centralactstdcheck_status,$centralactstdcheck_date,$personnel_ID,$personnel_ID_boss){
		$fieldData_Array = array('centralact_ID'=>$centralact_ID,
								'student_ID'=>$student_ID,
								'class_ID'=>$class_ID,
								'centralactstdcheck_status'=>$centralactstdcheck_status,
								'centralactstdcheck_date'=>$centralactstdcheck_date,
								'personnel_ID'=>$personnel_ID,
								'personnel_ID_boss'=>$personnel_ID_boss);
		parent::insertData($fieldData_Array);
	}
	
	public function insertArray($fieldData_Array){
		parent::insertData($fieldData_Array);
	}
}
?>