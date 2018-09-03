<?php
require_once 'Db_Table.php';
class Scoregroup extends Db_Table{
	public $scoregroup_ID;
	public $scoregroup_name;
	public $scoregroup_score;
	public $teach_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'scoregroup';
		$this->ID = 'scoregroup_ID';
	}
	
	public function queryByTeachID($teach_ID){
		return parent::queryByFk("teach_ID",$teach_ID);
	}
	
	public function sumScore($teach_ID){
		parent::queryBySql('Select sum(scoregroup_score) as sumscore From scoregroup Where teach_ID="'.$teach_ID.'"');
		$sumScore_fetch = parent::fetchRow();
		return $sumScore_fetch['sumscore'];
	}
	
	public function fetchRow(){
		$scoregroup_fetch = parent::fetchRow();
		$this->scoregroup_ID=$scoregroup_fetch['scoregroup_ID'];
		$this->scoregroup_name=$scoregroup_fetch['scoregroup_name'];
		$this->scoregroup_score=$scoregroup_fetch['scoregroup_score'];
		$this->teach_ID=$scoregroup_fetch['teach_ID'];
		return $scoregroup_fetch;
	}
	
	public function insertData($name,$score,$teach_ID){
		$fieldData_Array = array('scoregroup_name'=>$name,
								'scoregroup_score'=>$score,
								'teach_ID'=>$teach_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updateName($ID,$new_name){
		parent::updateData($ID,'scoregroup_name',$new_name);
	}
	
	public function updateScore($ID,$new_score){
		parent::updateData($ID,'scoregroup_score',$new_score);
	}
	
	public function updateFkID($ID,$new_teachID){
		parent::updateData($ID,'teach_ID',$new_teachID);
	}
}
?>