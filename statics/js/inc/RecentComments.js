function RecentComments(){
	//var _this=this;
	this.cmd="getcomment";
	this.div="comment-content";

	this.Abstract(DataCacher,{
		getCmd:function(){
			return this.cmd;
		}
	});

	this.htmlData=function(data){
		var sumstr="";
		var n=data.length;
		if($(this.div).title){
			n=$(this.div).title;
			n++;
		}
		for(var i=1;i<n;i++)
		{
			sumstr+="<li class=\"indent\">";
			sumstr+="<strong><a href=#"+this.div.substring(0,this.div.indexOf("-"))+"&"+data[i].id;
			if(data[i].log_id) sumstr+="&"+data[i].log_id;
			sumstr+=">";
			sumstr+=	data[i].Content.substring(0,10)+"......";
			sumstr+="</a></strong><br><small>"+data[i].PostTime+"</small></li>";
		}
		return sumstr;
	}
}
function RecentGuestbooks(){this.Extends(RecentComments);
	this.div="guestbook-content";
	this.cmd="getguestbook";
}
