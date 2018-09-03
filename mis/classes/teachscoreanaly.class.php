<?php 
include_once 'Teach.php';
include_once 'Subject.php';
include_once 'Student.php';
include_once 'Scoredetail.php';
include_once 'Scoregroup.php';
include_once '../classes/Stdscore.php';
include_once '../classes/Teachstd.php';

class Teachscoreanaly_class {
	private $teach;
	private $subject;
	private $student;
	private $scoredetail;
	private $scoregroup;
	private $stdscore;
	private $teachstd;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $check_period;
	public $personnel_ID;
	public $subject_ID;
	public $subject_name;
	public $subject_hourt;
	public $subject_hourp;
	public $subject_unit;
	public $student_ID;
	public $student_name;
	public $student_ser;
	public $student_grade;
	public $scoregroup_ID;
	public $scoregroup_name;
	public $scoregroup_score;
	public $scoredetail_ID;
	public $scoredetail_name;
	public $scoredetail_score;
	public $teachfinal_score;
	public $teachpoint_score;
		
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->student = new Student($dbconnecttion);
		$this->scoredetail = new Scoredetail($dbconnecttion);
		$this->scoregroup = new Scoregroup($dbconnecttion);
		$this->stdscore = new Stdscore($dbconnecttion);
		$this->teachstd = new Teachstd($dbconnecttion);
		$this->teach_ID = $teach_ID;
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->teach_term = $this->teach->teach_term;
		$this->teach_year = $this->teach->teach_year;
		$this->check_period = $this->teach->teach_term.'/'.$this->teach->teach_year;
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
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From student,teachstd Where student.student_ID=teachstd.student_ID and student.student_endstatus=0 and teachstd.teach_ID='.$this->teach_ID);
	}
	
	public function fetchStudent(){
		$student_fetch = $this->student->fetchRow();
		$this->student_ID = $this->student->student_ID;
		$this->student_name = $this->student->student_name;
		$this->student_ser = $this->student->student_ser;
		$this->student_grade = $student_fetch['grade'];
		return $student_fetch;
	}

	
	public function queryScoregroup(){
		return $this->scoregroup->queryBySql('Select * From scoregroup Where teach_ID="'.$this->teach_ID.'" and scoregroup_ID!=(Select scoregroup_ID From teach Where teach_ID="'.$this->teach_ID.'")');
	}
	
	public function fetchScoregroup(){
		$scoregroup_fetch = $this->scoregroup->fetchRow();
		$this->scoregroup_ID = $this->scoregroup->scoregroup_ID;
		$this->scoregroup_name = $this->scoregroup->scoregroup_name;
		$this->scoregroup_score = $this->scoregroup->scoregroup_score;
		return $scoregroup_fetch;
	}

	
	public function getSumScoredetail(){
		$sumscoredetail=0;
		$this->scoregroup->queryByTeachID($this->teach_ID);
		while($this->scoregroup->fetchRow()){
			$this->scoredetail->queryByScoregroupID($this->scoregroup->scoregroup_ID);
			while($this->scoredetail->fetchRow()){
				$this->stdscore->queryByScoredetailID($this->scoredetail->scoredetail_ID);
				if($this->stdscore->countRow()>0)
					$sumscoredetail += $this->scoredetail->sumScore($this->scoregroup->scoregroup_ID);
			}
		}
		return $sumscoredetail;
	}
	
	public function getStdscorepoint($scoregroup_ID){
		return $this->stdscore->sumScore($scoregroup_ID,$this->student_ID);

	}
	
	public function getStdsumscorepoint(){
		$sumscorepoint = 0;
		$this->queryScoregroup();
		while($this->fetchScoregroup()){
			$sumscorepoint += $this->getStdscorepoint($this->scoregroup_ID);
		}
		return $sumscorepoint;
	}
}
?>