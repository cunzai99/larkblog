<?php
/**
 * Larkblog ajax 接口类
 *
 * @category   controller
 * @package    api
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: index.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_APP_.'controller.php');
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
