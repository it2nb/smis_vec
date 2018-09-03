<?php
require_once 'Db_Table.php';
class Authority extends Db_Table{
	public $authority_ID;
	public $authority_name;
	public $authority_dest;
	public $authority_en;
	public $party_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'authority';
		$this->ID = 'authority_ID';
	}
	
	public function fetchRow(){
		$authority_fetch = parent::fetchRow();
		$this->authority_ID=$authority_fetch['authority_ID'];
		$this->authority_name=$authority_fetch['authority_name'];
		$this->authority_dest=$authority_fetch['authority_dest'];
		$this->authority_en=$authority_fetch['authority_en'];
		$this->party_ID=$authority_fetch['party_ID'];
		return $authority_fetch;
	}
	
	public function insertData($authority_name,$authority_dest,$authority_en,$party_ID){
		$fieldData_Array = array('authority_name'=>$authority_name,
								'authority_dest'=>$authority_dest,
								'authority_en'=>$authority_en,
								'party_ID'=>$party_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updateName($authority_ID,$new_name){
		parent::updateData($authority_ID,'authority_name',$new_name);
	}
	
	public function updateDescription($authority_ID,$new_des){
		parent::updateData($authority_ID,'authority_dest',$new_des);
	}
	
	public function updateEnable($authority_ID,$new_en){
		parent::updateData($authority_ID,'authority_en',$new_en);
	}
	
	public function updatePartyID($authority_ID,$new_partyID){
		parent::updateData($authority_ID,'party_ID',$new_partyID);
	}

}
?>