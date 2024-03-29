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
from util import checkLogin

from google.appengine.api import users
import logging
import time

path = os.path.join(os.path.dirname(__file__),"statics/js/inc")
jsFiles=[]
for root, dirs, files in os.walk(path):
    for file in files:
        if file.endswith('.js'):
            jsFiles.append(file)

import models
config = models.Config.all().get()
if not config:
    config=models.Config(name=u'康的blog',desc=u'关注java,python,javascript,flex,c++,sgs',skinName=u'clean-simple-white')
    config.put()

loginUrl=users.create_login_url("/login")

    
class MainHandler(webapp.RequestHandler):
    def get(self):
        logined = str(checkLogin()).lower()
        t=time.localtime(time.time())
        template_values = {
            'logined':logined,
            'jsFiles':jsFiles,
            'NOW_YEAR': time.strftime('%Y',t),
            'NOW_MONTH':time.strftime('%m',t),
            'NOW_DAY':time.strftime('%d',t),
            'config':config,
            'loginUrl':loginUrl
        }
        path = os.path.join(os.path.dirname(__file__),"templates/" + config.skinName+".php")
        logging.debug("@@@@")
        self.response.out.write(template.render(path, template_values))
        #self.response.out.write(path)

class TestHandler(webapp.RequestHandler):
    def get (self):
        #import sys 
        #sys.setdefaultencoding('utf-8') 

        logs=models.Article.all()
        logs = logs.fetch(10)
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
        self.response.out.write(getattr(kanglog, cgi.escape(self.request.get('action')))(self.request))

loginHtml='''
<html><head></head>
<body onload="window.opener.blog.login('%s');window.close();">
</body>
</html>
'''
class LoginHandler(webapp.RequestHandler):
    def get (self):
        if checkLogin():
            self.response.out.write(loginHtml%("success"));
        else:
            self.response.out.write(loginHtml%("falied"));
def main():
    application = webapp.WSGIApplication([('/', MainHandler),
                                          ('/test',TestHandler),
                                          ('/ajax.php',AjaxHandler),
                                          ('/login',LoginHandler)],
                                         debug=True)
    util.run_wsgi_app(application)


if __name__ == '__main__':
    main()
