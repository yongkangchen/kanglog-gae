function DataCacher(){this.Abstract();
	//var this=this;
	var _caches=[];

	this.getCmd=this.abstractMethod;
	this.getCaches=function(){return _caches;}
	this.init=function(back,page){
		if(!page) page=1;
		XMLHttp.getReq.call(this,"ajax.php?action="+this.getCmd()+"&page="+page,function(data){
			_caches=data;
			if(back){
				var backFun=back[0];
				var args=[];
				args[0]=this.htmlData(data);
				for(var i=1,l=back.length;i<l;i++){
					args.push(back[i]);
				}
				backFun.apply(this,args);
			}
		});
	}
	this.htmlData=function(data){
		return data;
	}
	this.getDataById=function(id,back){
		XMLHttp.getReq.call(this,"ajax.php?action="+this.getCmd()+"&id="+id,function(data){
			if(data){
				if(data.length<=1){
					//alert("数据不存在 DataCacher.add "+data[0].response);
					history.back();
				}
				else {
					_caches=data;
				}
			}
			if(back){
				back.call(this,data);
			}
		});
	}
	this.getDatas=function(back,page){
			this.init(back,page);
	}
}
