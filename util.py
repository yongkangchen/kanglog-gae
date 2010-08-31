from google.appengine.api import users
def checkLogin ():
    user=users.get_current_user()
    if user:
        return True
    else:
        return False