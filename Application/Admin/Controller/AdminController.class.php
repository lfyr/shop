<?php
namespace Admin\Controller;
use Component\CommonController;

class AdminController extends CommonController {

    public function add(){

      	if(IS_POST){
          
          $model = D('Admin');
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
          #取出角色
          $roleModel=M('Role');
          $roleData=$roleModel->select();
          $this->assign('roleData',$roleData);
        	$this->display();
    }

    public function lst(){
      $model = D('Admin');
      $data = $model->search();
      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));

      $this->display();
    }
   
    public function edit(){
      
      $id=I('get.id'); 
      $adminId=session('id'); #取出当前管理员id

      //如果是普通会员要修改其他管理员的信息提示无权修改
      if($adminId > 1 && $adminId != $id){
        $this->error('无权修改！');
      }
      if(IS_POST){

        $model=D('Admin');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p')));
            exit;
          }
        }
        $this->error($model->getError());
      }

      $model=D('Admin');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);

      #取出角色
      $roleModel=M('Role');
      $roleData=$roleModel->select();
      $this->assign('roleData',$roleData);

      #取出当前管理员所在的角色id
      $arModel=M('AdminRole');
      $role_id=$arModel->field('GROUP_CONCAT(role_id) role_id')->where(array('admin_id'=>array('eq',$id)))->find();
   
      $this->assign('role_id',$role_id);
      $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Admin');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }{
        $this->error($model->getError());
      }
      
   }

   //ajax修改启用状态
   public function ajaxUpdateIsuse(){
      $adminId=I('get.id');
      if($adminId==1){
        return false;
      }
      $model=M('admin');
      $info=$model->find($adminId);
      //判断如果当前是启用的就修改为禁用
      if($info['is_use']==1){
        $model->where(array('id'=>array('eq',$adminId)))->setField('is_use',0);
        echo "0";
      }else{
        $model->where(array('id'=>array('eq',$adminId)))->setField('is_use',1);
        echo "1";
      }
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

