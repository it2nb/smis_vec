<?php
require_once 'Db_Table.php';
class Teachstd extends Db_Table{
	public $teach_ID;
	public $class_ID;
	public $grade;
	public $student_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'teachstd';
	}
	
	public function queryByID($teach_ID,$student_ID){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'student_ID'=>$student_ID);
		parent::queryByMultiField($fieldData_Array);
		$this->fetchRow();
	}
	
	public function queryByTeachID($teach_ID){
		parent::queryByFk("teach_ID",$teach_ID);
	}
	
	public function queryByStudentID($student_ID){
		parent::queryByFk("student_ID",$student_ID);
	}
	
	public function fetchRow(){
		$teachstd_fetch = parent::fetchRow();
		$this->teach_ID=$teachstd_fetch['teach_ID'];
		$this->class_ID=$teachstd_fetch['class_ID'];
		$this->grade=$teachstd_fetch['grade'];
		$this->student_ID=$teachstd_fetch['student_ID'];
		return $teachstd_fetch;
	}
	
	public function insertData($teach_ID,$student_ID,$class_ID,$grade){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'student_ID'=>$student_ID,
								'class_ID'=>$class_ID,
								'grade'=>$grade);
		parent::insertData($fieldData_Array);
	}
	
	public function updateGrade($teach_ID,$student_ID,$new_grade){
		$fieldData_Array = array('teach_ID'=>$teach_ID,
								'student_ID'=>$student_ID);
		parent::updateByMultiField('grade',$new_grade,$fieldData_Array);
	}
	
	public function sumGrade($teach_ID,$class_ID,$grade){
		parent::queryBySql('Select count(student_ID) as sumgrade From teachstd Where teach_ID='.$teach_ID.' and class_ID='.$class_ID.' and grade="'.$grade.'" Group By teach_ID,class_ID');
		$teachstd_fetch = parent::fetchRow();
		return $teachstd_fetch['sumgrade'];
	}
	
	public function countGrade($teach_ID,$class_ID){
		parent::queryBySql('Select count(student_ID) as countgrade From teachstd Where teach_ID='.$teach_ID.' and class_ID='.$class_ID.' and grade!="" Group By teach_ID,class_ID');
		$teachstd_fetch = parent::fetchRow();
		return $teachstd_fetch['countgrade'];
	}
}
?>