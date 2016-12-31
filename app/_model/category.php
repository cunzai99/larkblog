<?php
use Lark\core\Model;
/**
 * 文章分类操作model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: category.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class category extends Model
{
    protected $_pk = 'catid';             //主键,可选
    protected $_tableName   = 'category';
    protected $_tablePrefix = 'Lark_';    //数据表前缀


    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, '', $dbConfig);
    }

    /**
     * 获取分类信息
     *
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        $data = $this->find($id);

        return $data;
    }

    /**
     * 获取文章分类列表
     *
     * @return array
     */
    public function getList($condition=array())
    {
        $list = $this->where($condition)->select();
        if(!$list) $list = array();

        return $list;
    }

    /**
     * 获取文章分类列表(层级)
     *
     * @return array
     */
    public function getListLevel($condition=array())
    {
        $list = $this->getList($condition);

        $data = array();
        foreach($list as $item){
            $pid   = $item['pid'];
            $catid = $item['catid'];
            $item['url'] = '/'.$item['letter'].'/index.html';
            $item['url'] = build_url('list', 'post', 'blog', array('catid'=>$catid));

            if($pid){
                $data[$pid]['children'][$catid] = $item;
            }else{
                if(isset($data[$catid])){
                    $item['children'] = $data[$catid]['children'];
                }
                $data[$catid] = $item;
            }
        }
        return $data;
    }

    /**
     * 获取文章分类列表(以catid做key)
     *
     * @return array
     */
    public function getListKV()
    {
        $list = $this->getList();

        $data = array();
        foreach($list as $item){
            $tmp = array();
            $tmp['catid']    = $item['catid'];
            $tmp['pid']      = $item['pid'];
            $tmp['childids'] = $item['childids'];
            $tmp['catname']  = $item['catname'];
            $tmp['letter']   = $item['letter'];
            $tmp['items']    = $item['items'];
            $tmp['hits']     = $item['hits'];
            $tmp['url']      = '/'.$item['letter'].'/list.html';

            $data[$item['catid']] = $tmp;
        }
        return $data;
    }

    /**
     * 更新分类
     *
     * @param $data
     * @return boolean
     */
    public function update($data)
    {
        $catid=isset($data['catid']) ? $data['catid'] : 0;

        if(!$catid){
            return false;
        }

        unset($data['catid']);

        $res = $this->where(array('catid'=>$catid))->save($data);

        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function insert($data)
    {
        unset($data['catid']);
        $data['url'] = isset($data['url']) ? $data['url'] : '';
        $catid = $this->add($data);
        return $catid;
    }

}

?>
