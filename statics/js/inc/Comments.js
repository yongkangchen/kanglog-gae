function Comments(blog){this.Extends(Guestbooks);
	this.blog=blog;
	this.cmd="comment";
	this.div=null;
	//var this=this;

	this.show=function(logId,elem){
		this.div=$("ContentComment"+logId);
		if(this.div.innerHTML=="") {
			this.cmd="comment&id="+logId;
			this.getDatas([this.showBack,this.div]);
			this.cmd="comment";
		}else{
			this.div.style.display=(this.div.style.display=="block")?"none":"block";
		}
		if(elem){
			if(elem.innerHTML.indexOf("-")!=-1){
				elem.innerHTML=elem.innerHTML.replace("-","+");
			}
			else elem.innerHTML=elem.innerHTML.replace("+","-");
		}
	}

	this.showBack=function(data,div){
		if(data.length==1){
			div.innerHTML='<div class="listbox"></div><div class="commentbox">此日志没有评论<br><br></div><div class="listbox-bottom"></div>';
			return;
		}
		var sumstr=this.page(data[0]);
		var replyhtml,where=this.cmd;
		sumstr+='<ol class="commentlist">';
		for(var i=1,l=data.length; i <l; i++ ){
		   if(data[i].reply){
			   replyhtml ="<div class=\"quote\">";
			   replyhtml+="		<div class=\"quote-title\">博主回复于"+data[i].replyTime+"</div>";
			   replyhtml+="		<div class=\"quote-content\"><span id=reply"+data[i].id+">"+data[i].reply+"</span></div>";
			   replyhtml+="</div>";
		   }else replyhtml="";
		   if(data[i].log_id==null) data[i].log_id="";
		   eval(Skin.config.COMMENT_HTML_JS);
		}
		sumstr+="</ol>";
		div.innerHTML='<div class="listbox"></div>'+sumstr+'<div class="listbox-bottom"></div>';
		this.showAdminTool();
	}
}

