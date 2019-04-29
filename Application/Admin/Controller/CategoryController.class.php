<?php
namespace Admin\Controller;
use Component\CommonController;

class CategoryController extends CommonController {

    public function add(){

      	if(IS_POST){
          
          $model = D('Category');
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
        #打印出所有分类作为父分类
        $parentModel=D('Category');
        $parentData=$parentModel->getTree();
        $this->assign('parentData',$parentData);
        $this->display();
    }

    public function lst(){
      $model = D('Category');
      $data = $model->getTree();
      $this->assign('data',$data);
      $this->display();
    }
   
    public function edit(){
      
       $id=I('get.id');
        if(IS_POST){
            $model=D('Category');

            if($model->create(I('post'),2)){
                if($model->save() !== FALSE){
                    $this->success('修改成功！',U('lst?p='.I('get.p')));
                    exit;
                }
            }
            $this->error($model->getError());
        }

        #取出基本数据
        $model = M('Category');
        $data = $model->find($id);
        $this->assign('data', $data);

        #取出所有父类
        $parentModel=D('Category');
        $parentData=$parentModel->getTree();
        $children = $parentModel->getChildren($id);
     
        $this->assign(array(
                'parentData' => $parentData,
                'children' => $children,
            ));
        $this->display();
   }

   public function del(){
      $id=I('get.id');
      $model=D('Category');
      if($model->delete(I('get.id', 0))){
        $this->success('操作成功！',U('lst'));
        exit;
      }{
        $this->error($model->getError());
      }
      
   }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));

