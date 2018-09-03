<?php
class Affective{
	public $affective_ID;
	public $affective_name;
	public $affective_detail;
	public $affective_en;
	private $dbconnecttion;
	private $affective_query;
	private $border=1;
	private $width='100%';
	private $haffective_ID='affective_ID';
	private $haffective_name='affective_name';
	private $haffective_detail='affective_detail';
	private $haffective_en='affective_en';
	
	function __construct($dbconnecttion){
		$this->dbconnecttion = $dbconnecttion;
	}
	
	public function queryAll(){
		$query='Select * From affective Order By affective_ID ASC';
		$this->affective_query=mysql_query($query);
	}
	
	public function queryLimit($limit,$start){
		$query='Select * From affective Order By affective_ID ASC Limit '.$start.','.$limit;
		$this->affective_query=mysql_query($query);
	}
	
	public function fetchRow(){
		$fetch=mysql_fetch_assoc($this->affective_query);
		$this->affective_ID = $fetch['affective_ID'];
		$this->affective_name = $fetch['affective_name'];
		$this->affective_detail = $fetch['affective_detail'];
		$this->affective_en = $fetch['affective_en'];
		return $fetch;
	}
	
	public function countRow(){
		return mysql_num_rows($this->affective_query);
	}
	
	public function queryByID($ID){
		$query='Select * From affective Where affective_ID="'.$ID.'"';
		$this->affective_query=mysql_query($query);
		$this->fetchRow();
	}
	
	public function insertData($name,$detail,$en){
		$query='Insert Into affective(affective_name,affective_detail,affective_en) Values ("'.$name.'","'.$detail.'","'.$en.'")';
		$this->affective_query=mysql_query($query);
	}
	
	private function updateData($ID,$attr,$value){
		$query='Update affective Set '.$attr.'="'.$value.'" Where affective_ID="'.$ID.'"';
		$this->affective_query=mysql_query($query);
	}
	
	public function updateName($ID,$new_name){
		$this->updateData($ID,'affective_name',$new_name);
	}
	
	public function updateDetail($ID,$new_detail){
		$this->updateData($ID,'affective_detail',$new_detail);
	}
	
	public function updateEn($ID,$new_en){
		$this->updateData($ID,'affective_en',$new_en);
	}
	
	public function toggleEn($ID){
		$this->queryByID($ID);
		if($this->affective_en==1)
			$this->updateData($ID,'affective_en',0);
		else
			$this->updateData($ID,'affective_en',1);
			
	}
	
	public function deleteData($ID){
		$query='Delete From affective Where affective_ID="'.$ID.'"';
		$this->affective_query=mysql_query($query);
	}
	
	public function deleteAllData(){
		$query='Delete From affective';
		$this->affective_query=mysql_query($query);
	}
	
	public function setTableWidth($width){
		$this->width=$width;
	}
	
	public function setTableBorder($border){
		$this->border=$border;
	}
	
	public function setTableHeadName($affective_ID,$affective_name,$affective_detail,$affective_en){
		$this->haffective_ID=$affective_ID;
		$this->haffective_name=$affective_name;
		$this->haffective_detail=$affective_detail;
		$this->haffective_en=$affective_en;
	}
	
	public function showTable(){
		echo '<table width="'.$this->width.'" border="'.$this->border.'" cellspacing="0" cellpadding="3">';
  		echo '<tr>';
    	echo '<td align="center" valign="middle"><b>'.$this->haffective_ID.'</b></td>';
    	echo '<td align="center" valign="middle"><b>'.$this->haffective_name.'</b></td>';
    	echo '<td align="center" valign="middle"><b>'.$this->haffective_detail.'</b></td>';
    	echo '<td align="center" valign="middle"><b>'.$this->haffective_en.'</b></td>';
  		echo '</tr>';
		for($i=mysql_num_rows($this->affective_query);$i>=1;$i--){
			$this->fetchRow($query);
  			echo '<tr>';
   	 		echo '<td align="center" valign="middle">'.$this->affective_ID.'</td>';
    		echo '<td valign="middle">'.$this->affective_name.'</td>';
    		echo '<td valign="top">'.$this->affective_detail.'</td>';
    		echo '<td align="center" valign="middle">'.$this->affective_en.'</td>';
  			echo '</tr>';
		}
		echo '</table>';
	}
}
?>