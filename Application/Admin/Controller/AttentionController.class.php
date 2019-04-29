<?php
namespace Admin\Controller;
use Component\CommonController;

class AttentionController extends CommonController {

    public function index(){
  
    	$id=I('get.id'); 
    	
    	if(IS_POST) {

    		$model=M('Attention');
    		
    		if($model->create(I('post.'),2)){

    			if($model->save() !== FALSE){

    				$this->success('修改成功！');
    				exit;
	    		}
    		}
    		
    		$this->error($model->getError());
    	}

    	$model=D('Attention');
    	$Attentionigdata=$model->find();

        $this->assign('Attentionigdata',$Attentionigdata);
        $this->display();

    }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));