<?php
namespace Admin\Model;
use Think\Model;

class KeywordModel extends Model{
	protected $insertFields = array('keyword','content','sort','addtime','author');
	protected $updateFields=array('id','keyword','content','sort','addtime','author');
	//添加管理员验证规则

	protected $_validate=array(
		array('keyword','require','关键字不能为空！'), //默认情况下用正则进行验证
		array('keyword','','关键字已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		array('content', 'require', '回复内容不能为空'),
		array('keyword', '1,32', '公众号标题的值最长不能超过 60 个字符！', 1, 'length', 1),
	);
	
	protected function _before_insert(&$data, $option){
		$data['addtime'] = strtotime(I('post.addtime'));
		
	}

	protected function _before_update(&$data, $option){
		$data['addtime'] = strtotime(I('post.addtime'));
		
	}

	public function search($pageSize = 2)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['keyword'] = array('like', "%$keyword%");

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