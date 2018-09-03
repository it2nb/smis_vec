<?php
require_once 'Db_Table.php';
class Centralacttchcheck extends Db_Table{
	public $centralact_ID;
	public $personnel_ID;
	public $centralacttchcheck_status;
	public $centralacttchcheck_date;
	public $personnel_ID_boss;
	
	function __construct($dbconnecttion){
		$this->table = 'centralacttchcheck';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$centralacttchcheck_fetch = parent::fetchRow();
		$this->centralact_ID=$centralacttchcheck_fetch['centralact_ID'];
		$this->personnel_ID=$centralacttchcheck_fetch['personnel_ID'];
		$this->centralactstdcheck_status=$centralacttchcheck_fetch['centralacttchcheck_status'];
		$this->centralactstdcheck_date=$centralacttchcheck_fetch['centralacttchcheck_date'];
		$this->personnel_ID_boss=$centralacttchcheck_fetch['personnel_ID_boss'];
		return $centralacttchcheck_fetch;
	}
	
	public function insertData($centralact_ID,$personnel_ID,$centralacttchcheck_status,$centralacttchcheck_date,$personnel_ID_boss){
		$fieldData_Array = array('centralact_ID'=>$centralact_ID,
								'personnel_ID'=>$personnel_ID,
								'centralacttchcheck_status'=>$centralacttchcheck_status,
								'centralacttchcheck_date'=>$centralacttchcheck_date,
								'personnel_ID_boss'=>$personnel_ID_boss);
		parent::insertData($fieldData_Array);
	}
}
?>