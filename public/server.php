
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 15:18
 */

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//绑定默认模块和控制器
define('BIND_MODULE','worker/Run');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';