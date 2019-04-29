<?php
namespace Admin\Controller;
use Component\CommonController;

class GoodsController extends CommonController {

    public function add(){

      	if(IS_POST){
          #设置这个脚本可以执行的时间，单位：秒，0：代表一直执行到结束，默认30秒
          set_time_limit(0);
          $model = D('Goods');
            if($model->create(I('post.'), 1))
            {

              if($id = $model->add())
              {
                $this->success('添加成功！', U('lst?p='.I('get.p')));
                exit;
              }
            }
            $this->error($model->getError());
          }
          
          #分类数据
          $CatModel=D('Category');
          $CatData=$CatModel->getTree();
          $this->assign('catData',$CatData);

          #品牌数据
          $BrandModel=D('Brand');
          $BrandData=$BrandModel->select();
          $this->assign('BrandData',$BrandData);
          #类型数据
          $typeModel=M('Type');
          $typeData=$typeModel->select();
          $this->assign('typeData',$typeData);
        	$this->display();
    }

    public function lst(){
      $model = D('Goods');
      $data = $model->search();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));

      $this->display();
    }
   
    public function edit(){

      $id=I('get.id'); 

      if(IS_POST){

        $model=D('Goods');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p')));
            exit;
          }
        }
        $this->error($model->getError());
      }

      #商品基本数据
      $model=D('Goods');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);

      #分类数据
      $CatModel=D('Category');
      $CatData=$CatModel->getTree();
      $this->assign('catData',$CatData);
      
      #品牌数据
      $BrandModel=D('Brand');
      $BrandData=$BrandModel->select();
      $this->assign('BrandData',$BrandData);

      #类型数据
      $typeModel=M('Type');
      $typeData=$typeModel->select();
      $this->assign('typeData',$typeData);

      #商品图片
      $gpModel=M('GoodsPics');
      $gpData=$gpModel->where(array('goods_id'=>$id))->select();
      $this->assign('gpData',$gpData);

      #商品属性
      $gaModel=M('GoodsAttr');
      $gaData=$gaModel->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')->alias('a')->join('LEFT JOIN wx_attribute b ON a.attr_id=b.id')->where(array('a.goods_id'=>$id))->order('a.attr_id ASC')->select();

      #取出属性的id
      $attr_id=array();
      foreach ($gaData as $k => $v) {
        $attr_id[]=$v['attr_id'];
      }
      #去重
      $attr_id=array_unique($attr_id);


      #商品其它以及新增的属性
      $attrModel = M('Attribute');

      if(!empty($gaData)){
        $otherAttr = $allAttrId = $attrModel->field('id attr_id,attr_name,attr_type,attr_option_values')->where(array(
            'type_id'=>array('eq', $data['type_id']), 
            'id'=>array('NOT IN', $attr_id)
            ))->select();

        #将新属性合并商品属性一起输出页面
        if($otherAttr){
          #合并属性
          $gaData=array_merge($gaData,$otherAttr);
          #重新根据attr_id字段重新排序这个合并之后的二维数组
          usort($gaData, 'attr_id_sort');
        }
      }
       
      $this->assign('gaData',$gaData);

      $this->display();
     }

    #商品库存
     public function goods_number(){
      $id=I('get.id');
      $goods_name=I('get.goods_name');

      if(IS_POST){
        $gaid=I('post.goods_attr_id');
        $gn=I('post.goods_number');
        $gnModel=M('GoodsNumber');

        #修改之前先删除商品属性
        $gnModel->where(array('goods_id'=>array('eq',$id)))->delete();
        
        #因为商品属性数目不定所以先计算出比例
        $rate=count($gaid)/count($gn);
          
        $_i=0; #定义这个变量作为下标用来取出属性id数据
        
        #此处因为属性id较多不能确定记录 而库存数据可以确定记录 故用库存来作为记录标识循环
        foreach ($gn as $k => $v) {

          #先定义一个空的数组用来存放属性id
          $_attr=array();

          #循环按比例取出属性id
          for($i=0; $i < $rate; $i++){ 
                   $_attr[]=$gaid[$_i];
                   $_i++;
          }     

          sort($_attr); #将这个数组升序排列
          $_attr=implode(',', $_attr);

          $gnModel->add(array(
            'goods_id'=>$id,
            'goods_number'=>$v,
            'goods_attr_id'=>$_attr, #升序处理好属性数组的字符串
          ));
        }
        $this->success('操作成功！');
        exit;
      }


      //取出商品的属性数据
      $sql='SELECT a.*,b.attr_name FROM wx_goods_attr a LEFT JOIN wx_attribute b on a.attr_id=b.id WHERE attr_id IN (SELECT attr_id FROM wx_goods_attr WHERE goods_id='.$id.' GROUP BY attr_id HAVING count(*)>1)  AND a.goods_id='.$id;
      $db=M();
      $_attrData=$db->query($sql);
      #为了方便将数据输出页面此时将二维数组转三维
      $attrData=array();
      foreach ($_attrData as $k => $v) {
        $attrData[$v['attr_id']][]=$v;
      }

      #取出商品已有的库存量数据
      $gnModel=M('GoodsNumber');
      $gnData=$gnModel->where(array('goods_id'=>array('eq',$id)))->select();
     
      $this->assign('goods_name',$goods_name);
      $this->assign('gnData',$gnData);
      $this->assign('attrData',$attrData);
      $this->display();
     }
    #放入回收站
    public function recycle(){
      $id=I('get.id');
      $model=D('Goods');
      $model->where(array('id'=>array('eq',$id)))->setField('is_delete',1);

      $this->success('操作成功！',U('lst'));
      exit;
    }

    #回收站列表
    public function recyclelst(){
      $model=D('Goods');
      $data = $model->search(5,1);
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));

      $this->display();
     
    }

    #还原商品
    public function restore(){
      $id=I('get.id');
      $model=D('Goods');
      $model->where(array('id'=>array('eq',$id)))->setField('is_delete',0);

      $this->success('操作成功！',U('recyclelst'));
      exit;
    }
    public function del(){
      $id=I('get.id');
      $model=D('Goods');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }{
        $this->error($model->getError());
      }
        
    }

    #ajax获取类型的属性 
    public function ajaxGetAttr(){
      $type_id=I('get.type_id');
      $attrMolde=M('Attribute');
      $attrData=$attrMolde->where(array('type_id'=>array('eq',$type_id)))->order('id ASC')->select();
      echo json_encode($attrData);
    }

    #ajax根据图片id删除图片
    public function ajaxDelImage(){

      $pic_id=I('get.pic_id');
      $gpMolde=M('GoodsPics');

      #获取图片以及缩略图的地址
      $gpData=$gpMolde->field('pic,sm_pic')->find($pic_id);


      #调用封装的方法删除图片文件
      deleteImage($gpData);

      #删除成功后再删除数据库中的数据
      $gpMolde->delete($pic_id);
    }

    
    #ajax根据删除商品属性
    public function ajaxDelGoodsAttr(){

      $gaid=I('get.gaid');
      $gaMolde=M('GoodsAttr');

      #删除数据库中的数据
      $gaMolde->delete($gaid);
    }

}
// file_put_contents('./axt.txt', var_export($data, TRUE));

