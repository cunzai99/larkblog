<?php
/**
 *
 */
$db_info = array(
        'dbms'        => 'pdo',         //默认为pdo
        'dbtype'      => 'mysql',       //数据库类型
        'debug'       => _DEBUG_,       //是否调试
        'tablePrefix' => '',            //可选
        'tableSuffix' => '',            //可选
        'dbFieldtypeCheck' => true,

        /**
         * 如果不分read和write ，将会自动合并成array('read'=>array(),'write'=>array())
         */
        'read' => array(
                'host'     => 'localhost',
                'port'     => '3306',
                'dbname'   => 'larkblog',
                'username' => 'root',
                'password' => '',
                'charset'  => 'utf8',
                'persist'  => '1'
        ),
        'write' => array(
                'host'     => 'localhost',
                'port'     => '3306',
                'dbname'   => 'larkblog',
                'username' => 'root',
                'password' => '',
                'charset'  => 'utf8',
                'persist'  => '1',
        )
);

$db_info['read'] = array(
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'dbname'   => 'larkblog',
        'username' => 'root',
        'password' => 'longshu',
        'charset'  => 'utf8',
        'persist'  => '1'
);

$db_info['write'] = array(
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'dbname'   => 'larkblog',
        'username' => 'root',
        'password' => 'longshu',
        'charset'  => 'utf8',
        'persist'  => '1'
);

return $db_info;
