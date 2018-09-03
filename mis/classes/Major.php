<?php
require_once 'Db_Table.php';
class Major extends Db_Table{
	public $major_ID;
	public $major_name;
	public $area_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'major';
		$this->ID = 'major_ID';
	}
	
	public function queryByAreaID($area_ID){
		return parent::queryByFk('area_ID',$area_ID);
	}
	public function fetchRow(){
		$major_fetch = parent::fetchRow();
		$this->major_ID=$major_fetch['major_ID'];
		$this->major_name=$major_fetch['major_name'];
		$this->area_ID=$major_fetch['area_ID'];
		return $major_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
}
?>