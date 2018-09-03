<?php
require_once 'Db_Table.php';
class Subject extends Db_Table{
	public $subject_ID;
	public $subject_name;
	public $subject_obj;
	public $subject_std;
	public $subject_pfm;
	public $subject_des;
	public $subject_hourt;
	public $subject_hourp;
	public $subject_unit;
	public $course_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'subject';
		$this->ID = 'subject_ID';
	}
	
	public function queryByID($subject_ID,$course_ID){
		$fieldData_Array = array('subject_ID'=>$subject_ID,
									'course_ID'=>$course_ID);
		parent::queryByMultiField($fieldData_Array);
		$this->fetchRow();
	}
	
	public function queryByCourseID($course_ID){
		return parent::queryByFk('course_ID',$course_ID);
	}
	
	public function fetchRow(){
		$subject_fetch = parent::fetchRow();
		$this->subject_ID=$subject_fetch['subject_ID'];
		$this->subject_name=$subject_fetch['subject_name'];
		$this->subject_obj=$subject_fetch['subject_obj'];
		$this->subject_std=$subject_fetch['subject_std'];
		$this->subject_pfm=$subject_fetch['subject_pfm'];
		$this->subject_des=$subject_fetch['subject_des'];
		$this->subject_hourt=$subject_fetch['subject_hourt'];
		$this->subject_hourp=$subject_fetch['subject_hourp'];
		$this->subject_unit=$subject_fetch['subject_unit'];
		$this->course_ID=$subject_fetch['course_ID'];
		return $subject_fetch;
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