<?php 
include 'Teach.php';
include '../classes/Teachstd.php';
include 'Classes.php';
include 'Subject.php';
include 'Personnel.php';
include 'Period.php';
include '../classes/Teachday.php';
include '../classes/Instrucrec.php';
include '../classes/Instrucrecsw.php';
include '../includefiles/datetimefunc.php';

class Instrucrecreport_class {
	private $personnel;
	private $pteach;
	private $teach;
	private $subject;
	private $classes;
	private $teachstd;
	private $period;
	private $teachday;
	private $instrucrec;
	private $instrucrecsw;
	private $datetime;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $period_start;
	public $period_end;
	public $course_ID;
	public $subject_ID;
	public $subject_name;
	public $personnel_ID;
	public $personnel_name;
	public $personnel_ser;
	public $class_ID;
	public $major_name;
	public $area_name;
	public $class_level;
	public $searchID;
	
	function __construct($dbconnecttion){
		$this->teach = new Teach($dbconnecttion);
		$this->pteach = new Teach($dbconnecttion);
		$this->personnel = new Personnel($dbconnecttion);
		$this->subject = new Subject($dbconnecttion);
		$this->classes = new Classes($dbconnecttion);
		$this->teachstd = new Teachstd($dbconnecttion);
		$this->period = new Period($dbconnecttion);
		$this->teachday = new Teachday($dbconnecttion);
		$this->instrucrec = new Instrucrec($dbconnecttion);
		$this->instrucrecsw = new Instrucrecsw($dbconnecttion);
		$this->datetime = new datetimefunc();
		$this->init();
	}
	
	private function init(){
		$this->period->queryBySql('Select * From period Where period_start=(Select max(period_start) From period)');
		$this->period->fetchRow();
		$this->teach_term = $this->period->period_term;
		$this->teach_year = $this->period->period_year;
		$this->period_start = $this->period->period_start;
		$this->period_end = $this->period->period_end;
		
	}
	
	public function setPeriod($teach_term,$teach_year){
		$this->period->queryByID($teach_term,$teach_year);
		$this->teach_term = $this->period->period_term;
		$this->teach_year = $this->period->period_year;
		$this->period_start = $this->period->period_start;
		$this->period_end = $this->period->period_end;
	}
	
	public function setSearch($personnel_ID){
		if(is_numeric($personnel_ID))
			$this->searchID = $personnel_ID;
		else
			$this->searchID = 'all';
	}
	public function queryTeach(){
		$this->teach->queryBySql('Select * From teach Where teach_term="'.$this->teach_term.'" and teach_year="'.$this->teach_year.'" and personnel_ID="'.$this->personnel_ID.'"');
	}
	
	public function fetchTeach(){
		$fecth_teach = $this->teach->fetchRow();
		$this->teach_ID = $this->teach->teach_ID;
		$this->subject->queryByID($this->teach->subject_ID,$this->teach->course_ID);
		$this->course_ID = $this->subject->course_ID;
		$this->subject_ID = $this->subject->subject_ID;
		$this->subject_name = $this->subject->subject_name;
		return $fecth_teach;
	}
	
	public function queryClass(){
		return $this->teachstd->queryBySql('Select DISTINCT class_ID From teachstd Where teach_ID='.$this->teach_ID);
	}
	
	public function fetchClass(){
		$fetch_teachstd = $this->teachstd->fetchRow();
		$this->classes->queryByID($this->teachstd->class_ID);
		$this->class_ID = $this->classes->class_ID;
		$this->area_name = $this->classes->area_name;
		$this->major_name = $this->classes->major_name;
		if(substr($this->class_ID,2,1)==2)
			$this->class_level = 'ปวช';
		else
			$this->class_level = 'ปวส';
		return $fetch_teachstd;
	}
	
	public function queryPersonnel(){
		if(is_numeric($this->searchID))
			return $this->pteach->queryBySql('Select DISTINCT personnel_ID From personnel Where personnel_status="work" and personnel_ID="'.$this->searchID.'"');
		else
			return $this->pteach->queryBySql('Select DISTINCT teach.personnel_ID From teach,personnel Where teach.personnel_ID=personnel.personnel_ID and personnel_status="work" and teach_term="'.$this->teach_term.'" and teach_year="'.$this->teach_year.'" Order By personnel_name ASC');
	}
	
	public function fetchPersonnel(){
		$fetch_teach = $this->pteach->fetchRow();
		$this->personnel->queryByIDStatus($this->pteach->personnel_ID,'work');
		$this->personnel->fetchRow();
		$this->personnel_ID = $this->personnel->personnel_ID;
		$this->personnel_name = $this->personnel->personnel_name;
		$this->personnel_ser = $this->personnel->personnel_ser;
		return $fetch_teach;
	}
	
	public function getCountAllTeachWeek(){
		$week = $this->datetime->getweek(date('Y-m-d'),$this->period_start,$this->period_end);
		if($week>17)
			$week=17;
		return $week;
	}
	
	public function getCountRecWeek(){
		$this->instrucrecsw->queryByTeach($this->personnel_ID,$this->subject_ID,$this->course_ID,$this->teach_term,$this->teach_year);
		if($this->getCountAllTeachWeek()<=$this->instrucrecsw->countRow())
			return $this->getCountAllTeachWeek();
		else
			return $this->instrucrecsw->countRow();
	}
	
	public function getPercentRecWeek(){
		if($this->getCountAllTeachWeek()<=$this->getCountRecWeek())
			return 100;
		else if($this->getCountAllTeachWeek())
			return round(($this->getCountRecWeek()/$this->getCountAllTeachWeek())*100,2);
		else
			return 0;
	}
	
	public function getCountWarningRecWeek(){
		$i=0;
		while($this->instrucrecsw->fetchRow()){
			if(strlen($this->instrucrecsw->instrucrecsw_detail)<20)
				$i++;
		}
		return $i;
	}
	
	public function getCountAllTeachDay(){
		$week = $this->getCountAllTeachWeek();
		$this->teachday->queryByTeachID($this->teach_ID);
		$day = $this->teachday->countRow();
		return ($week*$day);
	}
	
	public function getCountRecDay(){
		//$this->instrucrec->queryByTeachID($this->teach_ID);
		$this->instrucrec->queryBySql('Select * From instrucrec,teachday Where instrucrec.teach_ID="'.$this->teach_ID.'" and instrucrec.teachday_ID=teachday.teachday_ID');
		if($this->getCountAllTeachDay()<=$this->instrucrec->countRow())
			return $this->getCountAllTeachDay();
		else
			return $this->instrucrec->countRow();
	}
	
	public function getPercentRecDay(){
		if($this->getCountAllTeachDay()<=$this->getCountRecDay())
			return 100;
		else if($this->getCountAllTeachDay())
			return round(($this->getCountRecDay()/$this->getCountAllTeachDay())*100,2);
		else
			return 0;
	}
	
	public function getCountWarningRecDay(){
		$i=0;
		while($this->instrucrec->fetchRow()){
			if(strlen($this->instrucrec->instrucrec_detail)<20)
				$i++;
		}
		return $i;
	}
	
	public function getRecResult(){
		if($this->getPercentRecDay()>=80 || $this->getPercentRecWeek()>=80)
			return "ผ่าน";
		else
			return "ไม่ผ่าน";
			
	}
}
?>