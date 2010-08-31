function Categories(blog){

	var _blog=blog;
	var _cmd="getcategory";
	this.div="Category-content";
	//var this=this;

	//iplements AdminAble	
	this.Abstract(AdminAble,{
		getAdminData:function(){return this.getCaches();},
		innerAdminHtml:function(data,isAdmin){
			var divName="cate_id";
			var confirmText="确定要删除此分类吗？此分类下的文章也将被删除.";
			for(var i=0,l=data.length;i<l;i++){
				var html="";
				var id=data[i].id;
				if($(divName+id)){
					if(isAdmin){
						html ="<a href=javascript:void(0) onClick=\"blog.categorys.edit(\'"+data[i].name+"\')\">";
						html+="	<img src=\"images/icon_editcat.gif\" alt=\"编辑\" />";
						html+="</a>|";
						html+="<a  href=\"javascript:void(0)\" onClick=\"if(confirm('"+confirmText+"'))";
						html+="		blog.del('category',"+data[i].id+");\">";
						html+="	<img src=\"images/icon_del.gif\" alt=\"删除\" />";
						html+="</a>";
					}
					$(divName+id).innerHTML=html;
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

	this.getOptionsHtml=function(selected)
	{
		return _getOptionsHtml(this.getCaches(),selected);
		//_getOptionsHtml(this.getDatas);
	}
	this.getOptions=function(){
		return this.getCaches();
	}
	function _getOptionsHtml(categories,selected)
	{
		var options="";
		for(var i=0,l=categories.length;i<l;i++){
			options+="<option value=\""+categories[i].name;
			if(categories[i].name==selected){
				options+=" selected";
			}
			options+="\">"+categories[i].name+"</option>\n";
		}
		//options="<select name=\"log_catId\">"+options+"</select>";//get the code of category options.
		return options;
	}
	this.htmlData=function(data)
	{
		var sumstr="";
		var admincate="";
		for(var i=0,l=data.length;i<l;i++)
		{
			sumstr+="<li class=\"indent\">";
			sumstr+="	<a href=\"#category&"+data[i].id+"\">"+data[i].name+"</a>";
			sumstr+="	("+data[i].count+") <span id='cate_id"+data[i].id+"'></span>";
			sumstr+="	<a target=\"_blank\" title=\""+data[i].name+" RSS Feed\" href=\"feed.php?log_catId="+data[i].name+"\">";
			sumstr+="		<img src=\"images/rss.png\"/>";
			sumstr+="	</a>";
			sumstr+="</li>";
		}
		return sumstr;
	}
	this.show=function(catId,page){
		var cmd=_blog.articles.getCmd();
		_blog.articles.setCmd("category&cat_Id="+encodeURI(catId));
		_blog.articles.show(page);
		_blog.articles.setCmd(cmd);
	}
	this.edit=function(name){
		var cat_name=prompt("请输入分类新名称：",name);
		if(cat_name && cat_name!=name){
			var category=this.getCaches();
			for(var i=0,l=category.length;i<l;i++){
				if(category[i].cat_name==cat_name) {alert("分类名称重复");return;}
			}
			XMLHttp.getReq("ajax.php?action=editcatename&cat_name="+encodeURIComponent(cat_name)+"&name="+encodeURIComponent(name),function(data){
				call_Alert(data);
				_blog.freshCategory();
			});
		}		
	}
	this.add=function(){
		var cate=prompt("请输入分类名称：","");
		if(cate){
			var category=this.getCaches();
			for(var i=0,l=category.length;i<l;i++)
			{
				if(category[i].cat_name==cate) {alert("分类名称重复");return;}
			}
			XMLHttp.getReq("ajax.php?action=addcate&name="+encodeURIComponent(cate),function(data){
				call_Alert(data);
				_blog.freshCategory();
			});
		}		
	}
}

