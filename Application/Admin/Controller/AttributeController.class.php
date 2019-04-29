<?php
namespace Admin\Controller;
use Component\CommonController;

class AttributeController extends CommonController {

    public function add(){

      	if(IS_POST){
          
          $model = D('Attribute');
            if($model->create(I('post.'), 1))
            {
              if($id = $model->add())
              {
                $this->success('添加成功！', U('lst?p='.I('get.p').'&type_id='.I('get.type_id')));
                exit;
              }
            }
            $this->error($model->getError());
          }

          #接收当前类型type_id
          $type_id=I('get.type_id');
          $this->assign('type_id',$type_id);

          #取出所有类型
          $typeModel=M('Type');
          $typeData=$typeModel->select();
          $this->assign('typeData',$typeData);
       $this->display();
    }

    public function lst(){
      $model = D('Attribute');
      $data = $model->search();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      
      #接收当前类型type_id
      $type_id=I('get.type_id');
      $this->assign('type_id',$type_id);

      #取出所有类型
      $typeModel=M('Type');
      $typeData=$typeModel->select();
      $this->assign('typeData',$typeData);
      $this->display();
    }
   
    public function edit(){
      
      $id=I('get.id'); 

      if(IS_POST){
  
        $model=D('Attribute');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p').'&type_id='.I('get.type_id')));
            exit;
          }
        }
        $this->error($model->getError());
      }

      #接收当前类型type_id
      $type_id=I('get.type_id');
      $this->assign('type_id',$type_id);

      #取出所有类型
      $typeModel=M('Type');
      $typeData=$typeModel->select();
      $this->assign('typeData',$typeData);

      $model=D('Attribute');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);
      $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Attribute');

      #接收当前类型type_id
      $type_id=I('get.type_id');
    
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst?p='.I('get.p').'&type_id='.$type_id));
        exit;
      }{
        $this->error($model->getError());
      }
      
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

