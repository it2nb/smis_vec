<?php
require_once 'Db_Table.php';
class Teachaffective extends Db_Table{
	public $teach_ID;
	public $affective_ID;
	public $score;
	function __construct($dbconnection){
		$this->table = 'teachaffective';
		$this->ID = 'teach_ID';
	}
	
	public function queryByID($teach_ID,$affective_ID){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID);
		parent::queryByMultiField($fieldData_Array);
		$this->fetchRow();
	}
	
	public function queryByTeachID($teach_ID){
		return parent::queryByFk('teach_ID',$teach_ID);
	}
	
	public function fetchRow(){
		$teachaffective_fetch = parent::fetchRow();
		$this->teach_ID=$teachaffective_fetch['teach_ID'];
		$this->affective_ID=$teachaffective_fetch['affective_ID'];
		$this->score=$teachaffective_fetch['score'];
		return $teachaffective_fetch;
	}
	
	public function insertData($teach_ID,$affective_ID,$score){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID,
								'score'=>$score);
		return parent::insertData($fieldData_Array);
	}
	
	public function sumScoreTeach($teach_ID){
		$this->queryBySql('Select sum(score) as sum_score From teachaffective Where teach_ID='.$teach_ID.' Group By teach_ID');
		$sum_score = $this->fetchRow();
		return $sum_score['sum_score'];
	}
	
	public function updateScore($teach_ID,$affective_ID,$score){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
		'affective_ID'=>$affective_ID);
		return parent::updateByMultiField('score',$score,$fieldData_Array);
	}
	
	public function deleteTeachAffective($teach_ID,$affective_ID){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
		'affective_ID'=>$affective_ID);
		return parent::deleteDataByMultiField($fieldData_Array);
	}
}
?>