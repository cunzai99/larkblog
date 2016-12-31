<?php

//方便调试
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('Asia/Shanghai'); //'Asia/Shanghai' 亚洲/上海

// 系统变量
define('_SEPARATOR_' , DIRECTORY_SEPARATOR);
define('_WWW_'       , _ROOT_ );
define('_APP_'       , _ROOT_ . 'app'       . _SEPARATOR_);
define('_MODULES_'   , _APP_  . 'modules'   . _SEPARATOR_);
define('_FRAMEWORK_' , _ROOT_ . 'framework' . _SEPARATOR_);
define('_PLUGIN_'    , _APP_  . '_plugin'   . _SEPARATOR_);
define('_CONFIG_'    , _APP_  . '_config'   . _SEPARATOR_);
define('_DEBUG_'     , false);               //正式环境，设置为false

define('_DOMAIN_'    , 'http://' . $_SERVER['HTTP_HOST']);
define('_URL_'       , _DOMAIN_  . $_SERVER['REQUEST_URI']);

//判断是否在sae平台
define('__IS_SAE__'      , isset($_SERVER['HTTP_APPNAME']) ? true : false);
if(__IS_SAE__){
    define('_CACHE_DIR_' , 'saestor://cache/');      //可写临时缓存目录
}else{
    define('_CACHE_DIR_' , _ROOT_.'cache/');         //可写临时缓存目录
}

define('_DATA_DIR_'  , _CACHE_DIR_.'data/');    //可写上传数据目录
define('_IMG_URL_'   , _CACHE_DIR_.'img/');     //图库上传地址
define('_COMPILE_'   , _CACHE_DIR_.'compile/'); //图库上传地址
define('_FIELDS_'    , _CACHE_DIR_.'fields/');  //图库上传地址

define('_VIEW_PATH_'  , _ROOT_  .'view/');  //tpl路径

define('_VIEW_COMMON_', _VIEW_PATH_.'/common/');
define('_JS_PATH_'    , '/view/common/js/');         //js 路径
define('_CSS_PATH_'   , '/view/common/css/');        //css路径
define('_IMG_PATH_'   , '/view/common/img/');        //img路径


define('DEFAULT_APP'       , 'blog');       //默认应用
define('DEFAULT_CONTROLLER', 'post');       //默认控制器
define('DEFAULT_ACTION'    , 'index');      //默认动作
define('DEFAULT_THEME'     , 'test');       //默认模板主题

define('HTML_PATH', _ROOT_.'html/');    //生成html文件到此目录

define('LANGUAGE'      , 'zh-cn');      //默认语言包
define('ROUTER_ENGINE' , 'Query');      //默认路由规则
define('VIEWER_ENGINE' , 'Render');     //默认模板引擎
define('INIT_DIRECTORY', false);        //是否初始化目录结构

define('TOKEN_ON'    , true);       //开启令牌验证
define('TOKEN_NAME'  , '__hash__'); //令牌验证的表单隐藏字段名称
define('TOKEN_TYPE'  , 'md5');      //令牌验证哈希规则
define('TOKEN_RESET' , true);       //令牌错误后是否重置

define('CACHE_ENGINE', 'Lark_Cache_Memcache');

set_include_path( _ROOT_ . PATH_SEPARATOR . get_include_path());

$config = array();
$config['theme'] = 'test';
