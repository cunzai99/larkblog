<?php
use Lark\core\Model;
/**
 * 系统设置model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: setting.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class setting extends Model
{
    protected $_pk = 'id';                //主键,可选
    protected $_tableName   = 'setting';
    protected $_tablePrefix = 'Lark_';    //数据表前缀


    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, '', $dbConfig);
    }

    public function getByName($name)
    {
        $res = $this->where(array('name'=>$name))->select();

        if(isset($res[0])){
            return $res[0];
        }else{
            return false;
        }
    }

    /**
     * 获取系统设置信息
     *
     * @return array
     */
    public function getList()
    {
        $list = $this->_getList();
        $list = $this->_formatData($list);

        return $list;
    }

    public function update($data)
    {
        if(empty($data) || !is_array($data)){
            return false;
        }

        $list = $this->_getList();

        $_tmp = $_data = array();
        foreach ($list as $val) {
            $id = $val['id'];
            $name = $val['name'];
            $content = $val['content'];

            $_tmp[$name] = $id;

            if(isset($data[$name]) && $data[$name] != $content){
                $_data[$id] = $data[$name];
            }
        }

        $res = true;
        if(!empty($_data)) {
            foreach ($_data as $key => $val) {
                $res = $this->where(array('id'=>$key))->save(array('content'=>$val));
            }
        }

        $_data = array();
        foreach($data as $key=>$val){
            if(!isset($_tmp[$key])){
                $_data[$key] = $val;
            }
        }

        if(!empty($_data)) {
            foreach ($_data as $key => $val) {
                $res = $this->add(array('pid'=>1, 'name'=>$key, 'content'=>$val));
            }
        }

        if($res){
            return true;
        }else{
            return false;
        }

    }

    private function _getList()
    {
        $list = $this->select();
        $list = is_array($list) ? $list : array();

        return $list;
    }

    private function _formatData($data)
    {
        $data = is_array($data) ? $data : array();

        $_tmp = array();
        foreach ($data as $val) {
            $id   = $val['id'];
            $pid  = $val['pid'];
            $name = $val['name'];

            if(!$pid){
                $_tmp[$id] = $name;
            }
        }

        $_data = array();
        foreach ($data as $val) {
            $pid  = $val['pid'];
            $name = $val['name'];

            if($pid){
                $pname = isset($_tmp[$pid]) ? $_tmp[$pid] : '';
                if($pname){
                    $_data[$pname][$name] = $val;
                }
            }
        }

        return $_data;
    }

}

?>
