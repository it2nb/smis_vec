<?php 
include_once 'Teach.php';
include_once 'Affective.php';
include_once 'Teachaffective.php';
include_once 'Stdaffective.php';
include_once 'Subject.php';
include_once 'Student.php';
include_once 'Scoredetail.php';
include_once 'Scoregroup.php';
include_once 'Classes.php';
include_once 'Stdscore.php';
include_once 'Teachstd.php';

class Recordgrade_class {
	private $teach;
	private $subject;
	private $affective;
	private $teachaffective;
	private $student;
	private $stdaffective;
	private $scoredetail;
	private $scoregroup;
	private $stdscore;
	private $teachstd;
	private $classes;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $major_name;
	public $area_name;
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
	public $student_grade;
	public $stdaffective_score;
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
		$this->affective = new Affective($dbconnecttion);
		$this->teachaffective = new Teachaffective($dbconnecttion);
		$this->student = new Student($dbconnecttion);
		$this->stdaffective = new Stdaffective($dbconnecttion);
		$this->scoredetail = new Scoredetail($dbconnecttion);
		$this->scoregroup = new Scoregroup($dbconnecttion);
		$this->stdscore = new Stdscore($dbconnecttion);
		$this->teachstd = new Teachstd($dbconnecttion);
		$this->classes = new Classes($dbconnecttion);
		$this->teach_ID = $teach_ID;
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->teach_term = $this->teach->teach_term;
		$this->teach_year = $this->teach->teach_year;
		$this->check_period = $this->teach->teach_term.'/'.$this->teach->teach_year;
		$this->affective_score =$this->teach->affectscore;
		$this->personnel_ID = $this->teach->personnel_ID;
		$this->queryFinalscore();
		$this->teachpoint_score = $this->scoregroup->sumScore($this->teach_ID)-$this->teachfinal_score;
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
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From student,teachstd Where student.student_ID=teachstd.student_ID and (student.student_endstatus=0 or student.student_endstatus=5) and teachstd.teach_ID='.$this->teach_ID.' and teachstd.class_ID='.$this->class_ID);
	}
	
	public function fetchStudent(){
		$student_fetch = $this->student->fetchRow();
		$this->student_ID = $this->student->student_ID;
		$this->student_name = $this->student->student_name;
		$this->student_ser = $this->student->student_ser;
		$this->student_grade = $student_fetch['grade'];
		return $student_fetch;
	}
	
	public function queryStudentaffective(){
		//$stdaffective_fetch = $this->stdaffective->queryByTeachID($this->teach_ID);
		$stdaffective_fetch = $this->stdaffective->queryByID($this->student_ID,$this->teach_ID,$this->affective_ID);
		$this->stdaffective_score = $this->stdaffective->score;
		return $stdaffective_fetch;
	}
	
	public function getSumAffective(){
		$sum_stdaffective = $this->stdaffective->sumAffectiveStdTeach($this->student_ID,$this->teach_ID);
		$sum_teachaffectvie = $this->teachaffective->sumScoreTeach($this->teach_ID);
		if($sum_teachaffectvie>0)
			return round(($sum_stdaffective*$this->affective_score)/$sum_teachaffectvie,0);
		else
			return 0;
	}
	
	public function queryFinalscore(){
		$this->scoregroup->queryByFk('scoregroup_name','finalID'.$this->teach_ID);
		$this->scoregroup->fetchRow();
		$this->teachfinal_score = $this->scoregroup->scoregroup_score;
		$this->scoregroup_ID = $this->scoregroup->scoregroup_ID;
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
	
	public function fetchScoredetail(){
		$scoredetail_fetch = $this->scoredetail->fetchRow();
		$this->scoredetail_ID = $this->scoredetail->scoredetail_ID;
		$this->scoredetail_name = $this->scoredetail->scoredetail_name;
		$this->scoredetail_score = $this->scoredetail->scoredetail_score;
		return $scoredetail_fetch;
	}
	
	public function getStdscorepoint($scoregroup_ID){
		$stdscorepoint = $this->stdscore->sumScore($scoregroup_ID,$this->student_ID);
		$sumscoredetail = $this->scoredetail->sumScore($scoregroup_ID);
		if($sumscoredetail)
			$scorepoint = round($stdscorepoint/$sumscoredetail*$this->scoregroup_score,0);
		return $scorepoint;
	}
	
	public function getStdsumscorepoint(){
		$sumscorepoint = 0;
		$this->queryScoregroup();
		while($this->fetchScoregroup()){
			$sumscorepoint += $this->getStdscorepoint($this->scoregroup_ID);
		}
		return $sumscorepoint;
	}
	
	public function getStdfinalscore(){
		$this->queryFinalscore();
		$this->scoredetail->queryByScoregroupID($this->scoregroup_ID);
		$this->scoredetail->fetchRow();
		$this->stdscore->queryByAllFk($this->scoredetail->scoredetail_ID,$this->student_ID);
		$this->stdscore->fetchRow();
		return $this->stdscore->stdscore_score;
	}
	
	public function getStdgrade(){
		$sumscore = $this->getStdsumscorepoint()+$this->getSumAffective()+$this->getStdfinalscore();
		if($sumscore >= 80)
			$grade = 4;
		else if($sumscore >= 75)
			$grade = 3.5;
		else if($sumscore >= 70)
			$grade = 3;
		else if($sumscore >= 65)
			$grade = 2.5;
		else if($sumscore >= 60)
			$grade = 2;
		else if($sumscore >= 55)
			$grade = 1.5;
		else if($sumscore >= 50)
			$grade = 1;
		else
			$grade = 0;
		return $grade;
	}
	
	public function addStudentGrade($grade){
		$this->queryStudent();
		while($this->fetchStudent()){
			$txt .= $this->student_ID.'='.$grade[$this->student_ID];
			$this->teachstd->updateGrade($this->teach_ID,$this->student_ID,$grade[$this->student_ID]);
		}
	}
}
?>