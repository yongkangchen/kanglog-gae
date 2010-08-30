function Blog(year,month,day){this.Extends(UserPanel);
	//var this=this;
	
	this.nowYear=year;
	this.nowMonth=month;
	this.nowDay=day;
	
	this.isAdmin=false;

	this.page=function(cmd,pageN)
	{
		var callFun=new Function("this."+cmd+"s.show("+pageN+");");
		callFun.call(this);
	}
	this.login=function(str){
		switch(str)
		{
		 case "success":
						call_Alert("登陆成功"+str);
						closeActiveLayer();
						this.adminAble.open();
						break;
		 case "falied":call_Alert("帐号或密码错误。"+str);break;
		 case "": call_Alert("您已经登录"+str);break;
		 default: alert(str);
		}
	}
	this.logout=function(){
		XMLHttp.getReq.call(this,"ajax.php?action=logout",function(str){
			if(str=="logoutsuccess"){
				 call_Alert("登出成功"+str);
				 this.adminAble.close();
			}
		});
	}
	this.leaveMsg=function(data){
		if(typeof(data)=="string"){
			call_Alert(data);
			$("submit").disabled=false;
		}else{
			if(data.response=="success")
			{
				call_Alert("成功");
				this.url.fresh();
			}		
		}
	}
	this.search=function(data){
		if(typeof(data)=="string"){
			call_Alert(data);
		}else{
			this.articles.pageBack(data);
		}
	}
	this.setTitle=function(title){
		if(!title) document.title=this.name+"-"+this.desc;
		else{
			document.title=this.name+"-{"+title+"}";
		}
	}
	this.freshCategory=function(){
		dataCacher[2].getDatas([_showBack[2],dataCacher[2].div]);
	}
	this.del=function(cmd,id){
		XMLHttp.getReq.call(this,"ajax.php?action=del&cmd="+cmd+"&id="+id,function(data){
			if(typeof(data)=="string"){
				call_Alert(data);
			}else{
				switch(data[1].action){
					case "article":this.url.fresh();break;
					case "comment":
					case "guestbook":
									var node=$("edit"+data[1].action+data[1].id).parentNode.parentNode;
									node.parentNode.removeChild(node);	
									break;//@@#
					case "category":this.freshCategory();
									break;
				}
			}
		});
	}

	{//constructor
		this.skin=new Skin();
		this.articles=new Articles(this);
		this.categorys=new Categories(this);
		this.comments=new Comments(this);
		this.calendar=new Calendar();
		this.guestbooks=new Guestbooks(this);
		this.url=new Url(this);
		
		this.adminAble=new (function(blog){
			var _admin=[blog.articles,blog.comments,blog.guestbooks,blog.categorys,blog.skin];//alert(_admin[0].showAdminTool);
			function operate(){
				for(var i=0,l = _admin.length;i<l;i++){
					_admin[i].showAdminTool(blog.isAdmin);
				}		
			}
			this.open=function(){
				blog.isAdmin=true;
				operate();
			}
			this.close=function(){
				blog.isAdmin=false;
				operate();
			}
		})(this);

		//TODO 屏蔽
		var dataCacher=[new RecentComments,new RecentGuestbooks,this.categorys];
		var _showBack=[this.skin.siderBar.show];
		_showBack.push(_showBack[0]);
		_showBack.push(function(data,arg){
				//alert(data);
				_showBack[0](data,arg);
				this.showAdminTool();
			});
		for(var i=2,l=dataCacher.length;i< l;i++){
			dataCacher[i].getDatas([_showBack[i],dataCacher[i].div]);
		}
		//TODO 屏蔽
		//this.calendar.show(this.nowYear,this.nowMonth,this.nowDay);
		var dt=document.title;
		this.name=dt.substring(0,dt.indexOf("-"));
		this.desc=dt.substring(dt.indexOf("-")+1,dt.length);
		$("logo").onclick=function(){
			if(blog.isAdmin) blog.articles.post();
			else blog.skin.login();
		}
	}

}
