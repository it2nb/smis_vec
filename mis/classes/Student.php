<?php
require_once 'Db_Table.php';
class Student extends Db_Table{
	public $student_ID;
	public $student_prefix;
	public $student_name;
	public $student_ser;
	public $personnelcard_ID;
	public $student_level;
	public $student_startyear;
	public $area_ID;
	public $major_ID;
	public $student_endyear;
	public $student_endstatus;
	public $class_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'student';
		$this->ID = 'student_ID';
	}
	
	public function queryByClassID($class_ID){
		parent::queryByFk("class_ID",$class_ID);
	}
	
	public function fetchRow(){
		$student_fetch = parent::fetchRow();
		$this->student_ID=$student_fetch['student_ID'];
		$this->student_prefix=$student_fetch['student_prefix'];
		$this->student_name=$student_fetch['student_name'];
		$this->student_ser=$student_fetch['student_ser'];
		$this->personnelcard_ID=$student_fetch['personnelcard_ID'];
		$this->student_level=$student_fetch['student_level'];
		$this->student_startyear=$student_fetch['student_startyear'];
		$this->area_ID=$student_fetch['area_ID'];
		$this->major_ID=$student_fetch['major_ID'];
		$this->student_endyear=$student_fetch['student_endyear'];
		$this->student_endstatus=$student_fetch['student_endstatus'];
		$this->class_ID=$student_fetch['class_ID'];
		return $student_fetch;
	}
	
	/*public function insertData($student_ID,$student_ID,$class_ID,$grade){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'student_ID'=>$student_ID,
								'class_ID'=>$class_ID,
								'grade'=>$grade);
		parent::insertData($fieldData_Array);
	}*/
}
?>