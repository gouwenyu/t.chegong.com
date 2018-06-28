<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/20
 * Time: 21:24
 */

namespace app\push\controller;

use app\common\controller\Check as check;
use app\push\model\User;
class WarnCar extends check
{
    public function index(){
        $id = $this->sid;
        $user = new User();
        $err = $user->err_num($id);
        $err_info = $user->err_info($id);
        $license_list = $user->license_list($id);
        $this->assign('err_num',$err[0]['sum']);
        $this->assign('err_info',$err_info);
        $this->assign('license_num',count($license_list));
        $this->assign('license_info',$license_list);
        return view('index');
    }
}