<?php
/**
 * Larkblog管理后台首页操作类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: index.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class ajaxController extends CommonController
{

    public function buildUrlAction()
    {
        $param = $_GET['param'];

        $action     = isset($param['action'])     ? $param['action']     : '';
        $controller = isset($param['controller']) ? $param['controller'] : '';
        $app        = isset($param['app'])        ? $param['app']        : '';
        $param      = isset($param['param'])      ? $param['param']      : '';

        if($action && $controller){
            $url = build_url($action, $controller, $app, $param);
        }else{
            $url = '';
        }

        echo $url;
    }
}
