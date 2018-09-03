<?php 
include_once 'Teach.php';
include_once 'Subject.php';
include_once 'Student.php';
include_once 'Classes.php';
include_once 'Personnel.php';
include_once 'Teachstd.php';

class Recordsummary_class {
	private $teach;
	private $subject;
	private $teachstd;
	private $classes;
	private $personnel;
	private $sumgrade;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $major_name;
	public $area_name;
	public $check_period;
	public $affective_score;
	public $personnel_ID;
	public $personnel_name;
	public $personnel_ser;
	public $subject_ID;
	public $subject_name;
	public $subject_hourt;
	public $subject_hourp;
	public $subject_unit;
	public $class_ID;
		
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->teachstd = new Teachstd($dbconnecttion);
		$this->classes = new Classes($dbconnecttion);
		$this->personnel = new Personnel($dbconnecttion);
		$this->sumgrade = new Teachstd($dbconnecttion);
		$this->teach_ID = $teach_ID;
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->teach_term = $this->teach->teach_term;
		$this->teach_year = $this->teach->teach_year;
		$this->check_period = $this->teach->teach_term.'/'.$this->teach->teach_year;
		$this->affective_score =$this->teach->affectscore;
		$this->personnel_ID = $this->teach->personnel_ID;
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
	
	public function queryPersonnel(){
		$this->personnel->queryByID($this->personnel_ID);
		$this->personnel_name = $this->personnel->personnel_name;
		$this->personnel_ser = $this->personnel->personnel_ser;
	}
	
	public function queryTeachStdClass(){
		return $this->teachstd->queryBySql('Select DISTINCT class_ID From teachstd Where teach_ID='.$this->teach_ID);
	}
	
	public function fetchTeachStdClass(){
		$teachstd_fetch = $this->teachstd->fetchRow();
		$this->class_ID = $this->teachstd->class_ID;
		$this->classes->queryByID($this->class_ID);
		$this->major_name = $this->classes->major_name;
		$this->area_name = $this->classes->area_name;
		return $teachstd_fetch;
	}
	
	public function sumGrade($grade){
		$sum = $this->sumgrade->sumGrade($this->teach_ID,$this->class_ID,$grade);
		if(!empty($sum))
			return $sum;
		else
			return 0;
	}
	
	public function countGrade(){
		$sum = $this->sumgrade->countGrade($this->teach_ID,$this->class_ID);
		if(!empty($sum))
			return $sum;
		else
			return 0;
	}
}
?>