<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model 
{
    protected $insertFields = array('address','shr_name','shr_province','shr_city','shr_area','shr_address','shr_tel','pay_method','remark');
    protected $_validate = array(
        array('shr_name', 'require', '收货人姓名不能为空！', 1, 'regex', 3),
        array('shr_province', 'require', '收货人所在省份不能为空！', 1, 'regex', 3),
        array('shr_city', 'require', '收货人所在城市不能为空！', 1, 'regex', 3),
        array('shr_area', 'require', '收货人所在地区不能为空！', 1, 'regex', 3),
        array('shr_address', 'require', '收货人地址不能为空！', 1, 'regex', 3),
        array('shr_tel', 'require', '收货人电话不能为空！', 1, 'regex', 3),
        array('pay_method', 'require', '配送方式不能为空！', 1, 'regex', 3),
    );

    public function _before_insert(&$data,$option){
    	//判断购物车中是否有商品
    	$cartModel=D('Admin/Cart');
    	$cartData=$cartModel->cartList();

    	if(count($cartData)==0){
    		$this->error='亲请先购买商品！';
    		return FALSE;
    	}

    	//加锁支持高并发
    	$this->fp=fopen('./order.lock', 'r');
    	flock($this->fp, LOCK_EX);
       	//循环购物车中每件商品检查库存量够不够
       	$tp=0; //总价
       	$gnModel=M('GoodsNumber');

       	$buythis=session('buythis');
       	foreach ($cartData as $k => $v) {

       	   //判断商品有没有别选中
            if(!in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis))
                continue;

       		//取出这件商品的库存量
       		$gn=$gnModel->field('goods_number')->where(array(
       			'goods_id'=>array('eq',$v['goods_id']),
       			'goods_attr_id'=>array('eq',$v['goods_attr_id']),
       		))->find();

           
       		if($gn['goods_number']<$v['goods_number']){
       			$this->error='商品库存量不足！';
       			return false;
       		}

       		$tp+=$v['shop_price']*$v['goods_number'];
       	}

       	//以上验证通过方可下单 下单前补全所有字段
        $order_id=date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
       	$data['member_id']=session('mid');
       	$data['addtime']=time();
       	$data['total_price']=$tp;
        $data['order_id']=$order_id;


       	// 启用事务
        mysqli_query('START TRANSACTION');
    }

    protected function _after_insert($data,$option){
        
       	//处理订单基本表
       	//把购物车中的数据存入订单商品即可 减少库存 存到订单表
       	$cartModel=D('Admin/Cart');
       	$gnModel=M('GoodsNumber'); //库存量模型

       	$cartData=$cartModel->cartList();
       	//循环购物车中每件商品存入订单中
       	$ogModel=M('OrderGoods');
       	$buythis=session('buythis');
       	foreach ($cartData as $k => $v){
       	   //判断商品有没有别选中
           if(!in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis))
                continue;
           //减少库存量
           $rs=$gnModel->field('goods_number')->where(array(
                'goods_id'=>array('eq',$v['goods_id']),
                'goods_attr_id'=>array('eq',$v['goods_attr_id']),
            ))->setDec('goods_number',$v['goods_number']);

           if($rs === FALSE){
                mysqli_query('ROLLBACK');
                return FALSE;
            }

       		$rs=$ogModel->add(array(
       			'order_id'=>$data['id'],
       			'member_id'=>session('mid'),
       			'goods_id'=>$v['goods_id'],
       			'goods_attr_id'=>$v['goods_attr_id'],
       			'goods_attr_str'=>$v['goods_attr_str'],
       			'goods_price'=>$v['shop_price'],
       			'goods_number'=>$v['goods_number'],
       		));
       		if($rs === FALSE){
                mysqli_query('ROLLBACK');
                return FALSE;
            }
       	}

       	mysqli_query('COMMIT'); // 提交事务
       	//释放锁
       	flock($this->fp,LOCK_UN);
       	fclose($this->fp);
       	//清空购物车所选商品
       	$cartModel->clearDb();
       	session('buythis',null);
    }

    protected function _before_delete($option){
      $og=M('OrderGoods');
      $og->where(array('order_id'=>array('eq',$option['where']['id'])))->delete();
 
    }
    //设置订单为已支付状态
    public function setPaid($id){
        //更新订单的状态为已支付的状态
        $this->where(array('id'=>array('eq',$id)))->setField('pay_status',1);
        //增加会员的经验和积分 -订单的总价是多少就加多少经验值和积分
        $info=$this->field('total_price,member_id')->find($id); 
        $this->execute('UPDATE php34_member SET jyz=jyz+'.$info['total_price'],',jifen=jifen+'.$info['total_price'].' WHERE id='.$info['member_id']);
    }

    public function search($pageSize = 5)
    {
      /**************************************** 搜索 ****************************************/
      // 是否是回收站的商品
      if($keyword = I('get.keyword'))
        $where['order_id'] = array('like', "%$keyword%");
    
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


    public function order_goods($id,$pageSize = 5)
    {
      
      /************************************* 翻页 ****************************************/
      $model=M('OrderGoods');
      $count = $model->alias('a')->where($where)->count();

      $page = new \Think\Page($count, $pageSize);
      // 配置翻页的样式
      $page->setConfig('prev', '上一页');
      $page->setConfig('next', '下一页');
      $data['page'] = $page->show();

      $sql="SELECT a . * , b.goods_name, b.shop_price, b.sm_logo, c.goods_number gn
      FROM wx_order_goods a
      LEFT JOIN wx_goods b ON a.goods_id = b.id
      LEFT JOIN wx_goods_number c ON a.goods_id = c.goods_id
      WHERE a.goods_attr_id = c.goods_attr_id
      AND  `order_id` =  $id
      LIMIT $page->firstRow , $page->listRows";
      $data['data']=$model->query($sql);
      return $data;
    }

    public function yfh($pageSize = 5)
    {
      /**************************************** 搜索 ****************************************/
      // 是否是回收站的商品
        $where['post_status'] = array('eq', "1");
      if($keyword = I('get.keyword'))
        $where['order_id'] = array('like', "%$keyword%");
    
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

    public function wfh($pageSize = 5)
    {
      /**************************************** 搜索 ****************************************/
      // 是否是回收站的商品
        $where['post_status'] = array('eq', "0");

      if($keyword = I('get.keyword'))
        $where['order_id'] = array('like', "%$keyword%");
    
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

    public function yzf($pageSize = 5)
    {
      /**************************************** 搜索 ****************************************/
      // 是否是回收站的商品
        $where['pay_status'] = array('eq', "1");

      if($keyword = I('get.keyword'))
        $where['order_id'] = array('like', "%$keyword%");
    
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

    public function wzf($pageSize = 5)
    {
      /**************************************** 搜索 ****************************************/
      // 是否是回收站的商品
      $where['pay_status'] = array('eq', "0");
      if($keyword = I('get.keyword'))
        $where['order_id'] = array('like', "%$keyword%");
    
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
//var_dump($this->getlastsql());die;
//var_dump(get_defined_constants(true));die;
