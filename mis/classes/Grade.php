<?php
require_once 'Db_Table.php';
class Grade extends Db_Table{
	public $code;
	public $semes;
	public $tcode;
	public $level;
	public $tsubject;
	public $credit;
	
	function __construct(){
		$this->table = 'grade';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$grade_fetch = parent::fetchRow();
		$this->code=$grade_fetch['code'];
		$this->semes=$grade_fetch['semes'];
		$this->tcode=$grade_fetch['tcode'];
		$this->level=$grade_fetch['level'];
		$this->tsubject=$grade_fetch['tsubject'];
		$this->credit=$grade_fetch['credit'];
		return $grade_fetch;
	}
	
	/*public function insertData($name,$detail,$en){
		$fieldData_Array = array('affective_name'=>$name,
								'affective_detail'=>$detail,
								'affective_en'=>$en);
		parent::insertData($fieldData_Array);
	}*/
}
?>