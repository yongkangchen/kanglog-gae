<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
@header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);
@session_start();
//@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//@header("Cache-Control: no-cache, must-revalidate");
//@header("Pragma: no-cache");
include("inc/class.php");
$Blog_Table=new Table("config");
$Blog=($Blog_Table->query("id=1"));
$Blog=$Blog[0];

$skinKind="";
if($_REQUEST["skin"]) {
	$blog_skinname=$_REQUEST["skin"];
	if($_REQUEST["skinkind"]){
		$skinKind=$_REQUEST["skinkind"];
	}else{
		$skinKind="pjblog";
	}
}
else {
	$blog_skinname=$Blog->skin;
	$skinKind=$Blog->skin;
}
include('inc/skin/function.html.php');
include("inc/skin/$skinKind/js.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta name="author" content="xiao-kang" />
<meta name="description" content=<?=$Blog->desc?> />
<meta name="keywords" content="Kanglog" />
<title><?=$Blog->name?>-<?=$Blog->desc?></title>

<link type="text/css" rel="stylesheet" href="js/activelayer.css" />
<link id=skinstyles type="text/css" rel="stylesheet" href=skins/<?=$blog_skinname?>/styles.css />
<!--[if IE 6]>
   <style type="text/css">
	   /*<![CDATA[*/ 
			html {overflow-x:auto; overflow-y:hidden;}
	   /*]]>*/
   </style>
<![endif]-->
<style type="text/css">
body {
    margin:0;
    border:0;
    height:100%; /* 必须 */
    overflow-y:auto;/* 必须 */
}
img{
	border:0;
}
.index li{list-style-image:url(images/arrow.gif);}


a,area { blr:expression(this.onFocus=this.blur()) } /* for IE */
:focus { -moz-outline-style: none; } /* for Firefox */
</style>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script>
<?require("js/php_functions.php");?>
</script>
</head>
<body>


<iframe name="historyFrame" style="display:none;" width="0" height="0" src="history.html"></iframe>
<span id="skin_name" style="display:none;"><?=$blog_skinname?></span>
<span id="loading"><img src="images/load.gif" align="absbottom" />页面加载中loading...</span>
<div id="AlertLayer" class="AlertLayer"></div>
<div id="ActiveLayer" class="ActiveLayer"></div>
<div id="ShadowLayer" class="ShadowLayer"></div>
<?
	require("inc/skin/$skinKind/html.php");
?>
</body>
</html>
