<?php 
include_once 'Teach.php';
include_once 'Affective.php';
include_once 'Teachaffective.php';
include_once 'Stdaffective.php';
include_once 'Subject.php';
include_once 'Student.php';
include_once 'Userlogs.php';
class Stdaffectivescore_class {
	private $teach;
	private $subject;
	private $affective;
	private $teachaffective;
	protected $student;
	private $stdaffective;
	private $userlogs;
	
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
	public $affective_ID;
	public $affective_name;
	public $teachaffective_score;
	public $student_ID;
	public $student_name;
	public $student_ser;
	public $stdaffective_score;
	
	function __construct($dbconnecttion,$teach_ID,$affective_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->affective = new Affective($dbconnecttion);
		$this->teachaffective = new Teachaffective($dbconnecttion);
		$this->student = new Student($dbconnecttion);
		$this->stdaffective = new Stdaffective($dbconnecttion);
		$this->userlogs = new Userlogs($dbconnecttion);
		$this->teach_ID = $teach_ID;
		$this->affective_ID = $affective_ID;
		$this->init();
	}
	
	public function init(){
		$this->affective->queryByID($this->affective_ID);
		$this->affective_name=$this->affective->affective_name;
		$this->teachaffective->queryByID($this->teach_ID,$this->affective_ID);
		$this->teachaffective_score = $this->teachaffective->score;
	}
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From teachstd,student Where teachstd.student_ID=student.student_ID and teachstd.teach_ID="'.$this->teach_ID.'" and student_endstatus=0');
	}
	
	public function fetchStudent(){
		$student_fetch = $this->student->fetchRow();
		$this->student_ID = $this->student->student_ID;
		$this->student_name = $this->student->student_name;
		$this->student_ser = $this->student->student_ser;
		$this->stdaffective->queryByID($this->student_ID,$this->teach_ID,$this->affective_ID);
		$this->stdaffective_score = $this->stdaffective->score;
		return $student_fetch;
	}
	
	public function insertStdaffectivescore($affecitve_ID,$stdaffectivescore_score){
		if(!empty($affecitve_ID)){
			$this->student->queryBySql('Select * From teachstd,student Where teachstd.student_ID=student.student_ID and teachstd.teach_ID="'.$this->teach_ID.'" and student_endstatus=0');
			$newstdaffective = new Stdaffective($conn);
			while($this->student->fetchRow()){
				$stdaffectivescore_newscore = $stdaffectivescore_score[$this->student->student_ID];
				$this->stdaffective->queryByID($this->student->student_ID,$this->teach_ID,$affecitve_ID);
				if($this->stdaffective->countRow()>0){
					$newstdaffective->updateScore($this->student->student_ID,$this->teach_ID,$affecitve_ID,$stdaffectivescore_newscore);
				}else{
					$newstdaffective->insertData($this->student->student_ID,$this->teach_ID,$affecitve_ID,$stdaffectivescore_newscore);
				}
			}
			$userlogs_des='บันทึกคะแนนจิดพิสัย'.$this->teach_ID." ".$affecitve_ID;
			$this->userlogs->insertData($_SESSION['userID'],'Add Stdaffectivescore','teach_mis',$userlogs_des);
			echo "<script type='text/javascript'>
					alert('บันทึกข้อมูลเรียบร้อย');
					</script>";
		}
	}
}
?>