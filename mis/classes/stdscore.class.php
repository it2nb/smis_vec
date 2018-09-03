<?php 
include 'Scoregroup.php';
include 'Scoredetail.php';
include '../classes/Stdscore.php';
include 'Teach.php';
include 'Student.php';
include 'Userlogs.php';

class Stdscore_class {
	private $teach;
	private $student;
	private $stdaffective;
	private $scoredetail;
	private $scoregroup;
	private $stdscore;
	
	public $teach_ID;
	public $scoredetail_ID;
	public $scoredetail_name;
	public $scoregroup_name;
	public $student_ID;
	public $student_name;
	public $student_ser;
	public $stdscore_score;
	
	function __construct($dbconnecttion,$teach_ID,$scoredetail_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->student = new Student($dbconnecttion);
		$this->stdscore = new Stdscore($dbconnecttion);
		$this->scoregroup = new Scoregroup($dbconnecttion);
		$this->scoredetail = new Scoredetail($dbconnecttion);
		$this->userlogs = new Userlogs($dbconnecttion);
		$this->teach_ID = $teach_ID;
		$this->scoredetail_ID = $scoredetail_ID;
		$this->init();
	}
	
	public function init(){
		$this->scoredetail->queryByID($this->scoredetail_ID);
		$this->scoredetail_name = $this->scoredetail->scoredetail_name;
		$this->teach->queryByScoregroupID($this->scoredetail->scoregroup_ID);
		if($this->teach->countRow()>0 && !empty($this->scoredetail_ID)){
			$this->scoredetail_name="สอบปลายภาคเรียน";
		}
		else{
			$this->scoregroup->queryByID($this->scoredetail->scoregroup_ID);
			$this->scoregroup_name=$this->scoregroup->scoregroup_name;
			$this->scoredetail_name=$this->scoredetail->scoredetail_name;
		}
	}
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From teachstd,student Where teachstd.student_ID=student.student_ID and teachstd.teach_ID="'.$this->teach_ID.'" and student_endstatus=0');
	}
	
	public function fetchStudent(){
		$student_fetch = $this->student->fetchRow();
		$this->student_ID = $this->student->student_ID;
		$this->student_name = $this->student->student_name;
		$this->student_ser = $this->student->student_ser;
		$this->stdscore->queryByAllFk($this->scoredetail_ID,$this->student_ID);
	  	$this->stdscore->fetchRow();
		$this->stdscore_score = $this->stdscore->stdscore_score;
		return $student_fetch;
	}
	
	public function insertStdscore($scoredetail_ID,$stdscore_score){
		if(!empty($scoredetail_ID)){
			$this->student->queryBySql('Select * From teachstd,student Where teachstd.student_ID=student.student_ID and teachstd.teach_ID="'.$this->teach_ID.'" and student_endstatus=0');
			$newstdscore = new Stdscore($conn);
			while($this->student->fetchRow()){
				$stdscore_newscore = $stdscore_score[$this->student->student_ID];
				$this->stdscore->queryByAllFk($scoredetail_ID,$this->student->student_ID);
				$this->stdscore->fetchRow();
				if($this->stdscore->countRow()>0){
					$newstdscore->updateScore($this->stdscore->stdscore_ID,$stdscore_newscore);
					$newstdscore->updateDate($this->stdscore->stdscore_ID,date('Y-m-d H:i:s'));
				}else{
					$newstdscore->insertData(date('Y-m-d H:i:s'),$stdscore_newscore,$scoredetail_ID,$this->student->student_ID);
				}
			}
			$userlogs_des='บันทึกคะแนน'.$this->teach_ID." ".$check_date;
			$this->userlogs->insertData($_SESSION['userID'],'Add Stdscore','teach_mis',$userlogs_des);
			echo "<script type='text/javascript'>
					alert('บันทึกข้อมูลเรียบร้อย');
					</script>";
		}
	}
}
?>