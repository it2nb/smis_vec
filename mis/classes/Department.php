<?php
require_once 'Db_Table.php';
class Department extends Db_Table{
	public $department_ID;
	public $department_name;
	public $department_des;
	public $personnel_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'department';
		$this->ID = 'department_ID';
	}
	
	public function queryByPersonnelID($personnel_ID){
		return parent::queryByFk('personnel_ID',$personnel_ID);
	}
	
	public function fetchRow(){
		$department_fetch = parent::fetchRow();
		$this->department_ID=$department_fetch['department_ID'];
		$this->department_name=$department_fetch['department_name'];
		$this->department_des=$department_fetch['department_des'];
		$this->personnel_ID=$department_fetch['personnel_ID'];
		return $department_fetch;
	}
	
	public function insertData($department_name,$department_des,$personnel_ID){
		$fieldData_Array = array('department_name'=>$department_name,
								'department_des'=>$department_des,
								'personnel_ID'=>$personnel_ID);
		parent::insertData($fieldData_Array);
	}
}
?>