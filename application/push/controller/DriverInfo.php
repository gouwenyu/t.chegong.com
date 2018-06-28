<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/8/20
 * Time: 21:45
 */

namespace app\push\controller;
use app\push\model\User;
use think\Db;
use app\common\controller\Check as check;
class DriverInfo extends check
{

    public function kpi(){
        $id = $this->sid;
        $user = new User();
        $driver_list = $user->driver_list($id);
        $driver_cost0 = $user->driver_cost($id,0);
        $driver_cost1 = $user->driver_cost($id,1);
        $num0 = 0;$num1 = 0;$time0 =0;$time1 =0;
        foreach ($driver_cost0 as $v){
            if($v[0][0]['id']!==null){
                $num0++;
                $add_time0 = strtotime($v[0][0]['add_time']);
                if($add_time0>$time0){
                    $time0 = $add_time0;
                }
            }
        }
        foreach ($driver_cost1 as $v){
            if($v[1][0]['id']!==null){
                $num1++;
                $add_time1 = strtotime($v[1][0]['add_time']);
                if($add_time1>$time1){
                    $time1 = $add_time1;
                }
            }
        }
        $time0 = empty($time0)?'无':date('Y-m-d',$time0);
        $time1 = empty($time1)?'无':date('Y-m-d',$time1);
        $time = [$time0,$time1];
        $num = [$num0,$num1];
        $this->assign('list',$driver_list);
        $this->assign('num',$num);
        $this->assign('time',$time);
        $this->assign('driver_cost0',$driver_cost0);
        $this->assign('driver_cost1',$driver_cost1);
        return view('kpi');
    }
    public function analysis(){
        $id = $this->sid;
        $user = new User();
        $driver_list = $user->driver_list($id);
        $this->assign('list',$driver_list);
        return view('analysis');
    }
    public function oil(){
        $id = $this->sid;
        $user = new User();
        $car_list = $user->car_list($id);
        $oil = $user->oil($id);
        $list =[];
        foreach ($car_list as $v){
            $list[$v['department_id']][] = $v;
        }$oil_list = '';
        foreach ($oil as $v){
            if(!empty($v['value'])){
                $oil_list .= "{name: '".$v['name']."',value:".$v['value'].".toFixed(2),color:bg_color()},";
            }
        }
        $oil_list = "
        <script type='text/javascript'>
            function bg_color() {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256);
                return 'rgb(' + r + ',' + g + ',' + b + ')';
            }
            var data = [".$oil_list."];
        </script>";
        $this->assign('oil_list',$oil_list);
        $this->assign('list',$list);
        return view('oil');
    }
    public function driver_more(){
        $driver_id = input('post.driver_id');
        $type = input('post.type');
        $id = $this->sid;
        $user = new User();
        $user->driver_more($id,$type,$driver_id,false);
    }
    /*
    * 行驶轨迹接口
    * user_i 用户id
    * user_o obd盒子号
    * time_s 开始时间
    * time_e 结束时间
    * */
    public function current(){
        $obd_id = input('request.user_o');
        $user = input('request.user_i');
        $s_time = input('request.time_s');
        $e_time = input('request.time_e');

        if(!empty($s_time)&&!empty($e_time)) {
            $s = strtotime($s_time);
            $e = strtotime($e_time);

            if($s>$e){
                exit(json_encode('请勿非法操作'));
            }
            $current = Db::connect('chegongbao');
            if(!empty($obd_id)){
                $rst = $current
                    ->table('app_rundata_cdr_n')
                    ->field('user_id,vin,obd_id,end_longitude longitude,end_latitude latitude,current_start_time,current_end_time')
                    ->where('obd_id','in', $obd_id)
                    ->where('end_longitude','neq','0')
                    ->where('current_start_time', 'between', [$s_time, $e_time])
                    ->order('current_end_time')
//                    ->fetchSql(true)
                    ->select();

//                var_dump($rst.'---'.$s_time.'----'.$e_time);die;
            }elseif(!empty($user)){
                $rst = $current
                    ->table('app_rundata_cdr_n')
                    ->field('user_id,vin,obd_id,end_longitude longitude,end_latitude latitude,current_start_time,current_end_time')
                    ->where('user_id','in',$user)
                    ->where('obd_id','neq','')
                    ->where('end_longitude','neq','0')
                    ->where('current_start_time', 'between', [$s_time, $e_time])
                    ->order('obd_id')
                    ->order('current_end_time')
//                    ->fetchSql(true)
                    ->select();
            }else{
                exit(json_encode('参数为空,谨慎操作'));
            }
            if($rst) {
                $msg = [];
                foreach ($rst as $key => $value) {
                    $t = strtotime($value['current_start_time']);
                    if (!isset($msg[$t])) {
                        $msg[$t][] = $value['longitude'] . ',' . $value['latitude'];
                        $msg[$t]['start_time'] = $value['current_start_time'];
                    } else {
                        $msg[$t][] =  $value['longitude'] . ',' . $value['latitude'];
                        $msg[$t]['end_time'] = $value['current_end_time'];
                    }
                }
                $keys = array_keys($msg);
                foreach ($keys as $item){
                    $msg1['start_time'] = $msg[$item]['start_time'];
                    $msg1['end_time'] =  isset($msg[$item]['end_time'])?$msg[$item]['end_time']:$msg1['start_time'];
                    unset($msg[$item]['start_time'],$msg[$item]['end_time']);
                    $msg[$item] =implode('|',$msg[$item]);
                    $msg[$item] = (array)$this->post_amap($msg[$item]);
                    $msg[$item] = explode(';',$msg[$item]['locations']);
                    $msg[$item]['start_time'] = $msg1['start_time'];
                    $msg[$item]['end_time'] = $msg1['end_time'];
                }
                foreach ($keys as $time){
                    if(count($msg[$time])<8){
                        unset($msg[$time]);
                    }
                }
                exit(json_encode($msg));
            }else{
                exit($this->make_json_error('没有轨迹'));
            }
        }else{
            exit($this->make_json_error('请规范操作'));
        }
    }
    public function drive_time(){
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $driver_id = input('post.driver_id');
        $id = $this->sid;
        $user = new User();
        if(empty($start_time)||empty($end_time)){
            $this->make_json_error('获取时间失败，请规范操作');
        }else{
            if($start_time>=$end_time){
                $user->drive_time($id,$driver_id,$end_time,$start_time);
            }else{
               $user->drive_time($id,$driver_id,$start_time,$end_time);

            }
        }
    }
    public function mileage(){
        $id = $this->sid;
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $driver_id = input('post.driver_id');
        if(empty($start_time)||empty($end_time)){
            $this->make_json_error('获取里程失败，请规范操作');
        }else{
            $user = new User();
            if($start_time>=$end_time){
                $user->drive_mileage($id,$driver_id,$end_time,$start_time);
            }else{
                $user->drive_mileage($id,$driver_id,$start_time,$end_time);
            }
        }
    }
    public function speed(){
        $start_time = input('post.stime');
//        $start_time = '2017-09-01';
        $end_time = input('post.etime');
//        $end_time = '2017-10-30';
        if(strtotime($start_time)&&strtotime($end_time)){
            $driver_id = input('post.driver_id');
            $id = $this->sid;
            $user = new User();
            if ($start_time >= $end_time) {
                $res = $user->drive_speed($id, $driver_id, $end_time, $start_time);
//                var_dump($res, 1);
            } else {
                $res = $user->drive_speed($id, $driver_id, $start_time, $end_time);
//                var_dump($res, 2);
            }
        }else{
            $this->make_json_error('日期格式不正确，请规范操作');
        }
    }
    public function driveData()
    {
        $start_time = input('post.stime');
        $end_time = input('post.etime');
        $obd_id = input('post.oid');
        $partment_id = input('post.partmentid');
        $id = $this->sid;
        if (empty($obd_id) && empty($partment_id)) {
            $where = '';
        } elseif (!empty($partment_id)) {
            $where = " and a.department_id='$partment_id' ";
        } else {
            $where = " and a.obd_id='$obd_id' ";
        }
        $res = Db::query("
            select c.*,t.current_mileage,t.current_oil,t.fuel_bills from (
            select a.obd_id,a.plate_num,a.department_id,b.department_name from  
            chegong_merchant.t_car_info a left join chegong_merchant.t_department_info b 
            on (a.department_id = b.id and a.merchant_id = b.merchant_id) 
            where a.merchant_id='$id' $where) c 
            left join chegongbao.app_rundata_cdr_t t on (c.obd_id=t.obd_id and t.is_set=1 and t.user_id<>'' and t.current_start_time between '$start_time' and '$end_time')
            ");
        if (empty($res)) {
            $this->make_json_response('暂无数据', 1);
        } else {
            $list = [];
            foreach ($res as $item) {
                if (empty($list[$item['obd_id']])) {
                    $list[$item['obd_id']]['current_mileage'] = $item['current_mileage'];
                    $list[$item['obd_id']]['current_oil'] = $item['current_oil'];
                    $list[$item['obd_id']]['fuel_bills'] = $item['fuel_bills'];
                    $list[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list[$item['obd_id']]['department_id'] = $item['department_id'];
                    $list[$item['obd_id']]['department_name'] = $item['department_name'];
                } else {
                    $list[$item['obd_id']]['current_mileage'] += $item['current_mileage'];
                    $list[$item['obd_id']]['current_oil'] += $item['current_oil'];
                    $list[$item['obd_id']]['fuel_bills'] += $item['fuel_bills'];
                    $list[$item['obd_id']]['plate_num'] = $item['plate_num'];
                    $list[$item['obd_id']]['department_id'] = $item['department_id'];
                    $list[$item['obd_id']]['department_name'] = $item['department_name'];
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
            $this->make_json_error($list,0);
        }
    }
    public function post_amap($data){
        $ch = curl_init ();
        curl_setopt($ch,CURLOPT_URL,"http://restapi.amap.com/v3/assistant/coordinate/convert?locations=$data&coordsys=gps&output=json&key=47e9fd264b9f80d8ecc368e616af3e57" );
        curl_setopt($ch,CURLOPT_HEADER,0 );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1 );
        $rst = curl_exec($ch);
        curl_close($ch);
        return json_decode($rst);
    }
}