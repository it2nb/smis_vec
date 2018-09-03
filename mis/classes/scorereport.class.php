<?php
include_once 'Teach.php';
include_once 'Subject.php';
include_once 'Scoregroup.php';
include_once 'Personnel.php';
class Scorereport_class {
	private $teach;
	private $subject;
	private $scoregroup;
	private $personnel;
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $check_period;
	public $subject_ID;
	public $subject_name;
	public $subject_hourt;
	public $subject_hourp;
	public $subject_unit;
	public $personnel_name;
	public $personnel_ser;
	
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->scoregroup = new Scoregroup($dbconnecttion);
		$this->personnel = new Personnel($dbconnecttion);
		$this->teach_ID = $teach_ID;
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->teach_term = $this->teach->teach_term;
		$this->teach_year = $this->teach->teach_year;
		$this->check_period = $this->teach->teach_term.'/'.$this->teach->teach_year;
		$this->personnel->queryByID($this->teach->personnel_ID);
		$this->personnel_name = $this->personnel->personnel_name;
		$this->personnel_ser = $this->personnel->personnel_ser;
	}
	
	public function querySubject(){
		$this->queryTeach();
		$this->subject->queryByID($this->teach->subject_ID,$this->teach->course_ID);
		$this->subject_ID = $this->subject->subject_ID;
		$this->subject_name = $this->subject->subject_name;
		$this->subject_hourt = $this->subject->subject_hourt;
		$this->subject_hourp = $this->subject->subject_hourp;
		$this->subject_unit = $this->subject->subject_unit;
	}
	
	public function queryScoregroup(){
		return $this->scoregroup->queryBySql('Select * From scoregroup Where  scoregroup_name!="finalID'.$this->teach_ID.'" and scoregroup_name!="finalID'.(int)$this->teach_ID.'" and teach_ID='.$this->teach_ID.' Order By scoregroup_ID ASC');
	}
}
?>