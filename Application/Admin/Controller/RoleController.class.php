<?php
namespace Admin\Controller;
use Component\CommonController;

class RoleController extends CommonController {

    public function add(){

      	if(IS_POST){
          
          $model = D('Role');
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
          $priModel = D('Privilege');
          $priData=$priModel->getTree();
          $this->assign('priData',$priData);
        	$this->display();
    }

    public function lst(){
      $model = D('Role');
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

        $model=D('Role');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p')));
            exit;
          }
        }
        $this->error($model->getError());
      }
      #取出角色
      $model=D('Role');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);

      #取出所有权限
      $priModel = D('Privilege');
      $priData=$priModel->getTree();
      $this->assign('priData',$priData);
      
      #取出当前角色所拥有的权限
      $rpModel=M('RolePrivilege');
      $rpData=$rpModel->field('*,GROUP_CONCAT(pri_id) pri_id')->where(array('role_id'=>array('eq',$id)))->group('role_id')->find();

      $this->assign('rpData',$rpData['pri_id']);
      $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Role');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }{
        $this->error($model->getError());
      }
      
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

