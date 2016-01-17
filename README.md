# apidoc
apidoc

# manage
manage api doc

# debug
debug api doc

# install

# config
** 添加初始管理员
*** user = admin
*** pwd = sha1("admin")
./mongo
use apidoc;
db.admin.insert({username:"admin",password:"d033e22ae348aeb5660fc2140aec35850c4da997",super:"1",status:"0",time:"1453037697",update_time:"1453037697",authority:["read","write"]});