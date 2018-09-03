<?php
require_once 'Db_Table.php';
class Scoredetail extends Db_Table{
	public $scoredetail_ID;
	public $scoredetail_name;
	public $scoredetail_score;
	public $scoregroup_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'scoredetail';
		$this->ID = 'scoredetail_ID';
	}
	
	public function queryByScoregroupID($scoregroup_ID){
		parent::queryByFk("scoregroup_ID",$scoregroup_ID);
	}
	public function sumScore($scoregroup_ID){
		parent::queryBySql('Select sum(scoredetail_score) as sumscore From scoredetail Where scoregroup_ID="'.$scoregroup_ID.'"');
		$sumScore_fetch = parent::fetchRow();
		return $sumScore_fetch['sumscore'];
	}
	
	public function fetchRow(){
		$scoredetail_fetch = parent::fetchRow();
		$this->scoredetail_ID=$scoredetail_fetch['scoredetail_ID'];
		$this->scoredetail_name=$scoredetail_fetch['scoredetail_name'];
		$this->scoredetail_score=$scoredetail_fetch['scoredetail_score'];
		$this->scoregroup_ID=$scoredetail_fetch['scoregroup_ID'];
		return $scoredetail_fetch;
	}
	
	public function insertData($name,$score,$scoregroup_ID){
		$fieldData_Array = array('scoredetail_name'=>$name,
								'scoredetail_score'=>$score,
								'scoregroup_ID'=>$scoregroup_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updateName($ID,$new_name){
		parent::updateData($ID,'scoredetail_name',$new_name);
	}
	
	public function updateScore($ID,$new_score){
		parent::updateData($ID,'scoredetail_score',$new_score);
	}
	
	public function updateScoreByFk($scoregroup_ID,$new_score){
		parent::updateDataByFk('scoregroup_ID',$scoregroup_ID,'scoredetail_score',$new_score);
	}
	
	public function updateFkID($ID,$new_fkID){
		parent::updateData($ID,'scoregroup_ID',$new_fkID);
	}
	
	public function deleteByScoregroupID($scoregroup_ID){
		$this->deleteDataByField('scoregroup_ID',$scoregroup_ID);
	}
}
?>