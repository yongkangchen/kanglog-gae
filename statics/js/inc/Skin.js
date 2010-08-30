function Skin(){
	this.contentInner=function(html){
		$(Skin.html.contentDiv).innerHTML=html;
	}
	this.showAdminTool=function(isAdmin){
			var html;
			if(isAdmin){
				html=Skin.config.LOGIN_HTML;
			}else{
				html=Skin.config.LOGOUT_HTML;
			}
			$("logintext").innerHTML=html;
		}
	this.siderBar=new function(){
		this.show=function(data,where){
			$(where).innerHTML="<ul>"+data+"</ul>";
		}
	}
	this.messagepost=function(str){
			var fstr; 
			fstr ="<div class='listbox'><h2 id='respond'>Leave a Message</h2></div>";
			fstr+="		<form id='commentform' name=\"f3\" onsubmit=\"$('submit').disabled='true';return XMLHttp.formSubmit.call(blog,this,blog.leaveMsg);\" method='POST' action='ajax.php?action="+str+"'><div class=formbox>";
			fstr+="			昵称：<input class=text name=\"Messager\" type=\"text\" /><br/>";
			fstr+="			主页：<input class=text name=\"Url\" type=\"text\" /><br/>";
			fstr+="			ＱＱ：<input class=text name=\"QQ\" type=\"text\" /><br/>";
			fstr+="			邮箱：<input class=text name=\"Mail\" type=\"text\" /><br>";
			fstr+="			内容：<textarea id=comment name=\"Content\" cols=\"55\" rows=\"8\" onfocus=\"if(!$('random').src){$('random').click();$('randomspan').style.display='block';}\"></textarea><br>";
			fstr+="			<span id=randomspan style=\"display:none\">";
			fstr+="				验证码:<img id=random onClick=\"this.src='image.php?ran='+Math.random();\" title=\"更换一张验证码图片\" />";
			fstr+="					   <input name=\"random\" type=\"text\" id=\"random\" size=\"5\" maxlength=\"4\" /> 不区分大小写";
			fstr+="						[<a href=\"javascript:void(0);\" onclick=window.setTimeout(\"$('random').click()\",1)>看不清？</a>]<br>";
			fstr+="			</span>";
			fstr+="			<span><input class=\"button\" id=\"submit\" name=\"button\" type=\"submit\" value=\"submit\" />&nbsp;";
			fstr+="			<input  type=\"reset\" value=\"reset\" /></span>";
			fstr+="		</div>";
			fstr+="</form>";
			fstr+="<div class=\"listbox-bottom\"></div>"
			return fstr;
	}
	this.login=function(){
		var p={caption:"登陆",width:270,height:140,html:""};
		p.html+="<form name=f1 onsubmit='return XMLHttp.formSubmit.call(blog,this,blog.login);' action='ajax.php?action=login' method='POST'>";
		p.html+="	<table align=center>";
		p.html+="		<tr><td align=right><strong>帐号:</strong></td>";
		p.html+="			<td><input class=text type=text name=user_name /></td>";
		p.html+="		</tr><tr><td align=right valign=top><strong>密码:</strong></td>";
		p.html+="				 <td><input class=text type=password name=user_password /></td>";
		p.html+="		</tr><tr><td><strong>有效期</strong>：</td>";
		p.html+="				<td>不保存<input name=rt type=radio value=0 checked />";
		p.html+="					1小时<input name=rt type=radio value=3600 />";
		p.html+="					1天<input name=rt type=radio value=86400 /></td>";
		p.html+="		</tr><tr><td colspan=2 align=center>";
		p.html+="					<input class=button type=submit value=登陆 />&nbsp;";
		p.html+="					<input class=button type=button onClick=closeActiveLayer() value=取消 />";
		p.html+="				</td></tr></table></form>";
		openActiveLayer(p);
	}
	this.reply=function(cmd,id){
		var reply;
		var div=$("reply"+id);
		if(div!=null)  reply=div.innerHTML;else reply="";
		var box='<form name="f5" method="POST" action="ajax.php?action=reply&where='+cmd+'&id='+id+'" onsubmit="this.button1.disabled=true;return XMLHttp.formSubmit(this,blog.replyBack)">回复：<br><textarea name="Content" cols="55" rows="8">'+reply+'</textarea><br><input class="userbutton" id="button1" name="button" type="submit" value="提交" />&nbsp;<input class="userbutton" type="reset" value="重置" />&nbsp;<input class="userbutton" type="button" value="取消"  onClick="$(\'edit'+cmd+id+'\').innerHTML=\'\'"/></form>';
		$("edit"+cmd+id).innerHTML=box;
	}
};
