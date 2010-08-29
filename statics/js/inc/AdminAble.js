function AdminAble(){this.Abstract();
	this.getAdminData=this.abstractMethod;
	this.innerAdminHtml=this.abstractMethod;

	this.showAdminTool=function(){
		//JsLoad("js/admin.js");
		var data=this.getAdminData();
		this.innerAdminHtml(data,blog.isAdmin);
		if($("delbutton")){
			var visi="visible";
			if(!blog.isAdmin) visi="hidden";
			$("delbutton").style.visibility = visi;
		}
	}
	this.del=function(args){
		alert(args);
	}
	this.edit=function(args){
		alert(args);
	}
}
