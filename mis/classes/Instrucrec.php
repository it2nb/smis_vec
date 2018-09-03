<?php
require_once 'Db_Table.php';
class Instrucrec extends Db_Table{
	public $instrucrec_ID;
	public $instrucrec_detail;
	public $instrucrec_date;
	public $teach_ID;
	public $teachday_ID;
	public $week;
	
	function __construct($dbconnecttion){
		$this->table = 'instrucrec';
		$this->ID = 'instrucrec_ID';
	}

	public function queryByTeachID($teach_ID){
		return parent::queryByFk('teach_ID',$teach_ID);
	}
	
	public function fetchRow(){
		$instrucrec_fetch = parent::fetchRow();
		$this->instrucrec_ID=$instrucrec_fetch['instrucrec_ID'];
		$this->instrucrec_detail=$instrucrec_fetch['instrucrec_detail'];
		$this->instrucrec_date=$instrucrec_fetch['instrucrec_date'];
		$this->teach_ID=$instrucrec_fetch['teach_ID'];
		$this->teachday_ID=$instrucrec_fetch['teachday_ID'];
		$this->week=$instrucrec_fetch['week'];
		return $instrucrec_fetch;
	}
	
	public function insertData($instrucrec_detail,$instrucrec_date,$teach_ID,$teachday_ID,$week){
		$fieldData_Array = array('instrucrec_detail'=>$instrucrec_detail,
								'instrucrec_date'=>$instrucrec_date,
								'teach_ID'=>$teach_ID,
								'teachday_ID'=>$teachday_ID,
								'week'=>$week);
		parent::insertData($fieldData_Array);
	}
	
}
?>