<?php
namespace Admin\Controller;
use Component\CommonController;

class KeywordController extends CommonController {

    public function add(){

      	if(IS_POST){
          
          $model = D('Keyword');
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
      $model = D('Keyword');
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

        $model=D('Keyword');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p')));
            exit;
          }
        }
        $this->error($model->getError());
      }
      $model=D('Keyword');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);
      $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Keyword');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }else{
        $this->error($model->getError());
      }
      
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

