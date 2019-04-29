<?php
namespace Admin\Controller;
use Component\CommonController;

class OrderController extends CommonController {

    public function lst(){
      $model = D('Order');
      $data = $model->search();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
    }
    
    public function order_goods(){
      $id=I('get.id');
      $model = D('Order');
      $data = $model->order_goods($id);
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
    }
    

    public function yfh(){
      $model = D('Order');
      $data = $model->yfh();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
    }

    public function wfh(){
      $model = D('Order');
      $data = $model->wfh();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
   }

   public function yzf(){
      $model = D('Order');
      $data = $model->yzf();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
   }

   public function wzf(){
      $model = D('Order');
      $data = $model->wzf();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
   }

   public function del(){
    $id=I('get.id');
      $model=D('Order');
      if($model->delete($id)){
        $this->success('操作成功！',U('lst'));
        exit;
      }else{
        $this->error($model->getError());
      }
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

