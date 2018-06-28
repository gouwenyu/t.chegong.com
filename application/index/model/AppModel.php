<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 20:29
 */

namespace app\index\model;

use think\Model;
use think\Db;


class AppModel extends Model
{
    //车列表
    public function car_list($id)
    {
        $car_list = db('chegong_merchant')
            ->table('t_car_info')->alias('a')
            ->field([
                "a.obd_id",
                "a.id car_id",
            ])
            ->where('a.merchant_id', 'in', $id)
            ->select();
//        $car_list = Db::query("SELECT a.obd_id,a.id car_id FROM  t_car_info a WHERE a.merchant_id='$id'");
        if ($car_list) {
            foreach ($car_list as $item) {
                $car['obd_id'][] = $item['obd_id'];
                $car['car_id'][] = $item['car_id'];
            }
            $res['obd_id'] = implode(',', $car['obd_id']);
            $res['car_id'] = implode(',', $car['car_id']);
        } else {
            $res = null;
        }
        return $res;
    }

    //人列表
    public function driver_list($id)
    {
        $driver_list = db('chegong_merchant')
            ->table('t_driver_info')->alias('a')
            ->field([
                "a.id",
                "a.name",
            ])
            ->where('a.merchant_id', 'in', $id)
            ->select();
//        $driver_list = Db::query("SELECT `id`,`name`  FROM  `t_driver_info` a WHERE a.merchant_id='$id'");
        if ($driver_list) {
            foreach ($driver_list as $item) {
                $driver['id'][] = $item['id'];
            }
            $res['id'] = implode(',', $driver['id']);
        } else {
            $res = null;
        }
        return $res;
    }

    //地理位置转换
    public function post_amaps($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://restapi.amap.com/v3/assistant/coordinate/convert?locations=$data&coordsys=gps&output=json&key=47e9fd264b9f80d8ecc368e616af3e57");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rst = curl_exec($ch);
        curl_close($ch);
        return json_decode($rst);
    }

    //是否为本公司的车
    public function is_user_car($id, $obd_id)
    {
        $arrObdId = explode(',', $obd_id);
        $conn = db('chegong_merchant');
        foreach ($arrObdId as $item) {
            $res = $conn->table('t_car_info')
                ->where('obd_id', $item)
                ->where('merchant_id', 'in', $id)
                ->find();
            if (empty($res)) {
                return false;
            }
        }
        return true;
    }

    //是否为本公司的人
    public function is_user_driver($id, $driver_id)
    {
        $arrObdId = explode(',', $driver_id);
        $conn = db('chegong_merchant');
        foreach ($arrObdId as $item) {
            $res = $conn->table('t_driver_info')
                ->where('id', $item)
                ->where('merchant_id', 'in', $id)
                ->find();
            if (empty($res)) {
                return false;
            }
        }
        return true;
    }

    //实时位置
    public function positionList($id)
    {
        $where['a.source'] = 1;
        $where['a.obd_id'] = ['neq', ''];
        $where['a.longitude'] = ['neq', 0];
        $res['position'] = db('chegongbao')
            ->table('chegong_merchant.t_car_info')->alias('c')->field([
                "ifnull(c.plate_num,'') plate_num",
                "ifnull(c.obd_id,'') obd_id",
                "a.user_id",
                "a.longitude",
                "a.latitude",
                "a.date",
                "ifnull(a.address,'') address",
                "ifnull(e.error_code,'') error_code",
                "ifnull(d.name,'') name"
            ])
            ->join('chegongbao.t_map_position_last a', 'a.obd_id=c.obd_id', 'left')
            ->join('chegong_merchant.t_obd_err_code e', 'a.obd_id = e.obd_id', 'left')
            ->join('chegong_merchant.t_driver_info d', 'a.user_id=d.id', 'left')
            ->where($where)
            ->where('c.merchant_id', 'in', $id)
            ->select();
        $BeginDates = date('Y-m-01', strtotime(date("Y-m-d")));
        $BeginDatedatee = date('Y-m-d', strtotime("$BeginDates +1 month -1 day"));
        $car_list = $this->car_list($id)['obd_id'];
        $where['obd_id'] = ['in', $car_list];
        $where['current_start_time'] = ['between', [$BeginDates, $BeginDatedatee]];
        $rgent_speed = db('chegongbao')
            ->table('chegongbao.app_rundata_cdr_t')
            ->field([
                "sum(ifnull(rapid_acceleration_count,0)) rapid_acceleration_count",
                "sum(ifnull(rapid_deceleration_count,0)) rapid_deceleration_count"
            ])
            ->where('obd_id', 'in', $car_list)
            ->find();
        $res['rgentSpeed'] = $rgent_speed;
        return $res;
    }

    //窗体信息
    public function underway($obd_id)
    {
        $underway = Db::connect('chegongbao');
        $where['obd_id'] = $obd_id;
        $where['user_id'] = ['neq', ''];
        $rst = $underway
            ->table('app_rundata_ssd')
            ->field([
                "ifnull(current_start_time,'') current_start_time",
                "ifnull(current_run_time,'') current_run_time",
                "ifnull(current_mileage,'') current_mileage",
                "ifnull(current_oil,'') current_oil",
                "ifnull(current_average_speed,'') current_average_speed",
                "ifnull(current_speed,'') current_speed",
                "ifnull(current_100km_oil,'') current_100km_oil"
            ])
            ->where($where)
//            ->fetchSql(true)
            ->order('current_end_time', 'desc')
            ->find();
        return $rst;
    }

    //轨迹列表
    public function tripList($id, $type, $page, $obd_id, $driver_id, $start_time, $end_time)
    {
        $page_step = 10;
        $page_start = ($page - 1) * $page_step;
        $page = $page_start . "," . $page_step;
        if (!empty($start_time) && !empty($end_time)) {
            if ($start_time == $end_time) {
                $end_time = date('Y-m-d', strtotime(' + 1 day', strtotime($start_time)));
            }
            $where['a.current_start_time'] = ['between', [$start_time, $end_time]];
        }
        $where['a.user_id'] = ['neq', ''];
        switch ($type) {
            case 'Driver':
                if (empty($driver_id)) {
                    $driver_id = $this->driver_list($id)['id'];
                }
                $where['a.user_id'] = ['IN', $driver_id];
                break;
            case 'Car':
                if (empty($obd_id)) {
                    $obd_id = $this->car_list($id)['obd_id'];
                }
                $where['a.obd_id'] = ['IN', $obd_id];
                break;
            case 'NoType':
                $car_list = $this->car_list($id)['obd_id'];
                $where['a.obd_id'] = ['IN', $car_list];
                break;
            default:
                return null;
        }
        $connect = Db::connect('chegongbao');
        $where['a.is_set'] = 1;
        $where['a.source'] = 1;
        $res = $connect
            ->table('chegongbao.app_rundata_cdr_t')->alias('a')->field([
                'a.obd_id',
                'a.user_id',
                "ifnull(a.current_start_time,'') current_start_time",
                "ifnull(a.current_end_time,'') current_end_time",
                "ifnull(a.fuel_bills,'') fuel_bills ",
                "ifnull(a.current_mileage,'') current_mileage",
                "ifnull(a.current_100km_oil,'') current_100km_oil",
                "ifnull(a.start_place,'') start_place",
                "ifnull(a.end_place,'') end_place",
                "ifnull(v.brand,'无匹配车型') brand",
                "ifnull(v.series,'') series",
                'c.plate_num'
            ])
            ->join('chegong_merchant.t_car_info c', 'a.obd_id=c.obd_id', 'left')
            ->join('chegongbao.t_vin_shadow v', 'c.vin=v.vin', 'left')
            ->where($where)->order('a.current_start_time desc')->limit($page)->select();
        return $res;
    }

    //人车筛选列表

//    public function screenList($id, $type, $source = '')
//    {
//        switch ($type) {
//            case 'Driver':
//                $res = db('chegong_merchant')
//                    ->table('t_driver_info')
//                    ->alias('a')
//                    ->field(['a.merchant_id', 'a.name', 'u.username'])
//                    ->join('t_user u', 'a.merchant_id=u.id', 'left')
//                    ->order('a.create_time')
//                    ->where('a.merchant_id', 'in', $id)
////                    ->fetchSql(true)
//                    ->select();
//                break;
//            case 'Car':
//                $res = db('t_car_info')
//                    ->alias('a')
//                    ->field(['a.merchant_id', 'a.obd_id', 'a.plate_num', 'a.department_id', 'b.department_name', 'u.username'])
//                    ->join('t_department_info b', 'a.department_id = b.id and a.merchant_id = b.merchant_id', 'left')
//                    ->join('t_user u', 'a.merchant_id=u.id', 'left')
//                    ->order(['b.id', 'a.create_time'])
//                    ->where('a.merchant_id', 'in', $id)
////                    ->fetchSql(true)
//                    ->select();
//                break;
//            default:
//                return null;
//        }
//        if ($source == 'xcx') {
//            $list = [];
//            if (!empty($res)) {
//                foreach ($res as $item) {
//                    $list[$item['username']][$item['department_name']][] = $item;
//                }
//            }
//            return $list;
//
//
//        } else {
//            return $res;
//        }
//    }

    //公司列表
    public function merchantList($id)
    {
        $res = db('chegong_merchant')
            ->table('t_user')
            ->field(['id', 'username'])
            ->where('id', 'in', $id)
            ->select();
        return $res;
    }

    //部门列表
    public function departmentList($merchant_id)
    {
        $res = db('chegong_merchant')
            ->table('t_department_info')
            ->field(['id', 'department_name'])
            ->where('merchant_id', $merchant_id)
            ->select();
        return $res;
    }

    //人员列表
    public function driverList($merchant_id)
    {
        $res = db('chegong_merchant')
            ->table('t_driver_info')
            ->field(['id', 'name'])
            ->where('merchant_id', $merchant_id)
            ->select();
        return $res;
    }

    //车列表
    public function carList($deparment_id)
    {
        $res = db('chegong_merchant')
            ->table('t_car_info')
            ->field(['id', 'obd_id', 'plate_num'])
            ->where('department_id', $deparment_id)
            ->select();
        return $res;
    }

    //轨迹
    public function currentList($obd_id, $date)
    {
        $where['current_start_time'] = $date;
        $where['obd_id'] = $obd_id;
        $where['end_latitude'] = ['neq', '0'];
        $where['end_longitude'] = ['neq', '0'];
        $where['source'] = 1;
        $where['is_online'] = 0;
        $connect = Db::connect('chegongbao');
        $res = $connect
            ->table('app_rundata_cdr_n')
            ->field(["end_longitude lon", "end_latitude lat"])
            ->where($where)
            ->order('current_end_time')
            ->select();
        if (empty($res)) {
            $position = [];
        } else {
            foreach ($res as $key => $value) {
                $position[$key]['lon'] = strval($value['lon']);
                $position[$key]['lat'] = strval($value['lat']);
            }
        }

//        foreach ($res as $key => $value) {
//            if (!isset($position)) {
//                $position[] = $value['end_longitude'] . ',' . $value['end_latitude'];
//            } else {
//                $position[] = $value['end_longitude'] . ',' . $value['end_latitude'];
//            }
//        }
//        $position = implode('|', $position);
//        $position = (array)$this->post_amaps($position);
//        $position = explode(';', $position['locations']);
        $where['is_set'] = 1;
        $res = $connect
            ->table('app_rundata_cdr_t')
            ->field([
                'obd_id',
                'user_id',
                "ifnull(fuel_bills,'') fuel_bills",
                "ifnull(current_car_driving_Time,'') current_car_driving_Time",
                "ifnull(current_travel_time,'') current_travel_time",
                "ifnull(current_mileage,'') current_mileage",
                "ifnull(current_average_speed,'') current_average_speed",
                "ifnull(current_most_speed,'') current_most_speed",
                "ifnull(current_oil,'') current_oil",
                "ifnull(current_100km_oil,'') current_100km_oil",
                "ifnull(current_start_time,'') current_start_time",
                "ifnull(current_end_time,'') current_end_time"
            ])
            ->where($where)
            ->find();
        $res['position'] = $position;
        return $res;
    }

    //费用
    public function cost($id, $type, $cost_type, $car_id, $driver_id, $page = 1)
    {
        $page_num = 10;
        $page_start = ($page - 1) * $page_num;
        $page_end = $page * $page_num - 1;
        $page = $page_start . "," . $page_end;
        switch ($type) {
            case 'Driver':
                $where['a.driver_id'] = ['IN', $driver_id];
                break;
            case 'Car':
                $where['a.car_id'] = ['IN', $car_id];
                break;
            case 'NoType':
                $car_list = $this->car_list($id)['car_id'];
                $where['a.car_id'] = ['IN', $car_list];
                break;
            default:
                return null;
        }
        $where['cost_type'] = $cost_type;
        $res = db('chegong_merchant')
            ->table('t_cost_info')
            ->alias('a')
            ->join('t_car_info c', 'a.car_id=c.id')
            ->join('t_driver_info d', 'a.driver_id=d.id')
            ->field('a.driver_id,a.car_id,a.accident_cost,a.cost_type,a.car_describe,a.add_time,c.plate_num,c.obd_id,d.name')
            ->where($where)
            ->order('add_time', 'DESC')
            ->limit($page)
            ->select();
        return $res;
    }

    //kpi
    public function kpi($id, $driver_id, $start_time, $end_time)
    {
        $where['a.user_id'] = ['neq', ''];
        if (!empty($driver_id)) {
            $where['a.user_id'] = ['IN', $driver_id];
        } else {
            $car_list = $this->car_list($id)['obd_id'];
            $driver_id = $this->driver_list($id)['id'];
            $where['a.obd_id'] = ['IN', $car_list];
        }
        if ($start_time == $end_time) {
            $end_time = date('Y-m-d', strtotime(' + 1 day', strtotime($start_time)));
        }
        $where['a.is_set'] = 1;
        $where['a.source'] = 1;
        $where['a.current_start_time'] = ['between', [$start_time, $end_time]];
        $connect = Db::connect('chegongbao');
        $time = $connect
            ->table('app_rundata_cdr_t')->alias('a')
            ->field([
                "ifnull(sum(a.current_car_driving_time),'') current_car_driving_time",
                "ifnull(sum(a.current_travel_time),'') current_travel_time",
                "ifnull(sum(a.current_run_time),'') current_run_time"
            ])
            ->where($where)
            ->select();
        $mileage = $connect
            ->table('chegongbao.app_rundata_cdr_t')->alias('a')
            ->field(["sum(a.current_mileage) current_mileage", "ifnull(c.plate_num,'') plate_num"])
            ->group('a.obd_id')
            ->join('chegong_merchant.t_car_info c', 'a.obd_id=c.obd_id', 'left')
            ->where($where)
            ->select();
        $weizhang = $this->cost($id, 'Driver', '0', '', $driver_id, 1);
        $shigu = $this->cost($id, 'Driver', '1', '', $driver_id, 1);
        $res['illegal'] = empty($weizhang) ? [] : $weizhang;
        $res['accident'] = empty($shigu) ? [] : $shigu;;
        $res['time'] = empty($time) ? '' : $time[0];
        $res['mileage'] = empty($mileage) ? [] : $mileage;
        return $res;
    }

    //驾驶分析
    public function analysis($id, $driver_id, $start_time, $end_time)
    {
        if (empty($driver_id)) {
            $driver_list = $this->driver_list($id)['id'];
        } else {
            $driver_list = $driver_id;
        }
        if ($start_time == $end_time) {
            $end_time = date('Y-m-d', strtotime(' + 1 day', strtotime($start_time)));
        }
        $where['user_id'] = ['IN', $driver_list];
        $where['is_set'] = 1;
        $where['source'] = 1;
        $where['current_start_time'] = ['between', [$start_time, $end_time]];
        $connect = Db::connect('chegongbao');
        $res = $connect
            ->table('app_rundata_cdr_t')
            ->field([
                "sum(current_60_metres) current_60_metres",
                "sum(current80_60_metres) current80_60_metres",
                "sum(current100_80_metres) current100_80_metres",
                "sum(current120_100_metres) current120_100_metres",
                "sum(current140_120_metres) current140_120_metres",
                "sum(current140_metres) current140_metres",
                "sum(current_mileage) current_mileage",
                "sum(current_oil) current_oil",
                "sum(fuel_bills) fuel_bills",
                "avg(current_average_speed) current_average_speed"
            ])
            ->where($where)
            ->select();
        return $res[0];
    }

    //油耗统计
    public function oil($id, $obd_id, $start_time, $end_time)
    {
        if (empty($obd_id)) {
            $car_list = $this->car_list($id)['obd_id'];
        } else {
            $car_list = $obd_id;
        }
        if ($start_time == $end_time) {
            $end_time = date('Y-m-d', strtotime(' + 1 day', strtotime($start_time)));
        }
        $where['a.obd_id'] = ['IN', $car_list];
        $where['is_set'] = 1;
        $where['source'] = 1;
        $where['user_id'] = ['neq', ''];
        $where['current_start_time'] = ['between', [$start_time, $end_time]];
        $connect = Db::connect('chegongbao');
        $res = $connect
            ->table('chegong_merchant.t_car_info')
            ->alias('a')
            ->join('chegongbao.app_rundata_cdr_t t', 'a.obd_id=t.obd_id', 'left')
            ->field([
                "a.obd_id",
                "a.plate_num",
                "ifnull(t.current_mileage,'') current_mileage",
                "ifnull(t.current_oil,'') current_oil",
                "ifnull(t.fuel_bills,'') fuel_bills"
            ])
            ->where($where)
            ->select();
        if (empty($res)) {
            exit(json_encode(['status' => 2, 'msg' => '数据为空'], JSON_UNESCAPED_UNICODE));
        } else {
            $list = [];
            $list['mileage'] = 0;
            $list['oil'] = 0;
            $list['bills'] = 0;
            foreach ($res as $item) {
                if (empty($data[$item['obd_id']])) {
                    $data[$item['obd_id']]['current_mileage'] = floatval($item['current_mileage']);
                    $data[$item['obd_id']]['current_oil'] = floatval($item['current_oil']);
                    $data[$item['obd_id']]['fuel_bills'] = floatval($item['fuel_bills']);
                    $data[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list['mileage'] += $item['current_mileage'];
                    $list['oil'] += $item['current_oil'];
                    $list['bills'] += $item['fuel_bills'];
                } else {
                    $data[$item['obd_id']]['current_mileage'] += $item['current_mileage'];
                    $data[$item['obd_id']]['current_oil'] += $item['current_oil'];
                    $data[$item['obd_id']]['fuel_bills'] += $item['fuel_bills'];
                    $data[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list['mileage'] += $item['current_mileage'];
                    $list['oil'] += $item['current_oil'];
                    $list['bills'] += $item['fuel_bills'];
                }
            }
            foreach ($data as $key => $value) {
                $list['data'][] = $value;
            }
        }
        return $list;
    }
}