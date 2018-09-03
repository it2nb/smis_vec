<?php 
include 'Teach.php';
include 'Teachaffective.php';
include 'Affective.php';
include '../classes/Stdaffective.php';
include 'Userlogs.php';

class Affectivescoretype_class {
	private $teach;
	private $teachaffective;
	private $affective;
	private $stdaffective;
	private $userlogs;
	
	public $teach_ID;
	public $affective_ID;
	public $affective_name;
	public $affective_score;
	
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($dbconnecttion);
		$this->teachaffective = new Teachaffective($dbconnecttion);
		$this->affective = new Affective($conn);
		$this->stdaffective = new Stdaffective($conn);
		$this->userlogs = new Userlogs($dbconnecttion);
		$this->teach_ID = $teach_ID;
		$this->init();
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
	
	public function queryTeachaffective(){
		return $this->teachaffective->queryByTeachID($this->teach_ID);
	}
	
	public function fetchTeachaffective(){
		$teachaffective_fetch = $this->teachaffective->fetchRow();
		$this->affective->queryByID($this->teachaffective->affective_ID);
		$this->affective_ID = $this->affective->affective_ID;
		$this->affective_name = $this->affective->affective_name;
		$this->affective_score = $this->teachaffective->score;
		return $teachaffective_fetch;
	}

	public function insertTeachAffective($teach_ID,$affective_ID,$score){
		$this->teachaffective->queryByID($teach_ID,$affective_ID);
		if($this->teachaffective->countRow()<1){
			if(!empty($score)){
				if(is_numeric($score)){
					$this->teachaffective->insertData($teach_ID,$affective_ID,$score);
					$userlogs_des="เพิ่มหัวข้อจิตพิสัย ".$teach_ID;
					$this->userlogs->insertData($_SESSION['userID'],'Add Teachaffective','teach_mis',$userlogs_des);
				}
				else{
					echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
				}
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนน');</script>";
			}
		}else{
		echo "<script>alert('หัวข้อจิตพิสัยนี้มีอยู่แล้ว');</script>";
		}
	}
	
	
	public function updateTeachAffectiveScore($teach_ID,$affective_ID,$teachaffectivesocore){
		if(!empty($teachaffectivesocore)){
			if(is_numeric($teachaffectivesocore)){
				$this->teachaffective->queryByID($teach_ID,$affective_ID);
				$oldteachaffectivescore = $this->teachaffective->score;
				$this->teachaffective->updateScore($teach_ID,$affective_ID,$teachaffectivesocore);
				$this->affective->queryByID($affective_ID);
				$fieldData_Array = array('teach_ID'=>$teach_ID,
								'affective_ID'=>$affective_ID);
				$this->stdaffective->queryByMultiField($fieldData_Array);
				$newstdaffective = new Stdaffective($conn);
				while($this->stdaffective->fetchRow()){
					$newstdaffective->updateScore($this->stdaffective->student_ID,$teach_ID,$affective_ID,round($this->stdaffective->score*$teachaffectivesocore/$oldteachaffectivescore,0));
				}
				$userlogs_des="แก้ไขหัวข้อคะแนนจิดพิสัย ".$this->affective->affective_name." รหัสการสอน ".$teach_ID;
				$this->userlogs->insertData($_SESSION['userID'],'Edit Teachaffective','teach_mis',$userlogs_des);
				echo "<script>stdaffectivescore('".$teach_ID."','".$affective_ID."');</script>";
			}
			else{
				echo "<script>alert('กรุณากรอกคะแนนเป็นตัวเลข');</script>";
			}
		}
		else{
			echo "<script>alert('กรุณากรอกคะแนนจิดพิสัย');</script>";
		}
	}

	public function deleteTeachAffective($affective_ID,$teach_ID){
		$this->stdaffective->deleteStdAffective($teach_ID,$affective_ID);
		$this->teachaffective->deleteTeachAffective($teach_ID,$affective_ID);
		$userlogs_des="ลบหัวข้อคะแนนจิตพิสัย ".$teach_ID;
		$this->userlogs->insertData($_SESSION['userID'],'Delete Teachaffective','teach_mis',$userlogs_des);
	}
	
}
?>