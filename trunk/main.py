#!/usr/bin/env python
#encoding=utf-8
#
# Copyright 2007 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

from google.appengine.ext import webapp
from google.appengine.ext.webapp import util

import os
from google.appengine.ext.webapp import template

from google.appengine.api import users
import logging
import time

path = os.path.join(os.path.dirname(__file__),"statics/js/inc")
jsFiles=[]
for root, dirs, files in os.walk(path):
    for file in files:
        jsFiles.append(file)

#temp
def getSkin ():
    skinHtml={}
    skinHtml["page"]='''
    '<div class="page-nav"><span class="older">'+pageCount+'</span>'+sumstr+'<div class="clear"></div></div>'
    '''

    skinHtml["mode"]='''
    <div class='pageContent' style='text-align:Right;overflow:hidden;height:18px;line-height:140%'><span style='float:left'></span>预览模式: <a accesskey='1' href='javascript:void(0)' onclick='blog.articles.changeMode(1)'>普通</a> | <a accesskey='2' href='javascript:void(0)' onclick='blog.articles.changeMode(2)'>列表</a></div>
    '''

    skinHtml["article"]='''
        sumstr+=	'<div class="post-top">';
        sumstr+=		'<h2><a title="An image in a post" href="#article&'+data[i].id+'">'+data[i].title+'</a></h2>';
        sumstr+=		'<div class="post-meta">Posted in <a rel="category" title="View all posts in Uncategorized" href="#category&'+data[i].category+'">'+data[i].category+'</a> | '+data[i].author+' @ '+data[i].postTime+'</div>';
        sumstr+=	'</div>';
        sumstr+=	'<div class="post-content">';
        sumstr+=		'<p>'+data[i].content+'</p>';
        sumstr+=		'<div class="endline"></div>';				
        sumstr+=	'</div>';
        var moreHTML='';
        if(data[i].log_more) moreHTML='<a href="#article&'+data[i].id+'">≡阅读全文≡</a>';
        sumstr+=	'<div class="post-bottom" style="margin-bottom: 32px;">';
        sumstr+=		'<div class="post-comments" style="float:right"><span id=log_id'+data[i].id+'></span><a Onclick="blog.comments.show('+data[i].id+',this);" href="javascript:void(0)"> +Read Users’ Comments:('+data[i].commentCount+')</a></div>';
        sumstr+=		'<div class="post-readmore" style="float:left">'+moreHTML+'</div>';
        sumstr+=	'</div>';
        sumstr+=		'<div id="ContentComment'+data[i].id+'" style="display:block"></div><div class="clear post-spt"></div>';
    '''

    skinHtml["comment"]='''
        sumstr+='<li class="alt" style="margin-left: 0px;">';
        sumstr+=	'<a name="'+where+'&'+data[i].id;
        if(data[i].log_id) sumstr+='&'+data[i].log_id;
        sumstr+='"></a>';
        sumstr+=	'<cite><img border="0" src="images/by.png">'+data[i].Messager+'</cite>';
        sumstr+='<a target="_blank" href="http://wpa.qq.com/msgrd?V=1&Uin='+data[i].QQ+'&Site=我的blog" ><img border="0" src="images/qq.gif"></a><a target="_blank" href="'+data[i].Url+'"><img border="0" SRC="images/homepage.gif"></a><a target="_blank" href="mailto:'+data[i].Mail+'" ><img border="0" src="images/email.gif"></a><span class="commentinfo"><img border="0" src="images/time.gif">'+data[i].PostTime+'</span><span id="'+where+data[i].id+'"></span>';
        sumstr+=	'<div class="commentcontent">'+data[i].Content+replyhtml+'<div id=edit'+where+data[i].id+'></div></div>';
        sumstr+='<div class="boxline">&nbsp;</div>';
        sumstr+='</li>';
    '''

    skinHtml["commentReply"]='''
       replyhtml ='<div class="quote">';
       replyhtml+=		'<div class="quote-title">博主回复于'+data[i].replyTime+'</div>';
       replyhtml+=		'<div class="quote-content"><span id=reply'+data[i].id+'>'+data[i].reply+'</span></div>';
       replyhtml+='</div>';
    '''

    skinHtml["content"]="text";
    for k in skinHtml:
        skinHtml[k]=skinHtml[k].replace('\n','').replace('\'','\\\'');
        #print skinHtml[k]
    return skinHtml
skinHtml=getSkin();

import models
config = models.Config.all().get()
class MainHandler(webapp.RequestHandler):
    def get(self):
        user = users.get_current_user()
        logined='false'
        if user:
            logined='true'
        t=time.localtime(time.time())
        template_values = {
            'logined':logined,
            'jsFiles':jsFiles,
            'NOW_YEAR': time.strftime('%Y',t),
            'NOW_MONTH':time.strftime('%m',t),
            'NOW_DAY':time.strftime('%d',t),
            'skinHtml':skinHtml,
            'config':config
        }
        path = os.path.join(os.path.dirname(__file__),"templates/" + config.skinName+"/index.php")
        logging.debug("@@@@")
        self.response.out.write(template.render(path, template_values))
        #self.response.out.write(path)

class TestHandler(webapp.RequestHandler):
    def get (self):
        import sys 
        sys.setdefaultencoding('utf-8') 

        import models
        logs=models.Article.all().fetch(10)
        for log in logs:            
            #self.response.out.write(dir(log))
            self.response.out.write(log.category)

import cgi
import kanglog
class AjaxHandler(webapp.RequestHandler):
    def get (self):
        self.doAction();
    def post (self):
        self.doAction();
    def doAction (self):
        self.response.out.write(kanglog.__getattribute__(cgi.escape(self.request.get('action')))(self.request))
    
def main():
    application = webapp.WSGIApplication([('/', MainHandler),('/test',TestHandler),('/ajax.php',AjaxHandler)],
                                         debug=True)
    util.run_wsgi_app(application)


if __name__ == '__main__':
    main()
