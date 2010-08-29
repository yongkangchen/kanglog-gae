<?php
@header("Content-Type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";?>
<rss version="2.0">
<channel>
<?php
include_once("inc/class.php");
$Blog_Table=new Table("config");
$Blog=($Blog_Table->query("id=1"));
$Blog=$Blog[0];

$condition="";
$max=10;
$log_catId=$_REQUEST["log_catId"];
if($log_catId) $condition="log_catId='$log_catId'";
else $condition="1=1";
$condition.=" ORDER BY log_postTime DESC limit 0,$max";
$Article=new Article();
$articles=$Article->query($condition);
?>
<title><![CDATA[<?=$Blog->name?>]]></title>
<link><?=$Blog->url?></link>
<description><![CDATA[<?=$Blog->desc?>]]></description>
<language>zh-cn</language>
<copyright><![CDATA[Copyright <?=date("Y")?>, <?=$Blog->name?>]]></copyright>
<webMaster><![CDATA[<?=$Blog->email?> (<?$Blog->author?>)]]></webMaster>
<generator>kanglog 2.0</generator>
<pubDate><?=date("Y")?></pubDate>
<?php
foreach($articles as $article)
{
 ?>
<item>
    <link><![CDATA[<?php echo $Blog->url."/index.php?#article&".$article->id?>]]></link>
	<title><![CDATA[<?php echo $article->log_title?>]]></title>
	<author><![CDATA[<?php echo $article->log_author?>]]></author>
	<category><![CDATA[<?php echo $article->log_catId?>]]></category>
	<pubDate><?php echo $article->log_postTime?></pubDate>
	<description><![CDATA[<?php if($article->log_psw=="") echo $article->log_content;else echo "这是一篇加密日志";?>]]></description>
</item>
<?php } ?>
</channel>
</rss>