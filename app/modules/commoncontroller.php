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
namespace App\modules;
class CommonController extends \Lark\core\Action
{
    public function __construct($plugins=null)
    {
        parent::__construct($plugins);
    }

    public function setCategory($condition=array())
    {
        $model_category = $this->loadModel('category');
        $list = $model_category->getListLevel($condition);

        $this->assign('category_list', $list);
    }

    public function initVariable($theme='')
    {
        if($theme){
            C('theme', $theme);
        }else{
            $theme = C('theme');
        }

        $this->setLayoutPath(_VIEW_PATH_.$theme.'/');

        $this->assign('js_path'  , '/view/'.$theme.'/js/');
        $this->assign('css_path' , '/view/'.$theme.'/css/');
        $this->assign('img_path' , '/view/'.$theme.'/img/');
        $this->assign('build_url', build_url('buildurl', 'ajax'));

        // define('_TPL_JS_PATH_' , '/view/'.$theme.'/js/');
        // define('_TPL_CSS_PATH_', '/view/'.$theme.'/css/');
        // define('_TPL_IMG_PATH_', '/view/'.$theme.'/img/');
    }

    public function initSetting()
    {
        $this->model_setting = $this->loadModel('setting');
        $setting_info = $this->model_setting->getList();

        C('create_html', $setting_info['baseic']['create_html']['content']);

        $this->assign('setting_info', $setting_info['baseic']);
    }

    public function response($code, $data='', $msg='', $output=true, $return_type='json')
    {
        header('Content-type: application/json');

        $_data = array();
        $_data['code'] = $code;
        $_data['msg']  = $msg;
        $_data['data'] = $data;

        if($return_type == 'json'){
            $_data = json_encode($_data);
        }

        if($output)
            echo $_data;
        else
            return $_data;
    }

}
