<?php
require_once 'Db_Table.php';
class Bossparty extends Db_Table{
	public $year;
	public $term;
	public $party_ID;
	public $personnel_ID;
	
	function __construct($dbconnecttion){
		$this->table = 'bossparty';
		$this->ID = '';
	}
	
	public function queryByID($year,$term,$party_ID){
		$query='Select * From '.$this->table.' Where year="'.$year.'" and term="'.$term.'" and party_ID="'.$party_ID.'"';
		$this->tb_query=mysql_query($query);
		$this->fetchRow();
	}
	
	public function fetchRow(){
		$bossparty_fetch = parent::fetchRow();
		$this->year=$bossparty_fetch['year'];
		$this->term=$bossparty_fetch['term'];
		$this->party_ID=$bossparty_fetch['party_ID'];
		$this->personnel_ID=$bossparty_fetch['personnel_ID'];
		return $bossparty_fetch;
	}
	
	public function insertData($year,$term,$party_ID,$personnel_ID){
		$fieldData_Array = array('year'=>$year,
								'term'=>$term,
								'party_ID'=>$party_ID,
								'personnel_ID'=>$personnel_ID);
		parent::insertData($fieldData_Array);
	}
	
	public function updatePersonnelID($year,$term,$party_ID,$new_personnelID){
		$WherefieldData_Array = array('year' =>$year , 'term'=>$term, 'party_ID'=>$party_ID);
		parent::updateByMultiField('personnel_ID', $new_personnelID, $WherefieldData_Array);
	}
	
	public function deleteData($year,$term,$party_ID){
		$WherefieldData_Array = array('year' =>$year , 'term'=>$term, 'party_ID'=>$party_ID);
		parent::deleteDataByMultiField($WherefieldData_Array);
	}
}
?>