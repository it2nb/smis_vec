<?php
require_once 'Db_Table.php';
class Prefecture extends Db_Table{
	public $prefecture_ID;
	public $prefecture_name;
	public $province_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'prefecture';
		$this->ID = 'prefecture_ID';
	}
	
	public function fetchRow(){
		$prefecture_fetch = parent::fetchRow();
		$this->prefecture_ID=$prefecture_fetch['prefecture_ID'];
		$this->prefecture_name=$prefecture_fetch['prefecture_name'];
		$this->province_ID=$prefecture_fetch['province_ID'];
		return $prefecture_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>