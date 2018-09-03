<?php
require_once 'Db_Table.php';
class Centralact extends Db_Table{
	public $centralact_ID;
	public $centralact_name;
	public $centralact_detail;
	public $centralact_year;
	public $centralact_term;
	public $centralact_startdate;
	public $centralact_enddate;
	public $centralact_place;
	
	function __construct($dbconnecttion){
		$this->table = 'centralact';
		$this->ID = 'centralact_ID';
	}
	
	public function fetchRow(){
		$centralact_fetch = parent::fetchRow();
		$this->centralact_ID=$centralact_fetch['centralact_ID'];
		$this->centralact_name=$centralact_fetch['centralact_name'];
		$this->centralact_detail=$centralact_fetch['centralact_detail'];
		$this->centralact_year=$centralact_fetch['centralact_year'];
		$this->centralact_term=$centralact_fetch['centralact_term'];
		$this->centralact_startdate=$centralact_fetch['centralact_startdate'];
		$this->centralact_enddate=$centralact_fetch['centralact_enddate'];
		$this->centralact_place=$centralact_fetch['centralact_place'];
		return $centralact_fetch;
	}
	
	public function insertData($centralact_name,$centralact_detail,$centralact_year,$centralact_term,$centralact_startdate,$centralact_enddate,$centralact_place){
		$fieldData_Array = array('centralact_name'=>$centralact_name,
								'centralact_detail'=>$centralact_detail,
								'centralact_year'=>$centralact_year,
								'centralact_term'=>$centralact_term,
								'centralact_startdate'=>$centralact_startdate,
								'centralact_enddate'=>$centralact_enddate,
								'centralact_place'=>$centralact_place);
		parent::insertData($fieldData_Array);
	}
}
?>