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
        $address = $arr['address'];
        unset($arr['address']);


        $user_id = 1001016;//user_id
        $mac = 'R8:ZP:8W:CH:AB:WV';//obd mac
        $vin = md5('LE4FTM8X05A882227');//车架号
        //    $it = time(); $iit = date('Y-m-d h:i:s',$it);//插入时间
        $it = time()+11400; $iit = date('Y-m-d h:i:s',$it);//插入时间


        $obd_id = md5($mac);//自动生成obdMd5值
        $oil = mt_rand(700,900)/100;//设置百公里油耗
        $st = date('Y-m-d h:i:s',$it+1);//行程开始时间
        $eet = $it+2;//当前行程结束时间初值
        $ds = 0;//怠速时长初值
        $a = $arr[0][0];//起点经度
        $b = $arr[0][1];//起点纬度
        $jjs = 0; //急加速次数初值
        $jjss = 0; //急减速次数初值
        $zoil = 0;//总耗油量

//        $swz = $arr['start'];
//        $ewz = $arr['end'];
        //循环插入相关信息
        foreach ($arr as $k => $v){

            //UUid
            $uuid = md5($this->uuid('chegong.com'));
            //当前行程结束时间 Unicode
            $ccsj = mt_rand(8,20);
            $eet = $eet+$ccsj;
            //怠速时长
            $ds = $ds+mt_rand(5,8);
            //各段速度占比
            $sdt = mt_rand(1,60);
            if($sdt<2){
                $sd150 = mt_rand(141,150);
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
                $jjs +=1;
            }elseif (2<=$sdt&&$sdt<3){
                $sd140 = mt_rand(121,140);
                $sd150 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif (3<=$sdt&&$sdt<6){
                $sd120 = mt_rand(101,120);
                $sd140 = 0;
                $sd150 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif (6<=$sdt&&$sdt<11){
                $sd100 = mt_rand(81,100);
                $sd140 = 0;
                $sd120 = 0;
                $sd150 = 0;
                $sd80 = 0;
                $sd60 = 0;
            }elseif (11<=$sdt&&$sdt<32){
                $sd80 = mt_rand(61,80);
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd150 = 0;
                $sd60 = 0;
            }elseif (32<=$sdt&&$sdt<61){
                $sd60 = mt_rand(40,60);
                $sd140 = 0;
                $sd120 = 0;
                $sd100 = 0;
                $sd80 = 0;
                $sd150 = 0;
                $jjss += 1;
            }
            //各段速度融合数组
            $dqsdarr=[$sd150, $sd140, $sd120, $sd100, $sd80, $sd60];
            foreach ($dqsdarr as $key=>$val){
                if($val === 0){
                    unset($dqsdarr[$key]);
                }else{
                    $dqsd =$dqsdarr[$key];
                }

            }
            //此次里程
            $cclc = $dqsd*$ccsj;
            //此次耗油
            $ccoil = $cclc/100*$oil;
            //总油耗
            $zoil += $ccoil;
            //结束时间
            $et = date('Y-m-d h:i:s',$eet);
            //当前行程耗时
            $current_travel_time = $eet - $it;
            //判断行程是否结束
            if($k <count($arr)-1){
                $is_set = 0;
            }else{
                $is_set = 1;
            }
            $rst = Db::connect('local1')->query("
            insert into app_rundata_cdr_n
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
                current140_metres,
                current140_120_metres,
                current120_100_metres,
                current100_80_metres,
                current80_60_metres,
                current_60_metres,
                rapid_acceleration_count,
                rapid_deceleration_count,
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
                '$sd150',
                '$sd140',
                '$sd120',
                '$sd100',
                '$sd80',
                '$sd60',
                '$jjs',
                '$jjss',
                '$a',
                '$b',
                '$v[0]',
                '$v[1]',
                '$address[0]',
                '$address[$k]',
                0,
                0,
                '$is_set',
                1)");
            echo 'success'.$k.'</br>';
        }
    }
    function GetRealgeo($str,$para){
        $url="http://restapi.amap.com/v3/geocode/regeo?output=json&location=".$str."&key=".$para."&radius=500&extensions=base";

        $content = file_get_contents($url);
        $arr = json_decode($content,true);

        $data = array(
            "err_code" => $arr['infocode'], //错误编码，如出现错误可去高德地图查询原因
            "address" => $arr['regeocode']['formatted_address'],
            "country" => $arr['regeocode']['addressComponent']['country'],
            "province" => $arr['regeocode']['addressComponent']['province'],
            "city" => $arr['regeocode']['addressComponent']['city'],
            "district" => $arr['regeocode']['addressComponent']['district'],
            "township" => $arr['regeocode']['addressComponent']['township'],
            "citycode" => $arr['regeocode']['addressComponent']['citycode'],
            "adcode" => $arr['regeocode']['addressComponent']['adcode']

        );
        return $data;
        //测试OK
    }

}