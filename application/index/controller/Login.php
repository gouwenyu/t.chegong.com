<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/2
 * Time: 10:03
 */

namespace app\index\controller;

use think\Controller;

class Login extends Controller
{

    public function index()
    {
        if (!empty(session('aid'))) {
            $this->redirect('index/index');
        } else {
            return $this->fetch('login/login');
        }
    }
    //登录操作
    public function login()
    {
        $p['mobile'] = input('post.mobile');
        $p['source'] = input('post.source');
        if (!empty($p['mobile'])) {
            $user = db('t_user');
            $userinfo = $user
                ->where($p)
                ->find();
            if ($userinfo) {
                $password = md5(input('post.password'));
                if ($password == $userinfo['user_pwd']) {
                    if ($userinfo['status'] === 1) {
                        $rst = db('t_auth')
                            ->field('user_id')
                            ->where('parent_id', $userinfo['id'])
                            ->select();
                        if(!empty($rst)){
                            foreach ($rst as $item) {
                                $child[] = "'".$item['user_id']."'";
                            }
                            $children = implode(',',$child);
                            session('aid',$children);
                        }else {
                            session('aid', "'".$userinfo['id']."'");
                        }
                        session('uid',$userinfo['id']);
                        cookie('name', $userinfo['username']);
                        cookie('logo', $userinfo['image']);
                        cookie('wz',$userinfo['position']);
                        $this->make_json_response('登录成功', 0, 'index');
                    } else {
                        $this->make_json_error('请等待审核通过,或致电车工:010-56210102', 3, 'login/index');
                    }
                } else {
                    $this->make_json_error('密码错误，请重新输入', 1);
                }
            } else {
                $this->make_json_error('账号不存在，请重新输入', 2);
            }
        } else {
            $this->make_json_error('非法操作，请慎重！');
        }
    }

    //登录退出
    public function loginOut()
    {
        session(null);
        cookie(null);
        $this->redirect('Login/index');
    }
}