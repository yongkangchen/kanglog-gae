<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta name="author" content="xiao-kang" />
<meta name="description" content={{config.desc}} />
<meta name="keywords" content="Kanglog" />
<title>{{config.name}}-{{config.desc}}</title>

<link type="text/css" rel="stylesheet" href="js/activelayer.css" />
<link id=skinstyles type="text/css" rel="stylesheet" href=skins/{{config.skinName}}/styles.css />
<!--[if IE 6]>
   <style type="text/css">
	   /*<![CDATA[*/ 
			html {overflow-x:auto; overflow-y:hidden;}
	   /*]]>*/
   </style>
<![endif]-->
<style type="text/css">
body {
    margin:0;
    border:0;
    height:100%; /* 必须 */
    overflow-y:auto;/* 必须 */
}
img{
	border:0;
}
.index li{list-style-image:url(images/arrow.gif);}


a,area { blr:expression(this.onFocus=this.blur()) } /* for IE */
:focus { -moz-outline-style: none; } /* for Firefox */
</style>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/my.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

{% for jsFile in jsFiles %}
<script type="text/javascript" src="js/inc/{{jsFile}}"></script>
{% endfor %}
<script>
Skin.html={}
Skin.html.loginUrl='{{loginUrl}}'
var NOW_YEAR={{NOW_YEAR}};
var NOW_MONTH={{NOW_MONTH}};
var NOW_DAY={{NOW_DAY}};
var preHash,blog;
function wod(){
	var activeLayer=$("ActiveLayer");
	var alertLayer=$("AlertLayer");
	var shadowLayer=$("ShadowLayer");
	ActiveLayer.activeLayer=activeLayer;
	ActiveLayer.shadowLayer=shadowLayer;
	ActiveLayer.alertLayer=alertLayer;
	//fscroller.fscrollDiv.push([activeLayer,false],[$("loading"),true],[alertLayer,false]/*,[shadowLayer,false]*/);
	blog=new Blog(NOW_YEAR,NOW_MONTH,NOW_DAY);
	blog.isAdmin={{logined}}
	//display.skinList();
	//display.linkList();
	//skin_info();
	//display.getemotion();
};

addDOMLoadEvent(wod);
</script>
</head>
<body>


<iframe name="historyFrame" style="display:none;" width="0" height="0" src="history.html"></iframe>
<span id="skin_name" style="display:none;">{{config.skinName}}</span>
<span id="loading"><img src="images/load.gif" align="absbottom" />页面加载中loading...</span>
<div id="AlertLayer" class="AlertLayer"></div>
<div id="ActiveLayer" class="ActiveLayer"></div>
<div id="ShadowLayer" class="ShadowLayer"></div>

{% block content %}{% endblock %}
</body>
</html>
