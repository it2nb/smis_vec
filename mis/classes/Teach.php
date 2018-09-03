<?php
require_once 'Db_Table.php';
class Teach extends Db_Table{
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $personnel_ID;
	public $subject_ID;
	public $course_ID;
	public $teach_group;
	public $splan_ID;
	public $scoregroup_ID;
	public $affectscore;
	public $teach_hour;
	function __construct($dbconnecttion){
		$this->table = 'teach';
		$this->ID = 'teach_ID';
	}
	
	public function queryByScoregroupID($scoregroup_ID){
		parent::queryByFk('scoregroup_ID',$scoregroup_ID);
	}
	
	public function fetchRow(){
		$teach_fetch = parent::fetchRow();
		$this->teach_ID=$teach_fetch['teach_ID'];
		$this->teach_term=$teach_fetch['teach_term'];
		$this->teach_year=$teach_fetch['teach_year'];
		$this->personnel_ID=$teach_fetch['personnel_ID'];
		$this->subject_ID=$teach_fetch['subject_ID'];
		$this->course_ID=$teach_fetch['course_ID'];
		$this->splan_ID=$teach_fetch['splan_ID'];
		$this->scoregroup_ID=$teach_fetch['scoregroup_ID'];
		$this->affectscore=$teach_fetch['affectscore'];
		$this->teach_hour=$teach_fetch['teach_hour'];
		return $teach_fetch;
	}
	
	//public function insertData($name,$detail,$en){
		//$fieldData_Array = array('affective_name'=>$name,
								//'affective_detail'=>$detail,
								//'affective_en'=>$en);
		//parent::insertData($fieldData_Array);
	//}
	
	public function updateAffectscore($ID,$new_score){
		parent::updateData($ID,'affectscore',$new_score);
	}
	
	public function updateScoregroupID($ID,$new_scoregroupID){
		parent::updateData($ID,'scoregroup_ID',$new_scoregroupID);
	}
}
?>