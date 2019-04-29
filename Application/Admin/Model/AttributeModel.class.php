<?php
namespace Admin\Model;
use Think\Model;

class AttributeModel extends Model{
	protected $insertFields = array('attr_name','attr_type','attr_option_values','type_id');
	protected $updateFields=array('id','attr_name','attr_type','attr_option_values','type_id');
	//添加管理员验证规则

	protected $_validate=array(
		array('attr_name','require','类型名称不能为空！'), //默认情况下用正则进行验证
		
		array('attr_name', '1,32', '类型名称的值最长不能超过 30 个字符！', 1, 'length', 1),
	);
	
	protected function _before_insert(&$data, $option){
		$attr_option_values=$data['attr_option_values'];
	    $attr_option_values=str_replace("，",",",$attr_option_values);
	    $data['attr_option_values']=$attr_option_values;		
	}

	protected function _before_update(&$data, $option){
        $attr_option_values=$data['attr_option_values'];
	    $attr_option_values=str_replace("，",",",$attr_option_values);
	    $data['attr_option_values']=$attr_option_values;
	}

	public function search($pageSize = 5)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
	
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