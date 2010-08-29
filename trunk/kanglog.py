#!/usr/bin/env python
#encoding=utf-8
from models import *
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
            return dict([(name, getattr(obj, name)) for name
                in obj.properties().keys()])
        elif isinstance(obj, users.User):
            return {
                'nickname': obj.nickname(),
                'email': obj.email(),
                'user_id': obj.user_id(),
                'federated_identity': obj.federated_identity(),
                'federated_provider': obj.federated_provider(),
            }
        elif isinstance(obj,datetime.date):
            return obj.isoformat()
        elif isinstance(obj,db.Query):
            return [self.default(o) for o in obj]
        return super(GaeEncoder, self).default(obj)

def getPageNum (request):
    pageNum=request.get('page')
    if not pageNum:
        pageNum=1
    else:
        pageNum=int(pageNum)
    return pageNum

def article (request):
    def my_dic (obj,name):
        if name=='category':
            obj = obj.category.name
        elif name=='author':
            obj = u'小康'
        else:
            obj = getattr(obj, name)
        if isinstance(obj,datetime.date):
            obj = obj.isoformat()
        return (name, obj)
    
    a_id=request.get('id')
    if a_id:
        articles=[Article.get_by_id(int(a_id))]
    else:
        articles=Article.all().order('-postTime').fetch(10)
    dicList=[{"response":"article","comment":'true',"page":'null',"count":"1","max":"10","admin":""}]
    for obj in articles:
        dic=dict([my_dic(obj,name) for name in obj.properties().keys()])
        dic['id'] = obj.key().id()
        dicList.append(dic)
    return simplejson.dumps(dicList)

def getcomment (request):
    return simplejson.dumps(Comment.all().order('-postTime').fetch(10), cls=GaeEncoder)

def getcategory (request):
    return simplejson.dumps(Category.all(),cls=GaeEncoder)
def getguestbook (request):
    return simplejson.dumps(Guestbook.all().order('-postTime').fetch(10), cls=GaeEncoder)
    