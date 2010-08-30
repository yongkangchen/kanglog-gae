function Articles(blog){
	var _blog=blog;
	var _cmd="article";
	var _mode=1;//当前阅读模式
	var _modeHistory;//阅读模式备份

	//一个cell的点击事件
	var cellClickEvent=function(evt){
		evt=evt||window.event;
		var target=evt.target || evt.srcElement;
		var input=$$("input",target)[0];
		if(input){
			input.checked=!input.checked;
		}
	}
	var cellOverEvent=function(evt){
		this.style.backgroundColor="#D6DDE5";
	}
	var cellOutEvent = function(evt){
		this.style.backgroundColor="";
	}
	//implements AdminAble
	this.Abstract(AdminAble,{
		getAdminData:function(){return this.getCaches();},
		innerAdminHtml:function(data,isAdmin){
			var divName="log_id";
			for(var i=1,l=data.length;i<l;i++){
				var id=data[i].id;
				var html="";
				var div=$(divName+id);
				if(div){
					if(isAdmin){
						html="<a href=javascript:void(0) onClick=\"blog.articles.edit("+id+")\"><img src=\"images/icon_edit.gif\" alt=\"编辑\" /></a>|<a href=javascript:void(0) onClick=\"if (confirm('确定要删除这篇日志吗？')) blog.del('article',"+id+")\"><img src=\"images/icon_del.gif\" alt=\"删除\" />  </a>";
						if(_mode==2){
							html="<input type=\"checkbox\" name=\"log_id\" value="+id+" />"+html;
							var node=div.parentNode.parentNode;
							node.onclick=cellClickEvent;
							node.onmouseover=cellOverEvent;
							node.onmouseout=cellOutEvent;
						}
					}
					div.innerHTML=html;
				}
			}
		}
	});

	//implements DataCacher
	this.Abstract(DataCacher,{
		getCmd:function(){
			return _cmd;
		}
	});
	//implements PageAble
	this.Abstract(PageAble,{
		pageBack:_showBack,
		getDatas:this.getDatas
	});

	this.setCmd=function(cmd){
		_cmd=cmd;
	}
	this.changeMode=function(mode){
		if(_mode==mode) return;
		this.modeSave(mode);
		_blog.url.fresh();
	}
	this.modeSave=function(mode){
		_modeHistory=_mode;
		if(mode) _mode=mode;
	}
	this.modeRecov=function(){if(_modeHistory && _mode!=_modeHistory)	_mode=_modeHistory;}
	this.showById=function(id){
		this.modeSave(1);
		this.getDataById(id,_showBack);
	}
	this.showByCalen=function(year,month,day){//@@@@@
		if(!day) day="";
		_cmd="article&year="+year+"&month="+(month-1+1)+"&day="+day;
		this.getDatas([_showBack]);
		_cmd="article";
	}
	this.updateByObj=function(article){
		var data=["",article];
		update(data);
	}
	function update(data){
		var i=1,sumstr="";
		if(_mode==1){
			sumstr+=Skin.html.article(data[1])
			var div=$("post-"+data[1].id);
			if(div){
				div.innerHTML=sumstr;
			}
			else{
				
				var div=document.createElement("div");
				div.className="post";
				div.id="post-"+data[1];
				div.innerHTML=sumstr;
				$(Skin.html.contentDiv).appendChild(div);
			}
		}else if(_mode==2){
			alert("need to be done");
		}
		this.showAdminTool();			
	}
	this.updateById=function(id){
		this.getDataById(id,update);
	}
	this.batCheck=function(form){
		if(!checkBoxNum(form.log_id)){
			ActiveLayer.alert('没有选中项');return false;
		}
		var msg;
		if(form.cmd.value=='del'){
			msg='确认删除？'
		}else msg='确认移动？';
		if(confirm(msg)) return true;
		else return false;
	}
	function _showBack(data,page){
		if(data.length==1){
			_blog.skin.contentInner("没有日志。");
			_blog.setTitle("没有日志");
			return;
		}
		var sumstr=Skin.html.articleList(_mode,data);
		var windowTitle;
		if(data[0]==null || data[0].comment==true){ 
			this.modeRecov();
			windowTitle=data[1].log_title;
			sumstr+=_blog.skin.messagepost("comm&log_id="+data[1].id);//@@@#
			var hash='<a name="article&'+data[1].id+'"></a>';
			_blog.skin.contentInner(hash+sumstr);
			
			var node=$("log_id"+data[1].id).nextSibling;
			node.innerHTML=node.innerHTML.replace("+","-");
			
			_blog.comments.show(data[1].id);//@@@#
		}else{
			sumstr=Skin.html.mode+sumstr+this.page(data[0]);
			_blog.skin.contentInner(sumstr);
		}
		_blog.setTitle(windowTitle);
		this.showAdminTool();
	}
	this.edit=function(id){
		this.getDataById(id,this.post);
	}
	this.post=function(article){
		var action="edit";
		if(article==null){
			 article=[{},{"log_postTime":"","log_title":"","log_id":"","log_content":"","log_catId":"","log_author":"","log_psw":""}];
             //edit.display("gettime");
			 action="post";
		}
		this.editArticle=article[1];
		var p={caption:"发表日志",width:550,height:438,html:""};
		p.html='<iframe ID="blogEditor" name="blogEditor"  frameBorder="0" marginHeight="0" marginWidth="0" scrolling="No" style="height:350px;width:100%"></iframe>';
		openActiveLayer(p); //send to diaplay the post box;
		var editor=$("blogEditor");
		editor.src="HtmlEditor/index.html";
	}
	this.bat=function(data){
		if(data=="batdelsucces"){
			_blog.url.fresh();
			_blog.freshCategory();
		}else{alert("操作失败");}
	}
}
