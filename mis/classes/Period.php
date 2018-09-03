<?php
require_once 'Db_Table.php';
class Period extends Db_Table{
	public $period_term;
	public $period_year;
	public $period_start;
	public $period_end;
	
	function __construct($dbconnecttion){
		$this->table = 'period';
		$this->ID = '';
	}
	
	public function queryByID($period_term,$period_year){
		$fieldData_Array = array('period_term'=>$period_term,
								'period_year'=>$period_year);
		parent::queryByMultiField($fieldData_Array);
		$this->fetchRow();
	}
	
	public function fetchRow(){
		$period_fetch = parent::fetchRow();
		$this->period_term=$period_fetch['period_term'];
		$this->period_year=$period_fetch['period_year'];
		$this->period_start=$period_fetch['period_start'];
		$this->period_end=$period_fetch['period_end'];
		return $period_fetch;
	}
	
	public function insertData($period_term,$period_year,$period_start,$period_end){
		$fieldData_Array = array('period_term'=>$period_term,
								'period_year'=>$period_year,
								'period_start'=>$period_start,
								'period_end'=>$period_end);
		parent::insertData($fieldData_Array);
	}
}
?>