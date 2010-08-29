function UserPanel(){
	//var this=this;
	this.replyBack=function(data){
		if(data.response=="success"){
			var replyDiv=$("reply"+data.id);
			var formDiv=$("edit"+data.where+data.id);
			if(replyDiv){
				replyDiv.innerHTML=data.reply;
			}else{
				formDiv=$("edit"+data.where+data.id);
				var i=0;
				var data=[data];
				var replyhtml;
				eval(Skin.config.COMMENT_REPLY_HTML_JS);
				formDiv.insertAdjacentHTML("beforeBegin",replyhtml);
			}
			formDiv.innerHTML="";
		}else{
			alert("操作失败");
		}
	}
}
