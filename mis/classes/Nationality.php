<?php
require_once 'Db_Table.php';
class Nationality extends Db_Table{
	public $nationality_ID;
	public $nationality_name;
	
	function __construct($dbconnecttion){
		$this->table = 'nationality';
		$this->ID = 'nationality_ID';
	}
	
	public function fetchRow(){
		$nationality_fetch = parent::fetchRow();
		$this->nationality_ID=$nationality_fetch['nationality_ID'];
		$this->nationality_name=$nationality_fetch['nationality_name'];
		return $nationality_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>