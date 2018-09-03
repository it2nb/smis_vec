<?php
require_once 'Db_Table.php';
class Province extends Db_Table{
	public $province_ID;
	public $province_no;
	public $province_name;
	public $region;
	
	function __construct($dbconnecttion){
		$this->table = 'province';
		$this->ID = 'province_ID';
	}
	
	public function fetchRow(){
		$province_fetch = parent::fetchRow();
		$this->province_ID=$province_fetch['province_ID'];
		$this->province_no=$province_fetch['province_no'];
		$this->province_name=$province_fetch['province_name'];
		$this->region=$province_fetch['region'];
		return $province_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>