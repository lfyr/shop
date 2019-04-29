<?php
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model{
	protected $insertFields = array('goods_name','cat_id','brand_id','shop_price','logo','sm_logo','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc');
	protected $updateFields=array('id','goods_name','cat_id','brand_id','shop_price','logo','sm_logo','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc');
	//添加管理员验证规则

	protected $_validate=array(
		array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
		array('goods_name', '1,45', '商品名称的值最长不能超过 45 个字符！', 1, 'length', 3),
		array('cat_id', 'require', '主分类的id不能为空！', 1, 'regex', 3),
		array('cat_id', 'number', '主分类的id必须是一个整数！', 1, 'regex', 3),
		array('shop_price', 'currency', '本店价必须是货币格式！', 2, 'regex', 3),
		array('shop_price','currency','商品价格必须为货币格式'), //默认情况下用正则进行验证
		array('is_hot', 'number', '是否热卖必须是一个整数！', 2, 'regex', 3),
		array('is_new', 'number', '是否新品必须是一个整数！', 2, 'regex', 3),
		array('is_best', 'number', '是否精品必须是一个整数！', 2, 'regex', 3),
		array('is_on_sale', 'number', '是否上架：1：上架，0：下架必须是一个整数！', 2, 'regex', 3),
		array('seo_keyword', '1,150', 'seo优化_关键字的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('seo_description', '1,150', 'seo优化_描述的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('type_id', 'number', '商品类型id必须是一个整数！', 2, 'regex', 3),
		array('sort_num', 'number', '排序数字必须是一个整数！', 2, 'regex', 3),
		array('is_delete', 'number', '是否放到回收站：1：是，0：否必须是一个整数！', 2, 'regex', 3),

	);
	protected function _before_insert(&$data,$option){
		//获取当前时间
		$data['addtime']=time();

		//先检查图片是否上传 在执行上传代码
		if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
			$ret=uploadOne('logo','Goods',array(
				array(384,241),
			));

			if($ret['ok']==1){
				//把图片的路径放入数据库中
				$data['logo']=$ret['images'][0];
				$data['sm_logo']=$ret['images'][1];
			}else{

				$this->error=$ret['error'];
				return false;
			}
		}

	}

	protected function _after_insert($data,$option){
		/******************** 处理商品属性的数据 *********************/
		$ga=I('post.ga');
		$ap=I('post.attr_price');
		if($ga){
			$gaModel=M('GoodsAttr');
			foreach ($ga as $k => $v) {
				foreach ($v as $k1 => $v1) {
					if(empty($v1))
						continue;
					$price = isset($ap[$k][$k1]) ? $ap[$k][$k1] : '';
					$gaModel->add(array(
						'goods_id' => $data['id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $price,
					));
				}
			}
		}

		/******************** 处理商品图片 *********************/

		//利用函数hasImages()检测是否存在图片
		if(hasImage('pics')){

			$gpModel=M('GoodsPics'); #实例化商品图片表

			#将批量图片数据做数组转化
		  	$pics=array();
          	foreach ($_FILES['pics']['name'] as $k => $v) {
            	$pics[]=array(
              	'name'=>$v,
              	'type'=>$_FILES['pics']['type'][$k],
              	'tmp_name'=>$_FILES['pics']['tmp_name'][$k],
              	'error'=>$_FILES['pics']['error'][$k],
              	'size'=>$_FILES['pics']['size'][$k],
            	);
          	}

   			// 在后面调用uploadOne方法时会使用$_FILES数组上传图片，所以我们要把我们处理好的数组赎给$_FILES这样上传时使用的就是我们处理好的数组

   			$_FILES=$pics;

   			// 循环每张图片一个一个的上传
          	foreach ($pics as $k => $v) {
            	$ret=uploadOne($k,'Goods',array(
              	array(150,150),
            	));

            	if($ret['ok']==1){
              
	              	$gpModel->add(array(
	                	'goods_id'=>$data['id'],
	                	'pic'=>$ret['images']['0'], //原图地址
	                	'sm_pic'=>$ret['images']['1'], //缩略图地址
	              	));
            	}else{

					$this->error=$ret['error'];
					return false;
				}
          	}
		}
	}

	
	protected function _before_update(&$data, $option){

		//判断是否修改了类型 如果修改了那么就删除原来的商品属性
		//取出原来的类型
		if(I('post.old_type_id') != $data['type_id']){

			//删除当前商品所有属性
			$gaModel=M('GoodsAttr');
			$gaModel->where(array('goods_id'=>array('eq',$option['where']['id'])))->delete();
		}

		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(384,241),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}

			deleteImage(array(
				I('post.old_logo'),
				I('post.old_sm_logo'),
			));
		}


	}

	protected function _after_update($data,$option){
		/******************** 处理商品图片 *********************/

		//利用函数hasImages()检测是否存在图片
		if(hasImage('pics')){

			$gpModel=M('GoodsPics'); #实例化商品图片表

			#将批量图片数据做数组转化
		  	$pics=array();
          	foreach ($_FILES['pics']['name'] as $k => $v) {
            	$pics[]=array(
              	'name'=>$v,
              	'type'=>$_FILES['pics']['type'][$k],
              	'tmp_name'=>$_FILES['pics']['tmp_name'][$k],
              	'error'=>$_FILES['pics']['error'][$k],
              	'size'=>$_FILES['pics']['size'][$k],
            	);
          	}

   			// 在后面调用uploadOne方法时会使用$_FILES数组上传图片，所以我们要把我们处理好的数组赎给$_FILES这样上传时使用的就是我们处理好的数组

   			$_FILES=$pics;

   			// 循环每张图片一个一个的上传
          	foreach ($pics as $k => $v) {
            	$ret=uploadOne($k,'Goods',array(
              	array(150,150),
            	));

            	if($ret['ok']==1){
              
	              	$gpModel->add(array(
	                	'goods_id'=>$option['where']['id'],
	                	'pic'=>$ret['images']['0'], //原图地址
	                	'sm_pic'=>$ret['images']['1'], //缩略图地址
	              	));
            	}else{

					$this->error=$ret['error'];
					return false;
				}
          	}
		}

		// 处理新属性
		$ga=I('post.ga');
		$ap=I('post.attr_price');
		$gaModel=M('GoodsAttr');
		if($ga){
			foreach ($ga as $k => $v) {
				foreach ($v as $k1 => $v1) {
					if(empty($v1))
						continue;
					$price = isset($ap[$k][$k1]) ? $ap[$k][$k1] : '';
					$gaModel->add(array(
						'goods_id' => $option['where']['id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $price,
					));
				}
			}
		}

		// 处理原属性
		$oldga = I('post.old_ga');
		$oldap = I('post.old_attr_price');

		// 循环所更新一遍所有的旧属性
		foreach ($oldga as $k => $v)
		{
			foreach ($v as $k1 => $v1)
			{

				// 要修改的字段
				$oldField = array('attr_value' => $v1);
				// 如果有对应的价格就把价格也修改
				if(isset($oldap[$k]))
					$oldField['attr_price'] = $oldap[$k][$k1];
				$gaModel->where(array('id'=>array('eq', $k1)))->save($oldField);
			}
		}
	}
	protected function _before_delete($option){
		
		#删除商品主logo
		$goodsModel=M('Goods');
		$goodsData=$goodsModel->field('logo')->where(array('id'=>array('eq',$option['where']['id'])))->find();
		deleteImage($v);

		#删除商品属性
		$gaModel=M('GoodsAttr');
		$gaModel->where(array('goods_id'=>array('eq',$option['where']['id'])))->delete();

		#删除商品图片
		$gpModel=M('GoodsPics');
		$gpData=$gpModel->field('pic,sm_pic')->where(array('goods_id'=>array('eq',$option['where']['id'])))->select();
		
		#商品库存量
		$model = M('GoodsNumber');
		$model->where(array('goods_id'=>array('eq', $option['where']['id'])))->delete();
		
		#循环删除每张图片
		foreach ($gpData as $k => $v) {
			deleteImage($v);
		}

		$gpModel->where(array('goods_id'=>array('eq',$option['where']['id'])))->delete();
	}

	public function search($pageSize = 5,$is_delete=0)
	{
		/**************************************** 搜索 ****************************************/
		// 是否是回收站的商品
		if($keyword = I('get.keyword')){
			$where['goods_name'] = array('like', "%$keyword%");
		}

		$where['is_delete'] = array('eq', $is_delete);
		
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();

		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		$data['data'] = $this->field('a.*,ifnull(sum(b.goods_number),0) gn')->alias('a')->join('left join wx_goods_number b on a.id=b.goods_id')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}

	#取出首页封面的分类产品数据
	public function getHotGoods(){
		return $this->where(array(
			'is_on_sale'=>array('eq',1),//必须上架
			'is_delete'=>array('eq',0),//不在回收站
			'is_hot'=>array('eq',1),//是否热卖
		))->order('addtime DESC')->select();
	}

	//取出推荐产品
	public function getBestGoods(){
		
		return $this->where(array(
			'is_on_sale'=>array('eq',1),//上架
			'is_delete'=>array('eq',0),//不在回收站
			'is_best'=>array('eq',1),//热卖产品
			'is_promote'=>array('eq',0),//不是促销产品
		))->select();
	}

	//取出新产品
	public function getNewGoods(){
	
		return $this->where(array(
			'is_on_sale'=>array('eq',1),//上架
			'is_delete'=>array('eq',0),//不在回收站
			'is_new'=>array('eq',1),//热卖产品
			'is_promote'=>array('eq',0),//不是促销产品
		))->select();
	}
	
	#根据将商品属性的id转化为字符串
	public function convertGoodsAttrIdToGoodsAttrStr($gaid){
		if($gaid){
			$sql='SELECT GROUP_CONCAT( CONCAT( b.attr_name,  ":", a.attr_value ) SEPARATOR  "<br/>" ) gastr
					FROM wx_goods_attr a
					LEFT JOIN wx_attribute b ON a.attr_id = b.id
					WHERE a.id
					IN ( '.$gaid.' )';
			$ret=$this->query($sql);
			return $ret[0]['gastr'];
		}else{
			return '';
		}
	}
}