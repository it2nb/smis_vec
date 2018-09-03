<?php
require_once 'Db_Table.php';
class Party extends Db_Table{
	public $party_ID;
	public $party_name;
	public $party_des;
	public $party_level;
	public $party_en;
	
	function __construct($dbconnecttion){
		$this->table = 'party';
		$this->ID = 'party_ID';
	}
	
	public function fetchRow(){
		$party_fetch = parent::fetchRow();
		$this->party_ID=$party_fetch['party_ID'];
		$this->party_name=$party_fetch['party_name'];
		$this->party_des=$party_fetch['party_des'];
		$this->party_level=$party_fetch['party_level'];
		$this->party_en=$party_fetch['party_en'];
		return $party_fetch;
	}
	
	public function insertData($party_name,$party_des,$party_level,$party_en){
		$fieldData_Array = array('party_name'=>$party_name,
								'party_des'=>$party_des,
								'party_level'=>$party_level,
								'party_en'=>$party_en);
		parent::insertData($fieldData_Array);
	}
	
	public function updateName($party_ID,$new_name){
		parent::updateData($party_ID,'party_name',$new_name);
	}
	
	public function updateDescription($party_ID,$new_des){
		parent::updateData($party_ID,'party_des',$new_des);
	}
	
	public function updateLevel($party_ID,$new_level){
		parent::updateData($party_ID,'party_level',$new_level);
	}
	
	public function updateEnable($party_ID,$new_en){
		parent::updateData($party_ID,'party_en',$new_en);
	}

}
?>