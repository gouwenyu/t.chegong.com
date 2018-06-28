<?php
/**
 * Created by PhpStorm.
 * User: dong
 * Date: 2017/5/15
 * Time: 21:07
 */

namespace app\index\controller;

use app\index\model\User as UserModel;
use think\Controller;
class User extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function  login()
    {
        $user = $_POST['uname'];
        $pwd = $_POST['pwd'];
        $login =db('login');
        $result = $login
            ->table('cg_admin')
            ->where(['adminname'=>$user, 'password'=>$pwd])
            ->select();
        if($result)
            $this->success('登录成功','Index/model');
        else
            $this->error('用户名或密码错误');
    }
}