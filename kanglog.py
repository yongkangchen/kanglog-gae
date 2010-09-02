#!/usr/bin/env python
#coding=utf-8
from models import Article,Category,Comment,Guestbook
from util import checkLogin

#from django.utils import simplejson
#from django.core import serializers
def to_dict(model):
    return dict([(p, unicode(getattr(model, p))) for p in model.properties()])

import datetime
from google.appengine.api import users
from google.appengine.ext import db
from django.utils import simplejson

class GaeEncoder(simplejson.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, db.Model):
            dictList = [(name, getattr(obj, name)) for name in obj.properties().keys()]
            dictList.append(('id', obj.key().id()))
            return dict(dictList)
        elif isinstance(obj, users.User):
            return {
                'nickname': obj.nickname(),
                'email': obj.email(),
                'user_id': obj.user_id(),
                'federated_identity': obj.federated_identity(),
                'federated_provider': obj.federated_provider(),
            }
        elif isinstance(obj, datetime.date):
            return obj.isoformat()
        elif isinstance(obj, db.Query):
            return [self.default(o) for o in obj]
        return super(GaeEncoder, self).default(obj)

def getPageNum (request):
    pageNum = request.get('page')
    if not pageNum:
        pageNum = 1
    else:
        pageNum = int(pageNum)
    return pageNum

def article (request):
    def my_dic (obj, name):
        if name == 'category':
            obj = obj.category.name
        elif name == 'author':
            obj = u'小康'
        else:
            obj = getattr(obj, name)
        if isinstance(obj, datetime.date):
            obj = obj.isoformat()
        return (name, obj)
    
    a_id = request.get('id')
    category = request.get('cat_Id')
    if a_id:
        articles = [Article.get_by_id(int(a_id))]
    elif category:
        category = Category.get_by_id(int(category))
        articles = Article.all().filter('category =', category).fetch(10)
    else:
        articles = Article.all().order('-postTime').fetch(10)
    #TODO
    dicList = [{"response":"article", "comment":True, "page":'null', "count":"1", "max":"10", "admin":""}]
    for obj in articles:
        dic = dict([my_dic(obj, name) for name in obj.properties().keys()])
        dic['id'] = obj.key().id()
        dicList.append(dic)
    return simplejson.dumps(dicList)

def category (request):
    return article(request)

def search (request):
    pass

def getcategory (request):
    return simplejson.dumps(Category.all(), cls=GaeEncoder)
    
def getcomment (request):
    return simplejson.dumps(Comment.all().order('-postTime').fetch(10), cls=GaeEncoder)


def getguestbook (request):
    return simplejson.dumps(Guestbook.all().order('-postTime').fetch(10), cls=GaeEncoder)

#http://localhost:8080/ajax.php?action=comment&id=81&page=1&radnum=0.8674970943153371
def comment (request):
    a_id = int(request.get('id'))
    return simplejson.dumps(Comment.all().filter('article =', Article.get_by_id(a_id)), cls=GaeEncoder)
def guestbook (request):
    pass
def getcalendar (request):
    pass

def gb (request):
    #TODO
    pass

def comm (request):
    log_id = int(request.get("log_id"))
    comm = Comment(content=request.get("Content"), messager=request.get("Messager"), QQ=int(request.get("QQ")), url=request.get("Url"), mail=db.Email(request.get("Mail")))
    comm.postTime = datetime.datetime.now()
    comm.article = Article.get_by_id(log_id)
    comm.put()
    #TODO IP

def gettime (request):
    pass
    
    
    


def post (request, article=None):
    user = users.get_current_user()
    if not user:
        return "failed";
    if not article:
        article = Article(author=user)
    category = Category.all().filter('name =', request.get("log_catId")).get()

    article.content = request.get("content")
    article.title = request.get("title")
    article.password = request.get('log_psw')
    article.category = category

    postTime = request.get("postTime")
    if not postTime:
        postTime = datetime.date.today()
    else:
        postTime = datetime.datetime.strptime(postTime, '%Y-%m-%d').date()
    article.postTime = postTime

    article.put()
    return "success"
def edit (request):
    article = Article.get_by_id(int(request.get("id")))
    if not article:
        return "failed"
    return post(request, article)

def remove (request):
    if not checkLogin():
        return "falied"
    #cmd
    cmd = request.get("cmd")
    if cmd == 'article':    
        article = Article.get_by_id(int(request.get("id")))
        if article:
            article.delete()
            #TODO 删除评论
    elif cmd == 'comment':
        #TODO
        pass
    elif cmd == 'guestbook':
        #TODO
        pass
    elif cmd == 'category':
        #TODO
        pass
    '''
    case "article": $old_catId=$table->queryValue("log_catId","id='$id'");
                    $table->delById($id);
                    $comment=new Table("comment");
                    $comment->del("log_id='$id'");
                    $category=new Table("category");
                    $category->update(array("cat_count"=>"cat_count-1"),"cat_name='$old_catId'");
                    break;
    case "comment":$comment=$table->query("id='$id'");
                    $log_id=$comment[0]->log_id;
                    $table->delById($id);
                    $article=new Article();
                    $article->update(array("log_comms"=>"log_comms-1"),"id='$log_id'");
                    break;
    case "guestbook":$table->delById($id);
                    break;
    case "category":$category=$table->query("id='$id'");
                    $cat_name=$category[0]->cat_name;
                    $table->delById($id);
                    $article=new Article();
                    $article->del("log_catId='$cat_name'");
                    break;
    '''
    return 'success'

def editcatename (request):
    if not checkLogin():
        return 'failed'
    category = Category.all().filter('name =', request.get('name')).get()
    category.name = request.get('cat_name')
    category.put()
    return 'success'

def reply (request):
    where = request.get('where')
    a_id = int(request.get('id'))
    reply = request.get('Content')
    replyTime = datetime.date.today()
    if where == "comment":
        comment = Comment.get_by_id(a_id)
        comment.reply = reply
        comment.replyTime = replyTime
    elif where == "guestbook":
        comment = Guestbook.get_by_id(a_id)
        comment.reply = reply
        comment.replyTime = replyTime
    return "{\"response\":\"success\",\"where\":\"%s\",\"id\":\"%s\",\"reply\":\"%s\",\"replyTime\":\"%s\"}" % (where, a_id, reply, replyTime)

def  batcmd(request):
    log_id = request.get("log_id").split(",")
    cmd = request.get("cmd")
    for a_id in log_id:
        if not a_id.strip():
            continue
        log = Article.get_by_id(int(a_id))
        if not log:
            continue
        if cmd == "del":
            log.delete()
            #TODO 删除评论
        elif cmd == "move":
            log_cateId = request.get("log_catId")
            log.category = Category.all().filter('name =', log_cateId).get()#Category.get_by_id(log_cateId)
            log.put()    


