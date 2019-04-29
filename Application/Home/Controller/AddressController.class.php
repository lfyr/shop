<?php
namespace Home\Controller;
use Think\Controller;

class AddressController extends Controller {

    public function add(){
      if(IS_POST){
        $model=D('Admin/Address');
        if($model->create(I('post.'),1)){
          $model->add();
          redirect(U('lst'));
          exit;
        }
        $this->error($model->getError());
      }
      //取出省市区
      $sql='select * from wx_province';
      $model=M();
      $province=$model->query($sql);
      $this->assign('province',$province);
      $this->display();
    } 

    public function city(){
      $provinceid=I('get.provinceid');
      $sql="select * from wx_city where fatherid=".$provinceid;
      $model=M();
      $city=$model->query($sql);
      echo json_encode($city);
    } 

    public function area(){
      $areaid=I('get.cityid');
      $sql="select * from wx_area where fatherid=".$areaid;
      $model=M();
      $area=$model->query($sql);
      echo json_encode($area);
    } 

    public function lst(){  
      $mid=session('mid');
      $model=D('Admin/address');
      $data=$model->where(array('member_id'=>array('eq',$mid)))->select();
      $this->assign('data',$data);
      $this->display();
    } 

    public function edit(){
      
      $id=I('get.id'); 

      if(IS_POST){

        $model=D('Address');
        if($model->create(I('post.'),2)){

          if($model->save() !== FALSE){

            $this->success('操作成功！',U('lst?p='.I('get.p')));
            exit;
          }
        }
        $this->error($model->getError());
      }

      #取出地址
      $model=D('Address');
      $data=$model->where(array('id'=>$id))->find();
      $this->assign('data',$data);

      //取出省市区
      $sql='select * from wx_province';
      $model=M();
      $province=$model->query($sql);
      $this->assign('province',$province);

      $this->display();
    }

    #设置默认 
    public function setDefault(){
      $id=I('get.id');
      $model=D('Admin/address');
      #修改之前先重置该字段 
      $sql="UPDATE wx_address SET def=0";
      $model->execute($sql);

      #根据id再次设置新的默认地址
      $model->where(array('id'=>array('eq',$id)))->setField('def','1');
    }  
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

