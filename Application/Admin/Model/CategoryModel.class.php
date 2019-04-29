<?php
namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model{
	protected $insertFields=array('cat_name','parent_id');
	protected $updateFields=array('id','cat_name','parent_id');
	
	//添加管理员验证规则
	protected $_validate=array(
		array('cat_name','require','分类名称不能为空！'), 
		array('cat_name', '', '分类名已存在！',0, 'unique', 2),
        array('cat_name', '1,30', '分类名称的值最长不能超过 30 个字符！', 0, 'length', 3),
        array('parent_id', 'number', '上级分类的ID，0：代表顶级分类必须是一个整数！', 2, 'regex', 3),
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
			$this->execute("DELETE FROM wx_category WHERE id IN($children)");
		}

	}

	protected function _before_update(&$data,$option){
		
	}	 
}