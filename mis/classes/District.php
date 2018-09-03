<?php
require_once 'Db_Table.php';
class District extends Db_Table{
	public $district_ID;
	public $district_name;
	public $post;
	public $prefecture_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'district';
		$this->ID = 'district_ID';
	}
	
	public function fetchRow(){
		$district_fetch = parent::fetchRow();
		$this->province_ID=$district_fetch['district_ID'];
		$this->district_name=$district_fetch['district_name'];
		$this->post=$district_fetch['post'];
		$this->prefecture_ID=$district_fetch['prefecture_ID'];
		return $district_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>