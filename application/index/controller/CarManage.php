<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/20
 * Time: 21:32
 */

namespace app\index\controller;

use app\common\controller\Check as check;
use app\index\model\User;

class CarManage extends check
{
    public function index()
    {
        $id = $this->sid;
        $user = new User();
        $car_list = $user->car_list($id);
        $list = [];
        $username = [];
        foreach ($car_list as $item) {
            $list[$item['merchant_id']][$item['department_id']][] = $item;
            $username[$item['merchant_id']] = $item['username'];
        }
        $driver_list = $user->driver_list($id);
        $car_cost = $user->car_cost($id);
        $this->assign('list', $list);
        $this->assign('user_name',$username);
        $this->assign('car_list', $car_list);
        $this->assign('driver_list', $driver_list);
        $this->assign('cost_list', $car_cost);
        return view('index');
    }

    public function costInfo()
    {
        $costinfo = db('t_cost_info');
        $cost['id'] = input('post.cost_id');
        $cost['driver_id'] = input('post.driver_id');
        $cost['car_id'] = input('post.car_id');
        $cost['accident_cost'] = input('post.accident_cost');
        $cost['cost_type'] = input('post.money_type');
        $cost['car_describe'] = input('post.car_describe');
        $cost['add_time'] = input('post.add_time');
        $merchant_id = db('t_car_info')->field('merchant_id')->where('id', $cost['car_id'])->find()['merchant_id'];
        if (strpos($this->sid, $merchant_id) === false) {     //使用绝对等于
            //不包含
            $this->make_json_error('请勿非法操作');
        }
        $cost['merchant_id'] = $merchant_id;
        $time = date("Y-m-d h:i:s", time());
        $cost['up_time'] = $time;
        $rst = $costinfo
            ->where('id', $cost['id'])
            ->find();
        if ($rst) {
            $this->upCost($cost);
        } else {
            $cost['id'] = md5($this->uuid('cost'));
            $cost['create_time'] = $time;
            $this->addCost($cost);
        }
    }

    private function addCost($cost = [])
    {
        $costinfo = db('t_cost_info');
        $rst = $costinfo->insert($cost);
        if ($rst) {
            exit(json_encode(['error' => 0, 'msg' => '添加成功', 'car_id' => $cost['id']]));
        } else {
            exit(json_encode(['error' => 1, 'msg' => '添加失败,请填写完整']));
        }
    }

    private function upCost($cost = [])
    {
        $costinfo = db('t_cost_info');
        $rst = $costinfo
            ->where('id', $cost['id'])
            ->update($cost);
        if ($rst) {
            exit(json_encode(['error' => 0, 'msg' => '修改成功']));
        } else {
            exit(json_encode(['error' => 1, 'msg' => '修改失败']));
        }
    }

    public function more()
    {
        $type = input('post.type');
        $car_id = input('post.car');
        if (!empty($car_id)) {
            $id = $this->sid;
            $user = new User();
            $user->more($id, $type, $car_id, false);
        } else {
            $this->make_json_error('请勿非法操作');
        }
    }

}