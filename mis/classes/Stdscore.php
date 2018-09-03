<?php
require_once 'Db_Table.php';
class Stdscore extends Db_Table{
	public $stdscore_ID;
	public $stdscore_date;
	public $stdscore_score;
	public $scoredetail_ID;
	public $student_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'stdscore';
		$this->ID = 'stdscore_ID';
	}
	
	public function queryByAllFk($scoredetail_ID,$student_ID){
		$fielData_Array = array('scoredetail_ID'=>$scoredetail_ID,
								'student_ID'=>$student_ID);
		parent::queryByMultiField($fielData_Array);
	}
	
	public function queryByScoredetailID($scoredetail_ID){
		parent::queryByFk("scoredetail_ID",$scoredetail_ID);
	}
	
	public function queryByStudentID($student_ID){
		parent::queryByFk("student_ID",$student_ID);
	}
	
	public function sumScore($scoregroup_ID,$student_ID){
		//parent::queryBySql('Select sum(stdscore_score) as sumscore From stdscore Where scoredetail_ID="'.$scoredetail_ID.'" and student_ID="'.$student_ID.'"');
		//parent::queryBySql('Select sum(stdscore_score) as sumscore From stdscore Where scoredetail_ID="'.$scoredetail_ID.'" and student_ID="'.$student_ID.'"');
		parent::queryBySql('Select sum(stdscore_score) as sumscore From stdscore,scoredetail Where stdscore.scoredetail_ID=scoredetail.scoredetail_ID and student_ID="'.$student_ID.'" and scoregroup_ID="'.$scoregroup_ID.'"');
		$sumScore_fetch = parent::fetchRow();
		return $sumScore_fetch['sumscore'];
	}
	
	public function sumScoreByScoredetailID($scoredetail_ID){
		parent::queryBySql('Select sum(stdscore_score) as sumscore From stdscore Where scoredetail_ID="'.$scoredetail_ID.'"');
		$sumScore_fetch = parent::fetchRow();
		return $sumScore_fetch['sumscore'];
	}
	
	public function sumScoreByStudentID($student_ID){
		parent::queryBySql('Select sum(stdscore_score) as sumscore From stdscore Where student_ID="'.$student_ID.'"');
		$sumScore_fetch = parent::fetchRow();
		return $sumScore_fetch['sumscore'];
	}
	
	public function fetchRow(){
		$stdscore_fetch = parent::fetchRow();
		$this->stdscore_ID=$stdscore_fetch['stdscore_ID'];
		$this->stdscore_date=$stdscore_fetch['stdscore_date'];
		$this->stdscore_score=$stdscore_fetch['stdscore_score'];
		$this->scoredetail_ID=$stdscore_fetch['scoredetail_ID'];
		$this->student_ID=$stdscore_fetch['student_ID'];
		return $stdscore_fetch;
	}
	
	public function insertData($date,$score,$scoredetail_ID,$student_ID){
		$fieldData_Array = array('stdscore_date'=>$date,
								'stdscore_score'=>$score,
								'scoredetail_ID'=>$scoredetail_ID,
								'student_ID'=>$student_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updateDate($ID,$new_date){
		parent::updateData($ID,'stdscore_date',$new_date);
	}
	
	public function updateScore($ID,$new_score){
		parent::updateData($ID,'stdscore_score',$new_score);
	}
	
	public function updateScoreByFk($scoredetail_ID,$new_score){
		parent::updateDataByFk('scoredetail_ID',$scoredetail_ID,'stdscore_score',$new_score);
	}
	
	public function updateFkID($ID,$new_fkID){
		parent::updateData($ID,'scoredetail_ID',$new_fkID);
	}
	
	public function deleteByScoredetailID($scoredetail_ID){
		parent::deleteDataByField('scoredetail_ID',$scoredetail_ID);
	}
}
?>