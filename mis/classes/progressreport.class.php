<?php 
include 'Teach.php';
include '../classes/Teachstd.php';
include 'Classes.php';
include 'Subject.php';
include 'Personnel.php';
include 'Period.php';
include 'Scoregroup.php';
include 'Scoredetail.php';
include 'Stdaffective.php';
include '../classes/Stdscore.php';
include '../includefiles/datetimefunc.php';

class Progressreport_class {
	private $personnel;
	private $pteach;
	private $teach;
	private $subject;
	private $classes;
	private $teachstd;
	private $period;
	private $datetime;
	private $scoregroup;
	private $scoredetail;
	private $stdscore;
	private $stdaffective;
	
	public $teach_ID;
	public $teach_term;
	public $teach_year;
	public $affectscore;
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
		$this->scoregroup = new Scoregroup($dbconnecttion);
		$this->scoredetail = new Scoredetail($dbconnecttion);
		$this->stdscore = new Stdscore($dbconnecttion);
		$this->stdaffective = new Stdaffective($dbconnecttion);
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
		$this->affectscore = $this->teach->affectscore;
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
	
	public function getAllScorePercent(){
		$score = $this->scoregroup->sumScore($this->teach_ID)+$this->affectscore;
		return $score;
	}
	
	public function getStoreScorePercent(){
		$this->scoregroup->queryByTeachID($this->teach_ID);
		$allscore = 0;
		$storescore = 0;
		while($scoregroup_fetch = $this->scoregroup->fetchRow()){
			$this->scoredetail->queryByScoregroupID($scoregroup_fetch['scoregroup_ID']);
			while($scoredetail_fetch=$this->scoredetail->fetchRow()){
				$allscore+=$scoredetail_fetch['scoredetail_score'];
				$stdscore = $this->stdscore->queryByScoredetailID($scoredetail_fetch['scoredetail_ID']);
				if($this->stdscore->countRow()>0){
					$storescore+=$scoredetail_fetch['scoredetail_score'];
				}
			}
			
		}
		$allscore+=$this->affectscore;
		$this->stdaffective->queryByTeachID($this->teach_ID);
		if($this->stdaffective->countRow()>0){
			$storescore+=$this->affectscore;
		}
		if($allscore!=0){
			$gasp = $this->getAllScorePercent();
			$gssp = ($storescore/$allscore)*100;
			return round(($gasp/100)*$gssp,2);
		}
		else{
			return 0;
		}
	}
	
	public function getStdscorePercent(){
		$this->scoregroup->queryByTeachID($this->teach_ID);
		$allscore = 0;
		
		$sumstdavgscore=0;
		while($scoregroup_fetch = $this->scoregroup->fetchRow()){
			$scoregroupscore = $scoregroup_fetch['scoregroup_score'];
			$stdavgscore = 0;
			$storescore = 0;
			$this->scoredetail->queryByScoregroupID($scoregroup_fetch['scoregroup_ID']);
			while($scoredetail_fetch=$this->scoredetail->fetchRow()){
				$allscore+=$scoredetail_fetch['scoredetail_score'];
				$stdscore = $this->stdscore->queryByScoredetailID($scoredetail_fetch['scoredetail_ID']);
				if($this->stdscore->countRow()>0){
					$storescore+=$scoredetail_fetch['scoredetail_score'];
					$stdavgscore+=$this->stdscore->avgScoreByScoredetailID($scoredetail_fetch['scoredetail_ID']);
				}
			}
			if($storescore!=0)
				$sumstdavgscore+=$stdavgscore*$scoregroupscore/$storescore;
			
		}
		if($this->stdaffective->maxAffectiveTeach($this->teach_ID)!=0)
			$sumstdavgscore+=$this->stdaffective->avgAffectiveTeach($this->teach_ID)*$this->affectscore/$this->stdaffective->maxAffectiveTeach($this->teach_ID);
		return round($sumstdavgscore,2);
	}
}
?>