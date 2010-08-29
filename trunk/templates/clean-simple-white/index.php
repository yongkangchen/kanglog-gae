{% extends "../index.php" %}
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
			<li><a href="#guestbook">Guestbook</a></li>
			<li><a href="#aboutme">About Me</a></li>
			<li><a href="javascript:void(0)" id="logo">Dashboard</a></li>
		</ul>
		<div class="clear"></div>
	</div><!-- end head-nav -->

	<div id="main-content">
		<div id="text">
			日志加载中。。。。。。
		</div>
	</div><!-- end main-content -->

	<div id="sidebar">
		<div class="widget">
				<form name="f4" id="searchform" method="POST" action="ajax.php?action=search" onsubmit="document.location.hash='#search';return XMLHttp.formSubmit.call(blog,this,blog.search)"><div>
						<input type="text" id="searchText" class="searchtext" name="searchfor" />
						<input type="submit" name="sa" value="搜索">
				</div></form>
		</div>
		<div class="widget">
			<h4>Calendar</h4>
				<div id="Calendar-content">
					日历加载中。。。。。。
				</div>
		</div>
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
	<div id="foot-1">
		<div class="widget">
			<h4>RecentComments</h4>
			<div id="comment-content" title="5">
				最新评论加载中。。。。。。
			</div>
		</div>
	</div><!-- end foot-1 -->

	<div id="foot-right">
		<div id="foot-2">
			<div class="widget">
				<h4>RecentGuestbook</h4>
				<div id="guestbook-content" title="5">
					最新评论加载中。。。。。。
				</div>
			</div>
		</div><!-- end foot-2 -->

		<div id="foot-3">
			<div class="widget">
			<h4>Pages</h4>
			<ul>
				<li><?=getLogin()?></li>
			</ul>
			</div>
		</div><!-- end foot-3 -->

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