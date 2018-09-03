<?php
require_once 'Db_Table.php';
class Acttype extends Db_Table{
	public $acttype_ID;
	public $acttype_name;
	public $acttype_en;
	
	function __construct($dbconnecttion){
		$this->table = 'acttype';
		$this->ID = 'acttype_ID';
	}
	
	public function fetchRow(){
		$acttype_fetch = parent::fetchRow();
		$this->acttype_ID=$acttype_fetch['acttype_ID'];
		$this->acttype_name=$acttype_fetch['acttype_name'];
		$this->acttype_en=$acttype_fetch['acttype_en'];
		return $acttype_fetch;
	}
	
	public function insertData($acttype_name,$acttype_en){
		$fieldData_Array = array('acttype_name'=>$acttype_name,
								'acttype_en'=>$acttype_en);
		parent::insertData($fieldData_Array);
	}
}
?>