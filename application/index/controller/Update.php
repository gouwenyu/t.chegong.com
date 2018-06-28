<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 17:57
 */

namespace app\index\controller;

use app\common\controller\Check as check;


class Update extends check
{
    public function upName()
    {
        $id = session('uid');
        $username = empty(input('post.name')) ? $this->make_json_error('用户名不能为空') : trim(input('post.name'));
        $user = db('t_user');
        $userinfo = $user
            ->field('id')
            ->where('id', $id)
            ->find();
        $rst = $user
            ->where('id', $userinfo['id'])
            ->update(['username' => $username]);
        if ($rst) {
            cookie('name', $username);
            $this->make_json_response('修改成功', 0);
        } else {
            $this->make_json_error('修改失败');
        }
    }

    public function upPassword()
    {
        $id = session('uid');
        $pwd = input('post.pwd');
        $repwd = input('post.repwd');
        $repwd1 = input('post.repwd1');
        if (empty($pwd) | empty($repwd) | empty($repwd1)) {
            $this->make_json_error('数据不能为空');
        } elseif ($repwd != $repwd1) {
            $this->make_json_error('两次密码不一致');
        }elseif ($pwd == $repwd1) {
            $this->make_json_error('密码无变化');
        }
        $user = db('t_user');
        $userinfo = $user
            ->field('id')
            ->where(['id' => $id, 'user_pwd' => md5($pwd)])
            ->find();
        if (empty($userinfo)) {
            $this->make_json_error('原密码错误');
        }
        $rst = $user
            ->where('id', $userinfo['id'])
            ->update(['user_pwd' => md5($repwd)]);
        if ($rst) {
            session(null);
            cookie(null);
            $this->make_json_response('修改成功','0','index');
        } else {
            $this->make_json_error('修改失败');
        }
    }

    public function upload()
    {
        // 获取表单上传文件
        $file = request()->file('myfile');

        if (empty($file)) {
            $this->make_json_error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'jpg,png', 'size' => 1048576])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'index' . DS . 'upload');
        if ($info) {
            $user = db('t_user');
            $userinfo = $user
                ->field('id')
                ->where('id', session('uid'))
                ->find();
            $rst = $user
                ->where('id', $userinfo['id'])
                ->update(['image' => $info->getSaveName()]);
            if ($rst) {
                cookie('logo', $info->getSaveName());
                $this->make_json_response('logo修改传成功：', '0', $info->getSaveName());
            } else {
                $this->make_json_error('修改失败');
            }
            // 成功上传后 获取上传信息
            // echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            // echo $info->getFilename();
        } else {
            // 上传失败获取错误信息
            $this->make_json_error($file->getError());
        }
    }
}