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
class indexController extends CommonController
{
    public function indexAction()
    {
        $this->needLayout();

        //显示最新的5篇文章
        $model_post = $this->loadModel('post');
        $post_list  = $model_post->getList('', '0, 5');

        //显示最新的5条评论
        $model_comment = $this->loadModel('comment');
        $comment_list  = $model_comment->getList('', '0, 5');

        $this->assign('post_list'   , $post_list);
        $this->assign('comment_list', $comment_list);
        $this->display('index');
    }

}
