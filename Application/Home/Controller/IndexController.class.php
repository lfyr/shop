<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       $model=D('Admin/Goods');
       $hotData=$model->getHotGoods();
       $this->assign('hotData',$hotData);
       $this->display();
    }

    public function hot(){
       $model=D('Admin/Goods');
       $hotData=$model->getHotGoods();
       $this->assign('hotData',$hotData);
       $this->display();
    }

    public function best(){
       $model=D('Admin/Goods');
       $bestData=$model->getBestGoods();
       $this->assign('bestData',$bestData); 
       $this->display();
    }

    public function neww(){
       $model=D('Admin/Goods');
       $newData=$model->getNewGoods();
       $this->assign('newData',$newData); 
       $this->display();
    }


    public function goods(){
    	//接收商品id
    	$goodsId=I('get.id');
    	$goodsMolde=D('Admin/Goods');
    	$goodsData=$goodsMolde->where(array('id'=>array('eq',$goodsId)))->find();
    	
        #取出评论数
        $commemtModel=M('Comment');
        $commemtData=$commemtModel->where(array('goods_id'=>array('eq',$goodsId)))->count();
       
        $this->assign('commemtData',$commemtData);

    	#属性数据分两步去第一步先取出可选的 第二部取出唯一的
    	$gaMolde=D('Admin/GoodsAttr');

    	#第一步此处按照属性类型先取出可选的数据
    	// $_gaData=$gaMolde->field('a.*,b.attr_name')->alias('a')->join('left join wx_attribute b on a.attr_id=b.id')->where(array('a.goods_id'=>array('eq',$goodsId),'b.attr_type'=>array('eq',1)))->select();

        $sql='SELECT a.*,b.attr_name FROM wx_goods_attr a LEFT JOIN wx_attribute b on a.attr_id=b.id WHERE attr_id IN (SELECT attr_id FROM wx_goods_attr WHERE goods_id='.$goodsId.' GROUP BY attr_id HAVING count(*)>1)  AND a.goods_id='.$goodsId;
        $db=M();
        $_gaData=$db->query($sql);
    	
    	#由于取出的属性为二位数组不利于输出页面故将二维转为三维
    	$gaData1=array();
    	foreach ($_gaData as $k => $v) {
    		$gaData1[$v['attr_name']][]=$v;
    	}


    	#第二步此处按照属性类型先取出可选的数据
    	$gaData2=$gaMolde->field('a.*,b.attr_name')->alias('a')->join('left join wx_attribute b on a.attr_id=b.id')->where(array('a.goods_id'=>array('eq',$goodsId),'b.attr_type'=>array('eq',0)))->select();

 		#取出商品图片
    	$gpMolde=D('Admin/GoodsPics');
    	$gpData=$gpMolde->where(array('goods_id'=>array('eq',$goodsId)))->select();

        #取出购物车商品数量
        $cartModel=D('Admin/Cart');
        $mid=session('mid');
        if($mid){
            $cartCount=$cartModel->where(array('member_id'=>array('eq',$mid)))->count();
          
        }else{
            $cartCount=count(unserialize($_COOKIE['cart']));
            if(unserialize($_COOKIE['cart'])==false)
                $cartCount=0;
        }
    	$this->assign(array(
    		'goodsData'=>$goodsData,
    		'gaData1'=>$gaData1,
    		'gaData2'=>$gaData2,
            'gpData'=>$gpData,
    		'cartCount'=>$cartCount,
    	));
    	$this->display();
    }

    public function seach(){
        $keyword=I('get.keyword');
        $model=M('Goods');
        $keywordData=$model->where(array('goods_name'=>array('like',"%$keyword%")))->select();
        $this->assign('keywordData',$keywordData);
        $this->display();
    }
}