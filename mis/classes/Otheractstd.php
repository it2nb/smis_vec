<?php
require_once 'Db_Table.php';
class Otheractstd extends Db_Table{
	public $otheractstd_ID;
	public $otheractstd_name;
	public $otheractstd_detail;
	public $otheractstd_year;
	public $otheractstd_term;
	public $otheractstd_startdate;
	public $otheractstd_enddate;
	public $otheractstd_place;
	public $otheractstd_files;
	public $otheractstd_images;
	public $student_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'otheractstd';
		$this->ID = 'otheractstd_ID';
	}
	
	public function fetchRow(){
		$otheractstd_fetch = parent::fetchRow();
		$this->otheractstd_ID=$otheractstd_fetch['otheractstd_ID'];
		$this->otheractstd_name=$otheractstd_fetch['otheractstd_name'];
		$this->otheractstd_detail=$otheractstd_fetch['otheractstd_detail'];
		$this->otheractstd_year=$otheractstd_fetch['otheractstd_year'];
		$this->otheractstd_term=$otheractstd_fetch['otheractstd_term'];
		$this->otheractstd_startdate=$otheractstd_fetch['otheractstd_startdate'];
		$this->otheractstd_enddate=$otheractstd_fetch['otheractstd_enddate'];
		$this->otheractstd_place=$otheractstd_fetch['otheractstd_place'];
		$this->otheractstd_files=$otheractstd_fetch['otheractstd_files'];
		$this->otheractstd_images=$otheractstd_fetch['otheractstd_images'];
		$this->student_ID=$otheractstd_fetch['student_ID'];
		return $otheractstd_fetch;
	}
	
	public function insertData($otheractstd_name,$otheractstd_detail,$otheractstd_year,$otheractstd_term,$otheractstd_startdate,$otheractstd_enddate,$otheractstd_place,$otheractstd_files,$otheractstd_images,$student_ID){
		$fieldData_Array = array('otheractstd_name'=>$otheractstd_name,
								'otheractstd_detail'=>$otheractstd_detail,
								'otheractstd_year'=>$otheractstd_year,
								'otheractstd_term'=>$otheractstd_term,
								'otheractstd_startdate'=>$otheractstd_startdate,
								'otheractstd_enddate'=>$otheractstd_enddate,
								'otheractstd_place'=>$otheractstd_place,
								'otheractstd_files'=>$otheractstd_files,
								'otheractstd_images'=>$otheractstd_images,
								'student_ID'=>$student_ID);
		parent::insertData($fieldData_Array);
	}
}
?>