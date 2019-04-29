<?php
namespace Admin\Model;
use Think\Model;

class ConfigModel extends Model{
	protected $updateFields=array('id','title','logo','appid','appsecret','token','keyword','description','contacts','tel','qq','email','address','footerinfo');
	//添加管理员验证规则

	protected $_validate=array(
		array('title','require','公众号名称不能为空！'), //默认情况下用正则进行验证
		array('appid', 'require', 'appid不能为空！'),
		array('appsecret', 'require', 'appsecret不能为空！'),
		array('token', 'require', 'token不能为空！'),
		array('title', '1,64', '公众号标题的值最长不能超过 60 个字符！', 1, 'length', 1),
	);

}