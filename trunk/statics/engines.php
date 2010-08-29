<?php
@header("Content-Type: text/html; charset=utf-8");
include("inc/class.php");
$Blog_Table=new Table("config");
$Blog=($Blog_Table->query("id=1"));
$Blog=$Blog[0];
$id=$_REQUEST["id"];
$catId=$_REQUEST["catId"];
if(!getenv("HTTP_REFERER")){

	if($id){
		$table=new Article();
		$article=$table->queryById($id);
		$article=$article[0];
		$title=$article->log_title;
		if($article->log_psw!="")
			$article->log_content="这是一篇加密日志";
		$content.="<p>标题：$title</p><p>作者：$article->log_author</p><p>发表日期：".$article->log_postTime."</p><p>内容：<br/>".$article->log_content."</p>";
	}
	else if($catId)
	{
		$table=new Article();
		$articles=$table->query("log_catId='$catId'");
		$title=$catId;
		foreach($articles as $article){
			$content.="<a href=\"?id=".$article->id."\">".$article->log_title."</a>\n";
		}
	}
	else {
		$table=new Table("category");
		$rs=$table->queryValue("cat_name",null);
		$title=$Blog->desc;
		foreach($rs as $category)
		{
			$content.="<a href=\"?catId=".$category->cat_name."\">".$category->cat_name."</a>\n";
		}
	}
}
else {
	if($id) $url="index.php#article&$id";
	else if($catId) $url="index.php#category&$catId";
	else $url="index.php";
	echo "<script>document.location.href=\"$url\";</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta name="robots" content="all" />
<meta name="author" content="xiao-kang" />
<meta name="description" content=<?=$Blog->desc?> />
<title><?=$Blog->name."——".$title?></title>
</head>
<body>
<?=$content?>
</body>
</html>