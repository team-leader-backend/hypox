<?php

/**
 * @info get($table, $where_array='id=1')
 */
class Model
{
    public $link = null;
    private $host = 'localhost';
    private $login = 'root4';
    private $password = 'iLiLa(4884)';
    private $dbname = 'test';
	public function __construct()
    {
            $this->link = mysqli_connect($this->host,$this->login,$this->password,$this->dbname) or die('Not connect DB novost');
            mysqli_query($this->link, "SET NAMES 'utf8';");
            mysqli_query($this->link, "SET CHARACTER SET 'utf8';");
            mysqli_query($this->link,"SET SESSION collation_connection = 'utf8mb4_unicode_ci';");
    }
    public function __destruct()
    {
        mysqli_close($this->link);
    }
	public function get($table, $where_array=null)
	{
        if(is_null($where_array)) {
            $query = mysqli_query($this->link, "SELECT * FROM ".$table) or die('Query SELECT model_sql error. String - ' . __LINE__ );
            while ($row = mysqli_fetch_assoc($query)) {
                $result[] = $row;
            }
            mysqli_free_result($query);
            return $result ?? [];
        }else{
            $wh = '';
            foreach($where_array as $field=>$volume){
                    $wh .= "$volume ";
            }
            $sql = "SELECT * FROM `$table` WHERE ".$wh;
            $query = mysqli_query($this->link, $sql) or die('Query SELECT model_sql error. String - ' . __LINE__ . ' SQL = ' . $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $result[] = $row;
            }
            mysqli_free_result($query);
            return $result ?? [];
        }
	}
}