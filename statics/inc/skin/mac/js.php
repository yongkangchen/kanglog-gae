<?php
$skinHtml["page"]=<<<eot
	'<div id="div_message"><span class="alignleft">'+pageCount+'</span>'+sumstr+modestr+'</div>'
eot;

$skinHtml["mode"]=<<<eot
	"<span class='alignright'>预览模式:</span><a accesskey='1' href='javascript:void(0)' onclick='blog.articles.changeMode(1)'>普通</a> | <a accesskey='2' href='javascript:void(0)' onclick='blog.articles.changeMode(2)'>列表</a>"
eot;

$skinHtml["article"]=<<<eot
	sumstr+=	'<div class="post-top">';
	sumstr+=		'<div class="post-left"><h2><a title="An image in a post" href="#article&'+data[i].id+'">'+data[i].log_title+'</a></h2></div>';
	sumstr+=		'<div class="post-date">Posted in <a rel="category" title="View all posts in Uncategorized" href="#category&'+data[i].log_catId+'">'+data[i].log_catId+'</a> | '+data[i].log_author+' @ '+data[i].log_postTime+'</div>';
	sumstr+=	'</div>';
	sumstr+=	'<div class="post-content">';
	sumstr+=		'<p>'+data[i].log_content+'</p>';
	sumstr+=		'<div class="endline"></div>';				
	sumstr+=	'</div>';
	var moreHTML='';
	if(data[i].log_more) moreHTML='<span class="read"><a href="#article&'+data[i].id+'">阅读全文</a></span>';
	sumstr+=	'<div class="post-bottom">';
	sumstr+=		'<div class="post-comments"><span id=log_id'+data[i].id+'></span><a Onclick="blog.comments.show('+data[i].id+',this);" href="javascript:void(0)"> +Read Users’ Comments:('+data[i].log_comms+')</a></div>';
	sumstr+=		'<div class="post-readmore">'+moreHTML+'</div>';
	sumstr+=	'</div>';
	sumstr+=		'<div id="ContentComment'+data[i].id+'" style="display:block"></div>';
eot;

$skinHtml["comment"]=<<<eot
	sumstr+='<li class="alt" style="margin-left: 0px;">';
	sumstr+=	'<a name="'+where+'&'+data[i].id;
	if(data[i].log_id) sumstr+='&'+data[i].log_id;
	sumstr+='"></a>';
	sumstr+=	'<cite><img border="0" src="images/by.png">'+data[i].Messager+'</cite>';
	sumstr+='<a target="_blank" href="http://wpa.qq.com/msgrd?V=1&Uin='+data[i].QQ+'&Site=我的blog" ><img border="0" src="images/qq.gif"></a><a target="_blank" href="'+data[i].Url+'"><img border="0" SRC="images/homepage.gif"></a><a target="_blank" href="mailto:'+data[i].Mail+'" ><img border="0" src="images/email.gif"></a><span class="commentinfo"><img border="0" src="images/time.gif">'+data[i].PostTime+'</span><span id="'+where+data[i].id+'"></span>';
	sumstr+=	'<div class="commentcontent">'+data[i].Content+replyhtml+'<div id=edit'+where+data[i].id+'></div></div>';
	sumstr+='<div class="boxline">&nbsp;</div>';
	sumstr+='</li>';
eot;

$skinHtml["commentReply"]=<<<eot
   replyhtml ='<div class="quote">';
   replyhtml+=		'<div class="quote-title">博主回复于'+data[i].replyTime+'</div>';
   replyhtml+=		'<div class="quote-content"><span id=reply'+data[i].id+'>'+data[i].reply+'</span></div>';
   replyhtml+='</div>';
eot;

$skinHtml["content"]="text";
?>
