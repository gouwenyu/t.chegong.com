<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 18:04
 */

namespace app\index\controller;
use think\Controller;
use think\Db;

class Ins extends Controller
{
    public function index(){
        header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
        $arr = input('post.');//所有前端传值  包括经纬度和具体位置信息
        $lnglat = $arr['lnglat'];//所有经纬度
        foreach ($lnglat as $val){
            foreach ($val as $v){
                $address[] = $v;//所有经纬度
            }
        }
        $qidian = $arr['s_e_address'][0];//起点地理位置
        $zhongdian = $arr['s_e_address'][1];//起点地理位置
        $current_travel_time = 0;//当前行程总时间



        $user_id = 1001033;//user_id
        $mac = 'CF:VI:UY:IW:VL:Z2';//obd mac
        $vin = md5('LBEXDAEB4CX129399');//车架号
        $it = strtotime("2017-09-24 09:".mt_rand(0,45).":".mt_rand(0,59));//演示前一天
//        $it = strtotime("2017-09-24 09:".mt_rand(0,45).":".mt_rand(0,59))+11400;
//        $it = strtotime("2017-09-25 09:".mt_rand(0,45).":".mt_rand(0,59));//演示当天
//        $it = strtotime("2017-09-25 09:".mt_rand(0,45).":".mt_rand(0,59))+11400;

        $iit = date('Y-m-d h:i:s',$it);//插入时间
        $obd_id = md5($mac);//自动生成obdMd5值



        $st = date('Y-m-d h:i:s',$it+1);//行程开始时间
        $eet = $it+2;//当前行程结束时间初值
        $ds = 0;//怠速时长初值
        $a = $address[0][0];//起点经度
        $b = $address[0][1];//起点纬度
        $zoil = 0;//总耗油量
        $zlc = 0;

        //循环插入相关信息
        foreach ($address as $k => $v){

            //UUid
            $uuid = md5($this->uuid('chegong.com'));
            //此次行驶时间
            $ccsj = $v[2];
            //当前行程结束时间 Unicode
            $eet = $eet+$ccsj;
            //怠速时长
            $ds = $ds+mt_rand(2,4);
            //此次里程
            $cclc = $v[3];
            //此次速度
            if(!empty($ccsj)){
                $ccsd = $cclc*3.6/$ccsj;
            }else{
                $ccsd = 0;
            }
            if($ccsd>140){
                $sd150 = $ccsd;
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif(120<=$ccsd&&$ccsd<140){
                $sd150 = 0;
                $sd140 = $ccsd;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif(100<=$ccsd&&$ccsd<120){
                $sd150 = 0;
                $sd140 = 0;
                $sd120 = $ccsd;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif(80<=$ccsd&&$ccsd<100){
                $sd150 = 0;
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = $ccsd;
                $sd80 = 0;
                $sd60 = 0;
            }elseif(60<=$ccsd&&$ccsd<80){
                $sd150 = 0;
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = $ccsd;
                $sd60 = 0;
            }else{
                $sd150 = 0;
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = $ccsd;
            }
            //此次耗油
            $oil100 = mt_rand(700,900)/100;//设置百公里油耗
            $ccoil = $cclc/100000*$oil100;
            //总里程
            $zlc += $cclc;
            //总油耗
            $zoil += $ccoil;
            //结束时间
            $et = date('Y-m-d h:i:s',$eet);
            //当前行程耗时
            $current_travel_time += $ccsj;
            //判断行程是否结束
            if($k <count($address)-1){
                $is_set = 0;
                $zd = '';
            }else{
                $is_set = 1;
                $zd = $zhongdian;
            }
            $rst = Db::connect('local11')->query("
            insert into app_rundata_cdr_x
            (
                id,
                user_id,
                obd_id,
                obd_mac,
                vin,
                in_time,
                current_start_time,
                current_end_time,
                current_travel_time,
                current_car_driving_time,
                current_mileage,
                current_average_speed,
                current140_metres,
                current140_120_metres,
                current120_100_metres,
                current100_80_metres,
                current80_60_metres,
                current_60_metres,
                current_oil,
                current_100km_oil,
                start_longitude,
                start_latitude,
                end_longitude,
                end_latitude,
                start_place,
                end_place,
                is_online,
                is_del,
                is_set,
                source
            ) 
            values (
                '$uuid',
                $user_id,
                '$obd_id',
                '$mac',
                '$vin',
                '$iit',
                '$st',
                '$et',
                '$current_travel_time',
                '$ds',
                $zlc,
                $ccsd,
                '$sd150',
                '$sd140',
                '$sd120',
                '$sd100',
                '$sd80',
                '$sd60',
                $zoil,
                $oil100,
                '$a',
                '$b',
                '$v[0]',
                '$v[1]',
                '$qidian',
                '$zd',
                0,
                0,
                '$is_set',
                1)");
            echo 'success'.$k.'</br>';
        }
    }

}