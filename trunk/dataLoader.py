#coding=utf-8
import datetime
from google.appengine.ext import db
from google.appengine.tools import bulkloader
from google.appengine.ext import db
class Category(db.Model):
    name = db.StringProperty(required=True)
    count = db.IntegerProperty()

class Article(db.Model):
    author = db.UserProperty()
    category = db.ReferenceProperty(Category)
    title = db.StringProperty()
    content = db.TextProperty()
    postTime = db.DateProperty()
    password = db.StringProperty()
    commentCount = db.IntegerProperty()
    viewCount = db.IntegerProperty()
    


class Guestbook(db.Model):
    content = db.StringProperty(required=True)
    messager = db.StringProperty(required=True)
    QQ = db.IntegerProperty()
    url = db.LinkProperty()
    mail = db.EmailProperty()
    postTime = db.DateTimeProperty()
    reply = db.StringProperty()
    replyTime = db.DateTimeProperty()
    ip = db.StringProperty()

class Comment(Guestbook):
    article = db.ReferenceProperty(Article)

def decode (x):
    return x.decode('utf-8')
def date (x):
    return datetime.datetime.strptime(x, '%Y-%m-%d %H:%M:%S').date()
def cate (x):
    return Category.all().filter('name =',x.decode('utf-8')).get().key()
from google.appengine.api import users
def getUser (x):
    return None
    
class CategoryLoader(bulkloader.Loader):
  def __init__(self):
    bulkloader.Loader.__init__(self, 'Category',[('id',str),('name', decode),('count', int)])

class ArticleLoader(bulkloader.Loader):
  def __init__(self):
    #id	log_author	log_catId	log_title	log_content	log_postTime	log_psw	log_comms	log_views
    bulkloader.Loader.__init__(self, 'Article',[('id',str),('author', getUser),
                                ('category', cate),('title',decode),('content',decode),
                                ('postTime',date),('password',decode),('commentCount',int),('viewCount',int)])
loaders = [ArticleLoader]#CategoryLoader