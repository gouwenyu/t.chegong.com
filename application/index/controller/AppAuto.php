<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24
 * Time: 18:46
 */

namespace app\index\controller;
use think\Controller;
use think\Request;

class AppAuto extends Controller
{
    public function autoLogin(Request $request)
    {
        $act = $request->param('act');
        if ($act == '1' || $act == '2') {
            $token = empty($request->param('token'))?$this->app_json_error('无验证,请重新验证','2'):$request->param('token');
            $user = db('chegong_merchant')
                ->table('t_user')
                ->field('id')
                ->where('token', $token)
                ->find();
            if (empty($user)) {
                $this->app_json_error('身份验证过期,请重新验证');
            }else{
                session('aid', $user['id']);
            }
        }
    }
}