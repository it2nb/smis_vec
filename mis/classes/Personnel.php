<?php
require_once 'Db_Table.php';
class Personnel extends Db_Table{
	public $personnel_ID;
	public $personnel_name;
	public $personnel_ser;
	public $member_ID;
	public $deparment_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'personnel';
		$this->ID = 'personnel_ID';
	}
	
	public function queryByIDStatus($personnel_ID,$personnel_status){
		parent::queryBySql('Select * From personnel Where personnel_ID="'.$personnel_ID.'" and personnel_status="'.$personnel_status.'"');
	}
	
	public function queryByMemberID($member_ID){
		return parent::queryByFk("member_ID",$member_ID);
	}
	
	public function queryByDepartmentID($department_ID){
		return parent::queryByFk("department_ID",$department_ID);
	}
	
	public function fetchRow(){
		$personnel_fetch = parent::fetchRow();
		$this->personnel_ID=$personnel_fetch['personnel_ID'];
		$this->personnel_name=$personnel_fetch['personnel_name'];
		$this->personnel_ser=$personnel_fetch['personnel_ser'];
		$this->member_ID=$personnel_fetch['member_ID'];
		$this->deparment_ID=$personnel_fetch['department_ID'];
		return $personnel_fetch;
	}
	
	/*public function insertData($personnel_ID,$personnel_ID,$class_ID,$grade){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'personnel_ID'=>$personnel_ID,
								'class_ID'=>$class_ID,
								'grade'=>$grade);
		parent::insertData($fieldData_Array);
	}*/
}
?>