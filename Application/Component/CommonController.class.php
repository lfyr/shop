<?php
namespace Component;
use Think\Controller;

/**
* 
*/
class CommonController extends Controller
{

	public function __construct()
	{
		// 先调用父类的构造函数
		parent::__construct();

		// 获取当前管理员的ID
		$adminId = session('id');

		// 验证登录
		if(!session('id'))
			redirect(U('Admin/Login/login'));

		#所有管理员都能访问的页面
		if(CONTROLLER_NAME=='Index'){
			return true;
		}

		#当前访问的模块控制器方法
		$url=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		
		$where='module_name="'.MODULE_NAME.'" and controller_name="'.CONTROLLER_NAME.'" and action_name="'.ACTION_NAME.'"';

		if($adminId==1){
			$sql='select count(*) has from wx_privilege where '.$where;

		}else{
			$sql='select count(*) has from wx_admin a left join wx_admin_role b on a.id=b.admin_id left join wx_role_privilege c on b.role_id=c.role_id left join wx_privilege d on c.pri_id=d.id where a.id='.$adminId .' and '.$where;
		}

		#实例化空模型
		$db=M();
		$pri=$db->query($sql);
	

		if($pri[0]['has']<1){
			$this->error('对不起，您无权访问！','',3);
		}

	}

}
