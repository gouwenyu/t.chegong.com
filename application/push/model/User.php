<?php

/**
 * Created by PhpStorm.
 * User: xd
 * Date: 2017/6/6
 * Time: 19:34
 */
namespace app\push\model;
use think\Model;
use think\Db;
class User extends Model
{
//Db::table('think_artist')
//->alias('a')
//->join('think_work w','a.id = w.artist_id')
//->join('think_card c','a.card_id = c.id')
//->select();

//index
    //车列表
    public function car_list($id){
        $car_list = Db::query("SELECT a.*,b.department_name FROM  t_car_info a LEFT JOIN t_department_info b ON (a.department_id = b.id AND a.merchant_id = b.merchant_id) where a.merchant_id='$id' order by b.id,a.create_time");
        echo $car_list;
        return $car_list;
    }
    //30天平均油耗
    public function oil($id){
//        $a =time();$b = date('Y-m-d', $a-2592000);$c = date('Y-m-d',$a);
        $a =time();$b = date('Y-m-d', $a-2592000);$c = date('Y-m-d',$a);
        $oil = Db::query("
        SELECT c.name,c.obd_id,AVG(n.current_100km_oil) AS 'value' FROM ( 
        SELECT  a.plate_num AS 'name',a.obd_id FROM chegong_merchant.t_car_info a WHERE a.merchant_id='$id') c
        LEFT JOIN chegongbao.app_rundata_cdr_t n ON (n.obd_id=c.obd_id and n.is_del=0)		
        AND n.is_set='1' AND n.current_start_time BETWEEN '$b' AND '$c'
        GROUP BY n.obd_id
        ");
        return $oil;
    }
    //车辆使用率
    public function utilization ($id,$type='') {
        $sum = Db::query("select count(id) sum from t_car_info where merchant_id='$id'");
        if (!empty($sum[0]['sum'])){
            $utilization = Db::query("select count(car_id) u from t_mileage_center where merchant_id='$id' and use_car_state=1");
            $utilization_rate = round($utilization[0]['u']/$sum[0]['sum']*100,2);
            if (empty($type)) {
                exit(json_encode(['error'=>0,'msg'=>$utilization_rate.'%']));
            }else{
                return ['error'=>0,'msg'=>$utilization_rate];
            }
        }else{
            if (empty($type)) {
                exit(json_encode(['error'=>1,'msg'=>'无车辆']));
            }else{
                return ['error'=>1,'msg'=>'无车辆'];
            }
        }
    }
    //司机出勤率
    public function attendance ($id,$type='') {
        $sum = Db::query("select count(id) sum from t_driver_info where merchant_id='$id'");
        if (!empty($sum[0]['sum'])){
            $attendance = Db::query("select count(driver_id) u from t_mileage_center where merchant_id='$id' and use_car_state=1");
            $attendance_rate = round($attendance[0]['u']/$sum[0]['sum']*100,2);
            if (empty($type)) {
                exit(json_encode(['error'=>0,'msg'=>$attendance_rate.'%']));
            } else {
                return ['error'=>0,'msg'=>$attendance_rate];
            }
        }else{
            if (empty($type)) {
                exit(json_encode(['error'=>1,'msg'=>'无人员']));
            }else{
                return ['error'=>1,'msg'=>'无人员'];
            }
        }
    }
    //车辆故障率
    public function failure ($id,$type='') {
        $car = $this->error_car($id);
        $sum = Db::query("select count(id) sum from t_car_info where merchant_id='$id'");
        if (!empty($sum[0]['sum']) && !empty($car)){
            $err = Db::query("select count(*) sum from t_obd_err_code where obd_id in ($car)");
            $err_rate = round($err[0]['sum']/$sum[0]['sum']*100,2);
            if (empty($type)) {
                exit(json_encode(['error'=>0,'msg'=>$err_rate.'%']));
            }elseif($type === 2){
                return $err[0]['sum'];
            }else{
                return ['error'=>0,'msg'=>$err_rate];
            }
        }else{
            if (empty($type)) {
                exit(json_encode(['error'=>1,'msg'=>'无车辆']));
            }elseif($type === 2){
                return '无车辆';
            }else{
                return ['error'=>1,'msg'=>'无车辆'];
            }
        }
    }
    //窗体实时数据
    public function underway($obd_id)
    {
        $underway = Db::connect('chegongbao');
        $rst = $underway
            ->table('app_rundata_cdr_n')
            ->field(['current_start_time','current_travel_time','current_mileage','current_oil','current_average_speed','current_100km_oil'])
            ->where('obd_id',$obd_id)
            ->order('current_end_time','DESC')
//            ->fetchSql(true)
            ->find();
        exit(json_encode($rst));
    }
//Edit
    //车辆详细信息
    public function car_info($id)
    {
        $car_info = Db::query("select a.plate_num,a.car_name,b.* from  t_car_info a left join chegongbao.t_vin_shadow b on (a.vin = b.vin) where a.merchant_id='".$id."' order by plate_num");
        return $car_info;
    }
    //司机详细信息
    public function driver_list($id)
    {
        $driver_list = Db::query("select * from t_driver_info where merchant_id='$id' order by create_time,job_num");
        return $driver_list;
    }
    //部门详细信息
    public function department_list($id)
    {
        $department_list = Db::query("select * from t_department_info where merchant_id='".$id."'");
        return $department_list;
    }


//WarnCar
    //当前用户所有车辆obd_id
    public function error_car($id)
    {
        $c = Db::query("select obd_id,id from t_car_info where merchant_id='$id'");
        if (!empty($c)) {
            $car = null;
            foreach ($c as $key => $val) {
                if ($key < count($c) - 1) {
                    $car .= "'" . $val['obd_id'] . "',";
                } else {
                    $car .= "'" . $val['obd_id'] . "'";
                }
            }
            return $car;
        }else{
            return null;
        }
    }

    //故障车数量
    public function err_num($id){
        $error_car = $this->error_car($id);
        if(!empty($error_car)){
            $err = Db::query("select count(*) sum from t_obd_err_code where obd_id in ($error_car)");
            return $err;
        }else{
            return $err[0]['sum'] = 0;
        }
    }

    //故障车详细信息及故障信息
    public function err_info($id)
    {
        $error_car = $this->error_car($id);
        if (!empty($error_car)) {
            $err_info = Db::query("
            select f.*,g.name from (
            select d.*,e.department_name from (
            select c.id,c.plate_num,c.department_id,c.merchant_id,b.user_id,b.error_code,b.date from ( 
            select a.obd_id,a.user_id,a.date,a.error_code from t_obd_err_code a where a.obd_id in ($error_car)) b 
            left join t_car_info c on( b.obd_id = c.obd_id and c.merchant_id='$id')) d 
            left join t_department_info e on(d.department_id = e.id and d.merchant_id = e.merchant_id)) f 
            left join t_driver_info g on( f.user_id = g.id and f.merchant_id = g.merchant_id); 
            ");
            foreach ($err_info as $k => $v) {
                $error_code = explode(',', $v['error_code']);
                foreach ($error_code as $item) {
                    $rst = Db::query("select a.describe_cn from chegongbao.app_obd_code a where a.code ='$item'");
                    empty($rst) ?: $err_info[$k]['error_code'] = str_replace($item, $rst[0]['describe_cn'], $err_info[$k]['error_code']);
                }
            }
            return $err_info;
        }else{
            return null;
        }
    }

    //驾照过期提醒
     public function license_list($id){
         $license = Db::query("select job_num,name,card_id,enty_data,license_first,license_end from t_driver_info where merchant_id='$id' order by job_num");
         $license_list = [];
         if(!empty($license)){
             foreach ($license as $v){
                 $t = strtotime($v['license_end'])-time();
                 if($t<60*60*24*30){
                     $v['time'] =floor($t/(60*60*24));
                     $license_list[] =$v;
                 }
             }
         }
         return $license_list;
     }
 //CarManager
    //消费列表
    public function car_cost($id){
//        $rst = Db::query("
//        select d.*,e.name from (
//        select c.*,b.*from (
//        select a.id cid,a.plate_num,a.merchant_id mer_id from t_car_info a where merchant_id='$id') b
//        left join t_cost_info c
//        on(b.cid=c.car_id and b.mer_id=c.merchant_id)) d
//        left join t_driver_info e
//        on(d.driver_id = e.id and d.mer_id=e.merchant_id) order by cid asc,create_time desc;
//        ");
//        $cost_list = [];
//        foreach ($rst as $value){
//            $cost_list[$value['cid']][] = $value;
//        }
        $rst = Db::query("select a.id cid,a.plate_num,a.merchant_id mer_id from t_car_info a where merchant_id='$id'");
        $cost_list = [];
        if(!empty($rst)){
            foreach ($rst as $value){
                $cost_list[$value['cid']] =[];
                $cost_list[$value['cid']]['plate_num'] = $value['plate_num'];
                for($type=0;$type<6;$type++){
                    $cost_list[$value['cid']][$type] = $this->more($id,$type,$value['cid'],true);
                }
            }
        }
        return $cost_list;
    }
    public function driver_cost($id,$type){
        $rst = Db::query("select a.id did,a.name,a.merchant_id mer_id from t_driver_info a where merchant_id='$id'");
        $driver_cost = [];
        if(!empty($rst)){
            foreach ($rst as $value){
                $driver_cost[$value['did']] =[];
                $driver_cost[$value['did']][$type] = $this->driver_more($id,$type,$value['did'],true);
            }
        }
        return $driver_cost;
    }
    //Kpi获得司机的行驶总行驶时长和怠速时长
    public function drive_time($id,$driver_id=null,$start_time = '1970-01-01',$end_time = '1970-01-01')
    {
        if(!empty($driver_id)){
            $driver = " t.user_id='$driver_id' AND ";
            $car = '';
        }else{
            $car_id = $this->error_car($id);
            $car = "t.obd_id in($car_id) AND t.user_id<>'' and ";
            $driver= '';
        }
        $res = Db::query("
            select sum(t.current_travel_time) as 'current_travel_time',sum(t.current_car_driving_time) as 'current_car_driving_time',t.obd_id 
            from chegongbao.app_rundata_cdr_t t 
            where $driver t.is_set='1' and $car t.current_start_time between '$start_time' and '$end_time'
        ");
        if(!empty($res[0])){
            exit(json_encode(['error' => 0, 'msg' => $res[0]]));
        }else{
            exit(json_encode(['error' => 1, 'msg' => '请规范操作']));
        }
    }
    public function drive_mileage($id,$driver_id,$start_time,$end_time)
    {
        if(!empty($driver_id)){
            $driver = " t.user_id='$driver_id' AND ";
            $car = '';
        }else{
            $car_id = $this->error_car($id);
            $car = "t.obd_id in($car_id) AND t.user_id<>'' and ";
            $driver= '';
        }
        $res = Db::query("
            select c.plate_num,c.car_name,a.* from chegong_merchant.t_car_info c right join(
            select sum(t.current_mileage)/1000 as 'current_mileage',t.obd_id from chegongbao.app_rundata_cdr_t t 
            where $driver t.is_set='1' and $car t.source='1' and t.current_start_time between '$start_time' and '$end_time' group by t.obd_id) a
            on (a.obd_id=c.obd_id)
        ");
        if(is_array($res)){
            exit(json_encode(['error' => 0, 'msg' => $res]));
        }else{
            exit(json_encode(['error' => 1, 'msg' => '请规范操作']));
        }
    }
    public  function driver_more($id,$type,$user_id,$isUser){
        $type = intval(trim($type));
        $list = Db::query("
            SELECT d.id,d.did,d.name,d.car_id cid,d.accident_cost,d.cost_type,d.car_describe,d.add_time,d.create_time,e.plate_num FROM (
            SELECT c.*,b.did,b.name,b.mer_id FROM (
            SELECT a.id did,a.name,a.merchant_id mer_id FROM t_driver_info a WHERE merchant_id='$id' AND a.id='$user_id') b
            LEFT JOIN t_cost_info c 
            ON(b.did=c.driver_id AND b.mer_id=c.merchant_id AND c.cost_type=$type)) d 
            LEFT JOIN t_car_info e 
            ON(d.car_id = e.id AND d.mer_id=e.merchant_id) ORDER BY create_time DESC;
            ");
        if($isUser===true){
            if ($list){
                return $list;
            }else{
                return null;
            }
        }else{
            if ($list){
                $num = 0;
                $time = 0;
                foreach ($list as $v){
                    if($v['id']!==null){
                        $num++;
                        $add_time = strtotime($v['add_time']);
                        if($add_time>$time){
                            $time = $add_time;
                        }
                    }
                }
                $time = empty($time)?'无':date('Y-m-d',$time);
                exit(json_encode(['error'=>0,'msg'=>$list,'num'=>$num,'add_time'=>$time]));
            }else{
                exit(json_encode(['error'=>1,'msg'=>'无车辆']));
            }
        }
    }
    public  function driver_more_url($id,$type,$user_id,$isUser,$s_time,$e_time){
        $type = intval(trim($type));
        if($isUser===false) {
            $list = Db::query("
            select d.id,d.did,d.name,d.car_id cid,d.accident_cost,d.cost_type,d.car_describe,d.add_time,d.create_time,e.plate_num from (
            select c.*,b.did,b.name,b.mer_id from (
            select a.id did,a.name,a.merchant_id mer_id from t_driver_info a where merchant_id='$id' and a.id='$user_id'between $s_time and $e_time) b 
            left join t_cost_info c 
            on(b.did=c.driver_id and b.mer_id=c.merchant_id and c.cost_type=$type and c.create_time between '$s_time' and '$e_time')) d 
            left join t_car_info e 
            on(d.car_id = e.id and d.mer_id=e.merchant_id) order by create_time desc;
            ");
            if ($list) {
                $num = 0;
                $time = 0;
                foreach ($list as $v){
                    if($v['id']!==null){
                        $num++;
                        $add_time = strtotime($v['add_time']);
                        if($add_time>$time){
                            $time = $add_time;
                        }
                    }
                }
                $time = empty($time)?'无':date('Y-m-d',$time);
                exit(json_encode(['error'=>0,'msg'=>$list,'num'=>$num,'add_time'=>$time]));
            } else {
                exit(json_encode(['error' => 1, 'msg' => '无人员']));
            }
        }
    }
    public function more($id,$type=0,$car_id,$isUser){
        $type =intval(trim($type));
        $cost_list = Db::query("
        select d.id,d.cid,d.driver_id,d.department_id,d.plate_num,d.accident_cost,d.cost_type,d.car_describe,d.add_time,d.create_time,e.name from (
        select c.*,b.cid,b.plate_num,b.mer_id,b.department_id from (
        select a.id cid,a.plate_num,a.merchant_id mer_id,a.department_id from t_car_info a where merchant_id='$id' and a.id='$car_id') b 
        left join t_cost_info c 
        on(b.cid=c.car_id and b.mer_id=c.merchant_id and c.cost_type=$type)) d 
        left join t_driver_info e 
        on(d.driver_id = e.id and d.mer_id=e.merchant_id) order by create_time desc;
        ");
        if($isUser===true){
            if ($cost_list){
                return $cost_list;
            }else{
                return null;
            }
        }else{
            if ($cost_list){
                exit(json_encode(['error'=>0,'msg'=>$cost_list]));
            }else{
                exit(json_encode(['error'=>1,'msg'=>'无车辆']));
            }
        }
    }
    public function drive_speed($id,$driver_id,$start_time,$end_time)
    {
        if(!empty($driver_id)){
            $res = Db::query("select id from chegong_merchant.t_driver_info where merchant_id='$id' and id='$driver_id'");
            if(!empty($res[0])){
                $rst = Db::query("
                    select  sum(t.current_60_metres) as 'current_60_metres',
                    sum(t.current80_60_metres) as 'current80_60_metres',
                    sum(t.current100_80_metres) as 'current100_80_metres',
                    sum(t.current120_100_metres) as 'current120_100_metres',
                    sum(t.current140_120_metres) as 'current140_120_metres',
                    sum(t.current140_metres) as 'current140_metres',
                    sum(t.current_mileage)/1000 as 'current_mileage',
                    sum(t.current_oil) as 'current_oil',
                    avg(t.current_average_speed) as 'current_average_speed',
                    sum(t.fuel_bills) as 'fuel_bills'
                    from chegongbao.app_rundata_cdr_t as t where 
                    t.user_id='$driver_id' and is_set=1 and t.current_start_time between '$start_time' and '$end_time'
                ");
            }else{
                exit(json_encode(['error' => 1, 'msg' => '请规范操作,驾驶员不存在']));
            }
        }else{
            $rst = Db::query("
            select  sum(t.current_60_metres) as 'current_60_metres',
            sum(t.current80_60_metres) as 'current80_60_metres',
            sum(t.current100_80_metres) as 'current100_80_metres',
            sum(t.current120_100_metres) as 'current120_100_metres',
            sum(t.current140_120_metres) as 'current140_120_metres',
            sum(t.current140_metres) as 'current140_metres',
            sum(t.current_mileage)/1000 as 'current_mileage',
            sum(t.current_oil) as 'current_oil',
            avg(t.current_average_speed) as 'current_average_speed',
            sum(t.fuel_bills) as 'fuel_bills' 
            from (select id d_id,name d_name from chegong_merchant.t_driver_info  where merchant_id = '$id') as d
            left join chegongbao.app_rundata_cdr_t as t on d.d_id=t.user_id and is_set=1 and t.current_start_time between '$start_time' and '$end_time'
        ");
        }
        if(is_array($rst)){
            exit(json_encode(['error' => 0, 'msg' => $rst[0]]));
        }else{
            exit(json_encode(['error' => 1, 'msg' => '请规范操作']));
        }
    }
}