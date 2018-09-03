<?php 
include 'Teach.php';
include 'Scoregroup.php';
include 'Scoredetail.php';
include '../classes/Stdscore.php';
include 'Userlogs.php';

class Teachscoretype_class {
	private $teach;
	private $scoregroup;
	private $scoredetail;
	private $stdscore;
	private $userlogs;
	
	public $teach_ID;
	public $totalscore;
	public $scoregroup_ID;
	public $scoregroup_name;
	public $scoregroup_score;
	public $scoredetail_ID;
	public $scoredetail_name;
	public $scoredetail_score;
	
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($conn);
		$this->scoregroup = new Scoregroup($conn);
		$this->scoredetail = new Scoredetail($conn);
		$this->stdscore = new Stdscore($conn);
		$this->userlogs = new Userlogs($conn);
		$this->teach_ID = $teach_ID;
	}
	
	public function getAffectivescore(){
		$this->teach->queryByID($this->teach_ID);
		return $this->teach->affectscore;
	}
	
	public function updateAffectivescore($affectscore){
		if(!empty($affectscore)){
			if(is_numeric($affectscore)){
				$this->scoregroup->queryByTeachID($this->teach_ID);
				$totalscore = $this->scoregroup->sumScore($this->teach_ID);
				if(($totalscore+$affectscore)-$this->teach->affectscore<=100){
					$this->teach->updateAffectscore($this->teach_ID,$affectscore);
					$this->userlogs_des="แก้ไขคะแนนจิตพิสัย รหัสการสอน".$this->teach_ID;
					$this->userlogs->insertData($_SESSION['userID'],'Edit Affectivescore','teach_mis',$userlogs_des);
				}
				else{
					echo "<script>alert('คะแนนรวมเกิน 100 คะแนน');</script>";
				}
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกคะแนนจิตพิสัย');</script>";
		}
	}

	public function queryScoregroup(){
		$this->totalscore = $this->scoregroup->sumScore($this->teach_ID);
		return $this->scoregroup->queryBySql('Select * From scoregroup Where teach_ID="'.$this->teach_ID.'" and scoregroup_ID!=(Select scoregroup_ID From teach Where teach_ID="'.$this->teach_ID.'")');
	}
	
	public function fetchScoregroup(){
		$scoregroup_fetch = $this->scoregroup->fetchRow();
		$this->scoregroup_ID = $this->scoregroup->scoregroup_ID;
		$this->scoregroup_name = $this->scoregroup->scoregroup_name;
		$this->scoregroup_score = $this->scoregroup->scoregroup_score;
		return $scoregroup_fetch;
	}
	
	public function queryFinalscore(){
		$this->scoregroup->queryByFk('scoregroup_name','finalID'.$this->teach_ID);
		$this->fetchScoregroup();
		$this->scoredetail->queryByScoregroupID($this->scoregroup_ID);
		$this->fetchScoredetail();
	}

	public function updateFinalscore($scoregroup_ID,$scoregroup_score){
		if(!empty($scoregroup_score)){
			if(is_numeric($scoregroup_score)){
				$this->scoregroup->queryByID($scoregroup_ID);
				$oldscore = $this->scoregroup->scoregroup_score;
				$totalscore = $this->scoregroup->sumScore($this->teach_ID);
				$this->teach->queryByID($this->teach_ID);
				if(($totalscore+$scoregroup_score+$this->teach->affectscore)-$oldscore<=100){
					$this->scoregroup->updateScore($scoregroup_ID,$scoregroup_score);
					$this->scoredetail->updateScoreByFk($scoregroup_ID,$scoregroup_score);
					$this->scoredetail->queryByScoregroupID($scoregroup_ID);
					$this->scoredetail->fetchRow();
					$this->stdscore->queryByScoredetailID($scoredetail->scoredetail_ID);
					$newstdscore = new Stdscore($conn);
					while($this->stdscore->fetchRow()){
						$newscore = round(($scoregroup_score*$this->stdscore->stdscore_score)/$oldscore,0);
						$newstdscore->updateScore($this->stdscore->stdscore_ID,$newscore);
					}
					$userlogs_des="แก้ไขคะแนนสอบปลายภาค รหัสการสอน".$this->teach_ID;
					$this->userlogs->insertData($_SESSION['userID'],'Edit Finalscore','teach_mis',$userlogs_des);
					echo "<script>stdscore('".$this->scoredetail->scoredetail_ID."');</script>";
				}
				else{
					echo "<script>alert('คะแนนรวมเกิน 100 คะแนน');</script>";
				}
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกคะแนนสอบปลายภาค');</script>";
		}
	}

	public function insertScoregroup($scoregroup_name,$scoregroup_score){
		if(!empty($scoregroup_name)&&!empty($scoregroup_score)){
			if(is_numeric($scoregroup_score)){
				$this->scoregroup->queryByTeachID($this->teach_ID);
				$totalscore = $this->scoregroup->sumScore($this->teach_ID);
				$this->teach->queryByID($this->teach_ID);
				if(($totalscore+$scoregroup_score+$this->teach->affectscore)<=100){
					$this->scoregroup->insertData($scoregroup_name,$scoregroup_score,$this->teach_ID);
					$this->userlogs_des="เพิ่มหัวข้อคะแนนหลัก ".$scoregroup_name;
					$this->userlogs->insertData($_SESSION['userID'],'Add Scoregroup','teach_mis',$userlogs_des);
				}
				else{
					echo "<script>alert('คะแนนรวมเกิน 100 คะแนน');</script>";
				}
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกชื่อหัวข้อหลักและคะแนน');</script>";
		}
	}

	public function updateScoregroup($scoregroup_ID,$scoregroup_name,$scoregroup_score){
		if(!empty($scoregroup_name)&&!empty($scoregroup_score)){
			if(is_numeric($scoregroup_score)){
				$this->scoregroup->queryByID($scoregroup_ID);
				$oldscore=$this->scoregroup->scoregroup_score;
				$totalscore = $this->scoregroup->sumScore($this->teach_ID);
				$this->teach->queryByID($this->teach_ID);
				if(($totalscore+$scoregroup_score+$this->teach->affectscore)-$oldscore<=100){
					$this->scoregroup->updateName($scoregroup_ID,$scoregroup_name);
					$this->scoregroup->updateScore($scoregroup_ID,$scoregroup_score);
					$userlogs_des="แก้ไขหัวข้อคะแนนหลัก ".$scoregroup_name;
					$this->userlogs->insertData($_SESSION['userID'],'Edit Scoregroup','teach_mis',$userlogs_des);
				}
				else{
					echo "<script>alert('คะแนนรวมเกิน 100 คะแนน');</script>";
				}
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกชื่อหัวข้อหลักและคะแนน');</script>";
		}
	}

	public function deleteScoregroup($scoregroup_ID){
		$this->scoredetail->queryByScoregroupID($scoregroup_ID);
		while($this->scoredetail->fetchRow()){
			$this->stdscore->deleteByScoredetailID($this->scoredetail->scoredetail_ID);
		}
		$this->scoredetail->deleteByScoregroupID($scoregroup_ID);
		$this->scoregroup->deleteData($scoregroup_ID);
		$userlogs_des="ลบหัวข้อคะแนนหลัก ".$scoregroup_ID;
		$this->userlogs->insertData($_SESSION['userID'],'Delete Scoregroup','teach_mis',$userlogs_des);
	}
	
	public function queryScoredetail(){
		return $this->scoredetail->queryByScoregroupID($this->scoregroup_ID);
	}
	
	public function fetchScoredetail(){
		$scoredetail_fetch = $this->scoredetail->fetchRow();
		$this->scoredetail_ID = $this->scoredetail->scoredetail_ID;
		$this->scoredetail_name = $this->scoredetail->scoredetail_name;
		$this->scoredetail_score = $this->scoredetail->scoredetail_score;
		return $scoredetail_fetch;
	}
	
	public function insertScoredetail($scoredetail_name,$scoredetail_score,$scoregroup_ID){
		if(!empty($scoredetail_name)&&!empty($scoredetail_score)){
			if(is_numeric($scoredetail_score)){
				$this->scoredetail->insertData($scoredetail_name,$scoredetail_score,$scoregroup_ID);
				$userlogs_des="เพิ่มหัวข้อคะแนนย่อย ".$scoredetail_name;
				$this->userlogs->insertData($_SESSION['userID'],'Add Scoredetail','teach_mis',$userlogs_des);
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกชื่อหัวข้อย่อยและคะแนน');</script>";
		}
	}
	
	public function updateScoredetail($scoredetail_ID,$scoredetail_name,$scoredetail_score){
		if(!empty($scoredetail_name)&&!empty($scoredetail_score)){
			if(is_numeric($scoredetail_score)){
				$this->scoredetail->queryByID($scoredetail_ID);
				$oldscore = $this->scoredetail->scoredetail_score;
				$this->scoredetail->updateName($scoredetail_ID,$scoredetail_name);
				$this->scoredetail->updateScore($scoredetail_ID,$scoredetail_score);
				$this->stdscore->queryByScoredetailID($scoredetail_ID);
				$newstdscore = new Stdscore($conn);
				while($this->stdscore->fetchRow()){
					$newscore = round(($scoredetail_score*$this->stdscore->stdscore_score)/$oldscore,0);
					$newstdscore->updateScore($this->stdscore->stdscore_ID,$newscore);
				}
				$userlogs_des="แก้ไขหัวข้อคะแนนย่อย ".$scoredetail_name;
				$this->userlogs->insertData($_SESSION['userID'],'Edit Scoredetail','teach_mis',$userlogs_des);
				echo "<script>stdscore('".$scoredetail_ID."');</script>";
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกชื่อหัวข้อหลักและคะแนน');</script>";
		}
	}
	
	public function deleteScoredetail($scoredetail_ID){
		$this->stdscore->deleteByScoredetailID($scoredetail_ID);
		$this->scoredetail->deleteData($scoredetail_ID);
		$userlogs_des="ลบหัวข้อคะแนนย่อย ".$scoredetail_ID;
		$this->userlogs->insertData($_SESSION['userID'],'Delete Scoredetail','teach_mis',$userlogs_des);
	}
}
?>