<?php
require_once 'Db_Table.php';
class Persauthority extends Db_Table{
	public $persauthority_ID;
	public $persauthority_term;
	public $persauthority_year;
	public $persauthority_level;
    public $persauthority_des;
    public $persauthority_en;
    public $authority_ID;
    public $personnel_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'persauthority';
		$this->ID = 'persauthority_ID';
	}
	
	public function fetchRow(){
		$persauthority_fetch = parent::fetchRow();
		$this->persauthority_ID=$persauthority_fetch['persauthority_ID'];
		$this->persauthority_term=$persauthority_fetch['persauthority_term'];
		$this->persauthority_year=$persauthority_fetch['persauthority_year'];
        $this->persauthority_level=$persauthority_fetch['persauthority_level'];
        $this->persauthority_des=$persauthority_fetch['persauthority_des'];
        $this->persauthority_en=$persauthority_fetch['persauthority_en'];
        $this->authority_ID=$persauthority_fetch['authority_ID'];
		$this->personnel_ID=$persauthority_fetch['personnel_ID'];
		return $persauthority_fetch;
	}
	
	public function insertData($persauthority_term,$persauthority_year,$persauthority_level,$persauthority_des,$persauthority_en,$authority_ID,$personnel_ID){
		$fieldData_Array = array('persauthority_term'=>$persauthority_term,
								'persauthority_year'=>$persauthority_year,
								'persauthority_level'=>$persauthority_level,
								'persauthority_des'=>$persauthority_des,
								'persauthority_en'=>$persauthority_en,
								'authority_ID'=>$authority_ID,
								'personnel_ID'=>$personnel_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updateEnable($persauthority_ID,$new_en){
        parent::updateData($persauthority_ID,'persauthority_en',$new_en);
    }
}
?>