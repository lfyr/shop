<?php
namespace Home\Controller;
use Think\Controller;

class MemberController extends Controller {

    public function login(){

      if (IS_POST) {

        $model=D("Admin/Member");

        #写9是因为1代表添加 2代表修改 而此时登录不属于添加不属于修改故写9 也可以写除了1 2 3之外其他数字
        if($model->validate($model->_login_validate)->create(I('post.',9))){

          if($model->login()){
            //从session中取出有没有要调回的地址
            $returnUrl=session('returnUrl');
            if($returnUrl){
                //从session中删除，下次登录就正常跳到首页
                session('returnUrl',null);
                redirect($returnUrl);
            }else{
                redirect('/');  // 登录成功之后直接跳到首页
            }
          }
        }
        $this->error($model->getError());
      }
      $this->display();
    }

    public function regist(){

      if (IS_POST) {

        $model=D("Admin/Member");
        if($model->create(I('post.'),1)){
          if($model->add()){
             $this->success('注册成功！请尽快前去邮箱验证。');
             exit;
          }
        }
        $this->error($model->getError());
      }
      $this->display();
    }

    public function emailchk(){
      $code=I('get.code');

      if($code){
        $model=M('Member');
        $email=$model->where(array('email_code'=>array('eq',$code)))->find();
        if($email){
          $model->where(array('id'=>array('eq',$email['id'])))->setField('email_code');
          $this->success('已完成验证，现在可以去登录',U('login'));
          exit;
        }
      }
      $this->error('验证失败！');
    }

    public function chkcode(){

      $Verify = new \Think\Verify(array(
        'length' => 3,
        'useNoise' => false,
        'imageW' => 80,
        'imageH' => 32,
        'fontSize' => 15,
      ));
    $Verify->entry();
    }
    public function lst(){
      $model=D('Admin/Member');
      $data=$model->search();

      $this->assign(array(
        'data' => $data['data'],
        'page' => $data['page'],
      ));
      $this->display();
    }
    
    public function qqLogin(){
      include ("./qq/API/qqConnectAPI.php");
      $qc = new QC();
      // echo $qc->qq_callback();
      $openid=$qc->get_openid();

      $model=D("Admin/Member");
      $user=$model->field('email')->where(array('openid'=>array('eq',$openid)))->find();
      if($user){
        $model->email=$user['email'];  //把账号传给会员模型
        $model->login(false); //不需要密码直接登录

        //跳转首页并关闭窗口
            echo <<<JS
            <script>
                openid.window.location.href='/';
                window.close();
            </script>
JS;
        exit;
      }else{
        //如果是第一次用qq号登陆应该显示一个表单引导用户关联一个账号
        redirect(U('login'));
      }
      
    }
} 
// file_put_contents('./axt.txt', var_export($data, TRUE));

