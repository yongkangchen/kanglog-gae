function Url(blog){
	var _blog=blog;
	function articleCmd(args){
		var id=args[0];
		this.exec=function(){
			if(id){
				id=id.replace(new RegExp("[^0-9]","gm"),"");
				_blog.articles.showById(id);
			}else{
				_blog.articles.show();
			}
		}
	}
	function commentCmd(args){
		var log_id=args[1];
		this.exec=function(){	_blog.articles.showById(log_id);	}
	}
	function guestbookCmd(args){
		var id=args[0];
		this.exec=function(){	_blog.guestbooks.show();	}
	}
	function categoryCmd(args){
		var catName=args[0];
		this.exec=function(){	_blog.categorys.show(catName);	}
	}
	function calendarCmd(args){
		var year=args[0];
		var month=args[1];
		var day=args[2];
		this.exec=function(){	_blog.articles.showByCalen(year,month,day);	}
	}
	function pageCmd(args){
		var cmd=args[0];
		this.exec=function(){	
			  var pageArgs=[];
			  for(var i=1,l=args.length;i<l;i++)
				  pageArgs.push("'"+args[i]+"'");
			  _blog.page(cmd,pageArgs);
		}
	}
	function planCmd(args){	this.exec=plan;	}
	function aboutmeCmd(args){	this.exec=aboutme;	}

	
	function _getCmd(fresh){
		var curHash=document.location.hash;
		if(!curHash){
			document.location.hash="article";
			curHash=document.location.hash;
		}
		var cmdArgs=curHash.split("#")[1];
		if(cmdArgs!=null){
			cmdArgs=cmdArgs.split("&");
		}
		var obj={cmd:cmdArgs[0],args:[]};
		for(var i=1,l=cmdArgs.length;i<l;i++){
			obj.args.push(cmdArgs[i]);
		}
		var isHistory=true;
		if(obj.cmd=="guestbook"){
			curHash=obj.cmd;
			isHistory=false;
		}else if(obj.cmd=="comment"){
			curHash=obj.cmd+"&"+obj.args[1];
			isHistory=false;
		}
		if(fresh || preHash!=curHash){
			preHash=curHash;
			if(!fresh && isHistory){
				_addhistory();
			}
			return obj;
		}else{
			return null;
		}
	}
	function _exeCmd(obj){
		if(!obj) return;
		var cmd;
		eval("cmd=new "+obj.cmd+"Cmd(obj.args)");
		cmd.exec();
	}
	function _addhistory(){
		if(window.historyFrame.location.hash!=preHash){//@@@
			if(getBrowser()=="IE"){
				//var x=document.title;
				window.historyFrame.location.href="history.html?"+Math.random()+preHash;
			}
		}
	}
	this.fresh=function(){
		_exeCmd(_getCmd(true));
	}
	this.back=function(){
		history.back();
	}
	this.run=function(){
		_exeCmd(_getCmd());
	}
	{
		this.run();
		window.setInterval(this.run,1000);
	}
}


