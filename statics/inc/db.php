<?php
class Database
{
	private static $dbConnect;
	public static function getInstance()
	{
		if(!isset(self::$dbConnect))
		{
			self::$dbConnect=mysql_connect('localhost','@数据库账号','@数据库密码')  or die("Could not connect mysql.");
			mysql_query("SET NAMES 'UTF8'");
		}
		//如果连接失败抛出异常
		if (!self::$dbConnect) {
			throw new Exception("数据库连接失败");
		}
		//选择数据库，如果数据库不存在抛出异常
		if (!mysql_select_db("@数据库名称", self::$dbConnect)) {
			throw new Exception("数据库不存在");
		}
		return self::$dbConnect;
	}
	public static function getTable($tableName)
	{

	}
}
class Table
{
	protected $names;
	private $tableName;
	public function __construct($array)
	{
		$this->tableName=$array;
		/*
		foreach($array as $arr)
		{
			$this->names[$arr]="";
		}
		*/
	}
	public function __set ($name,$value )
	{
		if(isset($this->names[$name]))
		{
			$this->names[$name]=$value;
		}else{
			echo $name;
			throw new Exception("类成员不存在");
		}
	}
	public function query($condition)
	{
		$query="select * from blog_$this->tableName";
		if($condition){
			$query.=" where $condition";
		}
		//echo $query;
		return $this->queryByStr($query);
	}
	public function queryById($id){
		return $this->query("id='$id'");
	}
	public function queryValue($key,$condition){
		$query="select $key from blog_$this->tableName";
		if($condition){
			$query.=" where $condition";
		}
		$res=mysql_query($query,Database::getInstance());
		$objs=array();
		while($valueArr=mysql_fetch_object($res))
		{
			$objs[]=$valueArr;
		} 
		$length=count($objs);
		if($length==0)	return null;
		else if($length==1) return $objs[0]->$key;
		else return $objs;
	}
	public function queryByStr($query)
	{
		//echo $query;
		$res=mysql_query($query,Database::getInstance());
		$filedsNum=mysql_num_fields($res);
		$objs=array();
		while($valueArr=mysql_fetch_object($res))
		{
			/*
			$obj=new $tableName();
			for($i=0;$i<$filedsNum;$i++)
			{
				$key=mysql_field_name($res,$i);
				$obj->$key=$valueArr->$key;
			}
			$objs[]=$obj;
			*/
			$objs[]=$valueArr;
		} 
		return $objs;
	}
	public function getCount($condition)
	{
		$query="select count(*) as countN from blog_$this->tableName";
		if($condition){
			$query.=" where $condition";
		}
		$objs=$this->queryByStr($query);
		return $objs[0]->countN;
	}
	public function insert($data)
	{
		$keys="";
		$values="";
		foreach($data as $key => $value){
			$keys.="$key,";
			$values.="$value,";
		}
		$keys = preg_replace('/,$/', '', $keys);
		$values = preg_replace('/,$/', '', $values);
		$query = "INSERT INTO blog_$this->tableName ($keys) VALUES ($values)";
		mysql_query($query,Database::getInstance());
		return mysql_insert_id();
	}
	public function update($data,$condition){
		$fields="";
		foreach($data as $key => $value){
			$fields .= "$key = $value,";
		}
		$fields = preg_replace('/,$/', '', $fields);
		$query = "UPDATE blog_$this->tableName SET $fields where $condition";
		$this->updateByStr($query);
	}
	public function updateByStr($query){
		mysql_query($query,Database::getInstance());		
	}
	public function delById($id){
		$this->del("id='$id'");
	}
	public function del($condition){
		$query="DELETE FROM blog_$this->tableName";
		if($condition){
			$query.=" where $condition";
		}
		mysql_query($query,Database::getInstance());
	}
}
?>
