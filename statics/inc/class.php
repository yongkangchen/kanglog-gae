<?
include "db.php";
include "cuthtml.php";
function Page($page)
{
	$max=10;
	$page=$page?$page:1;
	$begin=($page-1)*$max;
	$end=$max;
	if($begin<0){
		$end=$begin+$end;
		$begin=0;
	}
	return "$begin,$end";
}
function jsonFilterStr($str)
{
	$str=preg_replace("/\n/",'\n',$str);
	$str=preg_replace("/\"/","\\\"",$str);
	$str=preg_replace("/\r/",'\r',$str);
	return $str;
}
function doLimit($str,$time)
{
	$now=time();
	if (session_is_registered("$str")||$_SESSION[$str])
	{
		if($now-(int)$_SESSION[$str]<$time)
		{
			return true;
		}
	}
	session_register($str);$_SESSION[$str]=$now;
	return false;
}
function getIp() {
	if (isset($_SERVER)) {
		if (isset($_SERVER[HTTP_X_FORWARDED_FOR])) {
			$realIp = $_SERVER[HTTP_X_FORWARDED_FOR];
		} elseif (isset($_SERVER[HTTP_CLIENT_IP])) {
			$realIp = $_SERVER[HTTP_CLIENT_IP];
		} else {
			$realIp = $_SERVER[REMOTE_ADDR];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$realIp = getenv( "HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$realIp = getenv("HTTP_CLIENT_IP");
		} else {
			$realIp = getenv("REMOTE_ADDR");
		}
	}
	return $realIp;
}
class Skin
{
	var $name;
	var $kind;
}
class Article extends Table
{
	public function __construct()
	{
		parent::__construct("article");//array("id","author","catId","title","content","postTime","psw","comms","views")
	}
	public function getJson()
	{
		$response="article";
		if($_REQUEST["id"]){
			$query="id='".$_REQUEST["id"]."'";
			$comment=true;	
		}else if($_REQUEST["cat_Id"]){
			$query="log_catId='".$_REQUEST["cat_Id"]."'";
		}else if($_REQUEST["year"]){
			$year=$_REQUEST["year"];
			$month=$_REQUEST["month"];
			if($_REQUEST["day"]!=null) {
				$day=$_REQUEST["day"];
				$date_begin=mktime(0,0,0,$month,$day,$year);//echo date("Y-m-d",mktime(0,0,0,$month,$day,$year));
				$date_end=mktime(0,0,0,$month,$day+1,$year);//echo date("Y-m-d",mktime(0,0,0,$month,$day+1,$year));
			}else{
				$date_begin=mktime(0,0,0,$month,1,$year);//echo date("Y-m-d",mktime(0,0,0,$month,1,$year));
				$date_end=mktime(0,0,0,$month+1,1,$year);//echo date("Y-m-d",mktime(0,0,0,$month+1,1,$year));
			}
			$query = "UNIX_TIMESTAMP(log_postTime) between \"$date_begin\" AND \"$date_end\"";
			$response.="&calendar";
		}else $query="1=1";
		
		$Article=$this->query("$query order by log_postTime desc limit ".page($_REQUEST["page"]));
		$Article=$this->dealContent($Article,$comment);
		array_unshift($Article,array("response"=>"$response","comment"=>$comment,"page"=>$_REQUEST["page"],"count"=>$this->getCount($query),"max"=>"10","admin"=>""));
		echo json_encode($Article);
	}
	public function getJsonByCate()
	{
		$query="log_catId='".$_REQUEST["cat_Id"]."'";

		$Article=$this->query("$query order by log_postTime desc limit ".page($_REQUEST["page"]));
		$Article=$this->dealContent($Article,$comment);
		array_unshift($Article,array("response"=>"category&".$_REQUEST["cat_Id"],"comment"=>$comment,"page"=>$_REQUEST["page"],"count"=>$this->getCount($query),"max"=>"10","admin"=>""));
		echo json_encode($Article);
	}
	private function dealContent($Article,$comment){
		foreach($Article as &$log){
			if($log->log_psw && $_SESSION["logined"]!=="true" && $log->log_psw!=$_REQUEST["log_psw"]){
				$log->log_content="";
				if($_REQUEST["log_psw"] && $log->log_psw!=$_REQUEST["log_psw"]){
					$log->log_psw=0;
				}else $log->log_psw=1;
			}else{
			 unset($log->log_psw);
			 if($comment==false){//hava bug @@@@@@@
				$log->log_more=1;
				$log->log_content=preg_replace("/<br>/is","<br/>",$log->log_content);
				if(stristr($log->log_content,"[separator]")){
					$log->log_content=htmlSubString($log->log_content,"[separator]");
				} else if(getStringLength($log->log_content)>400) {
					$log->log_content=htmlSubString($log->log_content,400);
				}else	$log->log_more=0;
			 }else $log->log_content=preg_replace("/\[separator\]/is","",$log->log_content);
			}
		}
		return $Article;
	}
	public function search()
	{
		$searchfor=$_REQUEST["searchfor"];
		if(getStringLength($searchfor)<10 && getStringLength($searchfor)>2){
			if(doLimit("search",15)){
				exit( "'为了节省系统资源，您不能在太短的时间里连续搜索。您的两次搜索的最短间隔为：15秒。'");
			}
			$query="log_psw='' and (`log_title` like '%$searchfor%' or `log_content` like '%$searchfor%')";
			$Article=$this->query("$query order by log_postTime desc");
			$Article=$this->dealContent($Article,$comment);
			array_unshift($Article,array("response"=>"search","comment"=>$comment,"admin"=>""));
			echo json_encode($Article);
		}else{
			exit("'搜索内容过短或过长.'");
		}
	}
}
/*
class Config extends Table
{
	function __construct()
	{
		parent::__construct(array("id"));
	}
}
class Category extends Table
{

	function __construct()
	{
		parent::__construct(array("id","name"));
	}
}
class GuestBook extends Table
{
	function __construct()
	{
		parent::__construct(array("id","content","messager","qq","url","mail","postTime","reply","replyTime","ip"));
	}
}
class Comment extends Table
{
	function __construct()
	{
		parent::__construct(array("id","content","messager","qq","url","mail","postTime","reply","replyTime","ip","log_id"));
	}
}
*/
?>
