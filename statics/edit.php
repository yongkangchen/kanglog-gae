<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="save" content="history">

<title>欢迎来到QQ邮箱编辑器(菜刀版)</title>
<link rel="stylesheet" type="text/css" href="comm.css" />
<script language="javascript" src="all.js"></script>
<script language="javascript" src="editor.js"></script>
<script language="javascript" src="editor_toolbar.js"></script>
<script language="javascript">
function checkform(){
    if(document.form1.title.value ==""){
	    alert("请输入标题");
		return false;
	}
	var v = DoProcess();
	if(v != true){
	    alert("请输入内容");
		return false;
	}	
}  
</script>
<style type="text/css">
 body { margin:0px auto;background-color:#F5F4EE;}
 .prompt {border:1px dotted #ccc;background-color:#ffe;color:#666;padding: 5px 5px 5px 30px;line-height:120%;width:600px} 
</style>
</head>
<body>
<table width="550" border="0" cellpadding="2" cellspacing="1">
<form name="editForm" method="post" action="?action=saveadd" target="_blank" onSubmit="return checkform();">
  <tr>
    <td align="right">标题：</td>
    <td><input name="log_title" type="text" id="title" value="测试" style="width:260px"><span  id="editor_toolbar_btn_container" style="margin:0 0 0 10px"></span></td>
  </tr>
  <tr>
    <td align="right">分类：</td>
    <td>
		<span id="log_catId">

		</span>
		日期：<input class=text name="log_postTime" value="测试" type="text"/>
	</td>
  </tr>
  <tr>
    <td align="right" valign="top" style="padding-top:4px">内容：</td>
    <td><textarea id="log_content" name="log_content" style="display:none;">您好，欢迎来到QQ邮箱编辑器(菜刀版)！</textarea>
		<script language="javascript">
		gContentId = "log_content";//要载入内容的content ID
		OutputEditorLoading();
		</script>
		<iframe id="HtmlEditor" class="editor_frame" frameborder="0" marginheight="0" marginwidth="0" style="width:100%;height:200px;overflow:visible;" hideFocus></iframe>
	</td>
  </tr>
  <tr>
	<td align="right">密码：</td>
	<td><input id="blogpsw" class="formtext" type="text" maxlength="18" size="15" value="测试" name="log_psw"/>留空不设密码。</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit"  value="确定提交"><input type="reset" value="清除重置" onClick="UnDoProcess();" /></td>
  </tr>
</form>  
</table>
<script>
/*
	var form=document.editForm;
	for(var i  in article){
		if(form[i]){
			form[i].value=article[i];
		}
	}
	document.getElementById("log_catId").innerHTML=categories;
	//article=[{},{"log_postTime":"","log_title":"","log_id":"","log_content":"","log_catId":"","log_author":"","log_psw":""}];
*/
</script>
</body>
</html>