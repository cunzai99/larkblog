<?php
/**
 * 应用程序公共类
 *
 * 此类是应用程序和框架的通信枢纽，为应用层提供框架的接口
 * 提供一些公共的方法，方便各应用使用（如：验证登陆状态）
 *
 * 所有的应用层controller需要继承这个类
 *
 * @category   Lark
 * @package    Lark_Bootstrap
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: controller.php v1.0.0 2013-04-01 cunzai99 $
 * @copyright
 * @license
 */

class CommonController extends \App\modules\CommonController
{
    protected $_user_id = '';

    public function __construct($plugins=null)
    {
        parent::__construct($plugins);

        $this->check_login();

        C('theme', 'admin');
        $this->initVariable();
    }

    //验证登陆状态
    public function check_login()
    {
        if($this->_application == 'admin'){
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
            if(!$username && $this->_controller != 'auth'){
                redirect(build_url('index', 'auth'), '', 0);
            }

            $this->_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        }
    }

}
