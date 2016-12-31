<?php
use Lark\core\Model;
/**
 * 用户操作model类
 *
 * 此类是应用程序和数据库通信枢纽，为应用层提供数据层接口
 *
 *
 * @category   Lark
 * @package    Lark_Model
 * @author     cunzai99 <cunzai99@gmail.com>
 * @version    $Id: user.php v1.0.0 2014-06-16 $
 * @copyright
 * @license
 */
class user extends Model
{
    protected $_pk          = 'id';      //主键,可选
    protected $_tablePrefix = 'Lark_';    //数据表前缀
    protected $_tableName   = 'user';    //表名

    public function __construct($name='', $param=array(), $dbConfig=array())
    {
        parent::__construct($name, $param, $dbConfig);
    }

    /**
     * 获取用户列表
     *
     */
    public function getList()
    {
        $list = $this->limit('0,2')->select();
        foreach($list as $val){}

        return $list;
    }

    /**
     * 获取用户信息
     *
     */
    public function getInfoById($id)
    {
        $id = intval($id);
        if (!$id) return false;

        $condition['id'] = $id;
        //$condition = 'id='.$id;        //这种方式也行
        $user_info = $this->where($condition)->select();

        return $user_info[0];
    }

    /**
     * 验证用户名密码
     *
     * @param $username
     * @param $password
     */
    public function checkPassword($username, $password)
    {
        if(!$username || !$password){
            return false;
        }

        $condition  = array();
        $condition['username'] = $username;
        $condition['password'] = md5($password);

        $res = $this->where($condition)->limit(0,1)->select();
        $res = $res ? $res[0] : array();

        return $res;
    }

    /**
     * 添加用户
     *
     */
    public function addUser($data)
    {

    }

    public function updatePwd($data)
    {
        $old_pwd = md5($data['old_pwd']);
        $new_pwd = md5($data['new_pwd']);

        $res = $this->where(array('id'=>$data['id'], 'password'=>$old_pwd))->save(array('password'=>$new_pwd));
        if($res){
            return true;
        }else{
            return false;
        }
    }
}

