<?php
return array(
	//'配置项'=>'配置值'
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'127.0.0.1',
	'DB_NAME'=>'app_weixin',
	'DB_USER'=>'root',
	'DB_PWD'=>'root201$',
	'DB_PREFIX'=>'wx_',
	'DB_CHARSET'=>'utf8',
	'DB_PORT'=>'3306',

	// 默认参数过滤方法 用于I函数...
	'DEFAULT_FILTER' =>  'trim,removeXSS', 

	/**md5加密**/
	'MD5_KEY'=>'jh@#*&hjk456$%^&^45646***//',

	// 跟图片相关的设置
	'IMG_maxSize'=>'3M',// 设置附件上传大小
	'IMG_exts'=>array('jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
	'IMG_rootPath'=>'./Public/Uploads/',// 设置附件上传根目录
	'IMG_URL'=>'/Public/Uploads/',

	/************** 发邮件的配置 ***************/
	'MAIL_ADDRESS' => 'chaoyi163@163.com',   // 发货人的email
	'MAIL_FROM' => 'chaoyi163',      // 发货人姓名
	'MAIL_SMTP' => 'smtp.163.com',      // 邮件服务器的地址
	'MAIL_LOGINNAME' => 'chaoyi163',   
	'MAIL_PASSWORD' => 'love123',
);