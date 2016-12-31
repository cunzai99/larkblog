<?php
/**
 * Larkblog 评论 接口类
 *
 * @category   controller
 * @package    api
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: comment.php v1.0.0 2014-03-15 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'api/controller.php');
class commentController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        $this->model_comment = $this->loadModel('comment');
    }

    public function indexAction()
    {
        echo 'Here is Larkblog API controller.';
    }

    /**
     * 评论列表
     *
     */
    public function listAction()
    {
        $param = array();
        $post_id = $this->getParam('post_id');
        if($post_id){
            $param['post_id'] = $post_id;
        }

        //查询条件
        $page  = isset($_GET['page']) ? $_GET['page'] : 1;
        $page_size = 20;
        $limit = ($page-1)*$page_size.','.$page_size;

        $count = $this->model_comment->getCount($param);
        if($count){
            $list = $this->model_comment->getList($param, $limit, 'id asc');
        }else{
            $list = array();
        }

        //分页
        $param = array();
        $param['base_url']    = build_url('list', 'post');
        $param['total_count'] = $count;
        $param['cur_page']    = $page;

        $pager = $this->loadPlugin('page');
        $page  = $pager->getPage($param);

        $data = array();
        $data['list']  = $list;
        $data['total'] = $count;

        $this->response(200, $data);
    }

    /**
     * 新增评论
     *
     */
    public function addAction()
    {
        $data = $this->post();    //获取表单数据
        if(!isset($data['post_id']) || !$data['post_id']){
            $this->response(400, '');
        }
        $id = $this->model_comment->addComment($data);

        if($id){
            $this->response(200, array('id'=>$id));
        }else{
            $this->response(400);
        }
    }

    /**
     * 删除评论
     *
     */
    public function deleteAction()
    {
        $id = $this->get('id');    //评论ID
        if($id){
            $model_comment = $this->loadModel('post');
            $res = $model_comment -> del($id);
        }

        $this->response(200);
    }

}
