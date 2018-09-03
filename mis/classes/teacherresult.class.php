<?php 
include 'Department.php';
include 'Personnel.php';

class Teacherresult_class {
	private $department;
	private $personnel;
	
	public $department_ID;
	public $department_name;
	public $personnel_ID;
	public $personnel_name;
	public $personnel_ser;
	
	function __construct($dbconnecttion){
		$this->department = new Department($dbconnecttion);
		$this->personnel = new Personnel($dbconnecttion);
	}
	
	public function queryDepartment(){
		$this->department->queryAll();
	}
	
	public function fetchDepartment(){
		$fetch_department = $this->department->fetchRow();
		$this->department_ID = $this->department->department_ID;
		$this->department_name = $this->department->department_name;
		$this->personnel_ID = $this->department->personnel_ID;
		$this->personnel->queryByID($this->personnel_ID);
		$this->personnel_name = $this->personnel->personnel_name;
		$this->personnel_ser = $this->personnel->personnel_ser;
		return $fetch_department;
	}
	
	public function getCountMenperDepart(){
		$this->personnel->queryBySql('Select count(personnel_ID) as countmen From personnel Where personnel_gender="ชาย" and personnel_status="work" and department_ID='.$this->department_ID);
		$fetch_personnel = $this->personnel->fetchRow();
		return $fetch_personnel['countmen'];
		
	}
	
	public function getCountMenTeacher(){
		$this->personnel->queryBySql('Select count(personnel_ID) as countmen From personnel Where personnel_gender="ชาย" and personnel_status="work" and department_ID!=""');
		$fetch_personnel = $this->personnel->fetchRow();
		return $fetch_personnel['countmen'];
		
	}
	
	public function getCountWomenperDepart(){
		$this->personnel->queryBySql('Select count(personnel_ID) as countwomen From personnel Where personnel_gender="หญิง" and personnel_status="work" and department_ID='.$this->department_ID);
		$fetch_personnel = $this->personnel->fetchRow();
		return $fetch_personnel['countwomen'];
		
	}
	
	public function getCountWomenTeacher(){
		$this->personnel->queryBySql('Select count(personnel_ID) as countwomen From personnel Where personnel_gender="หญิง" and personnel_status="work" and department_ID!=""');
		$fetch_personnel = $this->personnel->fetchRow();
		return $fetch_personnel['countwomen'];
		
	}
}
?>