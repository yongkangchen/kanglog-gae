<div id="header">

	<div id="pagelist">
		<ul>
			<li><a title="Home" class="current_page_item" href="#article">Home</a></li>
			<li><a href="#guestbook">Guestbook</a></li><li><a href="#aboutme">About Me</a></li>
			<li id="searchBar">
						<form name="f4" id="searchform" method="POST" action="ajax.php?action=search" onsubmit="document.location.hash='#search';return XMLHttp.formSubmit.call(blog,this,blog.search)"><div>
								<input type="text" id="searchText" class="searchtext" name="searchfor" />
								<input type="submit" id="searchsubmit" value="" />
								<div id="submmit" title="搜索"></div>
						</div></form>
			</li>
		</ul>
				<!-- Feed -->
	</div>
	<div id="header-feed">
		<a href="feed.php" target="_blank"><img src="skins/mac/img/feed.gif" alt="RSS Feed" width="150" height="74" /></a>
	</div>
		
	<div id="logo"></div>
	<div id="description">
		<h1><a href="#article"><?=$Blog->name?></a></h1>
		<div id="desc"><?=$Blog->desc?></div>
			
	</div>
</div>
<div id="content">
	<div id="side">
		<div id="sidebar-top"></div>
		<ul id="sidebar">
			<!--<li>
				<div id="diguShow" class="Pcontent">
<embed type="application/x-shockwave-flash" src="http://www.digushow.com/style/images/sign.swf?mid=kanglog&style=2" quality="autohigh" wmode="transparent" width="180" height="300"  pluginspage="http://www.adobe.com/go/getflashplayer" ></embed>
				</div>
			</li>
			<li>
				<h2>Picasa</h2>
				<div id="Picasa-content" class="Pcontent">
<embed type="application/x-shockwave-flash" src="http://picasaweb.google.com/s/c/bin/slideshow.swf" width="200" height="192" flashvars="host=picasaweb.google.com&hl=en_US&feat=flashalbum&RGB=0x000000&feed=http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fapi%2Fuser%2Flx1988cyk%3Falt%3Drss%26kind%3Dphoto%26access%3Dpublic%26psc%3DF%26q%26uname%3Dlx1988cyk" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
				</div>
			</li>-->

			<li>
				<h2>Calendar</h2>
				<div id="Calendar-content" class="Pcontent">
					日历加载中。。。。。。
				</div>
			</li>

			<li>
				<h2>Categories</h2>
				<div id="Category-content" class="Pcontent">
					日志加载中。。。。。
				</div>
			</li>

			<li>
				<h2>RecentComments</h2>

				<div id="comment-content" class="Pcontent" title="10">
					最新评论加载中。。。。。。
				</div>
			</li>

			<li>
				<h2>RecentGuestbook</h2>
				<div id="guestbook-content" class="Pcontent" title="10">
					最新留言加载中。。。。。。
				</div>
			</li>

			<li>
				<h2>Archives</h2>
				<ul>
					<li><a title="April 2008" href="JavaScript:void(0)">April 2008</a></li>
				</ul>
			</li>
			<li>
				<h2>Links</h2>
				<span style="display: none;">Blogroll</span>
				<ul class="xoxo blogroll">
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

				</ul>
				
			</li>
			<li>
				<h2>Meta</h2>
				<ul>
					<li><?=getLogin()?></li>
					
					<li><a title="Validates XHTML 1.0 Transitional" href="http://validator.w3.org/check/referer">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
				</ul>
			</li>
		</ul>
	 <div id="sidebar-bottom"></div>
	 </div>
	<div id="text">
		日志加载中。。。。。。
	</div>

	<div class="cleaner"></div>
</div>
<div id="footer">

	<span style="display:none;"><a href="engines.php" title="ajax,blog,kanglog">小康的blog-发布基于ajax的blog程序</a></span>
					<span style="float: right; padding-top: 30px; padding-right: 20px;">Powered By <a href="http://www.kanglog.com" target="_blank"><strong> kanglog 2.0    Author:小康</strong></a> CopyRight 2007<br><strong>发布基于ajax的blog程序</strong><br>Theme Designed by<a href="http://zmingcx.cn">Zming</a></span>
</div>

