<?php
require_once 'Db_Table.php';
class Centralacttype extends Db_Table{
	public $acttype_ID;
	public $centralact_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'centralacttype';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$centralacttype_fetch = parent::fetchRow();
		$this->acttype_ID=$centralacttype_fetch['acttype_ID'];
		$this->centralact_ID=$centralacttype_fetch['centralact_ID'];
		return $centralacttype_fetch;
	}
	
	public function insertData($acttype_ID,$centralact_ID){
		$fieldData_Array = array('acttype_ID'=>$acttype_ID,
								'centralact_ID'=>$centralact_ID);
		parent::insertData($fieldData_Array);
	}
}
?>