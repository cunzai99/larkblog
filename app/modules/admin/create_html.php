<?php
/**
 * 生成静态页管理类
 *
 * @category   controller
 * @package    admin
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: create_html.php v1.0.0 2014-06-03 cunzai99 $
 * @copyright
 * @license
 */

require_once(_MODULES_.'admin/controller.php');
class createHtmlController extends CommonController
{
    private $page_size = 10;

    public function __construct()
    {
        parent::__construct();
        $this->needLayout();
    }

    public function indexAction()
    {
        $type = $this->get('type');
        $type = $type ? $type : 'index';

        $this->assign('type', $type);
        $this->display('create_html');
    }

    public function saveAction()
    {
        $id   = $this->get('id');
        $type = $this->get('type');
        $type = $type ? $type : 'index';

        $this->setCategory();
        $this->initSetting();
        $this->initVariable('test');

        switch ($type) {
            case 'index':
                $res = $this->_createIndex();
                $res = $this->_createList('status=1', HTML_PATH, '/list/');
                break;
            case 'list':

                $this->model_category = $this->loadModel('category', 'blog', 'blog');
                $list_category = $this->model_category->getListKV();

                foreach ($list_category as $key => $val) {
                    $filepath  = strtolower($val['letter'] . '/list/');

                    $condition = '';
                    if($val['childids']) {
                        $condition = 'catid in ('.$val['childids'].')';
                    } else {
                        $condition = 'catid='.$key;
                    }

                    $condition .= ' and status=1';
                    $base_url = strtolower('/'.$val['letter'].'/list/');

                    $res = $this->_createList($condition, HTML_PATH, $base_url);
                }

                break;
            case 'content':

                if($id){
                    $this->_createContent($id);
                }else{
                    $model_post = $this->loadModel('post');
                    $list = $model_post->getList('status=1', '0, 100');
                    $list = is_array($list) ? $list : array();
                    foreach($list as $val){
                        $id = $val['id'];
                        $this->_createContent($id);
                    }
                }

                break;
            default:
                # code...
                break;
        }

        $this->initVariable('admin');

        $url  = build_url('index', 'create_html', 'admin', array('type'=>$type));
        redirect($url, '操作成功', 1);
    }

    private function _createIndex()
    {
        $page_size  = $this->page_size;

        $condition = array('status'=>1);
        $model_post = $this->loadModel('post');
        $count = $model_post->getCount($condition);
        if($count){

            $limit = '0, ' . $page_size;
            $list  = $model_post->getList($condition, $limit);

            //分页
            $base_url = '/list/';
            $param  = array('total_count'=>$count, 'page_size'=>$page_size, 'cur_page'=>1, 'base_url'=>$base_url);
            $plugin = $this->loadPlugin('page');
            $page   = $plugin -> getStaticPage($param);

            $this->assign('page', $page);
            $this->assign('list', $list);

            $filename = 'index.html';
            $base_dir = __ROOT__;
            $content  = $this->render('index', C('theme'));

            $res = F($filename, $content, $base_dir);
        }else{
            $this->assign('list', array());
        }
    }

    private function _createList($condition, $base_path, $base_url)
    {
        $page_size  = $this->page_size;

        $model_post = $this->loadModel('post');
        $count = $model_post->getCount($condition);
        if($count){
            $total_page = ceil($count/$page_size);
            for($i=1; $i<=$total_page; $i++){
                $start_row = ($i-1) * $page_size;
                $limit = $start_row . ', ' . $page_size;

                $list = $model_post->getList($condition, $limit);

                //分页
                $param  = array('total_count'=>$count, 'page_size'=>$page_size, 'cur_page'=>$i, 'base_url'=>$base_url);
                $plugin = $this->loadPlugin('page');
                $page   = $plugin -> getStaticPage($param);

                $this->assign('page', $page);
                $this->assign('list', $list);

                $file_path = $i.'.html';
                $base_dir  = $base_path . ltrim($base_url, '/');

                $content = $this->render('index', C('theme'));
                $res = F($file_path, $content, $base_dir);
            }
        }else{
            $this->assign('list', array());
        }
    }

    private function _createContent($id)
    {
        $model_post = $this->loadModel('post');
        $post_info  = $model_post->getById($id);

        $this->assign('post_info', $post_info);
        $this->assign('catid'    , $post_info['catid']);
        $this->assign('title'    , $post_info['title']);

        $content   = $this->render('show', C('theme'));
        $filename  = strtolower('/' . $post_info['letter'] . '/' . substr(md5($post_info['title']), 0, 15) . '.html');

        $res = F($filename, $content, HTML_PATH);

        $data['id']  = $id;
        $data['url'] = $filename;
        $result = $model_post->update($data);
    }

}
