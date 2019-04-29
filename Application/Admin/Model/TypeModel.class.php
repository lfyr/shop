<?php
namespace Admin\Model;
use Think\Model;

class TypeModel extends Model{
	protected $insertFields = array('type_name');
	protected $updateFields=array('id','type_name');
	//添加管理员验证规则

	protected $_validate=array(
		array('type_name','require','类型名称不能为空！'), //默认情况下用正则进行验证
		array('type_name','','类型名已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		array('type_name', '1,32', '类型名称的值最长不能超过 30 个字符！', 1, 'length', 1),
	);
	
	protected function _before_delete($option){

		#删除类型之前先判断还类型下有没有存在属性
		$attrModel=M('Attribute');
		$has=$attrModel->where(array('type_id'=>array('eq',$option['where']['id'])))->count();

		if($has>0){
			$this->error='此类型下面存在属性，无法删除';
			return false;
		}
	}

	protected function _before_update(&$data, $option){

		
	}

	public function search($pageSize = 5)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['type_name'] = array('like', "%$keyword%");
	
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