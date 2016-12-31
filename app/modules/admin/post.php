<?php
/**
 * 文章管理类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class postController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->needLayout();
    }

    public function indexAction()
    {
        $url = build_url('index', 'index');
        header("Location: ".$url);
        exit;
        echo 'This is a post controller in admin app.';
    }

    /**
     * 文章列表
     *
     */
    public function listAction()
    {
        $cur_page    = $this->getParam('page');
        $cur_page    = $cur_page ? $cur_page : 1;
        $page_size   = 10;
        $limit_start = ($cur_page-1)*$page_size;
        $limit       = $limit_start.','.$page_size;
        $model_post  = $this->loadModel('post');

        $condition   = '';

        $count = $model_post->getCount($condition);
        if($count){
            $list = $model_post->getList($condition, $limit);

            $param = array();
            $param['base_url']    = build_url('list', 'post');
            $param['total_count'] = $count;
            $param['cur_page']    = $cur_page;

            $pager = $this->loadPlugin('page');
            $page  = $pager->getPage($param);
        }else{
            $list = array();
            $page = '';
        }

        $this->assign('cur_page', $cur_page);
        $this->assign('page', $page);
        $this->assign('list', $list);
        $this->display('post_list');
    }

    /**
     * 新增文章页面
     *
     */
    public function newAction()
    {
        $this->setCategory();
        $this->display('post_new');
    }

    /**
     * 保存文章
     *
     */
    public function saveAction()
    {
        $data = $this->post();    //获取表单数据

        $model_post = $this->loadModel('post');
        if(isset($data['id'])){
            $id = $model_post->update($data);
        }else{
            $id = $model_post->addPost($data);
        }

        if(isset($data['page']) && $data['page']){
            $page = $data['page'];
        }else{
            $page = 1;
        }

        $url  = build_url('list', 'post');
        $url .= '?page='.$page;

        redirect($url, '操作成功', 1);
    }

    /**
     * 编辑文章页面
     *
     */
    public function editAction()
    {
        $id   = $this->get('id');
        $page = $this->get('page');
        if($id){
            $model_post = $this->loadModel('post');
            $info = $model_post -> getById($id);
        }else{
            $info = array();
        }

        $this->setCategory();

        $this->assign('is_edit', 1);
        $this->assign('page'   , $page);
        $this->assign('info'   , $info);
        $this->display('post_new');
    }

    /**
     * 删除文章
     *
     */
    public function deleteAction()
    {
        $id = $this->get('id');    //文章ID
        if($id){
            $model_post = $this->loadModel('post');
            $res = $model_post -> del($id);
        }

        $url = build_url('list', 'post');
        redirect($url, '操作成功', 1);
    }

}
