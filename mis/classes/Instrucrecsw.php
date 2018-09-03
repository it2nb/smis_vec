<?php
require_once 'Db_Table.php';
class Instrucrecsw extends Db_Table{
	public $instrucrecsw_ID;
	public $instrucrecsw_detail;
	public $instrucrecsw_date;
	public $instrucrecsw_week;
	public $instrucrecsw_term;
	public $instrucrecsw_year;
	public $subject_ID;
	public $course_ID;
	public $personnel_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'instrucrecsw';
		$this->ID = 'instrucrecsw_ID';
	}
	
	public function queryByTeach($personnel_ID,$subject_ID,$course_ID,$instrucrecsw_term,$instrucrecsw_year){
		$fieldData_Array = array('personnel_ID'=>$personnel_ID,
		'subject_ID'=>$subject_ID,
		'course_ID'=>$course_ID,
		'instrucrecsw_term'=>$instrucrecsw_term,
		'instrucrecsw_year'=>$instrucrecsw_year);
		return parent::queryByMultiField($fieldData_Array);
	}
	
	public function fetchRow(){
		$instrucrecsw_fetch = parent::fetchRow();
		$this->instrucrecsw_ID=$instrucrecsw_fetch['instrucrecsw_ID'];
		$this->instrucrecsw_detail=$instrucrecsw_fetch['instrucrecsw_detail'];
		$this->instrucrecsw_date=$instrucrecsw_fetch['instrucrecsw_date'];
		$this->instrucrecsw_week=$instrucrecsw_fetch['instrucrecsw_week'];
		$this->instrucrecsw_term=$instrucrecsw_fetch['instrucrecsw_term'];
		$this->instrucrecsw_year=$instrucrecsw_fetch['instrucrecsw_year'];
		$this->subject_ID=$instrucrecsw_fetch['subject_ID'];
		$this->course_ID=$instrucrecsw_fetch['course_ID'];
		$this->personnel_ID=$instrucrecsw_fetch['personnel_ID'];
		return $instrucrecsw_fetch;
	}
	
	public function insertData($instrucrecsw_detail,$instrucrecsw_date,$instrucrecsw_week,$instrucrecsw_term,$instrucrecsw_year,$subject_ID,$course_ID,$personnel_ID){
		$fieldData_Array = array('instrucrecsw_detail'=>$instrucrecsw_detail,
								'instrucrecsw_date'=>$instrucrecsw_date,
								'instrucrecsw_week'=>$instrucrecsw_week,
								'instrucrecsw_term'=>$instrucrecsw_term,
								'instrucrecsw_year'=>$instrucrecsw_year,
								'subject_ID'=>$subject_ID,
								'course_ID'=>$course_ID,
								'personnel_ID'=>$personnel_ID);
		parent::insertData($fieldData_Array);
	}
	
}
?>