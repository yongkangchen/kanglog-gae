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

class Config(db.Model):
    name = db.StringProperty()
    desc = db.StringProperty()
    skinName = db.StringProperty()