<?php
/**
 * Created by PhpStorm.
 * User: LXD
 * Date: 2017/5/31
 * Time: 20:16
 */

namespace application\push\controller;

use think\Request;
class Error
{
    public function index(Request $request)
    {
        //根据当前控制器名来判断要执行那个控制器的操作
        $controllerName = $request->controller();
        return $this->showMsg($controllerName);
    }

    //注意 showMsg方法 本身是 protected 方法
    protected function showMsg($name)
    {
        $this->error('当前控制器' . $name . '不存在');
    }
}
