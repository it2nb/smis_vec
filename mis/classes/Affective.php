<?php
require_once 'Db_Table.php';
class Affective extends Db_Table{
	public $affective_ID;
	public $affective_name;
	public $affective_detail;
	public $affective_en;
	public $a = '{"a":2}';
	function __construct(){
		$this->table = 'affective';
		$this->ID = 'affective_ID';
	}
	
	public function queryAllByEnable(){
		return parent::queryByFk('affective_en',1);
	}
	
	public function fetchRow(){
		$affective_fetch = parent::fetchRow();
		$this->affective_ID=$affective_fetch['affective_ID'];
		$this->affective_name=$affective_fetch['affective_name'];
		$this->affective_detail=$affective_fetch['affective_detail'];
		$this->affective_en=$affective_fetch['affective_en'];
		return $affective_fetch;
	}
	
	public function insertData($name,$detail,$en){
		$fieldData_Array = array('affective_name'=>$name,
								'affective_detail'=>$detail,
								'affective_en'=>$en);
		parent::insertData($fieldData_Array);
	}
	
	public function updateName($ID,$new_name){
		parent::updateData($ID,'affective_name',$new_name);
	}
	
	public function updateDetail($ID,$new_detail){
		parent::updateData($ID,'affective_detail',$new_detail);
	}
	
	public function updateEn($ID,$new_en){
		parent::updateData($ID,'affective_en',$new_en);
	}
	
	public function toggleEn($ID){
		parent::queryByID($ID);
		if($this->affective_en==1)
			parent::updateData($ID,'affective_en',0);
		else
			parent::updateData($ID,'affective_en',1);
	}
}
?>