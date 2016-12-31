<?php
use Lark\core\Model;
/**
 * 文章操作model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class post extends Model
{
    protected $_pk          = 'id';       //主键,可选
    protected $_tablePrefix = 'Lark_';     //数据表前缀
    protected $_tableName   = 'posts';    //表名

    protected $model_category;
    protected $categorys;

    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, $param, $dbConfig);

        $this->model_category = $this->loadModel('category', 'blog');
        $this->categorys      = $this->model_category->getListKV();
    }

    /**
     * 获取文章信息
     *
     * @param $id    文章ID
     * @return array
     */
    public function getById($id)
    {
        $categorys = $this->categorys;
        $data = $this->find($id);

        $pid = isset($data['id']) ? $data['id'] : '';
        if($pid){
            $model_post_content = $this->loadModel('post_content');
            $res = $model_post_content->getById($pid);

            // $data['title']   = mb_substr($data['title'], 0, 22, 'utf-8');
            $data['content'] = isset($res['content']) ? htmlspecialchars_decode($res['content']) : '';

            if(isset($data['catid']) && isset($categorys[$data['catid']])){
                $data['catname'] = $categorys[$data['catid']]['catname'];
                $data['letter']  = $categorys[$data['catid']]['letter'];
            }
        }

        return $data;
    }

    /**
     * 获取符合条件的文章总数
     *
     * @param  $condition    查询条件
     * @return int
     */
    public function getCount($condition=array())
    {
        $count = $this->where($condition)->count('id');
        return $count;
    }

    /**
     * 获取文章列表
     *
     * @param  $condition    查询条件
     * @param  $order        排序方式
     * @param  $limit        返回指定记录数
     * @return array
     */
    public function getList($condition=array(), $limit='0,10', $order='id desc')
    {
        $result = $this->where($condition)->limit($limit)->order($order)->select();
        $result = $result ? $result : array();
        $list   = $this->_formatData($result);

        return $list;
    }

    //
    public function _formatData($data)
    {
        $_data = array();
        foreach($data as $item){
            $id    = $item['id'];
            $catid = $item['catid'];

            $cat_info = isset($this->categorys[$catid]) ? $this->categorys[$catid] : '';

            $tmp = array();
            $tmp['id']      = $id;
            $tmp['catid']   = $catid;
            if(isset($cat_info['catname'])) $tmp['catname'] = $cat_info['catname'];
            $tmp['title']   = mb_substr($item['title'], 0, 40, 'utf-8');
            $tmp['summary'] = $item['summary'];
            $tmp['author']  = $item['author'];
            $tmp['update_time'] = $item['update_time'] ? date('Y-m-d H:i', $item['update_time']) : date('Y-m-d H:i', $item['create_time']);
            $tmp['create_time'] = date('Y-m-d H:i', $item['create_time']);
            $tmp['reprinted']  = $item['reprinted'];
            $tmp['status']  = $item['status'];
            $tmp['url'] = build_url('show', 'post', 'blog', array('id'=>$id));
            if(C('create_html')){
                $tmp['url'] = $item['url'] ? $item['url'] : $tmp['url'];
            }

            $_data[] = $tmp;
        }
        return $_data;
    }

    /**
     * 添加文章
     *
     * @param $data
     * @return post_id
     */
    public function addPost($data)
    {
        $catid   = trim($data['catid']);
        $title   = trim($data['title']);
        $content = trim($data['content']);
        $summary = isset($data['summary']) ? trim($data['summary']) : strip_tags(mb_substr($content, 0, 255)) ;

        if (!$title || !$content){
            return false;
        }

        $_data = array();
        $_data['catid']       = $catid;
        $_data['title']       = $title;
        $_data['summary']     = $summary;
        $_data['author']      = $_SESSION['nickname'];
        $_data['author_id']   = $_SESSION['id'];
        $_data['create_time'] = time();
        $_data['status']      = isset($data['is_show']) ? intval($data['is_show']) : 1;
        $_data['reprinted']   = $data['reprinted'];

        $post_id = $this->add($_data);
        if($post_id){
            $model_post_content = $this->loadModel('post_content');
            $_data = array();
            $_data['pid']     = $post_id;
            $_data['content'] = stripslashes($content);

            $res = $model_post_content->add($_data);
            if(!$res){
                //删除posts表记录
                //return false
            }
        }
        return $post_id;
    }

    /**
     * 更新文章
     *
     * @param $data
     * @return boolean
     */
    public function update($data)
    {
        $id=$data['id'];
        $summary = isset($data['summary']) ? trim($data['summary']) : (isset($data['content']) ? strip_tags(mb_substr($data['content'], 0, 255)) : '');

        if(isset($data['catid']))     $_data['catid']     = $data['catid'];
        if(isset($data['title']))     $_data['title']     = $data['title'];
        if(isset($data['url']))       $_data['url']       = $data['url'];
        if(isset($summary)&&$summary) $_data['summary']   = $summary;
        if(isset($data['status']))    $_data['status']    = $data['status'];
        if(isset($data['reprinted'])) $_data['reprinted'] = $data['reprinted'];
        $_data['update_time'] = time();
        //var_dump($_data);
        //exit;
        $res = $this->where(array('id'=>$id))->save($_data);
        if($res){
            $model_post_content = $this->loadModel('post_content');
            $_data = array();
            $_data['pid'] = $id;
            if(isset($data['content'])) {
                $_data['content'] = $data['content'];
                $res = $model_post_content->update($_data);
            }
        }

        if($res){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除文章
     *
     * @param $id
     * @return boolean
     */
    public function del($id)
    {
        if($id){
            $_data = array();
            $_data['status'] = 2;

            $res = $this->where(array('id'=>$id))->save($_data);
        }

        if($res){
            return true;
        }else{
            return false;
        }
    }

}





?>
