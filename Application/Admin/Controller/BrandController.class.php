<?php
namespace Admin\Controller;
use Component\CommonController;

class BrandController extends CommonController {

    public function add(){

      	if(IS_POST){
          $model = D('Brand');
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

        $this->display();
    }

    public function lst(){
      $model = D('Brand');
      $data = $model->search();
      $this->assign(array(
        'data'=>$data['data'],
        'page'=>$page['page'],
      ));
      $this->display();
    }
   
    public function edit(){
       $id=I('get.id');
        if(IS_POST){
            $model=D('Brand');
            if($model->create(I('post'),2)){
                if($model->save() !== FALSE){
                    $this->success('修改成功！',U('lst?p='.I('get.p')));
                    exit;
                }
            }
            $this->error($model->getError());
        }

        #取出基本数据
        $model = D('Brand');
        $data = $model->find($id);
        $this->assign('data', $data);
        $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Brand');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }{
        $this->error($model->getError());
      }
      
   }

}
// file_put_contents('./axt.txt', var_export($data, TRUE));

