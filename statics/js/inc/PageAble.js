function PageAble(){this.Abstract();
	//var this=this;

	this.pageBack=this.abstractMethod;
	this.getDatas=this.abstractMethod;

	this.show=function(page)
	{
		this.getDatas([this.pageBack],page);
	}
	this.page=function(data){
		var n=0;
		var max=parseInt(data.max);
		var counts=data.count;
		if(counts>max) n=counts%max==0?counts/max:parseInt(counts/max+1);
		else return "";
		var pageCount="共("+n+")页:";
		var modestr="";
		var sumstr="<a  href=\"#page&"+data.response+"&1\">«</a>";
		data.page=parseInt(data.page);
		var i=data.page-4;
		var len=data.page+4;
		if(i<1) i=1;
		if(len<9) len=9;

		for(;i<=len;i++){
			if(data.page==i){
				sumstr+="「"+i+"」 ";
			}else{
				sumstr+="<a  href=\"#page&"+data.response+"&"+i+"\">"+"『"+i+"』</a> ";
			}
		}
		sumstr+="<a  href=\"#page&"+data.response+"&"+n+"\">»</a>  ";
		eval("sumstr="+Skin.config.PAGE_HTML_JS);
		return sumstr;
	}
}

