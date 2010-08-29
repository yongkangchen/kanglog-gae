<?php
$loginHtml[0]=<<<eot
	<span id="logintext" >
		<a  href="javascript:void(0)" onClick="blog.skin.login()" >登录</a>
	</span>
eot;
$loginHtml[1]=<<<eot
	<span id="logintext" >
		您好，欢迎登录。
		<a  href="javascript:void(0)" onClick="blog.logout();">登出</a><br>
		<a  href="javascript:void(0)" onClick="blog.articles.post()">发表日志</a><br>
		<a  href="javascript:void(0)" onClick="blog.categorys.add();">增加分类</a><br>
		<a  href="javascript:void(0)" onClick="config.send()">blog设置</a><br>
		<a  href="javascript:void(0)" onClick="skinList.add()">增加皮肤</a><br>
		<a  href="javascript:void(0)" onClick="skinList.edit()">编辑皮肤列表</a><br>
		<a  href="javascript:void(0)" onClick="link.add()">增加链接</a><br><a  href="javascript:void(0)" onClick="link.edit()">编辑链接</a>
	</span>
eot;
@session_start();
function getLogin(){
	global $loginHtml,$logoutHtml;
	if (session_is_registered("logined")||$_SESSION["logined"]==="true")
	{
		return $loginHtml[1];
	}else{
		return $loginHtml[0];
	}
}
?>
