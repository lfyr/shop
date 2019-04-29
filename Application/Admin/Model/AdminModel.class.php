<?php
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model{
	protected $insertFields=array('username','password','cpassword','is_use','chkcode');
	protected $updateFields=array('id','username','password','cpassword','is_use');
	//添加管理员验证规则

	protected $_validate=array(
		array('username','require','账号不能为空！'), 
		array('username', '', '账号已存在！',0, 'unique', 1),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('is_use', 'number', '是否启用 1：启用0：禁用必须是一个整数！',2, 'regex', 3),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
	);

	public $_login_validate=array(
		array('username','require','用户名不能为空！',1),
		array('password','require','密码不能为空！',1),
		array('chkcode','require','验证码不能为空！',1),
		array('chkcode','chk_chkcode','验证码不正确',1,'callback'),
	);


	public function chk_chkcode($code){
		$verify=new \Think\Verify();
		return $verify->check($code);
	}

	public function login(){
		//获取表单中的用户名密码
		$username=$this->username;
		$password=$this->password;
		

		//首先查询数据库里有没有这个账号
		$user=$this->where(array(
			'username'=>array('eq',$username),
			))->find();

		//判断有没有这个账号
		if($user){
			//判断是否启用（超级管理）不能禁用
			if($user['id']==1 || $user['is_use']==1){
				//判断密码
				if($user['password']==md5($password.C('MD5_KEY'))){
					session('id',$user['id']);
					session('username',$user['username']);
					return TRUE;
				}else{
					$this->error="密码不正确！";
					return false;
				}
			}else{
				$this->error="账号未启用！";
				return false;
			}
		}else{
			$this->error="用户名不存在！";
			return false;
		}

	}

	public function _before_insert(&$data,$option){
		$data['password']=md5($data['password'].C('MD5_KEY'));
	}

	protected function _before_update(&$data,$option){
		#如果是超级管理员必须启用
		if($option['where']['id']==1){
			$data['is_use']=1;
		}

		#先清空原有这个管理员的所有角色
		$role_id=I('post.role_id');
		$arModel=M('AdminRole');
		$arModel->where(array('admin_id'=>array('eq',$option['where']['id'])))->delete();
		#重新添加
		if($role_id){
			foreach ($role_id as $v) {
				$arModel->add(array(
					'role_id'=>$v,
					'admin_id'=>$option['where']['id'],
				));
			}
		}

		$data['password']=md5($data['password'].C('MD5_KEY'));
	}
	
	protected function _after_insert($data,$option){
		$role_id=I('post.role_id');
		if($role_id){
			$arModel=M('AdminRole');
			foreach ($role_id as $v) {
				$arModel->add(array(
					'admin_id'=>$data['id'],
					'role_id'=>$v,
				));
			}
		}
	}

	protected function _before_delete($option){
		#超级管理员不允许删除
		if($option['where']['id']==1){
			$this->error='超级管理员不能删除';
			return false;
		}
		#删除管理之前先删除admin_role中对应这个管理员的数据
		$arModel=M('AdminRole');
		$arModel->where(array('admin_id'=>array('eq',$option['where']['id'])))->delete();
	}

	public function search($pageSize = 2)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['username'] = array('like', "%$keyword%");
	
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
	
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		$data['data'] = $this->alias('a')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}

	 
}