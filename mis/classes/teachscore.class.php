<?php 
include 'Subject.php';
include 'Teach.php';

class Teachscore_class {
	private $teach;
	private $subject;
	
	public $teach_ID;
	public $subject_ID;
	public $subject_name;
	public $subject_unit;
	public $subject_hourt;
	public $subject_hourp;
	
	function __construct($dbconnecttion,$teach_ID){
		$this->teach = new Teach($conn);
		$this->subject = new Subject($conn);
		$this->teach_ID = $teach_ID;
	}
	
	public function queryTeach(){
		$this->teach->queryByID($this->teach_ID);
		$this->subject->queryByID($this->teach->subject_ID,$this->teach->course_ID);
		$this->subject_ID = $this->subject->subject_ID;
		$this->subject_name = $this->subject->subject_name;
		$this->subject_unit = $this->subject->subject_unit;
		$this->subject_hourt = $this->subject->subject_hourt;
		$this->subject_hourp =$this->subject->subject_hourp;
	}
}
?>