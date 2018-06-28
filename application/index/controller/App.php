<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 19:56
 */

namespace app\index\controller;

use app\common\controller\Check as Check;
use app\index\model\AppModel;
use think\Request;

class App extends Check
{
    public function positionList()
    {
        $id = $this->sid;
        $user = new AppModel();
        $list = $user->positionList($id);
        $run = 0;
        $park = 0;
        $error = 0;
        if (!empty($list['position'])) {
            foreach ($list['position'] as $k => $item) {
                $xy = $this->post_amap($item['longitude'], $item['latitude']);
                $xy = (array)$xy;
                $a = explode(',', $xy['locations']);
                $list['position'][$k]['longitude'] = $a[0];
                $list['position'][$k]['latitude'] = $a[1];
                if (time() - 150 < strtotime($list['position'][$k]['date'])) {
                    $list['position'][$k]['status'] = 'run';
                    $run += 1;
                    $error += empty($item['error_code'])?0:1;
                } else {
                    $list['position'][$k]['status'] = 'park';
                    $park += 1;
                    $error += empty($item['error_code'])?0:1;
                }
            }
            $list['rgentSpeed']['run'] = strval($run);
            $list['rgentSpeed']['park'] = strval($park);
            $list['rgentSpeed']['error'] = strval($error);
            $this->app_json_success('请求成功', '0', ['list' => $list]);
        } else {
            $this->app_json_error('数据为空', '2');
        }
    }

    public function underway(Request $request)
    {
        $oid = $request->param('obdId');
        if (!empty($oid)) {
            $user = new AppModel();
            $res = $user->underway($oid);
            if (!empty($res)) {
                $this->app_json_success('请求成功', '0', ['list' => $res]);
            } else {
                $this->app_json_error('数据为空', '2');
            }
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function tripList(Request $request)
    {
        $type = $request->param('type');
        $obd_id = $request->param('obdId');
        $driver_id = $request->param('driverId');
        $page = empty($request->param('pageNum')) ? 1 : $request->param('pageNum');
//        $partment_id = $request->param('partmentId');
        $start_time = $request->param('startTime');
        $end_time = $request->param('endTime');
        if (!empty($start_time) && !empty($end_time)) {
            $is_time_start = strtotime($start_time) ? true : false;
            $is_time_end = strtotime($end_time) ? true : false;
            $is_dateb = strtotime($start_time) <= strtotime($end_time) ? true : false;
            if ($is_time_start && $is_time_end && $is_dateb) {
                $status = true;
            } else {
                $status = false;
            }
        } else {
            $status = true;
        }
        if ($type && $status) {
            $id = $this->sid;
            $user = new AppModel();
            if (!empty($driver) && $type == 'Driver') {
                $is_driver = $user->is_user_driver($id, $driver);
                if (!$is_driver) {
                    $this->app_json_error('无此人员,请规范操作', '4');
                }
            }
            if (!empty($obd_id) && $type == 'Car') {
                $is_driver = $user->is_user_car($id, $obd_id);
                if (!$is_driver) {
                    $this->app_json_error('无此车辆,请规范操作', '4');
                }
            }
            $res = $user->tripList($id, $type, $page, $obd_id, $driver_id, $start_time, $end_time);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function screenList(Request $request)
    {
        $type = $request->param('type');
        if ($type == 'Car' || $type == 'Driver') {
            $id = $this->sid;
            $user = new AppModel();
            $res = $user->screenList($id, $type);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res, 'type' => $type]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function currentList(Request $request)
    {
        $obd_id = $request->param('obdId');
        $date = $request->param('startDate');
        $is_date = strtotime($date) ? true : false;
        if (!empty($obd_id) && $is_date) {
            $id = $this->sid;
            $user = new AppModel();
            $is_car = $user->is_user_car($id, $obd_id);
            if ($is_car) {
                $res = $user->currentList($obd_id, $date);
//                var_dump($res);die;
                empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
            } else {
                $this->app_json_error('无此车辆,请规范操作', '4');
            }
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function costList(Request $request)
    {
        $type = $request->param('type');
        $cost_type = $request->param('costType');
        $is_cost_type = $cost_type === '0' ? true : false;
        $car_id = $request->param('carId');
        $driver_id = $request->param('driverId');
        if ($type && (0 < $cost_type || $is_cost_type)) {
            $id = $this->sid;
            $user = new AppModel();
            if (!empty($driver_id) && $type == 'Driver') {
                $is_driver = $user->is_user_driver($id, $driver_id);
                if (!$is_driver) {
                    $this->app_json_error('无此人员,请规范操作', '4');
                }
            }
            $res = $user->cost($id, $type, $cost_type, $car_id, $driver_id, 1);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function kpiList(Request $request)
    {
        $driver = $request->param('driverId');
        $start_time = $request->param('startTime');
        $is_time_start = strtotime($start_time);
        $end_time = $request->param('endTime');
        $is_time_end = strtotime($end_time);
        if ($is_time_start && $is_time_end && strtotime($start_time) <= strtotime($end_time)) {
            $id = $this->sid;
            $user = new AppModel();
            if (!empty($driver)) {
                $is_driver = $user->is_user_driver($id, $driver);
                if (!$is_driver) {
                    $this->app_json_error('无此人员,请规范操作', '4');
                }
            }
            $res = $user->kpi($id, $driver, $start_time, $end_time);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function analysisList(Request $request)
    {
        $driver = $request->param('driverId');
        $start_time = $request->param('startTime');
        $is_time_start = strtotime($start_time);
        $end_time = $request->param('endTime');
        $is_time_end = strtotime($end_time);
//        var_dump($driver);die;
        if ($is_time_start && $is_time_end && $is_time_start <= $is_time_end) {
            $id = $this->sid;
            $user = new AppModel();
            if (!empty($driver)) {
                $is_driver = $user->is_user_driver($id, $driver);
                if (!$is_driver) {
                    $this->app_json_error('无此人员,请规范操作', '4');
                }
            }
            $res = $user->analysis($id, $driver, $start_time, $end_time);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }

    public function oilList(Request $request)
    {
        $obd_id = $request->param('obdId');
        $start_time = $request->param('startTime');
        $is_time_start = strtotime($start_time);
        $end_time = $request->param('endTime');
        $is_time_end = strtotime($end_time);
        if ($is_time_start && $is_time_end && $is_time_start <= $is_time_end) {
            $id = $this->sid;
            $user = new AppModel();
            if (!empty($obd_id)) {
                $is_driver = $user->is_user_car($id, $obd_id);
                if (!$is_driver) {
                    $this->app_json_error('无此车辆,请规范操作', '4');
                }
            }
            $res = $user->oil($id, $obd_id, $start_time, $end_time);
            empty($res) ? $this->app_json_error('数据为空', '2') : $this->app_json_success('请求成功', '0', ['list' => $res]);
        } else {
            $this->app_json_error('请求参数错误', 3);
        }
    }
}