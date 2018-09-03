<?php
require_once 'Db_Table.php';
class Personnelsign extends Db_Table{
	public $personnel_ID;
	public $personnel_signature;
	
	function __construct($dbconnecttion){
		$this->table = 'personnelsign';
		$this->ID = 'personnel_ID';
	}
	
	public function fetchRow(){
		$personnelsign_fetch = parent::fetchRow();
		$this->personnel_ID=$personnelsign_fetch['personnel_ID'];
		$this->personnel_signature=$personnelsign_fetch['personnel_signature'];
		return $personnelsign_fetch;
	}
	
	public function insertData($personnel_ID,$personnel_signature){
		$fieldData_Array = array('personnel_ID'=>$personnel_ID,
								'personnel_signature'=>$personnel_signature);
		parent::insertData($fieldData_Array);
	}
}
?>