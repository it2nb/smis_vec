<?php
require_once 'Db_Table.php';
class Stdtoleave extends Db_Table{
	public $stdtoleave_ID;
    public $stdtoleave_term;
    public $stdtoleave_year;
	public $stdtoleave_date;
	public $stdtoleave_leavetime;
	public $stdtoleave_leavecomment;
    public $stdtoleave_cometime;
    public $stdtoleave_comecomment;
	public $student_ID;
	public $personnel_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'stdtoleave';
		$this->ID = 'stdtoleave_ID';
	}

	public function queryBystudentID($student_ID){
		return parent::queryByFk('student_ID',$student_ID);
	}
	
	public function queryBypersonnelID($personnel_ID){
		return parent::queryByFk('personnel_ID',$personnel_ID);
	}
    
    public function queryByDate($date){
        return parent::queryByFk('stdtoleave_date',$date);
    }
    
    
	public function fetchRow(){
		$stdtoleave_fetch = parent::fetchRow();
		$this->stdtoleave_ID=$stdtoleave_fetch['stdtoleave_ID'];
        $this->stdtoleave_term=$stdtoleave_fetch['stdtoleave_term'];
        $this->stdtoleave_year=$stdtoleave_fetch['stdtoleave_year'];
		$this->stdtoleave_date=$stdtoleave_fetch['stdtoleave_date'];
		$this->stdtoleave_leavetime=$stdtoleave_fetch['stdtoleave_leavetime'];
		$this->stdtoleave_leavecomment=$stdtoleave_fetch['stdtoleave_leavecomment'];
        $this->stdtoleave_cometime=$stdtoleave_fetch['stdtoleave_cometime'];
        $this->stdtoleave_comecomment=$stdtoleave_fetch['stdtoleave_comecomment'];
		$this->student_ID=$stdtoleave_fetch['student_ID'];
		$this->personnel_ID=$stdtoleave_fetch['personnel_ID'];
		return $stdtoleave_fetch;
	}
	
	public function insertData($stdtoleave_term,$stdtoleave_year,$stdtoleave_date,$stdtoleave_leavetime,$stdtoleave_leavecomment,$stdtoleave_cometime,$stdtoleave_comecomment,$student_ID,$personnel_ID){
		$fieldData_Array = array('stdtoleave_term'=>$stdtoleave_term,
                                'stdtoleave_year'=>$stdtoleave_year,
                                'stdtoleave_date'=>$stdtoleave_date,
								'stdtoleave_leavetime'=>$stdtoleave_leavetime,
								'stdtoleave_leavecomment'=>$stdtoleave_leavecomment,
                                'stdtoleave_cometime'=>$stdtoleave_cometime,
                                'stdtoleave_comecomment'=>$stdtoleave_comecomment,
								'student_ID'=>$student_ID,
								'personnel_ID'=>$personnel_ID);
		parent::insertData($fieldData_Array);
	}
	
}
?>