<?php
error_reporting(0);
class Db_Connection {
	private $conn;
	function __construct($db_user,$db_pass,$db_host){
        if(version_compare(PHP_VERSION,'7.0.0','<')){
		  $this->conn = mysql_pconnect($db_host,$db_user,$db_pass);
		  mysql_query("SET NAMES UTF8");
        }
        else{
            $this->conn = mysqli_connect($db_host,$db_user,$db_pass);
            mysqli_query($this->conn,"SET NAMES UTF8");
        }
	}
	
	public function setDbName($db_name){
        if(version_compare(PHP_VERSION,'7.0.0','<')){
		  mysql_select_db($db_name,$this->conn);
		  mysql_query("SET NAMES UTF8");
        }
        else{
            mysqli_select_db($this->conn,$db_name);
        }
		return $this->conn;
	}
}
$smis_db = 'smis_db';
$grade_db = 'smis_db';
$dbconnection = new Db_Connection('root','root_password','localhost');
$conn = $dbconnection->setDbName($smis_db);
if(version_compare(PHP_VERSION,'7.0.0','>=')){
    function mysql_query($query,$conn){
        return mysqli_query($conn,$query);
    }
    
    function mysql_result($query,$row,$field){
        return mysqli_result($query,$row,$field);
    }
    function mysql_fetch_assoc($query){
        return mysqli_fetch_assoc($query);
    }
    
    function mysql_fetch_array($query){
        return mysqli_fetch_array($query);
    }
    
    function mysql_num_rows($query){
        return mysqli_num_rows($query);
    }
    
    function mysql_error(){
        mysqli_error();
    }
    function split($pattern,$string){
        return explode($pattern,$string);
    }
    
    function mysqli_result($result,$row,$field) {
        if ($result===false) return false;
        if ($row>=mysqli_num_rows($result)) return false;
        if (is_string($field) && !(strpos($field,".")===false)) {
            $t_field=explode(".",$field);
            $field=-1;
            $t_fields=mysqli_fetch_fields($result);
            for ($id=0;$id<mysqli_num_fields($result);$id++) {
                if ($t_fields[$id]->table==$t_field[0] && $t_fields[$id]->name==$t_field[1]) {
                    $field=$id;
                    break;
                }
            }
            if ($field==-1) return false;
        }
        mysqli_data_seek($result,$row);
        $line=mysqli_fetch_array($result);
        return isset($line[$field])?$line[$field]:false;
    }
}
?>