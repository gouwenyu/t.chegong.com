<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/20
 * Time: 21:45
 */

namespace app\index\controller;

use app\index\model\User;
use think\Db;
use app\common\controller\Check as check;

class DriverInfo extends check
{

    public function kpi()
    {
        $id = $this->sid;
        $user = new User();
        $driver_list = $user->driver_list($id);
        $driver_cost0 = $user->driver_cost($id, 0);
        $driver_cost1 = $user->driver_cost($id, 1);
        $list = [];
        foreach ($driver_list as $item) {
            $list[$item['merchant_id']][] = $item;
        }
        $num0 = 0;
        $num1 = 0;
        $time0 = 0;
        $time1 = 0;
        foreach ($driver_cost0 as $val) {
            foreach ($val[0] as $v) {
                if ($v['id'] !== null) {
                    $num0++;
                    $add_time0 = strtotime($v['add_time']);
                    if ($add_time0 > $time0) {
                        $time0 = $add_time0;
                    }
                }
            }
        }
        foreach ($driver_cost1 as $val) {
            foreach ($val[1] as $v) {
                if ($v['id'] !== null) {
                    $num1++;
                    $add_time1 = strtotime($v['add_time']);
                    if ($add_time1 > $time1) {
                        $time1 = $add_time1;
                    }
                }
            }
        }
        $time0 = empty($time0) ? '无' : date('Y-m-d', $time0);
        $time1 = empty($time1) ? '无' : date('Y-m-d', $time1);
        $time = [$time0, $time1];
        $num = [$num0, $num1];
        $this->assign('list', $list);
        $this->assign('num', $num);
        $this->assign('time', $time);
        $this->assign('driver_cost0', $driver_cost0);
        $this->assign('driver_cost1', $driver_cost1);
        return view('kpi');
    }

    public function history()
    {
        $id = $this->sid;
        $user = new User();
        $driver_list = $user->driver_list($id);
        $dlist = [];
        foreach ($driver_list as $item) {
            $dlist[$item['merchant_id']][] = $item;
        }
        $car_list = $user->car_list($id);
        $clist = [];
        $username = [];
        foreach ($car_list as $item) {
            $clist[$item['merchant_id']][$item['department_id']][] = $item;
            $username[$item['merchant_id']] = $item['username'];
        }
        $this->assign('dlist', $dlist);
        $this->assign('clist', $clist);
        $this->assign('user_name', $username);
        return view('history');
    }
    public function analysis()
    {
        $id = $this->sid;
        $user = new User();
        $driver_list = $user->driver_list($id);
        $list = [];
        foreach ($driver_list as $item) {
            $list[$item['merchant_id']][] = $item;
        }
        $this->assign('list', $list);
        return view('analysis');
    }

    public function oil()
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
        $this->assign('list', $list);
        $this->assign('user_name', $username);
        return view('oil');
    }

    public function driver_more()
    {
        $driver_id = input('post.driver_id');
        $type = input('post.type');
        $id = $this->sid;
        $user = new User();
        $user->driver_more($id, $type, $driver_id, false);
    }

    public function mc_drivermore()
    {
        $merchant_id = input('post.mc_id');
        $type = input('post.type');
        $type = intval(trim($type));
        $merchantId = $this->sid;
        if (strpos($merchantId, $merchant_id) === false) {     //使用绝对等于
            //不包含
            $this->make_json_error('请勿非法操作');
        }
        $list = Db::query("
            select d.id,d.did,d.name,d.car_id cid,d.accident_cost,d.cost_type,d.car_describe,d.add_time,d.create_time,e.plate_num from (
            select c.*,b.did,b.name,b.mer_id from (
            select a.id did,a.name,a.merchant_id mer_id from t_driver_info a where merchant_id = '$merchant_id') b
            left join t_cost_info c 
            on(b.did=c.driver_id and b.mer_id=c.merchant_id and c.cost_type=$type)) d 
            left join t_car_info e 
            on(d.car_id = e.id and d.mer_id=e.merchant_id) order by create_time desc;
            ");
        if ($list) {
            $num = 0;
            $time = 0;
            foreach ($list as $v) {
                if ($v['id'] !== null) {
                    $num++;
                    $add_time = strtotime($v['add_time']);
                    if ($add_time > $time) {
                        $time = $add_time;
                    }
                }
            }
            $time = empty($time) ? '无' : date('Y-m-d', $time);
            exit(json_encode(['error' => 0, 'msg' => $list, 'num' => $num, 'add_time' => $time]));
        } else {
            exit(json_encode(['error' => 1, 'msg' => '无车辆']));
        }
    }

    public function current()
    {
        $obd_id = input('request.user_o');
        $user = input('request.user_i');
        $s_time = input('request.time_s');
        $e_time = input('request.time_e');
        $merchant_id = input('post.mc_id');
        if (!empty($s_time) && !empty($e_time)) {
            $s = strtotime($s_time);
            $e = strtotime($e_time);

            if ($s > $e) {
                exit(json_encode('请勿非法操作'));
            }
            $current = Db::connect('chegongbao');
            $merchant = Db::connect('chegong_merchant');
            if (!empty($obd_id)) {
	                $rst = $current
	                    ->table('app_rundata_cdr_n')
	                    ->field('user_id,vin,obd_id,end_longitude longitude,end_latitude latitude,current_start_time,current_end_time')
	                    ->where('obd_id', 'in', $obd_id)
	                    ->where('source', 'eq', 1)
	                    ->where('end_longitude', 'neq', '0')
	                    ->where('current_start_time', 'between', [$s_time, $e_time])
	                    ->order('current_end_time')
	                    ->select();
            } elseif (!empty($user)) {
                    $rst = $current
                        ->table('app_rundata_cdr_n')
                        ->field('user_id,vin,obd_id,end_longitude longitude,end_latitude latitude,current_start_time,current_end_time')
                        ->where('user_id', 'in', $user)
                        ->where('obd_id', 'neq', '')
                        ->where('end_longitude', 'neq', '0')
                        ->where('source', 'eq', 1)
                        ->where('current_start_time', 'between', [$s_time, $e_time])
                        ->order('obd_id')
                        ->order('current_end_time')
                        ->select();                        
            } elseif (!empty($merchant_id)) {
                $merchantId =$this->sid;
                if (strpos($merchantId, $merchant_id) === false) {     //使用绝对等于
                    //不包含
                    $this->make_json_error('请勿非法操作');
                }
                $res = db('t_driver_info')
                    ->field('id')
                    ->where('merchant_id', $merchant_id)
                    ->select();
                foreach ($res as $item) {
                    $driverList[] = "'" . $item['id'] . "'";
                }
                $user_id = implode(',', $driverList);
                $rst = $current
                    ->table('app_rundata_cdr_n')
                    ->field('user_id,vin,obd_id,end_longitude longitude,end_latitude latitude,current_start_time,current_end_time')
                    ->where('user_id', 'in', $user_id)
                    ->where('obd_id', 'neq', '')
                    ->where('end_longitude', 'neq', '0')
                    ->where('source', 'eq', 1)
                    ->where('current_start_time', 'between', [$s_time, $e_time])
                    ->order('obd_id')
                    ->order('current_end_time')
                    ->select();
            } else {
                exit(json_encode('参数为空,谨慎操作'));
            }
            if ($rst) {
                $msg = [];
                foreach ($rst as $key => $value) {
                    $t = md5(strtotime($value['current_start_time']) . $value['obd_id']);
                    if (!isset($msg[$t])) {
                        $msg[$t][] = $value['longitude'] . ',' . $value['latitude'];
                        $msg[$t]['start_time'] = $value['current_start_time'];
                        $msg[$t]['obd_id'] = $value['obd_id'];
                        $msg[$t]['user_id'] = $value['user_id'];
                    } else {
                        $msg[$t][] = $value['longitude'] . ',' . $value['latitude'];
                        $msg[$t]['end_time'] = $value['current_end_time'];
                    }
                }
                $keys = array_keys($msg);
                foreach ($keys as $item) {
                    $msg1['obd_id'] = $msg[$item]['obd_id'];
                    $msg1['user_id'] = $msg[$item]['user_id'];
                    $msg1['start_time'] = $msg[$item]['start_time'];
                    $msg1['end_time'] = isset($msg[$item]['end_time']) ? $msg[$item]['end_time'] : $msg1['start_time'];
                    unset($msg[$item]['start_time'], $msg[$item]['end_time'], $msg[$item]['obd_id'], $msg[$item]['user_id']);
                    $msg[$item] = implode('|', $msg[$item]);
                    $msg[$item] = (array)$this->post_amaps($msg[$item]);
                    $msg[$item] = explode(';', $msg[$item]['locations']);
                    $msg[$item]['start_time'] = $msg1['start_time'];
                    $msg[$item]['end_time'] = $msg1['end_time'];
                    $msg[$item]['obd_id'] = $msg1['obd_id'];
                    $msg[$item]['user_id'] = $msg1['user_id'];
                }
                foreach ($keys as $time) {
                    if (count($msg[$time]) < 8) {
                        unset($msg[$time]);
                    }
                }
                exit(json_encode($msg));
            } else {
                exit($this->make_json_error('没有轨迹'));
            }               
        } else {
            exit($this->make_json_error('请规范操作'));
        }
    }

    public function drive_time()
    {
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $driver_id = input('post.driver_id');
        $id = $this->sid;
        $user = new User();
        if (empty($start_time) || empty($end_time)) {
            $this->make_json_error('获取时间失败，请规范操作');
        } else {
            if ($start_time >= $end_time) {
                $user->drive_time($id, $driver_id, $end_time, $start_time);
            } else {
                $user->drive_time($id, $driver_id, $start_time, $end_time);

            }
        }
    }

    public function mc_drivetime()
    {
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $merchant_id = input('post.mc_id');
        $merchantId = $this->sid;
        if (strpos($merchantId, $merchant_id) === false) {     //使用绝对等于
            //不包含
            $this->make_json_error('请勿非法操作');
        }
        if (empty($start_time) || empty($end_time)) {
            $this->make_json_error('获取时间失败，请规范操作');
        } else {
            if ($start_time >= $end_time) {
                $t = $start_time;
                $start_time = $end_time;
                $end_time = $t;
            }
            $rst = db('t_driver_info')
                ->field('id')
                ->where('merchant_id', $merchant_id)
                ->select();
            foreach ($rst as $item) {
                $driverList[] = "'" . $item['id'] . "'";
            }
            $user_id = implode(',', $driverList);
            $res = Db::query("
                select sum(t.current_run_time) as 'current_travel_time',sum(t.current_car_driving_time) as 'current_car_driving_time' 
                from chegongbao.app_rundata_cdr_t t 
                where t.user_id in($user_id) and t.is_set=1 and t.source=1 and t.current_start_time between '$start_time' and '$end_time'
            ");
            if (!empty($res[0])) {
                exit(json_encode(['error' => 0, 'msg' => $res[0]]));
            } else {
                exit(json_encode(['error' => 1, 'msg' => '请规范操作']));
            }
        }
    }

    public function mileage()
    {
        $id = $this->sid;
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $driver_id = input('post.driver_id');
        if (empty($start_time) || empty($end_time)) {
            $this->make_json_error('获取里程失败，请规范操作');
        } else {
            $user = new User();
            if ($start_time >= $end_time) {
                $user->drive_mileage($id, $driver_id, $end_time, $start_time);
            } else {
                $user->drive_mileage($id, $driver_id, $start_time, $end_time);
            }
        }
    }

    public function mc_mileage()
    {
        $merchantId = $this->sid;
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $merchant_id = input('post.mc_id');
        if (strpos($merchantId, $merchant_id) === false) {     //使用绝对等于
            //不包含
            $this->make_json_error('请勿非法操作');
        }
        if (empty($start_time) || empty($end_time)) {
            $this->make_json_error('获取里程失败，请规范操作');
        } else {
            if ($start_time >= $end_time) {
                $t = $start_time;
                $start_time = $end_time;
                $end_time = $t;
            }
            $rst = db('t_driver_info')
                ->field('id')
                ->where('merchant_id', $merchant_id)
                ->select();
            foreach ($rst as $item) {
                $driverList[] = "'" . $item['id'] . "'";
            }
            $user_id = implode(',', $driverList);
            $res = Db::query("
                    select c.plate_num,c.car_name,a.* from chegong_merchant.t_car_info c right join(
                    select sum(t.current_mileage)/1000 as 'current_mileage',t.obd_id from chegongbao.app_rundata_cdr_t t 
                    where t.user_id in($user_id) and t.is_set=1 and t.source=1 and t.current_start_time between '$start_time' and '$end_time' group by t.obd_id) a
                    on (a.obd_id=c.obd_id)
                ");
            if (is_array($res)) {
                exit(json_encode(['error' => 0, 'msg' => $res]));
            } else {
                exit(json_encode(['error' => 1, 'msg' => '请规范操作']));
            }
        }
    }

    public function speed()
    {
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $merchant_id = input('post.mc_id');
        if (strtotime($start_time) && strtotime($end_time)) {
            $driver_id = input('post.driver_id');
            $id = $this->sid;
            $user = new User();
            if ($start_time >= $end_time) {
                $user->drive_speed($id, $driver_id, $end_time, $start_time, $merchant_id);
            } else {
                $user->drive_speed($id, $driver_id, $start_time, $end_time, $merchant_id);
            }
        } else {
            $this->make_json_error('日期格式不正确，请规范操作');
        }
    }

    public function driveData()
    {

        $obd_id = input('post.oid');
        $partment_id = input('post.partmentid');
        $subsidiary_id = input('post.subsidiaryid');
        $start_time = strtotime(input('post.stime'))*1000;
        $end_time = strtotime(input('post.etime'))*1000;
        $id = $this->sid;
        if (empty($obd_id) && empty($partment_id) && empty($subsidiary_id)) {
            $where = " a.merchant_id in ($id) ";
        } elseif (!empty($subsidiary_id)) {
            $where = " a.merchant_id in ('$subsidiary_id') ";
        } elseif (!empty($partment_id)) {
            $where = " a.merchant_id in ($id) and a.department_id='$partment_id' ";
        } else {
            $where = " a.merchant_id in ($id) and a.obd_id='$obd_id' ";
        }
//        $res = Db::query("
//            select c.*,t.current_mileage,t.current_oil,t.fuel_bills,u.username from (
//            select a.obd_id,a.plate_num,a.department_id,b.department_name,a.merchant_id from
//            chegong_merchant.t_car_info a
//            left join chegong_merchant.t_department_info b
//            on (a.department_id = b.id and a.merchant_id = b.merchant_id) where $where) c
//            left join chegongbao.app_rundata_cdr_t t on (c.obd_id=t.obd_id and t.is_set=1 and t.user_id<>'' and t.current_start_time between '$start_time' and '$end_time')
//            left join chegong_merchant.t_user u on (c.merchant_id=u.id)
//        ");
        try {
            $res = Db::query("
            select c.*,t.fuel current_oil,t.mileage current_mileage,t.accelerateTimes,t.dccelerateTimes,t.sharpTurnTimes,u.username from (
            select a.openCarId,a.obd_id,a.plate_num,a.department_id,b.department_name,a.merchant_id from  
            chegong_merchant.t_car_info a 
            left join chegong_merchant.t_department_info b 
            on (a.department_id = b.id and a.merchant_id = b.merchant_id) where $where) c 
            left join chegongbao.kartor_cstdp_0006 t on (
            c.openCarId=t.openCarId and t.travelType=1 and t.openId<>'' and t.mileage>0 and t.startTime > '$start_time' and t.startTime < '$end_time') 
            left join chegong_merchant.t_user u on (c.merchant_id=u.id)
        ");
        }catch (Exception $exception){
            Log::record($exception->getMessage(),"ErrorSql");
            exit("请联系管理员");
        }
        if (empty($res)) {
            $this->make_json_response('暂无数据', 1);
        } else {
            $list = [];
            foreach ($res as $item) {
                if (empty($list[$item['obd_id']])) {
                    $list[$item['obd_id']]['current_mileage'] = $item['current_mileage'];
                    $list[$item['obd_id']]['current_oil'] = $item['current_oil'];
                    $list[$item['obd_id']]['accelerateTimes'] = $item['accelerateTimes'];
                    $list[$item['obd_id']]['dccelerateTimes'] = $item['dccelerateTimes'];
                    $list[$item['obd_id']]['sharpTurnTimes'] = $item['sharpTurnTimes'];
                    $list[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list[$item['obd_id']]['department_id'] = $item['department_id'];
                    $list[$item['obd_id']]['merchant_id'] = $item['merchant_id'];
                    $list[$item['obd_id']]['department_name'] = $item['department_name'];
                    $list[$item['obd_id']]['username'] = $item['username'];
                } else {
                    $list[$item['obd_id']]['current_mileage'] += $item['current_mileage'];
                    $list[$item['obd_id']]['current_oil'] += $item['current_oil'];
                    $list[$item['obd_id']]['accelerateTimes'] += $item['accelerateTimes'];
                    $list[$item['obd_id']]['dccelerateTimes'] += $item['dccelerateTimes'];
                    $list[$item['obd_id']]['sharpTurnTimes'] += $item['sharpTurnTimes'];
                    $list[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list[$item['obd_id']]['department_id'] = $item['department_id'];
                    $list[$item['obd_id']]['merchant_id'] = $item['merchant_id'];
                    $list[$item['obd_id']]['department_name'] = $item['department_name'];
                    $list[$item['obd_id']]['username'] = $item['username'];
                }
            }
//            $d = [];
//            if (!empty($partment_id)) {
//                foreach ($list as $k => $v) {
//                    if (empty($d[$v['department_id']])) {
//                        $d[$v['department_id']]['current_mileage'] = $v['current_mileage'];
//                        $d[$v['department_id']]['current_oil'] = $v['current_oil'];
//                        $d[$v['department_id']]['fuel_bills'] = $v['fuel_bills'];
//                    } else {
//                        if ($d[$v['department_id']] == $v['department_id']) {
//                            $d[$v['department_id']]['current_mileage'] += $v['current_mileage'];
//                            $d[$v['department_id']]['current_oil'] += $v['current_oil'];
//                            $d[$v['department_id']]['fuel_bills'] += $v['fuel_bills'];
//                        }
//                    }
//                }
//            }            
            $this->make_json_error($list, 0);
        }
    }

    public function currentInfo()
    {
        $obd_id = input('request.oid');
        $start_time = input('request.stime');
        $start_times = date("Y-m-d",strtotime($start_time));
        // $this->make_json_error($obd_id);
        // if( $obd_id == "491084ad00e05309a90399461ed6de6a" ){
           $conn = Db::connect("chegong_merchant");
           $res = $conn->table("t_car_info")
                 ->alias("c")
                 ->field("info.name,info.mobile,c.plate_num,min(k.create_date) current_start_time,max(k.create_date) current_end_time")
                 ->join("t_driver_info info","c.obd_mac = info.id","left")
                 ->join("chegongbao.kartor_cstdp_0007 k","info.id = k.openCarId","left")
                 ->where(array("c.obd_id"=>array("eq",$obd_id),"k.create_date"=>array("like","%".$start_times."%")))
                 ->find();
        /*} else {
         $where['a.obd_id'] = $obd_id;
         $where['a.current_start_time'] = $start_time;
         $where['a.source'] = 1;
         $conn = Db::connect("chegongbao");
         $res = $conn->table('chegongbao.app_rundata_cdr_t')
            ->alias('a')
            ->field(['d.name', 'd.mobile', 'c.plate_num', 'a.current_start_time', 'a.current_end_time'])
            ->join('chegong_merchant.t_car_info c', 'a.obd_id=c.obd_id', 'left')
            ->join('chegong_merchant.t_driver_info d', 'a.user_id=d.id', 'left')
            ->where($where)
            ->find();       	
        }*/
        exit(json_encode($res, JSON_UNESCAPED_UNICODE));
    }
}