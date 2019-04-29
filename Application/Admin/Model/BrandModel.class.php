<?php
namespace Admin\Model;
use Think\Model;

class BrandModel extends Model{
	protected $insertFields=array('brand_name','logo');
	protected $updateFields=array('id','brand_name','logo');
	
	//添加管理员验证规则
	protected $_validate=array(
		array('brand_name','require','品牌名称不能为空！'), 
		array('logo','require','品牌名称不能为空！'), 
		array('brand_name', '', '品牌名已存在！',0, 'unique', 2),
        array('brand_name', '1,30', '品牌名称的值最长不能超过 30 个字符！', 0, 'length', 3),
	);


	protected function _before_insert(&$data,$option){
		//先检查图片是否上传 在执行上传代码
		if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
			$ret=uploadOne('logo','Brand');

			if($ret['ok']==1){
				//把图片的路径放入数据库中
				$data['logo']=$ret['images'][0];
			}else{

				$this->error=$ret['error'];
				return false;
			}
		}
	}



	protected function _before_update(&$data, $option){
		
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
			{
				$ret = uploadOne('logo', 'Brand');
				if($ret['ok'] == 1)
				{
					$data['logo'] = $ret['images'][0];
				}
				else 
				{
					$this->error = $ret['error'];
					return FALSE;
				}

				deleteImage(array(
					I('post.old_logo'),
				));
			}
	}

	protected function _before_delete($option){
		#删除商品图片
		$brandModel=M('Brand');
		$brandData=$brandModel->field('logo')->where(array('id'=>array('eq',$option['where']['id'])))->find();
		deleteImage($brandData);
	}

	public function search($pageSize = 5)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword'))
			$where['brand_name'] = array('like', "%$keyword%");
	
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		#select a.*,GROUP_CONCAT(c.pri_name) from wx_role a left join wx_role_privilege b on a.id=b.role_id left join wx_privilege c on b.pri_id=c.id group by a.id;
		$data['data'] = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	
}