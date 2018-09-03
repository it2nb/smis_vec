<?php
require_once 'Db_Table.php';
class Authmenu extends Db_Table{
	public $authority_ID;
	public $menu_ID;
	public $authmenu_en;
	
	function __construct($dbconnecttion){
		$this->table = 'authmenu';
		$this->ID = '';
	}
	
	public function fetchRow(){
		$authmenu_fetch = parent::fetchRow();
		$this->authority_ID=$authmenu_fetch['authority_ID'];
		$this->menu_ID=$authmenu_fetch['menu_ID'];
		$this->authmenu_en=$authmenu_fetch['authmenu_en'];
		return $authmenu_fetch;
	}
	
	public function queryByID($authority_ID,$menu_ID){
		$query='Select * From '.$this->table.' Where authority="'.$authority_ID.'" and menu_ID="'.$menu_ID.'"';
		$this->tb_query=mysql_query($query);
		$this->fetchRow();
	}
	
	public function insertData($authority_ID,$menu_ID,$authmenu_en){
		$fieldData_Array = array('authority_ID'=>$authority_ID,
								'menu_ID'=>$menu_ID,
								'authmenu_en'=>$authmenu_en);
		parent::insertData($fieldData_Array);
	}
	
	public function updateEnable($authority_ID,$menu_ID,$new_en){
		$WherefieldData_Array = array('authority_ID'=>$authority_ID,
									'menu_ID'=>$menu_ID);
		parent::updateByMultiField('authmenu_en',$new_en,$WherefieldData_Array);
	}
	
	public function deleteData($authority_ID,$menu_ID){
		$WherefieldData_Array = array('authority_ID' =>$authority_ID , 'menu_ID'=>$menu_ID);
		parent::deleteDataByMultiField($WherefieldData_Array);
	}

}
?>