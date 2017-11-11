<?php
use Lark\core\Model;
/**
 * 文章正文操作model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: post_content.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class postContent extends Model
{
    protected $_pk          = 'pid';            //主键,可选
    protected $_tablePrefix = 'Lark_';           //数据表前缀
    protected $_tableName   = 'posts_content';  //表名

    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, $param, $dbConfig);
    }


    /**
     * 获取文章信息
     */
    public function getById($id)
    {
        if($id){
            $data = $this->find($id);
        }else{
            $data = array();
        }
        return $data;
    }

    /**
     * 添加文章
     */
    public function addPost($data)
    {
        $pid     = trim($data['catid']);
        $content = trim($data['content']);

        if (!$pid || !$content){
            return false;
        }

        $data = array();
        $data['pid']     = $pid;
        $data['content'] = $content;

        $result = $this->add($data);
        return $result;
    }

    /**
     * 更新文章
     *
     * @param $data
     * @return boolean
     */
    public function update($data)
    {
        $pid   = trim($data['pid']);
        $_data = array();
        if(isset($data['content'])) $_data['content'] = $data['content'];
        $res   = $this->where(array('pid'=>$pid))->save($_data);

        if($res){
            return true;
        }else{
            return false;
        }
    }


}

