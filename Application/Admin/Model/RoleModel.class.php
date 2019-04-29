<?php
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{
	protected $insertFields = array('role_name');
	protected $updateFields=array('id','role_name');
	//添加管理员验证规则

	protected $_validate=array(
		array('role_name','require','角色名不能为空！'), //默认情况下用正则进行验证
		array('role_name','','角色已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		array('role_name', '1,30', '角色名的值最长不能超过 30 个字符！', 1, 'length', 1),
	);
	
	protected function _after_insert(&$data, $option){
		$pri_id=I('post.pri_id');

		$rpModel=M('RolePrivilege');
		foreach ($pri_id as $v) {
			$rpModel->add(array(
				'pri_id'=>$v,
				'role_id'=>$data['id'],
			));
		}
	}

	protected function _before_update(&$data, $option){
		#先清空原来权限
		$rpModel=M('RolePrivilege');
		$rpModel->where(array('role_id'=>array('eq',$option['where']['id'])))->delete();
		#重新添加权限
		$pri_id=I('post.pri_id');
		if($pri_id){
			$rpModel=M('RolePrivilege');
			foreach ($pri_id as $k => $v) {
				$rpModel->add(array(
					'pri_id'=>$v,
					'role_id'=>$option['where']['id'],
				));
			}
		}
	}

	protected function _before_delete($option){
		#删除角色之前先判断有没有管理员
		$arModel=M('AdminRole');
		$has=$arModel->where(array('role_id'=>array('eq',$option['where']['id'])))->count();

		if($has>0){
			$this->error='此角色下面存在管理员，无法删除';
			return false;
		}

		#把这个角色所分配的 权限全部删除
		$rpModel=M('RolePrivilege');
		$rpModel->where(array('role_id'=>array('eq',$option['where']['id'])))->delete();
	}
	public function search($pageSize = 2)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['role_name'] = array('like', "%$keyword%");
	
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		#select a.*,GROUP_CONCAT(c.pri_name) from wx_role a left join wx_role_privilege b on a.id=b.role_id left join wx_privilege c on b.pri_id=c.id group by a.id;
		$data['data'] = $this->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')->alias('a')->join('left join wx_role_privilege b on a.id=b.role_id left join wx_privilege c on b.pri_id=c.id')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
}