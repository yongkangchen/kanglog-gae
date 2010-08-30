/***AJAX----begin***/
var XMLHttp={
	//GET请求
	getReq:function(url,callback){
		XMLHttp.__sendReq.call(this,'GET',url,callback,null);
	},
	//POST请求
	postReq:function(url,callback,data){
		XMLHttp.__sendReq.call(this,'POST',url,callback,data);
	},
	//请求处理
	__sendReq:function(method,url,callback,data){
		//XMLHttp对象生成
		var objXMLHttp;
		if (window.XMLHttpRequest) objXMLHttp=new XMLHttpRequest();
		else{
			var MSXML = ['MSXML2.XMLHTTP.6.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP'];
			for(var n = 0; n < MSXML.length; n ++){
				try{objXMLHttp=new ActiveXObject(MSXML[n]);break;}catch(e){}
			}
		}
		try{
			//url附随机码，防缓存
			url+=(url.indexOf("?")==-1?"?":"&")+"radnum="+Math.random();
			
			//打开连接
			objXMLHttp.open(method,url,true);
			
			//设置请求头和编码
			objXMLHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=UTF-8');

			//发送数据
			objXMLHttp.send(data);

			//AJAX loading条
			$("loading").style.display = "block";

			var _this=this;
			objXMLHttp.onreadystatechange=function(){
				
				if (objXMLHttp.readyState==4){
					if (objXMLHttp.status>=200 && objXMLHttp.status<=300){
							if(objXMLHttp.getResponseHeader("Content-Type")=="text/xml;charset=UTF-8"){
								//返回XML
								callback.call(_this,objXMLHttp.responseXML);
							}else{
								var responseData;
								//返回JSON
								eval("responseData="+objXMLHttp.responseText);
								callback.call(_this,responseData);
							}
							$("loading").style.display = "none";
							goHash();
					}else alert("连接失败："+objXMLHttp.statusText);
				}
			}
		}catch(e){alert(e);}
	},
	//提取表单的内容
	formData:function(form){
		var data='';
		var preName='';
		for (var i=0; i < form.length ; i ++ ){
			var child=form[i];
			var value;
			if (child.name!=''){
				if (child.type=='select-one'){
					value=child.options[child.selectedIndex].value;
				}else if (child.type=='checkbox' || child.type=='radio'){
					if (!child.checked) continue;
					value=child.value;
				}else {
					value=child.value;
				}
				value=value.replace(/\&/g,"%26");
				if(preName!=child.name){
					data+="&"+child.name+'='+value;
				}else{
					data+=","+value;
				}
				preName=child.name;
			}
		}
		//alert(data);
		return data;
	},
	//提交表单
	formSubmit:function(form,callback,check){
		if(check && !check(form)) return false;
		XMLHttp.__sendReq.call(this,form.method,form.action,callback,XMLHttp.formData(form));
		return false;
	}
};
/***AJAX----end***/

/***Some prototype start***/
//XML原型
try{
	if(document.implementation && document.implementation.createDocument){
		XMLDocument.prototype.loadXML = function(xmlString){
			var childNodes = this.childNodes;
			for (var i = childNodes.length - 1; i >= 0; i--)
				this.removeChild(childNodes[i]);

			var dp = new DOMParser();
			var newDOM = dp.parseFromString(xmlString, "text/xml");
			var newElt = this.importNode(newDOM.documentElement, true);
			this.appendChild(newElt);
		};

		// check for XPath implementation
		if( document.implementation.hasFeature("XPath", "3.0") ){
		   // prototying the XMLDocument
		   XMLDocument.prototype.selectNodes = function(cXPathString, xNode){
			  if( !xNode ) { xNode = this; }
			  var oNSResolver = this.createNSResolver(this.documentElement)
			  var aItems = this.evaluate(cXPathString, xNode, oNSResolver,
						   XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null)
			  var aResult = [];
			  for( var i = 0; i < aItems.snapshotLength; i++){
				 aResult[i] =  aItems.snapshotItem(i);
			  }
			  return aResult;
		   }

		   // prototying the Element
		   Element.prototype.selectNodes = function(cXPathString){
			  if(this.ownerDocument.selectNodes)
			  {
				 return this.ownerDocument.selectNodes(cXPathString, this);
			  }
			  else{throw "For XML Elements Only";}
		   }
		}

		// check for XPath implementation
		if( document.implementation.hasFeature("XPath", "3.0") ){
		   // prototying the XMLDocument
		   XMLDocument.prototype.selectSingleNode = function(cXPathString, xNode){
			  if( !xNode ) { xNode = this; }
			  var xItems = this.selectNodes(cXPathString, xNode);
			  if( xItems.length > 0 ){
				 return xItems[0];
			  }else{
				 return null;
			  }
		   }

		   // prototying the Element
		   Element.prototype.selectSingleNode = function(cXPathString){
			  if(this.ownerDocument.selectSingleNode){
				 return this.ownerDocument.selectSingleNode(cXPathString, this);
			  }else{throw "For XML Elements Only";}
		   }
		}
	}
}catch(e){}

//加载js
function JsLoad(str){
	//检测是否已经加载
	var js=document.getElementsByTagName("script");
	for(var i=0;i<js.length;i++){
		if(str==js[i].getAttribute('src'))
			return;
	}

	var ascript=document.createElement("script");
	ascript.type="text/javascript";
	ascript.src=str;
	document.body.appendChild(ascript);
};

//加载css
function CssLoad(str){
	//检测是否已经加载
	var elems=document.getElementsByTagName("link");
	for(var i=0;i<elems.length;i++){
		if(str==elems[i].getAttribute('href'))
			return;
	}
	var elem=document.createElement("link");
	elem.rel="stylesheet";
	elem.type="text/css";
	elem.href=str;
	document.body.appendChild(elem);
};

//RssItem Class
function RssItem(node){
	if (window.XMLHttpRequest) this.title=node.selectSingleNode("cn").childNodes[0].nodeValue;
	else this.title=node.selectSingleNode("cn").childNodes[0].nodeValue;
	this.pubDate=node.selectSingleNode("t").childNodes[0].nodeValue.substr(2);
}
//RSS Class
function RssClass(rssdoc){
	try{
		var root=rssdoc.selectNodes("root/info/md/ml");
		var numNode=rssdoc.selectNodes("root/info/pg/total");
		this.count=numNode[0].childNodes[0].nodeValue;
	}catch (e){
		alert(e);alert(typeof(rssdoc));
	}
	this.length=root.length;
	this.getItem=function(n){
			return new RssItem(root[n]);
	}
	this.getCount=function(){
		return this.count;//return root[0].parentNode.attributes.getNamedItem("archive").value;	
	}
}
if(getBrowser()!="IE"){
    HTMLElement.prototype.click = function() {
        var evt = this.ownerDocument.createEvent('MouseEvents');
        evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
        this.dispatchEvent(evt);
    }
	HTMLElement.prototype.insertAdjacentHTML=function(where, html){
			   var e=this.ownerDocument.createRange();
			   e.setStartBefore(this);
			   e=e.createContextualFragment(html);
			   switch (where) {
						case 'beforeBegin': this.parentNode.insertBefore(e, this);break;
						case 'afterBegin': this.insertBefore(e, this.firstChild); break;
						case 'beforeEnd': this.appendChild(e); break;
						case 'afterEnd':
						if(!this.nextSibling) this.parentNode.appendChild(e);
						else this.parentNode.insertBefore(e, this.nextSibling); break;
			   }
	};

}
function getBrowser(){
   if(navigator.userAgent.indexOf("MSIE")>0) { return "IE"; }
   if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ return "Firefox"; }
   if(isSafari=navigator.userAgent.indexOf("Safari")>0) { return "Safari"; }
   if(isCamino=navigator.userAgent.indexOf("Camino")>0){ return "Camino"; }
   if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){ return "Gecko"; }
}
function CookieEnable(){
    var result=false;
    if(navigator.cookiesEnabled) return true;
    document.cookie = "testcookie=yes;";
    var cookieSet = document.cookie;
    if (cookieSet.indexOf("testcookie=yes") > -1) result=true;
    document.cookie = "";
    return result;
};

var EnglishMonth=["","Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec"];
function parseDate(date){
	var n=date.indexOf("-")+1;
	var m=date.indexOf("-",n)+1;
	return {month:EnglishMonth[parseInt(date.substr(n,2))],day:date.substr(m,2)};
}
function goHash(){
	window.setTimeout("document.location.href=document.location.hash",500);
}
/***Some prototype end***/
String.prototype.trim=function(){
	return this.replace(/^\s+/, '').replace(/\s+$/, '');
}

/*Object.prototype.Extends = function(){
	for(var i=0;i<arguments.length;i++){
		arguments[i].call(this);
	}
}*/

//继承
Object.prototype.Extends = function(BaseClass)
 {
     var base=new BaseClass();
     for ( var key in base )
     {
         if ( !this[key] )
         {
             this[key] = base[key];
             if ( typeof(base[key]) != 'function' )
             {
                 delete base[key];
             }
         }
     }
     this.base = base;
 };
/*
//例子：
Function.prototype.ClassExtends=function(BaseClass){
	if(!this.__classInit__){
		this.prototype.Extends(BaseClass);
		for(var i in BaseClass){
			if(!this[i])
				this[i]=BaseClass[i];
		}
		this.__classInit__=true;
	}
	return this;
}
var Class1=function(){}
var Class2=function(){}.ClassExtends(Class1);

Function.prototype.ClassAbstract=function(AbstractClass,ImplMethods){
	if(!this.__AbstractClass__){
		this.__AbstractClass__=[];
	}
	for(var i=0;i<this.__AbstractClass__.length;i++){
		if(this.__AbstractClass__[i]==AbstractClass) return;
	}
	this.prototype.Abstract(AbstractClass,ImplMethods);
	this.__AbstractClass__.push(AbstractClass);
	return this;
	
}
*/

//获得一个抽象类的抽象方法
Function.getAbstractMethod=function(AbstractClass){
	var funStr=AbstractClass.toString();
	var abstractMethods=[];

	var arr=funStr.split(";");
	for(var i=0;i<arr.length;i++)
	{
		if(arr[i].indexOf("abstractMethod")!=-1){
			var method=arr[i].split("=")[0];
			method=method.split("this.")[1];
			method=method.split(" ");
			abstractMethods.push(method[0]);
		}
	}
	return abstractMethods;
}
//获得一个类的名字
Function.getName=function(fun){
	var str=fun.toString();
	var name=str.match(/(function)([   \t])([^\(]+)/);
	if(name) return name[3];
	else return null;
}
/*
//例子：
function Fun(){this.Abstract();
	this.method1 = this.abstractMethod;	
	this.method3 = this.abstractMethod;
	this.method2=function(){
		this.method1();
	}
	this.method3=function(){
		alert("do something");	
	}
}

function Fun2(){
	this.Abstract(Fun,{
		method1:function(){
			alert("absctact class implements from Fun2");
		}
	});
}
var a=new Fun2();
*/

//定义抽象
Object.prototype.Abstract=function(AbstractClass,methods){
	var _this=arguments.callee.caller;
	var className=Function.getName(_this);
	
	if(typeof(AbstractClass)=="function"){
		var abstractMethods=Function.getAbstractMethod(AbstractClass);
		var abstractName=Function.getName(AbstractClass);
		if(abstractMethods.length==0) return;
		if(methods && methods.length!=0){
			AbstractClass.isAbstract=true;
			this.Extends(AbstractClass);
			AbstractClass.isAbstract=null;
			for(var i=0;i<abstractMethods.length;i++){
				var boo=false;
				for(var j in methods){
					if(typeof(methods[j])=="function" && j==abstractMethods[i]){
						this[j]=methods[j];
						boo=true;
						break;
					}
				}
				if(!boo)alert("The Class {"+className+"} does not override abstract method {"+abstractMethods[i]+"} in {"+abstractName+"}");
			}
			return;
		}
	}

	this.abstractMethod=function(){
		alert("The Class {"+className+"} does not override abstract method {methodName} in {parentClassName}\n");
	}
	{
		if(!_this.isAbstract){
			//alert(_this.caller.caller);
			alert("The Class {"+className+"} is abstract;Cannot be instantiated");
		}
	}
}

addDOMLoadEvent = (function(){
        // create event function stack
        var load_events = [],
            load_timer,
            script,
            done,
            exec,
            old_onload,
            init = function () {
                done = true;
                // kill the timer
                clearInterval(load_timer);

                // execute each function in the stack in the order they were added
                while (exec = load_events.shift())
                    setTimeout(exec, 10);
                if (script) script.onreadystatechange = '';
            };

            return function (func) {
                // if the init function was already ran, just run this function now and stop
                if (done) return func();


                if (!load_events[0]) {
                    // for Mozilla/Opera9
                    if (document.addEventListener)
                        document.addEventListener("DOMContentLoaded", init, false);

                    // for Internet Explorer
                    if(getBrowser()=="IE"){
                        document.write("<script id=__ie_onload defer src=//0><\/scr"+"ipt>");
                        script = document.getElementById("__ie_onload");
                        script.onreadystatechange = function() {
                            if (this.readyState == "complete")
                                init(); // call the onload handler
                        };
                    }

                    // for Safari
                    if (/WebKit/i.test(navigator.userAgent)) { // sniff
                        load_timer = setInterval(function() {
                            if (/loaded|complete/.test(document.readyState))
                                init(); // call the onload handler
                        }, 10);
                    }

                    // for other browsers set the window.onload, but also execute the old window.onload
                    old_onload = window.onload;

                    window.onload = function() {
                        init();
                        if (old_onload) old_onload();
                    };
                }

            load_events.push(func);
        }
})();

//根据id获得一个element
function $(id){
	return document.getElementById(id); 
}
//根据标签获得元素
function $$(tag,target){
	if(!target) target=document;
	return target.getElementsByTagName(tag);
}


function debug(elem){
	debugE=elem;
	return true;
}


function CheckBoxAll(form,tag,checked){
    var nodes=$$(tag,form);
    for (var i=0;i<nodes.length;i++) {
        nodes[i].firstChild.click();
    }
}
function checkBoxNum(checkBoxs){
	if(!checkBoxs) return false;
	if(checkBoxs.length){
		for(var i=0;i<checkBoxs.length;i++){
			if(checkBoxs[i].checked){				return true;
			}
		}
	}else return checkBoxs.checked;
}


/**
// Simple JavaScript Templating
// John Resig - http://ejohn.org/blog/javascript-micro-templating - MIT Licensed
(function(){
  var cache = {};
  
  this.tmpl = function tmpl(str, data){
	// Figure out if we're getting a template, or if we need to
	// load the template - and be sure to cache the result.
	var fn = !/\W/.test(str) ?
	  cache[str] = cache[str] ||
		tmpl(document.getElementById(str).innerHTML) :
	  
	  // Generate a reusable function that will serve as a template
	  // generator (and which will be cached).
	  new Function("obj",
		"var p=[],print=function(){p.push.apply(p,arguments);};" +
		
		// Introduce the data as local variables using with(){}
		"with(obj){p.push('" +
		
		// Convert the template into pure JavaScript
		str
		  .replace(/[\r\t\n]/g, " ")
		  .split("<%").join("\t")
		  .replace(/((^|%>)[^\t]*)'/g, "$1\r")
		  .replace(/\t=(.*?)%>/g, "',$1,'")
		  .split("\t").join("');")
		  .split("%>").join("p.push('")
		  .split("\r").join("\\'")
	  + "');}return p.join('');");
	
	// Provide some basic currying to the user
	return data ? fn( data ) : fn;
  };
})();

<script type="text/html" id="user_tmpl">
  <% for ( var i = 0; i < users.length; i++ ) { %>
	<li><a href="<%=users[i].url%>"><%=users[i].name%></a></li>
  <% } %>
</script>

example:
	var results = document.getElementById("results");
	var dataObject={users:[{name:'second name1',url:'www.baidu.com'},
					 {name:'second name2',url:'www.g.cn'}
					]};
	results.innerHTML = tmpl("user_tmpl", dataObject);
*/