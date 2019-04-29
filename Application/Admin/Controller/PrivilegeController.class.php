<?php
namespace Admin\Controller;
use Component\CommonController;

class PrivilegeController extends CommonController {
    public function add(){

        if (IS_POST) {
            $model=D('Privilege');
            if($model->create(I('post.'),1)){
                if($id=$model->add()){
                    $this->success('添加成功！','lst');
                    exit;
                }
            }
            $this->error($model->getError());
        }
        //取出父级id输出页面
        $parentModel=D('Privilege');
        $parentData=$parentModel->getTree();
        $this->assign('parentData',$parentData);
        $this->display();   
    }

    public function lst(){
        $model = D('Privilege');
        $data = $model->getTree();

        $this->assign('data',$data);

        $this->display();
    }

    public function edit(){
        $id=I('get.id');
        if(IS_POST){
            $model=D('Privilege');

            if($model->create(I('post'),2)){
                if($model->save() !== FALSE){
                    $this->success('修改成功！',U('lst?p='.I('get.p')));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $model = M('Privilege');
        $data = $model->find($id);
        $this->assign('data', $data);
        $parentModel=D('Privilege');
        $parentData=$parentModel->getTree();
        $children = $parentModel->getChildren($id);
        $this->assign(array(
                'parentData' => $parentData,
                'children' => $children,
            ));
        $this->display();
    }

    public function del(){
        $model=D('Privilege');
        if($model->delete(I('get.id',0)) !== FALSE){
            $this->success('删除成功！',U('lst',array('p'=>I('get.p',1))));
            exit;
        }else{
            $this->error($model->getError());
        }
    }
}