{% extends "index.php" %}
{% block content %}
<div id="wrapper">
	<div id="container">
	<div id="header">
		<h1><a href="#article">{{config.name}}</a></h1>
		<div id="head-desc">{{config.desc}}</div>
	</div><!-- end header -->

	<div id="head-nav">
		<ul id="nav">
			<li><a title="Home" class="current_page_item" href="#article">Home</a></li>
			<!--<li><a href="#guestbook">Guestbook</a></li>-->
			<li><a href="#aboutme">About Me</a></li>
			<li><a href="javascript:void(0)" id="logo">Dashboard</a></li>
		</ul>
		<div class="clear"></div>
	</div><!-- end head-nav -->

	<div id="main-content">
		<div id="text">
			日志加载中。。。。。。
			<script>
				Skin.html.contentDiv="text";			
				Skin.html.comment = function(){
					var sumstr="";
					sumstr+='<li class="alt" style="margin-left: 0px;">';
					sumstr+=	'<a name="'+this.where+'&'+this.data.id;
					if(this.data.log_id) sumstr+='&'+this.data.log_id;
					sumstr+='"></a>';
					sumstr+=	'<cite><img border="0" src="images/by.png">'+this.data.messager+'</cite>';
					sumstr+='<a target="_blank" href="http://wpa.qq.com/msgrd?V=1&Uin='+this.data.QQ+'&Site=我的blog" ><img border="0" src="images/qq.gif"></a><a target="_blank" href="'+this.data.Url+'"><img border="0" SRC="images/homepage.gif"></a><a target="_blank" href="mailto:'+this.data.mail+'" ><img border="0" src="images/email.gif"></a><span class="commentinfo"><img border="0" src="images/time.gif">'+this.data.postTime+'</span><span id="'+this.where+this.data.id+'"></span>';
					sumstr+=	'<div class="commentcontent">'+this.data.Content+replyhtml+'<div id=edit'+this.where+this.data.id+'></div></div>';
					sumstr+='<div class="boxline">&nbsp;</div>';
					sumstr+='</li>';
					return sumstr;
				}
				Skin.html.commentReply = function(){
					var replyhtml="";
					replyhtml ='<div class="quote">';
					replyhtml+=		'<div class="quote-title">博主回复于'+data[i].replyTime+'</div>';
					replyhtml+=		'<div class="quote-content"><span id=reply'+data[i].id+'>'+data[i].reply+'</span></div>';
					replyhtml+='</div>';
					return replyhtml;
				}
				Skin.html.mode = "<div class='pageContent' style='text-align:Right;overflow:hidden;height:18px;line-height:140%'><span style='float:left'></span>预览模式: <a accesskey='1' href='javascript:void(0)' onclick='blog.articles.changeMode(1)'>普通</a> | <a accesskey='2' href='javascript:void(0)' onclick='blog.articles.changeMode(2)'>列表</a></div>";

				Skin.html.page = function() {
					return '<div class="page-nav"><span class="older">'+this.pageCount+'</span>'+this.sumstr+'<div class="clear"></div></div>';
				}
				/**
				 * article 模板
				 * @param data article的json数据
				 */
				Skin.html.article = function(data){
					var sumstr="";
					sumstr+=	'<div class="post-top">';
					sumstr+=		'<h2><a title="An image in a post" href="#article&'+data.id+'">'+data.title+'</a></h2>';
					sumstr+=		'<div class="post-meta">Posted in <a rel="category" title="View all posts in Uncategorized" href="#category&'+data.category+'">'+data.category+'</a> | '+data.author+' @ '+data.postTime+'</div>';
					sumstr+=	'</div>';
					sumstr+=	'<div class="post-content">';
					sumstr+=		'<p>'+data.content+'</p>';
					sumstr+=		'<div class="endline"></div>';				
					sumstr+=	'</div>';
					var moreHTML='';
					if(data.log_more) moreHTML='<a href="#article&'+data.id+'">≡阅读全文≡</a>';
					sumstr+=	'<div class="post-bottom" style="margin-bottom: 32px;">';
					sumstr+=		'<div class="post-comments" style="float:right"><span id=log_id'+data.id+'></span><a Onclick="blog.comments.show('+data.id+',this);" href="javascript:void(0)"> +Read Users’ Comments:('+data.commentCount+')</a></div>';
					sumstr+=		'<div class="post-readmore" style="float:left">'+moreHTML+'</div>';
					sumstr+=	'</div>';
					sumstr+=		'<div id="ContentComment'+data.id+'" style="display:block"></div><div class="clear post-spt"></div>';
					return sumstr;
				}
				Skin.html.pswArticle = function(data){
						if(typeof(data.log_psw)=="number"){
							if(data.log_psw==0) {ActiveLayer.alert('密码错误');return;}
							data.log_content='<div id="protectedblog'+data.id+'" class="quote">';
							data.log_content+=	'<div class="quote-title">加密日志</div>';
							data.log_content+=	'<div class="quote-content">';
							data.log_content+=		'<form id="protected'+data.id+'" method="POST" action="ajax.php?action=article&id='+data.id+'" onsubmit="return XMLHttp.formSubmit.call(blog.articles,this,blog.articles.pageBack);">';
							data.log_content+=			'这篇日志被加密了。请输入密码后查看。<br/>';
							data.log_content+=			'密码 <input type="password" class="text" id="log_psw" name="log_psw"/>';
							data.log_content+=			'<input type="submit" class="button" value="提交"/>';
							data.log_content+=		'</form>';
							data.log_content+=	'</div>';
							data.log_content+='</div>';
						}
						return data;
				}
				Skin.html.articleList = function(mode,data){
					var sumstr="";
					if(mode==1){
						for(var i=1,l=data.length; i < l; i++){
							data[i]=Skin.html.pswArticle(data[i]);
							sumstr+='<div class="post" id="post-'+data[i].id+'">';
							sumstr+=Skin.html.article(data[i]);
							sumstr+='</div>';
						}
					}else if(mode==2){
					  sumstr+='<form name="f6" method="POST" action="ajax.php?action=batcmd" onsubmit="return XMLHttp.formSubmit(this,blog.articles.bat);">';
					  sumstr+=	"<div class='listbox'></div>";
					  sumstr+=		"<div class='listbox-table'>";
					  sumstr+=			"<table width='100%' cellspacing='0' cellpadding='2'>";
					  sumstr+=			"<tbody>";
					  sumstr+=				"<tr>";
					  sumstr+=					"<td class='listbox-header' align='center'>标题</td>";
					  sumstr+=					"<td class='listbox-header' align='center'>作者</td>";
					  sumstr+=					"<td class='listbox-header' width='120' align='center'>发表于</td>";
					  sumstr+=					"</tr>";
					  for(var i=1,l=data.length;i<l;i++){
						  sumstr+=					"<tr>";
						  sumstr+=						"<td class='listbox-entry'>";
						  sumstr+=							"<span id=log_id"+data[i].id+"></span>";
						  sumstr+=								"["+data[i].category+"]<a href='#article&"+data[i].id+"'>"+data[i].title+"</a>";
						  sumstr+=						"</td>";
						  sumstr+=						"<td class='listbox-entry'>"+data[i].author+"</td>";
						  sumstr+=						"<td class='listbox-entry' align='center' width='120' height='35'>"+data[i].postTime+"</td>";
						  sumstr+=					"</tr>";
					  }
					  sumstr+=					"</tbody>";
					  sumstr+=				"</table>";
					  sumstr+=			"</div>";
					  sumstr+=			"<div class='listbox-bottom'>";
					  sumstr+=			"<span id=delbutton style='visibility: hidden;'>";
					  sumstr+=				"<input type='checkbox' onclick=\"CheckBoxAll(this.form,\'tr\',this.checked);\"/>";
					  sumstr+=				"选中项：<input type='radio' name='cmd' value='del' checked=true />删除";
					  sumstr+=				"<input type='radio' name='cmd' value='move' />移动到<select name='log_catId'>"+blog.categorys.getOptionsHtml()+"</select>"/*@@@#*/;
					  sumstr+=				"<input type='submit' value='确定'>";
					  sumstr+=			"</span></div>";
					  sumstr+=		"</form>";
					}
					return sumstr;
				}
			</script>
		</div>
	</div><!-- end main-content -->

	<div id="sidebar">
		<div class="widget">
				<form name="f4" id="searchform" method="POST" action="ajax.php?action=search" onsubmit="document.location.hash='#search';return XMLHttp.formSubmit.call(blog,this,blog.search)"><div>
						<input type="text" id="searchText" class="searchtext" name="searchfor" />
						<input type="submit" name="sa" value="搜索">
				</div></form>
		</div>
		<!--
		<div class="widget">
			<h4>Calendar</h4>
				<div id="Calendar-content">
					日历加载中。。。。。。
				</div>
		</div>-->
		<div class="widget">
			<h4>Categories</h4>
				<div id="Category-content">
					分类加载中。。。。。。
				</div>
		</div>

		<div class="widget">
		<h4>Links</h4>
		<ul>
					<li><a href="http://www.kanglog.com/">Kanglog</a></li>
					<li class="indent"><a target="_blank" href="http://strongwillow.net/live/voyage/">strongwillow</a> </li>
					<li class="indent"><a title="bo-blog" target="_blank" href="http://www.kcvg.cn">可惜危机</a></li>
					<li class="indent"><a title="bo-blog" target="_blank" href="http://www.cnbeta.com">cnbeta</a></li>
					<li class="indent"><a title="pjhome" target="_blank" href="http://www.pjhome.net">pjhome</a></li>
					<li class="indent"><a title="pjhome" target="_blank" href="http://solidot.org/">奇客的资讯</a></li>
					<li class="indent"><a title="设计就像荡秋千" target="_blank" href="http://www.pdmb.org">设计就像荡秋千</a></li>
					<li class="indent"><a target="_blank" href="http://bbs.javascript.com.cn/">bbs  javascript</a> </li>
					<li class="indent"><a target="_blank" href="http://www.codecoke.com/tech/css2_guide/">css2参考手册</a> </li>
					<li class="indent"><a target="_blank" href="http://gceclub.sun.com.cn/Java_Docs/html/zh_CN/api/index.html">Java2se api中文</a> </li>
					<li class="indent"><a target="_blank" href="http://www.json.org/">json</a> </li>
					<li class="indent"><a target="_blank" href="http://www.prototypejs.org/">prototypejs</a> </li>
					<li class="indent"><a target="_blank" href="http://www.snap.com/">snap  网页快照</a> </li>
					<li class="indent"><a target="_blank" href="http://art.gnome.org/themes/metacity">Window Borders Themes </a> </li>
					<li class="indent"><a target="_blank" href="http://www.fireyy.com/doc/xmlhttp/index.html">xmlhttp小手册</a> </li>
					<li class="indent"><a target="_blank" href="http://blog.csdn.net/caterpillar_here/">林信良（良葛格）的专栏</a></li>
		</ul></div>
	</div><!-- end sidebar -->
<div class="clear"></div>

<div id="footer">
	<!--
	<div id="foot-1">
		<div class="widget">
			<h4>RecentComments</h4>
			<div id="comment-content" title="5">
				最新评论加载中。。。。。。
			</div>
		</div>
	</div>--><!-- end foot-1 -->
	
	<div id="foot-right">
		<!--
		<div id="foot-2">
			<div class="widget">
				<h4>RecentGuestbook</h4>
				<div id="guestbook-content" title="5">
					最新评论加载中。。。。。。
				</div>
			</div>
		</div>--><!-- end foot-2 -->
		<!--
		<div id="foot-3">
			<div class="widget">
			<h4>Pages</h4>
			<ul>
				<li><?=getLogin()?></li>
			</ul>
			</div>
		</div>--><!-- end foot-3 -->

		<div class="clear"></div>
	</div><!-- end foot-right -->
	<div class="clear"></div>
</div><!-- end footer -->

<div id="footer-credit">
	<span style="display:none;"><a href="engines.php" title="ajax,blog,kanglog">小康的blog-发布基于ajax的blog程序</a></span>
Copyright &copy; <?php echo date("Y") ?> <b>{{config.name}}</b>. <a href="feed.php">Entries (RSS)</a>. Clean Simple White Theme by <a href="http://mazznoer.web.id/">Mazznoer</a>. Powered by <a href="http://www.kanglog.com" target="_blank"><strong> kanglog 2.0    Author:小康</strong></a> 
<div id="footer-desc">{{config.desc}}</div>
</div><!-- end footer-credit -->

</div><!-- end div #container -->
</div><!-- end div #wrapper -->

<!--
	Clean Simple White (CSW) Theme for WordPress
	Designed by Mazznoer
	website : http://mazznoer.web.id/
-->
{% endblock %}