<?php
require_once 'Db_Table.php';
class Persmenu extends Db_Table{
	public $personnel_ID;
	public $menu_ID;
	public $persmenu_en;
	
	function __construct($dbconnecttion){
		$this->table = 'persmenu';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$persmenu_fetch = parent::fetchRow();
		$this->personnel_ID=$persmenu_fetch['personnel_ID'];
		$this->menu_ID=$persmenu_fetch['menu_ID'];
		$this->persmenu_en=$persmenu_fetch['persmenu_en'];
		return $persmenu_fetch;
	}
	
	public function queryByID($personnel_ID,$menu_ID){
		$query='Select * From '.$this->table.' Where personnel_ID="'.$personnel_ID.'" and menu_ID="'.$menu_ID.'"';
		$this->tb_query=mysql_query($query);
		$this->fetchRow();
	}
	
	public function insertData($personnel_ID,$menu_ID,$persmenu_en){
		$fieldData_Array = array('personnel_ID'=>$personnel_ID,
								'menu_ID'=>$menu_ID,
								'persmenu_en'=>$persmenu_en);
		parent::insertData($fieldData_Array);
	}
	
	public function updateEnable($personnel_ID,$menu_ID,$new_en){
		$WherefieldData_Array = array('personnel_ID'=>$personnel_ID,
									'menu_ID'=>$menu_ID);
		parent::updateByMultiField('persmenu_en',$new_en,$WherefieldData_Array);
	}

	public function deleteData($personnel_ID,$menu_ID){
		$WherefieldData_Array = array('personnel_ID' =>$personnel_ID , 'menu_ID'=>$menu_ID);
		parent::deleteDataByMultiField($WherefieldData_Array);
	}
}
?>