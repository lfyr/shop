<?php
namespace Admin\Controller;
use Component\CommonController;

class IndexController extends CommonController {

    public function index(){
    	//查找配置信息
    	$ConfigModel=D('Config');
    	
    	$ConfigData=$ConfigModel->field('appid,appsecret,token,logo')->find();
      $this->assign('ConfigData',$ConfigData);

      $adminId = session('id');
      #菜单数据
      if($adminId==1){
        $sql='select * from wx_privilege';

      }else{
        $sql='select d.* from wx_admin a 
        left join wx_admin_role b on a.id=b.admin_id 
        left join wx_role_privilege c on b.role_id=c.role_id 
        left join wx_privilege d on c.pri_id=d.id where a.id='.$adminId;
      }
      $db=M();
      $pri=$db->query($sql);
   
      $btn=array(); //放两级权限

      #从所有权限中全出前两级权限
      foreach ($pri as $k => $v) {
        
        //先找顶级权限
        if($v['parent_id']==0){

          foreach ($pri as $k1 => $v1) {

            if($v1['parent_id']==$v['id']){

              $v['children'][]=$v1;

            }
          }
          $btn[] = $v;
        }
      }
    
      $this->assign('btn',$btn);
    	$this->display();
    	$appid=$ConfigData['appid'];
    	$appsecret=$ConfigData['appsecret'];
    	$token=$ConfigData['token'];
    	
    	$WeChatModel=new \Admin\Model\WeChatModel($appid, $appsecret, $token);

    	//$AccessToken=$WeChatModel->getQRCode();
    
      // 第一次验证：
		  //$WeChatModel->firstValid();
 
  		// 处理威信公众平台的的消息（事件）
  		$WeChatModel->responseMSG();
      
    }
    public function info(){

    	$id=I('get.id'); 
    	
    	if(IS_POST) {

    		$model=D('Config');
    		
    		if($model->create(I('post.'),2)){

    			if($model->save() !== FALSE){

    				$this->success('修改成功！');
    				exit;
	    		}
    		}
    		
    		$this->error($model->getError());
    	}

    	$model=D('Config');
    	$Configdata=$model->find();
    	$this->assign('Configdata',$Configdata);
      $this->display();
    }
    public function ajaxLogoUpload(){

	  	$id=I('get.id');
     
  		//实际保存路径
  		$path="./Public/Admin/images/";
  		$pth="/Public/Admin/images/";

  		//文件名
  		$name=$_FILES['image']['name'];

  		$name=iconv('UTF-8','GB2312',$name);

  		//附件上传逻辑
  		
  		$logoAddr=$pth.$name;
  	
  		$messg="上传成功！";

  		$data=array('dz'=>$logoAddr,'msg'=>$messg);
  		$json_string = json_encode($data);

  		//move_uploaded_file(临时路径名，真实路径名);
  		$upload=move_uploaded_file($_FILES['image']['tmp_name'],$path.$name);
  	
  		if ($upload==TRUE) {
  			echo $json_string;
  		}else{
  			exit('上传失败！');
  		}

      $ConfigModel=D('Config');
      $ConfigData=$ConfigModel->field('logo')->find();
      $oldlogo=$ConfigData['logo'];
      $oldlogo=substr($oldlogo, 1);
      unlink($oldlogo);
      
      #删除原图
   
  		//写入数据库
  		$model=D('Config');
		  $result = $model->where(array('id'=>$id))->setField(array('logo'=>$logoAddr)); 

    }

    public function delete_dir(){
      set_time_limit(0);
      $dir_name='./Application/Html';
      $ret=delete_dir($dir_name);
      if($ret!==false){
        $this->success('缓存清理成功！','',5);
        exit;
      }
      $this->error('暂无缓存！');
    }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));