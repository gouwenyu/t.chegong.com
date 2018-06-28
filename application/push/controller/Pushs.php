<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/6/26
 * Time: 15:56
 */

namespace app\push\controller;

use think\Db;
use app\common\controller\Check as check;
class Pushs extends check
{
    /*
     * 推送时实位置接口
     * */
    public function push(){
        $msg = [];
        $data = [];
        do{
//            $res = Db::query("SELECT a.user_id,a.obd_id,a.vin,a.longitude,a.latitude,a.date,b.error_code FROM chegongbao.t_map_position_last a LEFT JOIN chegong_merchant.t_obd_err_code b ON (a.user_id = b.user_id AND a.obd_id = b.obd_id) WHERE a.obd_id<>''");
//            $res = Db::query("SELECT a.user_id,a.obd_id,a.vin,a.longitude,a.latitude,a.date,b.error_code FROM chegongbao.t_map_position_last a LEFT JOIN chegong_merchant.t_obd_err_code b ON (a.obd_id = b.obd_id) WHERE a.obd_id<>''");
//            $res = Db::query("
//            SELECT a.user_id,a.obd_id,a.vin,a.longitude,a.latitude,a.date FROM chegongbao.t_map_position_last a where a.source='1' and a.obd_id<>'' and a.longitude<>'0'
//            ");
            $id = $this->sid;
            $res = Db::query("
                select x.*,d.name from(
                select z.*,e.error_code from(
                select c.plate_num,c.obd_id,a.user_id,a.longitude,a.latitude,a.date,a.address from chegong_merchant.t_car_info c
                left join chegongbao.t_map_position_last a 
                on(c.obd_id=a.obd_id and c.merchant_id='$id') where a.source='1' and a.obd_id<>'' and a.longitude<>'0') z
                left join chegong_merchant.t_obd_err_code e on (z.obd_id = e.obd_id)) x
                left join chegong_merchant.t_driver_info d on(x.user_id=d.id); 
            ");
            foreach ($res as $item) {
                $xy = $this->post_amap($item['longitude'],$item['latitude']);
                $xy = (array)$xy;
                $a = explode(',',$xy['locations']);
                $item['longitude'] = $a[0];
                $item['latitude'] = $a[1];
                if(!isset($msg[$item['user_id']][$item['obd_id']])){
                    $msg[$item['user_id']][$item['obd_id']] = [
                        'run' => [$item['longitude'], $item['latitude']],
                        'code'=>empty($item['error_code'])?0:$item['error_code'],
                        'date'=>$item['date'],
                        'plate_num'=>$item['plate_num'],
                        'address'=>$item['address'],
                        'user_name'=>$item['name'],
                        'a'=>0
                    ];
                    $data[$item['user_id']][$item['obd_id']] = [
                        'run' => [$item['longitude'], $item['latitude']],
                        'code'=>empty($item['error_code'])?0:$item['error_code'],
                        'date'=>$item['date'],
                        'plate_num'=>$item['plate_num'],
                        'address'=>$item['address'],
                        'user_name'=>$item['name']
                    ];
                }elseif($item['date'] != $msg[$item['user_id']][$item['obd_id']]['date']){
                    $msg[$item['user_id']][$item['obd_id']] = [
                        'run' => [$item['longitude'], $item['latitude']],
                        'code'=>empty($item['error_code'])?0:$item['error_code'],
                        'date'=>$item['date'],
                        'plate_num'=>$item['plate_num'],
                        'address'=>$item['address'],
                        'user_name'=>$item['name'],
                        'a'=>0
                    ];
                    $data[$item['user_id']][$item['obd_id']] = [
                        'run' => [$item['longitude'], $item['latitude']],
                        'code'=>empty($item['error_code'])?0:$item['error_code'],
                        'plate_num'=>$item['plate_num'],
                        'address'=>$item['address'],
                        'user_name'=>$item['name'],
                        'date'=>$item['date']
                    ];
                }else{
                    if($msg[$item['user_id']][$item['obd_id']]['a'] > 30){
                        $msg[$item['user_id']][$item['obd_id']] = [
                            'park' => [$item['longitude'], $item['latitude']],
                            'code'=>empty($item['error_code'])?0:$item['error_code'],
                            'date'=>$item['date'],
                            'plate_num'=>$item['plate_num'],
                            'address'=>$item['address'],
                            'user_name'=>$item['name'],
                            'a'=>$msg[$item['user_id']][$item['obd_id']]['a'],
                        ];
                        $data[$item['user_id']][$item['obd_id']] = [
                            'park' => [$item['longitude'], $item['latitude']],
                            'code'=>empty($item['error_code'])?0:$item['error_code'],
                            'plate_num'=>$item['plate_num'],
                            'address'=>$item['address'],
                            'user_name'=>$item['name'],
                            'date'=>$item['date']
                        ];
                    }else{
                        $msg[$item['user_id']][$item['obd_id']] = [
                            'run' => [$item['longitude'], $item['latitude']],
                            'code'=>empty($item['error_code'])?0:$item['error_code'],
                            'date'=>$item['date'],
                            'plate_num'=>$item['plate_num'],
                            'address'=>$item['address'],
                            'user_name'=>$item['name'],
                            'a'=>$msg[$item['user_id']][$item['obd_id']]['a']+1,
                        ];
                        $data[$item['user_id']][$item['obd_id']] = [
                            'run' => [$item['longitude'], $item['latitude']],
                            'code'=>empty($item['error_code'])?0:$item['error_code'],
                            'plate_num'=>$item['plate_num'],
                            'address'=>$item['address'],
                            'user_name'=>$item['name'],
                            'date'=>$item['date']
                        ];
                    }
                }
            }
            sleep(5);
            $this->sendmsg($data,$id);
//            file_put_contents('./Data.php',json_encode($msg));
        }while(true);
    }

    public function post_amap($x,$y){
        $ch = curl_init ();
        curl_setopt($ch,CURLOPT_URL,"http://restapi.amap.com/v3/assistant/coordinate/convert?locations=$x,$y&coordsys=gps&output=json&key=47e9fd264b9f80d8ecc368e616af3e57" );
        curl_setopt($ch,CURLOPT_HEADER,0 );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1 );
        $rst = curl_exec($ch);
        curl_close($ch);
        return json_decode($rst);
    }
    public function sendmsg($data,$id){
        $data =json_encode($data);
        // 指明给谁推送，为空表示向所有在线用户推送
        $to_uid = "$id";
        // 推送的url地址，使用自己的服务器地址
        $push_api_url = "show.chegong.com:2121/";
        $post_data = array(
            "type" => "publish",
            "content" =>$data,
            "to" => $to_uid,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);
    }
}