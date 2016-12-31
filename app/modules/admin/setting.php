<?php
/**
 * 系统设置类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post.php v1.0.0 2014-06-03 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class settingController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->needLayout();

        $this->model_setting = $this->loadModel('setting');
    }

    public function indexAction()
    {
        $setting_info = $this->model_setting->getList();

        $this->assign('setting_info', $setting_info);
        $this->display('setting');
    }

    public function saveAction()
    {
        $data = $this->post();

        $res = $this->model_setting->update($data);

        $msg = $res ? '操作成功' : '操作失败';
        redirect('/admin/setting', $msg, 1);
    }

}
