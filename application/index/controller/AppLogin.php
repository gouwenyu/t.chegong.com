<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 19:25
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class AppLogin extends Controller
{
    public function login(Request $request)
    {
        $act = $request->param('act');
        $mobile = $request->param('mobile');
        $pwd = $request->param('pwd');
        if (!empty($mobile) && !empty($pwd)) {
            $user = db('t_user');
            $userinfo = $user
                ->where(['mobile' => $mobile])
                ->find();
            if ($userinfo) {
                if ($pwd == $userinfo['user_pwd']) {
                    if ($userinfo['status'] === 1) {
                        $token = empty($userinfo['token' . $act]) ? md5($mobile . $pwd . time()) : $userinfo['token' . $act];
                        $res = $user->where('id', $userinfo['id'])->update(['token' . $act => $token]);
                        $this->app_json_success('登录成功','0',['list'=>['token' => $token]]);
                    } else {
                        $this->app_json_error('请等待审核通过,或致电车工:010-56210102','4');
                    }
                } else {
                    $this->app_json_error('密码错误，请重新输入','3');
                }
            } else {
                $this->app_json_error('账号不存在，请重新输入','2');
            }
        } else {
            $this->app_json_error('请求参数错误');
        }
    }

}