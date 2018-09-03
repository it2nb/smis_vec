<?php
require_once 'Db_Table.php';
class Avgrade extends Db_Table{
	public $addcre;
	public $addpoint;
	public $tolcre;
	public $tolpoint;
	public $code;
	public $name;
	public $cre1;
	public $cre2;
	public $cre3;
	public $cre4;
	public $cre5;
	public $cre6;
	public $cre7;
	public $cre8;
	public $cre9;
	public $tolcre1;
	public $tolcre2;
	public $tolcre3;
	public $tolcre4;
	public $tolcre5;
	public $tolcre6;
	public $tolcre7;
	public $tolcre8;
	public $tolcre9;
	public $point1;
	public $point2;
	public $point3;
	public $point4;
	public $point5;
	public $point6;
	public $point7;
	public $point8;
	public $point9;
	public $tolpoint1;
	public $tolpoint2;
	public $tolpoint3;
	public $tolpoint4;
	public $tolpoint5;
	public $tolpoint6;
	public $tolpoint7;
	public $tolpoint8;
	public $tolpoint9;
	
	function __construct(){
		$this->table = 'avgrade';
		$this->ID = 'code';
	}
	
	public function fetchRow(){
		$avgrade_fetch = parent::fetchRow();
		$this->addcre=$avgrade_fetch['addcre'];
		$this->addpoint=$avgrade_fetch['addpoint'];
		$this->tolcre=$avgrade_fetch['tolcre'];
		$this->tolpoint=$avgrade_fetch['tolpoint'];
		$this->code=$avgrade_fetch['code'];
		$this->name=$avgrade_fetch['name'];
		$this->cre1=$avgrade_fetch['cre1'];
		$this->cre2=$avgrade_fetch['cre2'];
		$this->cre3=$avgrade_fetch['cre3'];
		$this->cre4=$avgrade_fetch['cre4'];
		$this->cre5=$avgrade_fetch['cre5'];
		$this->cre6=$avgrade_fetch['cre6'];
		$this->cre7=$avgrade_fetch['cre7'];
		$this->cre8=$avgrade_fetch['cre8'];
		$this->cre9=$avgrade_fetch['cre9'];
		$this->tolcre1=$avgrade_fetch['tolcre1'];
		$this->tolcre2=$avgrade_fetch['tolcre2'];
		$this->tolcre3=$avgrade_fetch['tolcre3'];
		$this->tolcre4=$avgrade_fetch['tolcre4'];
		$this->tolcre5=$avgrade_fetch['tolcre5'];
		$this->tolcre6=$avgrade_fetch['tolcre6'];
		$this->tolcre7=$avgrade_fetch['tolcre7'];
		$this->tolcre8=$avgrade_fetch['tolcre8'];
		$this->tolcre9=$avgrade_fetch['tolcre9'];
		$this->point1=$avgrade_fetch['point1'];
		$this->point2=$avgrade_fetch['point2'];
		$this->point3=$avgrade_fetch['point3'];
		$this->point4=$avgrade_fetch['point4'];
		$this->point5=$avgrade_fetch['point5'];
		$this->point6=$avgrade_fetch['point6'];
		$this->point7=$avgrade_fetch['point7'];
		$this->point8=$avgrade_fetch['point8'];
		$this->point9=$avgrade_fetch['point9'];
		$this->tolpoint1=$avgrade_fetch['tolpoint1'];
		$this->tolpoint2=$avgrade_fetch['tolpoint2'];
		$this->tolpoint3=$avgrade_fetch['tolpoint3'];
		$this->tolpoint4=$avgrade_fetch['tolpoint4'];
		$this->tolpoint5=$avgrade_fetch['tolpoint5'];
		$this->tolpoint6=$avgrade_fetch['tolpoint6'];
		$this->tolpoint7=$avgrade_fetch['tolpoint7'];
		$this->tolpoint8=$avgrade_fetch['tolpoint8'];
		$this->tolpoint9=$avgrade_fetch['tolpoint9'];
		return $avgrade_fetch;
	}
	
	/*public function insertData($name,$detail,$en){
		$fieldData_Array = array('affective_name'=>$name,
								'affective_detail'=>$detail,
								'affective_en'=>$en);
		parent::insertData($fieldData_Array);
	}*/
}
?>