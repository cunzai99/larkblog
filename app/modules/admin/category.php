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

require_once(_MODULES_.'admin/controller.php');
class categoryController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->needLayout();

        $this->model_category = $this->loadModel('category');
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
        $this->setCategory();
        $this->display('category_new');
    }

    public function editAction()
    {
        $catid = $this->get('id');
        $info  = $this->model_category->getById($catid);

        $this->setCategory();

        $this->assign('info', $info);
        $this->display('category_new');
    }

    public function saveAction()
    {
        $data = $this->post();

        if(isset($data['catid']) && $data['catid']){
            $id = $this->model_category->update($data);
        }else{
            $id = $this->model_category->insert($data);
        }

        $url  = build_url('list', 'category');
        redirect($url, '操作成功', 1);
    }

    /**
     * 分类列表
     *
     */
    public function listAction()
    {

        $list = $this->model_category->getListLevel();

        $this->assign('list', $list);
        $this->display('category_list');
    }

}
