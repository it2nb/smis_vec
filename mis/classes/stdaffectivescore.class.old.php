<?php
include_once 'Teach.php';
include_once 'Affective.php';
include_once 'Teachaffective.php';
include_once 'Stdaffective.php';
include_once 'Subject.php';
include_once 'Student.php';
class Stdaffectivescore_class {
	private $teach;
	private $subject;
	private $affective;
	private $teachaffective;
	protected $student;
	private $stdaffective;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $check_period;
	public $affective_score;
	public $personnel_ID;
	public $subject_ID;
	public $subject_name;
	public $subject_hourt;
	public $subject_hourp;
	public $subject_unit;
	public $affective_ID;
	public $affective_name;
	public $teachaffective_score;
	public $student_ID;
	public $student_name;
	public $student_ser;
	public $stdaffective_score;
	
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->affective = new Affective($dbconnecttion);
		$this->teachaffective = new Teachaffective($dbconnecttion);
		$this->student = new Student($dbconnecttion);
		$this->stdaffective = new Stdaffective($dbconnecttion);
		$this->teach_ID = $teach_ID;
		$this->init();
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->teach_term = $this->teach->teach_term;
		$this->teach_year = $this->teach->teach_year;
		$this->check_period = $this->teach->teach_term.'/'.$this->teach->teach_year;
		$this->affective_score =$this->teach->affectscore;
		$this->personnel_ID = $this->teach->personnel_ID;
	}
	
	public function init(){
		$this->teachaffective->queryByTeachID($this->teach_ID);
		if($this->teachaffective->countRow()<=0){
			$this->affective->queryBySql('Select * From affective Where affective_en=1');
			while($this->affective->fetchRow()){
				$this->teachaffective->insertData($this->teach_ID,$this->affective->affective_ID,2);
			}
		}
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
	
	public function queryTeachaffective(){
		return $this->teachaffective->queryByTeachID($this->teach_ID);
	}
	
	public function getTeacaffectiveQty(){
		$this->queryTeachaffective();
		return $this->teachaffective->countRow();
	}
	
	public function fetchTeachaffective(){
		$teachaffective_fetch = $this->teachaffective->fetchRow();
		$this->affective->queryByID($this->teachaffective->affective_ID);
		$this->affective_ID = $this->affective->affective_ID;
		$this->affective_name = $this->affective->affective_name;
		$this->teachaffective_score = $this->teachaffective->score;
		return $teachaffective_fetch;
	}
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From student,teachstd Where student.student_ID=teachstd.student_ID and student.student_endstatus=0 and teachstd.teach_ID='.$this->teach_ID);
	}
	
	public function fetchStudent(){
		$student_fetch = $this->student->fetchRow();
		$this->student_ID = $this->student->student_ID;
		$this->student_name = $this->student->student_name;
		$this->student_ser = $this->student->student_ser;
		return $student_fetch;
	}
	
	public function queryStudentaffective(){
		//$stdaffective_fetch = $this->stdaffective->queryByTeachID($this->teach_ID);
		$stdaffective_fetch = $this->stdaffective->queryByID($this->student_ID,$this->teach_ID,$this->affective_ID);
		$this->stdaffective_score = $this->stdaffective->score;
		return $stdaffective_fetch;
	}
	
	public function getSumScore(){
		$sum_stdaffective = $this->stdaffective->sumAffectiveStdTeach($this->student_ID,$this->teach_ID);
		$sum_teachaffectvie = $this->teachaffective->sumScoreTeach($this->teach_ID);
		return round(($sum_stdaffective*$this->affective_score)/$sum_teachaffectvie,0);
	}
	
	public function addStudentAffective($score){
		$this->queryStudent();
		while($this->fetchStudent()){
			$this->queryTeachaffective();
			while($this->fetchTeachaffective()){	
				$this->stdaffective->queryByID($this->student_ID,$this->teach_ID,$this->affective_ID);
				if($this->stdaffective->countRow()<=0){
					$this->stdaffective->insertData($this->student_ID,$this->teach_ID,$this->affective_ID,$score[$this->student_ID][$this->affective_ID]);
				}
				else{
					$this->stdaffective->updateScore($this->student_ID,$this->teach_ID,$this->affective_ID,$score[$this->student_ID][$this->affective_ID]);
				}
			}
		}		
	}
}
?>