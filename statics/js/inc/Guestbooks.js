function Guestbooks(blog){
	this.cmd="guestbook";
	this.blog=blog;
	//var this=this;

	//iplements AdminAble
	this.Abstract(AdminAble,{
		getAdminData:function(){return this.getCaches();},
		innerAdminHtml:function(data,isAdmin){
			var cmd=this.cmd;
			for(var i=1,l=data.length;i<l;i++){
				var id=data[i].id;
				var html="";
				if($(cmd+id)){
					if(isAdmin){
						html='<a href="javascript:void(0)" onClick="blog.skin.reply(\''+cmd+'\','+id+')"><img src="images/icon_reply.gif" alt="回复" />|</a><a href="javascript:void(0)" onClick="if(confirm(\'确定要删除吗？\')) blog.del(\''+cmd+'\','+id+')"> <img src="images/icon_replydel.gif" alt="删除" /></a>';
					}
					$(cmd+id).innerHTML=html;
				}
			}
		}	
	});
	//implements DataCacher
	this.Abstract(DataCacher,{
		getCmd:function(){
			return this.cmd;
		}
	});

	this.showBack=function(data){
		var replyhtml,where=this.cmd;
		var sumstr;
		sumstr =this.blog.skin.messagepost("gb");//@@@#
		//sumstr+="<br><font size=\"4\" color=\"#ff0000\"><strong>本blog源程序暂停下载,等有时间进一步整理和完善后再发布。</strong></font><br><br>";
		sumstr+=this.page(data[0]);
		sumstr+='<div class="listbox"></div>';
		sumstr+='<ol class="commentlist">';
		for(var i=1,l=data.length;i<l;i++)
		{
		   if(data[i].reply){
			   eval(Skin.config.COMMENT_REPLY_HTML_JS);
		   }else replyhtml="";
		   eval(Skin.config.COMMENT_HTML_JS);
		}
		sumstr+="</ol>";
		sumstr+='<div class="listbox-bottom"></div>';
		this.blog.skin.contentInner(sumstr);//@@@#
		this.blog.setTitle("留言本");
		this.showAdminTool();
	}

	//implements PageAble
	this.Abstract(PageAble,{
		pageBack:this.showBack,
		getDatas:this.getDatas
	});
}


