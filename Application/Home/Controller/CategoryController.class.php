<?php
namespace Home\Controller;
use Think\Controller;

class CategoryController extends Controller {

    public function lst(){
      $model = M('Brand');
      $data = $model->select();
      $this->assign('data',$data);
      $this->display();
    }

    public function moreLst(){
      $cat_id=I('get.cateId');
      $brand_id=I('get.brand_id');
      $model = M('Goods');
      if($cat_id){
        $data = $model->where(array('cateId'=>array('eq',$cat_id),'is_delete'=>array('eq',0)))->select();
      }else{
        $data = $model->where(array('brand_id'=>array('eq',$brand_id),'is_delete'=>array('eq',0)))->select();
      }
      
      $this->assign('data',$data);
      $this->display();
    }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

