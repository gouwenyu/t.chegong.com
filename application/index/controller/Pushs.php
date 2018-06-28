<?php
/**
 * Created by PhpStorm.
 * User: XD
 * Date: 2017/6/26
 * Time: 15:56
 */

namespace app\index\controller;

use think\Db;
use app\common\controller\Check as check;

class Pushs extends check
{
    /*
     * 推送时实位置接口
     * */
    public function push()
    {
        do{
        $id = $this->sid;
        $res = Db::query("
                select x.*,d.name from(
                select z.*,e.error_code from(
                select c.plate_num,c.obd_id,a.user_id,a.longitude,a.latitude,a.date,a.address from chegong_merchant.t_car_info c
                left join chegongbao.t_map_position_last a 
                on(c.obd_id=a.obd_id) where a.source=1 and c.merchant_id in($id) and a.obd_id<>'' and a.longitude<>'0') z
                left join chegong_merchant.t_obd_err_code e on (z.obd_id = e.obd_id)) x
                left join chegong_merchant.t_driver_info d on(x.user_id=d.id); 
            ");
        foreach ($res as $k => $item) {
            $xy = $this->post_amap($item['longitude'], $item['latitude']);
            $xy = (array)$xy;
            $a = explode(',', $xy['locations']);
            $res[$k]['lonlat'] =  $a[0] . ',' . $a[1];
            unset($res[$k]['longitude'], $res[$k]['latitude']);
                if (time() - 120 < strtotime($item['date'])) {
                    $res[$k]['status'] = 'run';
                } else {
                    $res[$k]['status'] = 'park';
                }
            }
        sleep(5);
        $this->sendmsg($res, session('uid'));
//        file_put_contents('./Data.php', json_encode($res));
        }while(true);
    }

    public function sendmsg($data, $id)
    {
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        // 指明给谁推送，为空表示向所有在线用户推送
        $to_uid = "$id";
        // 推送的url地址，使用自己的服务器地址
        $push_api_url = "show.chegong.com:2121/";
        $post_data = array(
            "type" => "publish",
            "content" => $data,
            "to" => $to_uid,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $push_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec($ch);
        curl_close($ch);
        var_export($return);
    }
}