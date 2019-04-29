<?php
namespace Home\Controller;
use Think\Controller;

class CartController extends Controller {

    public function ajaxAdd(){
      #接收属性id
      $goods_attr_id=I('post.goods_attr_id');
      
      #检测是否存在属性id     
      if($goods_attr_id){
        #将属性id升序排序方便取库存
        sort($goods_attr_id);
        #转为字符串存入数据库
        $goods_attr_id=implode(',', $goods_attr_id);
      }
      $cartModel=D('Admin/Cart');
      $data=$cartModel->addToCart(I('post.goods_id'),$goods_attr_id,I('post.goods_number'));
    }

    public function add(){
      #接收属性id
      $goods_attr_id=I('post.goods_attr_id');
      
      #检测是否存在属性id     
      if($goods_attr_id){
        #将属性id升序排序方便取库存
        sort($goods_attr_id);
        #转为字符串存入数据库
        $goods_attr_id=implode(',', $goods_attr_id);
      }
      $cartModel=D('Admin/Cart');
      $cartModel->addToCart(I('post.goods_id'),$goods_attr_id,I('post.goods_number'));
      redirect(U('lst'));
    }

    public function lst(){
      $cartModel=D('Admin/Cart');
      #显示购物车数据
      $data=$cartModel->cartList();

      $this->assign('data',$data);

      $this->display();
    }

    public function ajaxUpdateData(){
      $gid=I('get.gid');
      $gaid=I('get.gaid','');
      $gn=I('get.gn');
      $cartModel=D('Admin/Cart');
      $data=$cartModel->updateData($gid,$gaid,$gn);
    }

    public function order(){
      
       //接收选中的商品
      $buythis=I('post.buythis');
      //判断表单中是否选择
      if(!$buythis){
        $buythis=session('buythis');
        if(!$buythis){
            $this->error('请先选择商品',U('lst'));
        }
      }else{
        session('buythis',$buythis);
      }
      $mid=session('mid');
      //如果会员没有登录跳到登录页面，登录成功之后再跳回来
      if(!$mid){
        //把当前这个页面的地址存到session中，这样登录成功之后就跳回来了
        session('returnUrl',U('order'));

        redirect(U('Home/Member/login'));
      }

      if(IS_POST && !isset($_POST['buythis'])){
    
        //下订单先验证
        $orderModel=D('Admin/Order');
        if($orderModel->create(I('post.'),1)){
          if ($id=$orderModel->add()) {
            $this->success('下单成功！',U('order_ok?id='.$id));
            exit;
          }
        }
        $this->error($orderModel->getError());
      }

      #取出购物 车商品
      $cartModel=D('Admin/Cart');
      #显示购物车数据
      $data=$cartModel->cartList();
      $buythis=session('buythis');
      foreach ($data as $k => $v) {
        if(!in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis))
              unset($data[$k]);
      }
      $this->assign('data',$data);


      $this->display();
    } 

     #取出默认 
    public function getDefault(){
      $mid=session('mid');
      $model=M('Address');

      #根据id再次设置新的默认地址
      $data=$model->where(array('member_id'=>array('eq',$mid),'def'=>array('eq',1)))->find();
      echo json_encode($data);
    }  
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

