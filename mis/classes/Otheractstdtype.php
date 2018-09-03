<?php
require_once 'Db_Table.php';
class Otheractstdtype extends Db_Table{
	public $acttype_ID;
	public $otheractstd_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'otheractstdtype';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$otheractstdtype_fetch = parent::fetchRow();
		$this->acttype_ID=$otheractstdtype_fetch['acttype_ID'];
		$this->otheractstd_ID=$otheractstdtype_fetch['otheractstd_ID'];
		return $otheractstdtype_fetch;
	}
	
	public function insertData($acttype_ID,$otheractstd_ID){
		$fieldData_Array = array('acttype_ID'=>$acttype_ID,
								'otheractstd_ID'=>$otheractstd_ID);
		parent::insertData($fieldData_Array);
	}
}
?>