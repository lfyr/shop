权限模块制作sql需要五张表
二张中间表：会员角色表  角色权限表
三张独立表：会员表 权限表  角色表

①权限表

DROP TABLE IF EXISTS wx_privilege;
CREATE TABLE wx_privilege
(
	id smallint unsigned not null auto_increment,
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(10) not null comment '模块名称',
	controller_name varchar(10) not null comment '控制器名称',
	action_name varchar(20) not null comment '方法名称',
	parent_id smallint unsigned not null default '0' comment '上级权限的ID，0：代表顶级权限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限表';

②角色表
DROP TABLE IF EXISTS wx_role;
CREATE TABLE wx_role(
	id smallint unsigned not null auto_increment,
	role_name varchar(30) not null comment '角色名称',
	primary key (id)
)engine=myisam default charset=utf8 comment='角色表';

③管理员表
DROP TABLE IF EXISTS wx_admin;
CREATE TABLE wx_admin(
	id tinyint unsigned not null auto_increment,
	username varchar(32) not null comment '用户名',
	password char(32) not null comment '密码',
	is_use tinyint(3) unsigned  not null default '1' comment '是否启用 1启用 0禁用',
)engine=myisam default charset=utf8 comment='管理员表';

④角色权限表  
DROP TABLE IF EXISTS wx_role_privilege;
CREATE TABLE wx_role_privilege(
	id  smallint unsigned not null  auto_increment,
	pri_id smallint unsigned not null comment '权限的id',
	role_id smallint unsigned not null comment '角色的id',
	primary key(id)
)engine=myisam default charset=utf8 comment='角色权限表' 

⑤会员角色表 
DROP TABLE IF EXISTS wx_admin_role;
CREATE TABLE wx_admin_role(
	id smallint unsigned not null auto_increment,
	admin_id smallint unsigned not null comment '管理员id',
	role_id smallint unsigned not null comment '角色id',
	primary key(id)
)engine=myisam default charset=utf8 comment='会员角色表';

