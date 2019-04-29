<?php
namespace Home\Controller;
use Think\Controller;

class CommentController extends Controller {

    

    public function ajaxGetComment(){
      
      //定义每页显示的条数
      $perpage = 5;
      $p = I('get.p');
      $offset = ($p-1)*$perpage;  // 从第几条记录开始取
      $goods_id=I('get.goods_id');
      $model=M('Comment');
      $data=$model->field('a.*,b.email,b.face')->alias('a')->join('LEFT JOIN wx_member b on a.member_id=b.id')->where(array('a.goods_id'=>array('eq',$goods_id)))->limit("$offset,$perpage")->order('addtime desc')->select();
      
      //处理一下数据
      foreach ($data as $k => $v) {
          $data[$k]['face']=$v['face']?'/Public/Home/'.$v['face']:'/Public/Home/images/default_face.jpg';
          $data[$k]['addtime']=date('Y-m-d H:i',$v['addtime']);
      }
      if(!empty($data)){
        echo json_encode($data);   
      }else{
        echo 'null';
      }
        
    }
} 
// file_put_contents('./axt.txt', var_export($data, TRUE));

