<?php
/**
 * 用户管理类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: user.php v1.0.0 2014-06-03 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class userController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->needLayout();

        $this->model_user = $this->loadModel('user');
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
        $this->display('user_new');
    }

    public function saveAction()
    {
        $this->display('user_list');
    }

    public function profileAction()
    {
        $this->display('user_new');
    }

    /**
     * 用户列表
     *
     */
    public function listAction()
    {
        $model_user = $this->loadModel('user');
        $list = $model_user->getList();

        $this->assign('list', $list);
        $this->display('user_list');
    }

    public function passwordAction()
    {
        $this->display('password');
    }

    public function updatepwdAction()
    {
        $data = $this->post();

        if(empty($data['old_pwd'])){
            echo 1; exit;
        }

        if(empty($data['new_pwd'])){
            echo 2; exit;
        }

        if($data['new_pwd'] != $data['re_new_pwd']){
            echo 3; exit;
        }

        $data['id'] = $this->_user_id;

        $res = $this->model_user->updatePwd($data);

        $msg = $res ? '密码修改成功' : '密码修改失败';
        redirect('/admin/user/password', $msg, 1);
    }

}

