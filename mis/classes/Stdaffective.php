<?php
require_once 'Db_Table.php';
class Stdaffective extends Db_Table{
	public $student_ID;
	public $teach_ID;
	public $affective_ID;
	public $score;
	function __construct($dbconnection){
		$this->table = 'stdaffective';
		$this->ID = 'student_ID';
	}
	
	public function queryByID($student_ID,$teach_ID,$affective_ID){
		$fieldData_Array = array('student_ID'=>$student_ID,
								'teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID);
		parent::queryByMultiField($fieldData_Array);
		$this->fetchRow();
	}
	
	public function queryByTeachID($teach_ID){
		return parent::queryByFk('teach_ID',$teach_ID);
	}
	
	public function fetchRow(){
		$stdaffective_fetch = parent::fetchRow();
		$this->student_ID=$stdaffective_fetch['student_ID'];
		$this->teach_ID=$stdaffective_fetch['teach_ID'];
		$this->affective_ID=$stdaffective_fetch['affective_ID'];
		$this->score=$stdaffective_fetch['score'];
		return $stdaffective_fetch;
	}
	
	public function insertData($student_ID,$teach_ID,$affective_ID,$score){
		$fieldData_Array = array('student_ID'=>$student_ID,
								'teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID,
								'score'=>$score);
		return parent::insertData($fieldData_Array);
	}
	
	public function updateScore($student_ID,$teach_ID,$affective_ID,$score){
		$fieldData_Array = array('student_ID'=>$student_ID,
								'teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID);
		return parent::updateByMultiField('score',$score,$fieldData_Array);
	}
	
	public function deleteStdAffective($teach_ID,$affective_ID){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID);
		return parent::deleteDataByMultiField($fieldData_Array);
	}
	
	public function sumAffectiveStdTeach($student_ID,$teach_ID){
		$this->queryBySql('Select sum(score) as sum_score From stdaffective Where student_ID='.$student_ID.' and teach_ID='.$teach_ID.' Group By student_ID,teach_ID');
		$sum_score = $this->fetchRow();
		return $sum_score['sum_score'];		
	}
}
?>