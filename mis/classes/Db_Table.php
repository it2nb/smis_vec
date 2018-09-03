<?php
class Db_Table{
	private $dbconnecttion;
	protected $tb_query;
	protected $table;
	protected $ID;
	function __construct($dbconnecttion){
		$this->dbconnecttion = $dbconnecttion;
	}
	
	public function queryAll(){
		$query='Select * From '.$this->table.' Order By '.$this->ID.' ASC';
		return $this->tb_query=mysql_query($query);
	}
	
	public function queryLimit($limit,$start){
		$query='Select * From '.$this->table.' Order By '.$this->ID.' ASC Limit '.$start.','.$limit;
		return $this->tb_query=mysql_query($query);
	}
	
	public function queryByID($ID){
		$query='Select * From '.$this->table.' Where '.$this->ID.'="'.$ID.'"';
		$this->tb_query=mysql_query($query);
		$this->fetchRow();
	}
	
	public function queryByFk($fkField,$fkData){
		$query='Select * From '.$this->table.' Where '.$fkField.'="'.$fkData.'"';
		return $this->tb_query=mysql_query($query);
	}
	
	public function queryByMultiField($fieldData_Array){
		$query='Select * From '.$this->table.' Where ';
		$i=1;
		foreach($fieldData_Array as $key=>$value){
			$query .= $key.'="'.$value.'"';
			if($i<count($fieldData_Array)){
				$query .= ' and ';
			}
			$i++;
		}
		return $this->tb_query=mysql_query($query);
	}
	
	public function queryBySql($sqlCommand){
		$this->tb_query=mysql_query($sqlCommand);
		return $this->tb_query;
	}
	
	protected function fetchRow(){
		$fetch=mysql_fetch_assoc($this->tb_query);
		return $fetch;
	}
	
	public function countRow(){
		return mysql_num_rows($this->tb_query);
	}
	
	protected function insertData($fieldData_Array){
		$i=1;
		foreach($fieldData_Array as $key=>$value){
			$field .= $key;
			$data .=  '"'.$value.'"';
			if($i<count($fieldData_Array)){
				$field .= ',';
				$data .= ',';
			}
			$i++;
		}
		$query='Insert Into '.$this->table.'('.$field.') Values ('.$data.')';
		return $this->tb_query=mysql_query($query);
	}
	
	protected function updateData($ID,$attr,$value){
		$query='Update '.$this->table.' Set '.$attr.'="'.$value.'" Where '.$this->ID.'="'.$ID.'"';
		return $this->tb_query=mysql_query($query);
	}
	
	protected function updateDataByFk($fkField,$fkData,$attr,$value){
		$query='Update '.$this->table.' Set '.$attr.'="'.$value.'" Where '.$fkField.'="'.$fkData.'"';
		return $this->tb_query=mysql_query($query);
	}
	
	protected function updateByMultiField($UpdateAttr,$new_value,$WherefieldData_Array){
		$query='Update '.$this->table.' Set '.$UpdateAttr.'="'.$new_value.'" Where ';
		$i=1;
		foreach($WherefieldData_Array as $key=>$value){
			$query .= $key.'="'.$value.'"';
			if($i<count($WherefieldData_Array)){
				$query .= ' and ';
			}
			$i++;
		}
		return $this->tb_query=mysql_query($query);
	}
	
	public function deleteData($ID){
		$query='Delete From '.$this->table.' Where '.$this->ID.'="'.$ID.'"';
		return $this->tb_query=mysql_query($query);
	}
	
	protected function deleteDataByField($fieldName,$fieldData){
		$query='Delete From '.$this->table.' Where '.$fieldName.'="'.$fieldData.'"';
		return $this->tb_query=mysql_query($query);
	}
	
	protected function deleteDataByMultiField($WherefieldData_Array){
		$query='Delete From '.$this->table.' Where ';
		$i=1;
		foreach($WherefieldData_Array as $key=>$value){
			$query .= $key.'="'.$value.'"';
			if($i<count($WherefieldData_Array)){
				$query .= ' and ';
			}
			$i++;
		}
		return $this->tb_query=mysql_query($query);
	}
	
	public function deleteAllData(){
		$query='Delete From '.$this->table;
		return $this->tb_query=mysql_query($query);
	}
}
?>