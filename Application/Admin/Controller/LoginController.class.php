<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{

    public function login()
    {
        if (IS_POST) {
            $model = D("Admin");
            if ($model->validate($model->_login_validate)->create()) {
                if (true === $model->login()) {
                    redirect(U('Admin/Index/index')); //直接跳转
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    public function chkcode()
    {

        $Verify = new \Think\Verify(array(
            'length'   => 3,
            'useNoise' => false,
            'imageW'   => 80,
            'imageH'   => 32,
            'fontSize' => 15,
        ));
        $Verify->entry();
    }

    public function logout()
    {

        $_SESSION = array(); //清除SESSION值

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 1, '/');
        }
        session_destroy(); //清除服务器的sesion文件
        redirect(U('Admin/Login/login')); //直接跳转
    }
}
// file_put_contents('./axt.txt', var_export($data, TRUE));
