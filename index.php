<?php

/**
 * 程序入口
 *
 * @category   Lark
 * @package    Lark_Bootstrap
 * @copyright
 * @license
 */
// cpu:XHPROF_FLAGS_CPU 内存:XHPROF_FLAGS_MEMORY
// 如果两个一起：XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY
// xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
// xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
require_once('larkphp/controller.php');

// 中心控制 请求->路由->过滤->分发->响应
$controller = Lark_Controller::getInstance();


$controller -> run();

// $data = xhprof_disable();   //返回运行数据

// xhprof_lib在下载的包里存在这个目录,记得将目录包含到运行的php代码中
// include_once "xhprof_lib/utils/xhprof_lib.php";
// include_once "xhprof_lib/utils/xhprof_runs.php";

// $objXhprofRun = new XHProfRuns_Default();

// 第一个参数j是xhprof_disable()函数返回的运行信息
// 第二个参数是自定义的命名空间字符串(任意字符串),
// 返回运行ID,用这个ID查看相关的运行结果
// $run_id = $objXhprofRun->save_run($data, "xhprof_test");
// var_dump($run_id);

?>
