<?php
require_once 'Db_Table.php';
class Userlogs extends Db_Table{
	public $userlogs_ID;
	public $member_ID;
	public $userlogs_action;
	public $userlogs_system;
	public $userlogs_datetime;
	public $userlogs_des;
	
	function __construct($dbconnecttion){
		$this->table = 'userlogs';
		$this->ID = 'userlogs_ID';
	}
	
	public function queryByMemberID($member_ID){
		parent::queryByFk("member_ID",$member_ID);
	}
	
	public function fetchRow(){
		$userlogs_fetch = parent::fetchRow();
		$this->userlogs_ID=$userlogs_fetch['userlogs_ID'];
		$this->member_ID=$userlogs_fetch['member_ID'];
		$this->userlogs_action=$userlogs_fetch['userlogs_action'];
		$this->userlogs_system=$userlogs_fetch['userlogs_system'];
		$this->userlogs_datetime=$userlogs_fetch['userlogs_datetime'];
		$this->userlogs_des=$userlogs_fetch['userlogs_des'];
		return $userlogs_fetch;
	}
	
	public function insertData($member_ID,$action,$system,$des){
		$fieldData_Array = array('member_ID'=>$member_ID,
								'userlogs_action'=>$action,
								'userlogs_system'=>$system,
								'userlogs_des'=>$des);
		parent::insertData($fieldData_Array);
	}
}
?>