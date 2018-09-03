<?php
require_once 'Db_Table.php';
class Area extends Db_Table{
	public $area_ID;
	public $area_name;
	public $area_level;
	
	function __construct($dbconnecttion){
		$this->table = 'area';
		$this->ID = 'area_ID';
	}
	
	public function fetchRow(){
		$area_fetch = parent::fetchRow();
		$this->area_ID=$area_fetch['area_ID'];
		$this->area_name=$area_fetch['area_name'];
		$this->area_level=$area_fetch['area_level'];
		return $area_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>