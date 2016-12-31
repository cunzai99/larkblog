<?php
/**
 * 文章管理类
 *
 * @category   Post
 * @package    blog
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'blog/controller.php');
class postController extends CommonController{

    protected $model_post;
    protected $model_category;

    public function __construct($plugins=null)
    {
        parent::__construct($plugins);

        $this->needLayout();
        $this->model_post = $this->loadModel('post');
        $list_new_post = $this->model_post->getList();

        $this->assign('list_new_post', $list_new_post);
    }

    public function indexAction()
    {
        $this->listAction();
    }

    //文章列表
    public function listAction()
    {
        $catid = $this->get('catid');
        $page  = $this->get('page');
        $page  = $page ? $page : 1;
        $page_size = 10;
        $limit = ($page-1)*$page_size.','.$page_size;

        //查询条件
        $param = array();
        $param['status'] = 1;

        if($catid){
            $param['catid'] = $catid;
        }

        $list  = array();
        $count = $this->model_post->getCount($param);
        if($count){
            $list  = $this->model_post->getList($param, $limit);

            //
            $param = array();
            $param['base_url']    = build_url('list', 'post');
            $param['total_count'] = $count;
            $param['cur_page']    = $page;

            $pager = $this->loadPlugin('page');
            $page  = $pager->getPage($param);
        }else{
            $page  = '';
        }

        $this->setCategory(array('status'=>1));

        $this->assign('page', $page);
        $this->assign('list', $list);
        $this->display('index');
    }

    //文章详情页
    public function showAction()
    {
        $id = $this->get('id');

        $post_info = $this->model_post->getById($id);

        if (empty($post_info)){
            redirect('/', '页面不存在', 1);
        }

        if($post_info['status'] != 1){
            redirect('/', '页面不存在', 1);
        }

        $this->setCategory(array('status'=>1));

        $this->assign('post_info', $post_info);
        $this->assign('catid'    , $post_info['catid']);
        $this->assign('title'    , $post_info['title']);
        $this->display('show');
    }

}
