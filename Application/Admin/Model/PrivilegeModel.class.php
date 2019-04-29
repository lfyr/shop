<?php
namespace Admin\Model;
use Think\Model;

class PrivilegeModel extends Model{
	protected $insertFields=array('pri_name','module_name','controller_name','action_name','parent_id');
	protected $updateFields=array('id','pri_name','module_name','controller_name','action_name','parent_id');
	//添加管理员验证规则

	protected $_validate=array(
		array('pri_name','require','权限名称不能为空！'), 
		array('pri_name', '', '权限名已存在！',0, 'unique', 2),
        array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('module_name','require','模块名称不能为空！'), 
        array('module_name', '1,20', '模块名称的值最长不能超过 20 个字符！', 1, 'length', 3),
        array('controller_name','require','控制器名称不能为空！'), 
        array('controller_name', '1,20', '控制器名称的值最长不能超过 20 个字符！', 1, 'length', 3),
		array('action_name','require','方法名称不能为空！'), 
        array('action_name', '1,20', '方法名称的值最长不能超过 20 个字符！', 1, 'length', 3),
        array('parent_id', 'number', '上级权限的ID，0：代表顶级权限必须是一个整数！', 2, 'regex', 3),
	);

	
	public function getTree(){
		$data=$this->select();
		return $this->_reSort($data);
	}

	private function _reSort($data,$parent_id=0,$level=0){
		static $ret=array();
		foreach($data as $k=>$v){
			if($v['parent_id']==$parent_id){
				$v['level']=$level;
				$ret[]=$v;
				$this->_reSort($data,$v['id'],$level+1);
			}
		}
		return $ret;
	}

	public function getChildren($id){
		$data=$this->select();
		return $this->_children($data,$id);
	}

	private function _children($data,$parent_id=0){
		static $ret=array();
		foreach ($data as $k => $v) {
			if($v['parent_id']==$parent_id){
				$ret[]=$v['id'];
				$this->_children($data,$v['id']);
			}
		}
		return $ret;
	}
	public function _before_delete($option){
		#查找出该分类的子类一起删除
		$children=$this->getChildren($option['where']['id']);

		if($children){
			$children=implode(',', $children);
			$this->execute("DELETE FROM wx_privilege WHERE id IN($children)");
		}

		#查找该类所对应的角色记录删除掉
		$rpModel=M('RolePrivilege');
		$rpModel->where(array('pri_id'=>array('eq',$option['where']['id'])))->delete();
	}

}