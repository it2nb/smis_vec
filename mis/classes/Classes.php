<?php
require_once 'Db_Table.php';
class Classes extends Db_Table{
	public $class_ID;
	public $major_ID;
	public $personnel_ID;
	public $personnel_ID2;
	public $year;
	public $area_name;
	public $major_name;
	
	function __construct($dbconnecttion){
		$this->table = 'class';
		$this->ID = 'class_ID';
	}
	
	public function queryByMajorID($major_ID){
		return parent::queryByFk('major_ID',$major_ID);
	}
	
	public function queryByPersonnelID2($personnel_ID2){
		return parent::queryByFk('personnel_ID2',$personnel_ID2);
	}
	
	public function queryByPersonnelID($personnel_ID){
		return parent::queryByFk('personnel_ID',$personnel_ID);
	}
	
	public function fetchRow(){
		$class_fetch = parent::fetchRow();
		$this->class_ID=$class_fetch['class_ID'];
		$this->major_ID=$class_fetch['major_ID'];
		$this->personnel_ID=$class_fetch['personnel_ID'];
		$this->personnel_ID2=$class_fetch['personnel_ID2'];
		$this->year=$class_fetch['year'];
		$this->area_name=$class_fetch['area_name'];
		$this->major_name=$class_fetch['major_name'];
		return $class_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>