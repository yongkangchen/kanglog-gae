function CenterDiv(div){
		var height=parseInt(div.style.height);
		var width=parseInt(div.style.width);

		var get_h_1=self.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var get_osw_1=document.documentElement.offsetWidth || document.body.offsetWidth;

		var get_h_2=height || 0;
		var get_osw_2=width || 0;

		var top= (get_h_1-get_h_2)/2;//+document.documentElement.scrollTop;
		var left=(get_osw_1-get_osw_2)/2;

		div.style.left=left+"px";
		div.style.top=top+"px";	
}

var ActiveLayer={
	open:function(p){
		var selects = $$("select");
		for(i = 0; i < selects.length; i++)
			selects[i].style.visibility = "hidden";
	/********************************************************************************************************************/
		var get_h_1=self.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var get_h_3=self.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	/*******************************************************************************************************************/		
		this.shadowLayer.style.width=get_h_3+"px";
		this.shadowLayer.style.height=get_h_1+"px";
		this.shadowLayer.style.display="block";

		document.body.style.overflow="hidden";

		this.activeLayer.innerHTML="<div id='ALayer_title' class='ALayer_title'>"+p.caption+"<span style='float:right;margin:-18px auto;align=right;' ><a href='javascript:void(0);' onclick='closeActiveLayer()' style='text-decoration:none;'> X </a></span></div><div id='ALayer_content'>"+p.html+"</div>";

		this.activeLayer.style.width=p.width+20+"px";
		this.activeLayer.style.height=p.height+20+"px";
		CenterDiv(this.activeLayer);
		this.activeLayer.style.display="block";

		//fscroller.fscroll(this.activeLayer);
		//fscroller.fscroll(this.shadowLayer);

		dragged($("ALayer_title"),this.activeLayer);
		document.onkeydown=function(evt){
			evt=evt||window.event;
			if(evt.keyCode==27){
				ActiveLayer.close();
				document.onkeydown=null;
			}
		}
	},
	close:function(){
		var selects = $$("select");
		for(i = 0; i < selects.length; i++)
		  selects[i].style.visibility = "visible";
		this.activeLayer.style.display="none";
		this.shadowLayer.style.display="none";
		document.body.style.overflow="auto";
		cancelDrag($("ALayer_title"));
		//fscroller.close();
	},
	alert:function(str){

		var p={width:210,height:50};

		this.alertLayer.innerHTML='<div id="alert_content" class="alert_content">'+str+'</div><input class="button" type="button" value="OK" onClick="$(\'AlertLayer\').style.display=\'none\';cancelDrag($(\'alert_content\'));" />';
		
		this.alertLayer.style.width=p.width+"px";
		this.alertLayer.style.height=p.height+"px";
		CenterDiv(this.alertLayer);
		
		this.alertLayer.style.display="block";
		dragged($("alert_content"),this.alertLayer);
		//fscroller.fscroll(this.alertLayer);
		window.setTimeout("$(\"AlertLayer\").style.display=\"none\";cancelDrag($(\"alert_content\"));",4000);
	}
}
function openActiveLayer(p){
	ActiveLayer.open(p);
};
function closeActiveLayer(){
	ActiveLayer.close();
};
function call_Alert(str){
	ActiveLayer.alert(str);
};

function dragged(div_title,div_body)
{
	var n_left,n_top;
	//var div_body=$(body);
	//var div_title=$(title);
	div_title.unselectable="on";
	div_title.style.cursor="move";
	div_body.unselectable="on";

	div_title.onmousedown=function(evt){
		evt=evt||window.event;
		this.style.cursor="default";
		if(!div_body.style.left) div_body.style.left=div_body.offsetLeft+"px";
		if(!div_body.style.top) div_body.style.top=div_body.offsetTop+"px";
		document.onmousemove =move;
		document.onmouseup=function(){
			document.onmousemove=null;
			n_left=null;n_top=null;
			div_title.style.cursor="move";
			document.onmouseup=null;
		}
	}
	function move(evt){
		evt=evt||window.event;
		if(!n_left) n_left=document.body.scrollLeft+evt.clientX-parseInt(div_body.style.left.replace("px",""));
		if(!n_top) n_top=document.body.scrollTop+evt.clientY-parseInt(div_body.style.top.replace("px",""));
		div_body.style.left=document.body.scrollLeft+evt.clientX-n_left+"px";
		div_body.style.top=document.body.scrollTop+evt.clientY-n_top+"px";
	}
};
function cancelDrag(div_title){
	div_title.onmousedown=null;
}