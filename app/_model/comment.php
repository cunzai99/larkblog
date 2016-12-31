<?php
use Lark\core\Model;
/**
 * 评论操作model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: comment.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class comment extends Model
{
    protected $_pk          = 'id';       //主键,可选
    protected $_tablePrefix = 'Lark_';     //数据表前缀
    protected $_tableName   = 'comment';  //表名

    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, $param, $dbConfig);
    }

    /**
     * 获取评论信息
     *
     * @param $id    评论ID
     * @return array
     */
    public function getById($id)
    {
        $data = $this->find($id);

        return $data;
    }

    /**
     * 获取符合条件的评论总数
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
     * 获取评论列表
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

        return $result;
    }

    /**
     * 添加评论
     *
     * @param $data
     * @return comment_id
     */
    public function addComment($data)
    {
        $post_id  = isset($data['post_id'])  ? strip_tags($data['post_id'])  : '';
        $nickname = isset($data['nickname']) ? strip_tags($data['nickname']) : '';
        $content  = isset($data['content'])  ? strip_tags($data['content'])  : '';

        if (!$post_id || !$nickname || !$content){
            return false;
        }

        $_data = array();
        $_data['uid']         = 1;
        $_data['nickname']    = $nickname;
        $_data['content']     = $content;
        $_data['post_id']     = $post_id;
        $_data['create_time'] = time();

        $comment_id = $this->add($_data);

        return $comment_id;
    }

    /**
     * 删除评论
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
