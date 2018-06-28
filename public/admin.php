<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 定义项目路径
// 定义项目路径
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架基础文件
require __DIR__ . '/../thinkphp/base.php';
// 绑定当前入口文件到push模块
\think\Route::bind('push');
// 关闭push模块的路由
\think\App::route(false);
// 执行应用
\think\App::run()->send();

