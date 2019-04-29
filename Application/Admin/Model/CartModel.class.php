<?php
namespace Admin\Model;
use Think\Model;

class CartModel extends Model{
	protected $insertFields=array('username','password','cpassword','is_use','chkcode');
	protected $updateFields=array('id','username','password','cpassword','is_use');
	//添加管理员验证规则

	protected $_validate=array(
		array('username','require','账号不能为空！'), 
		array('username', '', '账号已存在！',0, 'unique', 1),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('is_use', 'number', '是否启用 1：启用0：禁用必须是一个整数！',2, 'regex', 3),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
	);

	#加入购物车
	public function addToCart($goods_id,$goods_attr_id,$goods_number=1){
		
		$mid=session('mid');

		#登录情况下写入数据库
		if($mid){
			$cartModel=M('Cart');
			#检测是否购物车已经拥有该商品
			$has=$cartModel->where(array(
					'member_id'=>array('eq',$mid),
					'goods_id'=>array('eq',$goods_id),
					'goods_attr_id'=>array('eq',$goods_attr_id),
				))->find();

			#如果存在就加上新的数量
			if($has){
				$cartModel->where(array('id'=>array('eq',$has['id'])))->setInc('goods_number',$goods_number);
			}

			#还没有就重新添加
			else{
				$cartModel->add(array(
					'goods_id'=>$goods_id,
					'goods_attr_id'=>$goods_attr_id,
					'goods_number'=>$goods_number,
					'member_id'=>$mid,
				));
			}
		}
		#未登录情况下 写入cookie
		else{
			
			$cart=isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			#把商品加入这个数组
			$key=$goods_id.'-'.$goods_attr_id;
			#判断是否已经存在该商品
			if(isset($cart[$key])){

				#存在加上这次的数量
				$cart[$key] +=$goods_number;
			}else{
				#不存在重新添加
				$cart[$key]=$goods_number;
			}
			#把这个数组放入cookie
			$aMonth=30*86400;
			setcookie('cart',serialize($cart),time()+$aMonth,'/','redreambj.com');	
		}
	}

	#购物车列表
	public function cartList(){
		$mid=session('mid');
		if($mid){
	        $cartModel=M('Cart');
	        $_cart=$cartModel->where(array('member_id'=>array('eq',$mid)))->select();
	      }else{
	        $_cart_=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();

	        #转化这个数组结构和从数据库中取出的数组结构一样，都是二维的
	        $_cart=array();
	        foreach ($_cart_ as $k => $v) {
	              $_k=explode('-', $k);
	              $_cart[]=array(
	                  'goods_id'=>$_k[0],
	                  'goods_attr_id'=>$_k[1],
	                  'goods_number'=>$v,
	                  'member_id'=>0,
	                );
	        }
	      }

	      $goodsModel=D('Admin/Goods');
	      foreach ($_cart as $k => $v) {
	        $ginfo=$goodsModel->field('goods_name,sm_logo,shop_price')->find($v['goods_id']);
	        $_cart[$k]['goods_name']=$ginfo['goods_name'];
	        $_cart[$k]['sm_logo']=$ginfo['sm_logo'];
	        $_cart[$k]['shop_price']=$ginfo['shop_price'];
	        $_cart[$k]['goods_attr_str']=$goodsModel->convertGoodsAttrIdToGoodsAttrStr($v['goods_attr_id']);
	      }

	      return $_cart;
	}



	#把cookie中的数据转移到数据库
	public function moveDataToDb(){
		$mid=session('mid');
		if($mid){
			//从cookie中取出购物车数据
			 $cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();

			 if($cart){
			 	//循环每件商品加入到数据库
			 	foreach ($cart as $k => $v) {

			 		$_k=explode('-',$k);
			 		
			 		$this->addToCart($_k[0],$_k[1],$v);
			 	}
			 	//清空cookie中的数据库
			 	setcookie('cart','',time()-1,'/','redreambj.com');
			 }
		}
	}

	#修改购物车中商品的数量
	public function updateData($gid,$gaid,$gn){
		$mid=session('mid');
		if($mid){
			$cartModel=M('Cart');
			if($gn==0){
				$cartModel->where(array(
					'goods_id'=>array('eq',$gid),
					'goods_attr_id'=>array('eq',$gaid),
					'member_id'=>array('eq',$mid),
				))->delete();
			}else{
				$cartModel->where(array(
					'goods_id'=>array('eq',$gid),
					'goods_attr_id'=>array('eq',$gaid),
					'member_id'=>array('eq',$mid),
				))->setField('goods_number',$gn);
			}
			
		}else{

			$cart=isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			#把商品加入这个数组
			$key=$gid.'-'.$gaid;
			if($gn==0){
				unset($cart[$key]);
			}else{
				$cart[$key]=$gn;
			}
			
			
			#把这个数组放入cookie
			$aMonth=30*86400;
			setcookie('cart',serialize($cart),time()+$aMonth,'/','redreambj.com');	
		}
	}

	//清空购物车
	public function clearDb(){
		$mid=session('mid');
		if($mid){
			$buythis=session('buythis');
			$cartModel=M('Cart');

			#循环勾选的商品进行删除
			foreach ($buythis as $k => $v) {
				#从字符串中取出商品id和属性id
				$_v=explode('-', $v);
				$cartModel->where(array('member_id'=>array('eq',$mid),'goods_id'=>array('eq',$_v[0]),'goods_attr_id'=>array('eq',$_v[1])))->delete();
			}
		}
	}
}