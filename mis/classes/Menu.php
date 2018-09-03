<?php
require_once 'Db_Table.php';
class Menu extends Db_Table{
	public $menu_ID;
	public $menu_name;
	public $menu_link;
	public $menu_perm;
	public $menu_en;
	
	function __construct($dbconnecttion){
		$this->table = 'menu';
		$this->ID = 'menu_ID';
	}
	
	public function queryAll(){
		$query='Select * From menu Order By menu_name ASC';
		return $this->tb_query=mysql_query($query);
	}
	
	public function fetchRow(){
		$menu_fetch = parent::fetchRow();
		$this->menu_ID=$menu_fetch['menu_ID'];
		$this->menu_name=$menu_fetch['menu_name'];
		$this->menu_link=$menu_fetch['menu_link'];
		$this->menu_perm=$menu_fetch['menu_perm'];
		$this->menu_en=$menu_fetch['menu_en'];
		return $menu_fetch;
	}
	
	public function insertData($menu_ID,$menu_name,$menu_link,$menu_perm,$menu_en){
		$fieldData_Array = array('menu_ID'=>$menu_ID,
								'menu_name'=>$menu_name,
								'menu_link'=>$menu_link,
								'menu_perm'=>$menu_perm,
								'menu_en'=>$menu_en);
		parent::insertData($fieldData_Array);
	}
	
	public function updateID($menu_ID,$new_ID){
		parent::updateData($menu_ID,'menu_ID',$new_ID);
	}
	
	public function updateName($menu_ID,$new_name){
		parent::updateData($menu_ID,'menu_name',$new_name);
	}
	
	public function updateLink($menu_ID,$new_link){
		parent::updateData($menu_ID,'menu_link',$new_link);
	}

	public function updatePerm($menu_ID,$new_perm){
		parent::updateData($menu_ID,'menu_perm',$new_perm);
	}
	
	public function updateEnable($menu_ID,$new_en){
		parent::updateData($menu_ID,'menu_en',$new_en);
	}
}
?>