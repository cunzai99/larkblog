<?php
/**
 * 文章分类管理类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post.php v1.0.0 2014-06-03 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'api/controller.php');
class categoryController extends CommonController
{
    public function indexAction()
    {
        echo 'Here is Larkblog API controller.';
    }

    /**
     * 文章列表
     *
     */
    public function listAction()
    {
        $model_category = $this->loadModel('category');
        $list = $model_category->getListLevel();

        $data = array();
        $data['list'] = is_array($list) ? $list : array();

        $this->response(200, $data);
    }

}
