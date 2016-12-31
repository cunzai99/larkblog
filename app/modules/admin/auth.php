<?php
/**
 * 登陆操作类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: login.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class AuthController extends CommonController
{
    /**
     * user表model类
     *
     * $model_user
     */
    protected $model_user = null;

    public function indexAction()
    {
        $this->display('login');
    }

    public function loginAction()
    {
        //验证登陆
        $username = $_POST['username'];
        $password = $_POST['password'];

        $model_user = $this->loadModel('user');
        $user_info  = $model_user->checkPassword($username, $password);

        if(!empty($user_info)){
            $_SESSION['id'] = $user_info['id'];
            $_SESSION['username'] = $username;
            $_SESSION['nickname'] = $user_info['nickname'];

            redirect(build_url('index', 'index'), '', 0);
        }else{
            redirect(build_url('index', 'login'), '用户名或密码错误(此处验证需要改成异步)', 1);
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['nickname']);

        redirect(build_url('index', 'login'), '退出成功', 1);
    }

}

?>
