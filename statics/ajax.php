<?
session_start();
include "inc/class.php";
if(false){
	$Blog_Table=new Table("config");
	$Blog=$Blog_Table->query("id=1");
	print_r($Blog);
}
$action=$_REQUEST["action"];
if($action=="article"){
	$articles=new Article();
	echo $articles->getJson();
}else if($action=="category"){
	$articles=new Article();
	echo $articles->getJsonByCate();
}else if($action=="search"){
	$articles=new Article();
	echo $articles->search();
}else if($action=="getcategory"){
	$Category_Table=new Table("category");
	$Category=$Category_Table->query(null);
	@array_unshift($Category,array("response"=>$action));
	echo json_encode($Category);
}else if($action=="getcomment" || $action=="getguestbook"){
	$_action=preg_replace("/get/","",$action);
	$Table=new Table($_action);
	$data=$Table->query("1=1 order by postTime desc limit 0,10");
	@array_unshift($data,array("response"=>$action));
	echo json_encode($data);
}else if($action=="comment" || $action=="guestbook"){
	$Comment_Table=new Table($action);
	if($_REQUEST["id"]){
		$query="log_id='".$_REQUEST["id"]."'";
	}else $query="1=1";
	$Comment=$Comment_Table->query("$query order by postTime desc limit ".page($_REQUEST["page"]));
	@array_unshift($Comment,array("response"=>$action,"max"=>"10","page"=>$_REQUEST["page"],"count"=>$Comment_Table->getCount($query)));
	echo json_encode($Comment);
}else if($action=="getcalendar"){
    if($_REQUEST["year"]==null) {
        $year=date("Y");
        $month=date("m");
    } else {
        $year=$_REQUEST["year"];
        $month=$_REQUEST["month"];
    }
    $date_begin=mktime(0,0,0,$month,0,$year);
    $date_end=mktime(0,0,0,$month+1,0,$year);
	$n=date("t",mktime(0,0,0,$month,1,$year));

	$Calendar_Table=new Table("article");
	$date=$Calendar_Table->queryValue("Date(`log_postTime`) as postTime","UNIX_TIMESTAMP(`log_postTime`) between \"$date_begin\" AND \"$date_end\"");
    echo "new Array(";
    for($i=1;$i<=$n;$i++) {
        $comma=$i==$n?"":",";
        $date_temp=(object)array("postTime"=>date("Y-m-d",mktime(0,0,0,$month,$i,$year)));
        if($date && in_array($date_temp, $date)) echo 1;
        else echo 0;
        echo $comma;
    }
    echo ")";
}else if($action=="gb"||$action=="comm"){
    if(@!eregi($_REQUEST["random"],$_SESSION["code"]))
		exit("'验证码错误'");
	if(doLimit("search",15))
		exit("'为了节省系统资源，您不能在太短的时间里连续留言或评论。最短间隔为：30秒。'");

	$Messager=trim($_REQUEST["Messager"]);$Url=$_REQUEST["Url"];$QQ=$_REQUEST["QQ"];$Main=$_REQUEST["Mail"];$Content=trim($_REQUEST["Content"]);
	$log_id=$_REQUEST["log_id"];$messageto="guestbook";
	if(!strlen($Content)>5)
		exit("'内容不能少于5个字'");
	if(!strlen($Messager)>1)
		exit("'昵称不能少于2个字'");
	if($QQ!="" && !preg_match("/[1-9][0-9]{4,9}/",$QQ))
		exit("'QQ不正确'");
	if($Mail!="" && !preg_match("/[_a-z0-9-]+(.[_a-z0-9-]+)*[a-z0-9-]+(.[a-z0-9-]+)*/",$Mail))
		exit("'电子邮箱输入错误'");
	if($Url!="" && !preg_match("/[:\/.0-9a-zA-Z]{1,}/",$Url))
		exit("'主页地址错误'");
	$Messager=preg_replace("/</","&lt;",$Messager);
	$Url=preg_replace("/</","&lt;",$Url);
	if(!preg_match("/\http:\/\//",$Url))
		$Url="http://".$Url;
	$Mail=preg_replace("/</","&lt;",$Mail);
	$Content=preg_replace("/</","&lt;",$Content);
	$ip=getIp();
	if($log_id && $action=="comm") {
		$data=array("messager"=>"'$Messager'","url"=>"'$Url'","qq"=>"'$QQ'","mail"=>"'$Mail'","content"=>"'$Content'","ip"=>"'$ip'","log_id"=>"'$log_id'");
		$Comment=new Table("comment");
		$Comment->insert($data);

		$articles=new Article();
		$articles->update(array("log_comms"=>"log_comms+1"),"id=\""."$log_id\"");//@@@
	}else{
		$data=array("messager"=>"'$Messager'","url"=>"'$Url'","qq"=>"'$QQ'","mail"=>"'$Mail'","content"=>"'$Content'","ip"=>"'$ip'");
		$Comment=new Table("guestbook");
		$Comment->insert($data);
	}
	echo"{\"response\":\"success\",\"log_id\":\"$log_id\"}";
	$body="昵称:{$Messager}\n主页:{$Url}\nQQ:{$QQ}\n邮箱:{$Mail}\n内容:{$Content}\nIP:{$ip}\n{$log_id}";
	$subject=$action;
	include ("inc/sendmail.php");
}else if($action=="gettime") {
	echo"[{\"response\":\"gettime\"},{\"time\":\"".date("Y-m-d H:i:s",time())."\"}]";return;
}
if(session_is_registered("logined")&& $_SESSION["logined"]==="true") {
	if($action=="logout") {
		echo"'logoutsuccess'";session_unregister("logined");session_unset();session_destroy();
	}
    if($action=="post"||$action=="edit") {
        $log_catId=$_REQUEST["log_catId"];$log_title=$_REQUEST["log_title"];$log_author="小康";$log_content=$_REQUEST["log_content"];$log_postTime=$_REQUEST["log_postTime"];$log_psw=$_REQUEST["log_psw"];
        $log_content=preg_replace("/'/",'‘',$log_content);
		$log_postTime=$log_postTime?$log_postTime:date("Y-m-d H:i:s",time());
		$articles=new Article();
		$data=array("log_catId"=>"'$log_catId'","log_title"=>"'$log_title'","log_author"=>"'$log_author'","log_content"=>"'$log_content'","log_postTime"=>"'$log_postTime'","log_psw"=>"'$log_psw'");
		$category=new Table("category");
		$update_cate=false;
        if($action=="edit") {
            $log_id=$_REQUEST["id"];
			$old_catId=$articles->queryValue("log_catId","id='$log_id'");
			if($old_catId!=$log_catId){
				$category->update(array("cat_count"=>"cat_count+1"),"cat_name='$log_catId'");
				$category->update(array("cat_count"=>"cat_count-1"),"cat_name='$old_catId'");
				$update_cate=true;
			}
			$articles->update($data,"id='$log_id'");
        }else{
			$log_id=$articles->insert($data);
			//$category->updateByStr("update `blog_category` set cat_count=(select count(*) from blog_article WHERE cat_name=log_catId)");
			$category->update(array("cat_count"=>"cat_count+1"),"cat_name='$log_catId'");
			$update_cate=true;
			if($log_catId=="他人语录" || $log_catId=="个人语录" || $log_catId=="个人日记" ){
				$body=$log_content;
				$subject="[".$log_catId."]".$log_title;
				$to="278171718@qzone.qq.com";
				//include ("inc/lx1988.php");
			}
		}
        echo "['postsuccess','$log_id','$update_cate']";
	}else if($action=="del"){
		$id=$_REQUEST["id"];
		$cmd=$_REQUEST["cmd"];
		$table=new Table($cmd);
		switch($cmd){
			case "article": $old_catId=$table->queryValue("log_catId","id='$id'");
							$table->delById($id);
							$comment=new Table("comment");
							$comment->del("log_id='$id'");
							$category=new Table("category");
							$category->update(array("cat_count"=>"cat_count-1"),"cat_name='$old_catId'");
							break;
			case "comment":$comment=$table->query("id='$id'");
							$log_id=$comment[0]->log_id;
							$table->delById($id);
							$article=new Article();
							$article->update(array("log_comms"=>"log_comms-1"),"id='$log_id'");
							break;
			case "guestbook":$table->delById($id);
							break;
			case "category":$category=$table->query("id='$id'");
							$cat_name=$category[0]->cat_name;
							$table->delById($id);
							$article=new Article();
							$article->del("log_catId='$cat_name'");
							break;
			default:exit("'操作失败'");
		}
		echo "[{\"response\":\"delsuccess\"},{\"action\":\"$cmd\",\"id\":\"$id\"}]";
	}else if($action=="editcatename") {
        $cat_name=$_REQUEST["cat_name"];
		$name=$_REQUEST["name"];
		$category=new Table("category");
		$category->update(array("cat_name"=>"'$cat_name'"),"cat_name='$name'");
		
		$article=new Article();
		$article->update(array("log_catId"=>"'$cat_name'"),"log_catId='$name'");
        echo "'修改分类成功'";
    }else if($action=="reply") {
        $where=$_REQUEST["where"];$id=$_REQUEST["id"];$reply=$_REQUEST["Content"];
		$table=new Table($where);
		$table->update(array("reply"=>"'$reply'","replyTime"=>"now()"),"id='$id'");
        echo "{\"response\":\"success\",\"where\":\"$where\",\"id\":\"$id\",\"reply\":\"$reply\",\"replyTime\":\"".date("Y-m-d H:i:s",time())."\"}";
    }else if($action=="batcmd") {
        $log_id=$_REQUEST["log_id"];
	$article=new Article();	
	$action=$_REQUEST["cmd"];
	//echo "id in ($log_id)";
        if($action=="del") {
            $article->del("id in ($log_id)");
            $comment=new Table("comment");
	    $comment->del("log_id in ($log_id)");
        } else if($action=="move") {
            $log_catId=$_REQUEST["log_catId"];
            $article->update(array("log_catId"=>"'$log_catId'"),"id in ($log_id)");
	    $category=new Table("category");
	    $category->updateByStr("update `blog_category` set cat_count=(select count(*) from blog_article WHERE cat_name=log_catId)");
        }
        echo"'batdelsucces'";
    }
}else if($action=="login"){
    $login="'falied'";
	$Blog_Table=new Table("config");
	$Blog=($Blog_Table->query("id=1"));
	$Blog=$Blog[0];

    if($Blog->username===$_POST["user_name"]&&$Blog->password===$_POST["user_password"]){
        $login="'success'";session_register("logined");$_SESSION["logined"]="true";
		if($_POST["rt"]) setcookie(session_name(), session_id(), time()+(int)$_POST["rt"]);}
    echo $login;
}
?>
