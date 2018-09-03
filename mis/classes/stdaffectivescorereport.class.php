<?php
include_once 'stdaffectivescore.class.old.php';
include_once 'Teachstd.php';
include_once 'Department.php';
include_once 'Classes.php';
include_once 'Personnel.php';
class Stdaffectivescorereport_class extends Stdaffectivescore_class {
	private $teachstd;
	private $classes;
	private $personnel;
	private $department;
	
	public $class_ID;
	public $major_name;
	public $personnel_name;
	public $personnel_ser;
	public $department_ID;
	
	function __construct($dbconnecttion,$teach_ID){
		parent::__construct($dbconnecttion,$teach_ID);
		$this->teachstd = new Teachstd($dbconnecttion);
		$this->classes = new Classes($dbconnecttion);
		$this->personnel = new Personnel($dbconnecttion);
		$this->department = new Department($dbconnecttion);
	}
	
	public function queryStudent(){
		return $this->student->queryBySql('Select * From student,teachstd Where student.student_ID=teachstd.student_ID and (student.student_endstatus=0 or student.student_endstatus=5) and teachstd.teach_ID='.$this->teach_ID.' and teachstd.class_ID='.$this->class_ID);
	}
	
	public function queryPersonnel(){
		$this->personnel->queryByID($this->personnel_ID);
		$this->personnel_name = $this->personnel->personnel_name;
		$this->personnel_ser = $this->personnel->personnel_ser;
		$this->department_ID = $this->personnel->deparment_ID;
	}
	public function queryTeachStdClass(){
		return $this->teachstd->queryBySql('Select DISTINCT class_ID From teachstd Where teach_ID='.$this->teach_ID);
	}
	
	public function fetchTeachStdClass(){
		$teachstd_fetch = $this->teachstd->fetchRow();
		$this->class_ID = $this->teachstd->class_ID;
		$this->classes->queryByID($this->class_ID);
		$this->major_name = $this->classes->major_name;
		return $teachstd_fetch;
	}
	
	public function getHOD(){
		$this->department->queryByID($this->department_ID);
		$hod = new Personnel($conn);
		$hod->queryByID($this->department->personnel_ID);
		return $hod->personnel_name.' '.$hod->personnel_ser;
	}
}
?>