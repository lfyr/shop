<?php
namespace Admin\Model;
use Think\Model;

class MemberModel extends Model{
	protected $insertFields=array('email','password','cpassword','chkcode');
	protected $updateFields=array('id','email','password','cpassword','chkcode');
	
	//添加会员验证规则
	protected $_validate=array(
		array('email','require','账号不能为空！'), 
		array('email','email','email格式不正确！'), 
		array('email', '', '账号已存在！',0, 'unique', 1),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
		array('chkcode','chk_chkcode','验证码不正确',1,'callback'),
	);

	public $_login_validate=array(
		array('email','require','用户名不能为空！',1),
		array('email','email','email格式不正确！'), 
		array('password','require','密码不能为空！',1),
		array('chkcode','require','验证码不能为空！',1),
		array('chkcode','chk_chkcode','验证码不正确',1,'callback'),
	);


	public function chk_chkcode($code){
		$verify=new \Think\Verify();
		return $verify->check($code);
	}

	public function login($userPassword=true){
		$email=$this->email;
		$password=$this->password;
		#根据账号查找用户
		$user=$this->where(array('email'=>array('eq',$email)))->find();
		#判断是否存在该用户
		if($user){
			#检测该用户是否完成激活
			if(empty($user['email_code'])){

				if($userPassword){
					#检测该用户密码输入是否正确
					if($user['password']!=md5($password.C('MD5_KEY'))){
						$this->error='密码错误！';
						return false;
					}
				}
				#将可用的用户信息存入session
				session('mid',$user['id']);
				session('email',$user['email']);

				#登录成功把cookie中的商品移动到数据库并删除cookie
				$cartModel=D('Admin/Cart');
				$cartModel->moveDataToDb();

				// 如果有openid就绑定到这个账号上
				if(isset($openid))
				{
					$this->where(array('id'=>array('eq', $user['id'])))->setField('openid', $openid);
					unset($openid);
				}

				return true;

			}else{
				$this->error='该账号尚未通过验证！';
				return false;
			}
		}else{
			$this->error='用户名错误！';
			return false;
		}
		
	}

	public function _before_insert(&$data,$option){
		$data['password']=md5($data['password'].C('MD5_KEY'));
		$data['email_code']=md5(uniqid());
		$data['addtime']=time();
	}

	
	protected function _after_insert($data,$option){

		$content =<<<HTML
		<p>亲爱的用户{$data['email']}欢迎您成为shop会员，请点击下面链接地址完成email验证：</p>
		<p><a href="http://www.redreambj.com/index.php/Home/Member/emailchk/code/{$data['email_code']}">点击完成验证</a></p>
		<p>如非本人操作，请忽略此邮件</p>

HTML;
		sendMail($data['email'],'shop在线会员认证',$content);
	}

	
	public function search($pageSize = 5)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['email'] = array('like', "%$keyword%");
	
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